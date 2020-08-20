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
                
                echo' <div id="hashover"></div>';
                echo '<noscript>Please enable JavaScript to view the <a href="https://www.barkdull.org/software/hashover">comments powered by HashOver.</a></noscript>';
			echo '</div>';
		}
	?>
    
<!-- HASHOVER COMMENTS -->
<script type="text/javascript" src="/hashover/comments.php"></script>
</div>
<!-- END   - Left Column: Blog Post Column -->