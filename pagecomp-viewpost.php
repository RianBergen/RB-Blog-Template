<?php
// Get Post Data
if ($id != NULL) {
	$statement = $connection->prepare('
        SELECT
            postID,
            postTitle,
            postContent,
            postDate,
            postSlug,
            postImage,
            postTags
        FROM 
            blog_posts
        WHERE
            postSlug = :postSlug
    ');
	$statement->execute(array(
        ':postSlug' => $id
    ));
	$row = $statement->fetch();
    
    $statement = $connection->prepare('
        UPDATE
            blog_posts
        SET
            postViewCount = postViewCount + 1
        WHERE
            postSlug = :postSlug
    ');
	$statement->execute(array(
        ':postSlug' => $id
    ));
}
?>

	<!-- Back To Posts Button -->
	<div class="rb-nav-flex-grid">
		<div>
			<a href="javascript:history.back()" class="rb-button rb-button-border rb-padding-1rem-2rem rb-margin-2rem-left" style="margin-bottom: 0rem !important; margin-top: 2rem;"><b>Go Back</b></a>
		</div>
		<div>
		</div>
	</div>

	<!-- Blog Post -->
	<?php
		if($row['postID'] == "") {
			// Card
			echo '<div class="rb-card">';
				echo '<div>';
					echo '<h3><b>Post Was Not Found, Or Is Empty!</b></h3>';
				echo '</div>';
				echo '<div>';
					echo '<p>Please type in a different URL, or select a different Post.</p>';
				echo '</div>';
			echo '</div>';
		} else {
			echo '<div class="rb-card">';
				if ($row['postImage'] != "") {
					echo '<img class="rb-card-img" src="/'.$row['postImage'].'" onerror="this.src=&#39;/_res/images/missing/Placeholder-Image-1920x1080.png&#39;" alt="N/A">';
				}
				echo '<div>';
					echo '<h3><b>'.$row['postTitle'].'</b></h3>';
					echo '<h5>Posted On: <span class="rb-text-opacity">'.date('F d, Y', strtotime($row['postDate'])).'</span></h5>';
						$statement2 = $connection->prepare('
                            SELECT
                                categoryTitle,
                                categorySlug
                            FROM
                                blog_categories,
                                blog_post_categories
                            WHERE
                                blog_categories.categoryID = blog_post_categories.pcCategoryID
                                AND blog_post_categories.pcPostID = :postID'
                        );
						$statement2->execute(array(
                            ':postID' => $row['postID']
                        ));
						$categoryRow = $statement2->fetchAll(PDO::FETCH_ASSOC);
						$links = array();
						foreach ($categoryRow as $category) {
							$links[] = "<a class='rb-card-categories-tag' href='/category/".$category['categorySlug']."'>".$category['categoryTitle']."</a>";
						}
						
						if (empty($categoryRow) != true) {
                            echo '<h5>Posted In: <span class="rb-text-opacity">';
                            echo implode(", ", $links);
                        }
					echo '</span></h5>';
                    if ($row['postTags'] != NULL) {
                        echo '<h5>Tagged As: <span class="rb-text-opacity">';
                            $links = array();
                            $parts = explode(', ', $row['postTags']);
                            foreach ($parts as $tag) {
                                $links[] = "<a class='rb-card-categories-tag' href='/tag/".$tag."'>".$tag."</a>";
                            }
                            
                            echo implode(", ", $links);
                        echo '</span></h5>';
                    }
				echo '</div>';
				echo '<div>';
					echo ''.$row['postContent'].'';
				echo '</div>';
                
                echo '<hr/>';
                
                echo' <div id="disqus_thread"></div>';
                echo '<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>';
			echo '</div>';
		}
	?>
    
<!-- DISQUS COMMENTS -->
<script>
    /**
     *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT 
     *  THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR 
     *  PLATFORM OR CMS.
     *  
     *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: 
     *  https://disqus.com/admin/universalcode/#configuration-variables
     */
    
    var disqus_config = function () {
        // Replace PAGE_URL with your page's canonical URL variable
        <?php echo 'this.page.url = "/post/'.$id.'";';?>
        
        // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        <?php echo 'this.page.identifier = '.$row["postID"].';';?>
    };
    
    
    (function() {    // REQUIRED CONFIGURATION VARIABLE: EDIT THE SHORTNAME BELOW
        var d = document, s = d.createElement('script');
        
        // IMPORTANT: Replace EXAMPLE with your forum shortname!
        <?php echo 's.src = "https://'.DISQUS.'.disqus.com/embed.js";';?>
        
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();
</script>
</div>
<!-- END   - Left Column: Blog Post Column -->