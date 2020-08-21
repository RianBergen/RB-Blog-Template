    <?php
		try {
			// Setup Paginator
			$pages = new Paginator(POSTSPERPAGE,'p');
			$statement = $connection->query('
                SELECT
                    postID
                FROM
                    blog_posts'
            );
			
			// Give Paginator Number Pages
			$pages->set_total($statement->rowCount());
			
            // Fetch Posts According To The Number Of Pages From Paginator
			$statement = $connection->query('
                SELECT
                    postID,
					postTitle,
					postContent,
                    postTags,
                    postDate,
                    postSlug,
                    postImage
                FROM
                    blog_posts
                ORDER BY
                    postID DESC '.$pages->get_limit()
            );
            
			while($row = $statement->fetch()) {
				// Card
				echo '<div class="rb-card">';
					// Display Image
					if($row['postImage'] != NULL) {
						echo '<a href="/post/'.$row['postSlug'].'" class="rb-card-link"><img class="rb-card-img" src="/'.$row['postImage'].'" onerror="this.src=&#39;/_res/images/missing/Placeholder-Image-1920x1080.png&#39;" alt="N/A"></a>';
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
							echo '<p><a href="/action/about" class="rb-card-link rb-text-opacity">Read More &gt;</a></p>';
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
			
			echo $pages->page_links();
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	?>
</div>
<!-- END   - Left Column: Blog Post Column -->