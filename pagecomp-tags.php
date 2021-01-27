<?php ?>

    <!-- Home Button -->
	<div class="rb-nav-flex-grid">
		<div>
			<a href="/" class="rb-button rb-button-border rb-padding-1rem-2rem rb-margin-2rem-left" style="margin-bottom: 0rem !important; margin-top: 2rem;"><b>Home</b></a>
		</div>
		<div>
		</div>
	</div>
    
	<?php
		try {
			// Setup Paginator
			$pages = new Paginator(POSTSPERPAGE,'p');
			$stmt = $connection->prepare('
                SELECT
                    postID
                FROM
                    blog_posts
                WHERE
                    postTags like :postTags
                ORDER BY
                    postID DESC'
            );
            $stmt->execute(array(
                ':postTags' => '%'.$id.'%'
            ));
			
			// Pass Number Of Dates To Database Querry
			$pages->set_total($stmt->rowCount());
			$statement = $connection->prepare('
                SELECT
                    postID,
					postTitle,
					postContent,
                    postSlug,
                    postDate,
					postTags,
					postImage
                FROM
                    blog_posts
                WHERE
                    postTags like :postTags
                ORDER BY
                    postID DESC '.$pages->get_limit()
            );
            $statement->execute(array(
                ':postTags' => '%'.$id.'%'
            ));
            
            
			while($row = $statement->fetch()) {
				// Card
				echo '<div class="rb-card">';
					if($row['postImage'] != NULL) {
						$stmt2 = $connection->query('
							SELECT
								imageID,
								imageTitle,
								imagePath
							FROM
								blog_images
							WHERE
								imageID = '.$row['postImage']
						);

						$stmt2->execute(array());
						$row2 = $stmt2->fetch();

						echo '<a href="/post/'.$row['postSlug'].'" class="rb-card-link"><img class="rb-card-img" title="'.$row2['imageTitle'].'" src="/'.$row2['imagePath'].'?v='.CSSVERSION.'" onerror="this.src=&#39;/_res/images/missing/Placeholder-Image-1920x1080.png&#39;" alt="N/A"></a>';
					}

					echo '<div>';
						// Display Title and Date
						echo '<a href="/post/'.$row['postSlug'].'" class="rb-card-link"><h3 class="rb-card-title"><b>'.$row['postTitle'].'</b></h3></a>';
						echo '<a href="/post/'.$row['postSlug'].'" class="rb-card-link"><h5 class="rb-card-date"><span class="rb-text-opacity">'.date('F d, Y', strtotime($row['postDate'])).'</span></h5></a>';

						// Prepare Description From Content
						$array1 = explode('[END OF DESCRIPTION]' , $row['postContent']);
						$array1[0] = strip_tags(html_entity_decode($array1[0]), '<p><ul><li><img><b><h1><h2><h3><h4><h5><strong>');

						// Display Description
            			echo '<div>';
							echo '<a href="/post/'.$row['postSlug'].'" class="rb-card-link">'.$array1[0].'</a>';
							echo '<p><a href="/post/'.$row['postSlug'].'" class="rb-card-link rb-text-opacity">Read More &gt;</a></p>';
            			echo '</div>';
					echo '</div>';
					echo '<div class="rb-card-footer">';
					if ($row['postTags'] != NULL) {
						echo '<h5 class="rb-card-footer-tags"><span class="rb-text-opacity"><ul class="rb-card-footer-tags-table">';
							$links = array();
							$parts = explode(', ', $row['postTags']);
							foreach ($parts as $tag) {
								echo "<li class='rb-card-footer-tags-table-item'><a class='rb-card-categories-tag rb-text-opacity' href='/tag/".$tag."'>#".$tag."</a></li>";
							}
						echo '</ul></span></h5>';
					}
					echo '</div>';
				echo '</div>';
			}
			
			echo $pages->page_links($month.'-'.$year.'&');
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	?>
</div>
<!-- END   - Left Column: Blog Post Column -->