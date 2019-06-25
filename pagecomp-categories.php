<?php ?>

<!-- START - Left Column: Blog Post Column -->
<div class="rb-main-flex-grid-left-column">
    <!-- Home Button -->
	<div class="rb-nav-flex-grid">
		<div>
			<a href="/" class="rb-button rb-button-border rb-padding-1rem-2rem rb-margin-2rem-left" style="margin-bottom: 0rem !important; margin-top: 2rem;"><b>Home</b></a>
		</div>
		<div>
		</div>
	</div>
    
	<?php
		// Check If Posts Exist In Category
		$statement = $connection->prepare('
            SELECT
                categoryID,
                categoryTitle
            FROM
                blog_categories
            WHERE
                categorySlug = :categorySlug'
        );
		$statement->execute(array(
            ':categorySlug' => $id
        ));
		$row = $statement->fetch();
		
		// Display Empty Card If No Posts Exist
		if($row['categoryID'] == '') {
			// Card
			echo '<div class="rb-card">';
				echo '<div>';
					echo '<h3><b>Categroy Was Not Found, Or Is Empty!</b></h3>';
				echo '</div>';
				echo '<div>';
					echo '<p>Please type in a different URL, or select a different Category.</p>';
				echo '</div>';
			echo '</div>';
		}
		
		try {
			// Setup Paginator
			$pages = new Paginator(POSTSPERPAGE,'p');
			$statement = $connection->prepare('
                SELECT
                    blog_posts.postID
                FROM
                    blog_posts,
                    blog_post_categories
                WHERE
                    blog_posts.postID = blog_post_categories.pcPostID
                    AND blog_post_categories.pccategoryID = :categoryID'
            );
			$statement->execute(array(
                ':categoryID' => $row['categoryID']
            ));
			
			// Pass Records To Database Querry
			$pages->set_total($statement->rowCount());
			$statement = $connection->prepare('
				SELECT 
					blog_posts.postID, blog_posts.postTitle, blog_posts.postSlug, blog_posts.postDescription, blog_posts.postDate, blog_posts.postViewCount, blog_posts.postTags
				FROM 
					blog_posts,
					blog_post_categories
				WHERE
					 blog_posts.postID = blog_post_categories.pcPostID
					 AND blog_post_categories.pccategoryID = :categoryID
				ORDER BY 
					postID DESC '.$pages->get_limit()
            );
			$statement->execute(array(
                ':categoryID' => $row['categoryID']
            ));
			
			while($row = $statement->fetch()){
				// Card
				echo '<div class="rb-card">';
					if($row['postImage'] != NULL) {
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
						echo ''.$row['postDescription'].'';
						echo '<div class="rb-card-flex-grid-container">';
							echo '<div class="rb-card-flex-grid-left-column">';
								echo '<a href="/post/'.$row['postSlug'].'" class="rb-button rb-button-border rb-padding-1rem-2rem"><b>READ MORE</b></a>';
							echo '</div>';
							echo '<div class="rb-card-flex-grid-right-column">';
								echo '<p class="rb-text-align-right rb-padding-1rem-2rem rb-card-flex-grid-right-column-views"><span><b>Comments  </b><a href="/post/'.$row['postSlug'].'#disqus_thread" class="rb-text-black-tag">0</a></span></p>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}
			
			echo $pages->page_links($id.'&');
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	?>
</div>
<!-- END   - Left Column: Blog Post Column -->