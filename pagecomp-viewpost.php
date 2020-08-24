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
			postTags,
			postComments
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

    <!-- Home Button -->
	<div class="rb-nav-flex-grid">
		<div>
			<a href="/" class="rb-button rb-button-border rb-padding-1rem-2rem rb-margin-2rem-left" style="margin-bottom: 0rem !important; margin-top: 2rem;"><b>Home</b></a>
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

					echo '<img class="rb-card-img" title="'.$row2['imageTitle'].'" src="/'.$row2['imagePath'].'?v='.CSSVERSION.'" onerror="this.src=&#39;/_res/images/missing/Placeholder-Image-1920x1080.png&#39;" alt="N/A">';
				}

				echo '<div>';
					// Display Title and Date
					echo '<h3 class="rb-card-title"><b>'.$row['postTitle'].'</b></h3>';
					echo '<h5 class="rb-card-date"><span class="rb-text-opacity">'.date('F d, Y', strtotime($row['postDate'])).'</span></h5>';

					// Display Content
            		echo '<div>';
						echo str_replace('[END OF DESCRIPTION]', ' ', $row['postContent']);
        			echo '</div>';
				echo '</div>';

				if($row['postComments'] == 1) {
					echo '<div class="rb-card-footer rb-card-footer-comment_separator">';
				} else {
					echo '<div class="rb-card-footer">';
				}
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
				if($row['postComments'] == 1) {
					// HashOver Comments
                	echo' <div id="hashover"></div>';
					echo '<noscript>Please enable JavaScript to view the <a href="https://www.barkdull.org/software/hashover">comments powered by HashOver.</a></noscript>';
					echo '<script type="text/javascript" src="/hashover/comments.php?v='.CSSVERSION.'"></script>';
				}
			echo '</div>';
		}
	
echo '</div>';
echo '<!-- END   - Left Column: Blog Post Column -->';
?>