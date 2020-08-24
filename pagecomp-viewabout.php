<?php
// Get Post Data
if ($id != NULL) {
	$statement = $connection->prepare('
        SELECT
            pageID,
            pageTitle,
            pageContent,
			pageSlug,
			pageImage
        FROM 
            blog_pages
        WHERE
            pageSlug = :pageSlug
    ');
	$statement->execute(array(
        ':pageSlug' => $id
    ));
	$row = $statement->fetch();
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
		if($row['pageTitle'] == "") {
			// Card
			echo '<div class="rb-card">';
				echo '<div>';
					echo '<h3><b>Page Was Not Found, Or Is Empty!</b></h3>';
				echo '</div>';
				echo '<div>';
					echo '<p>Please type in a different URL, or select a different Page.</p>';
				echo '</div>';
			echo '</div>';
		} else {
			echo '<div class="rb-card">';

				// About Image
				echo '<!-- About Image -->';
				if($row['pageImage'] != NULL) {
					$stmt2 = $connection->query('
						SELECT
							imageID,
							imageTitle,
							imagePath
						FROM
							blog_images
						WHERE
							imageID = '.$row['pageImage']
					);

					$stmt2->execute(array());
					$row2 = $stmt2->fetch();

					echo '<img class="rb-card-img" title="'.$row2['imageTitle'].'" src="/'.$row2['imagePath'].'?v='.CSSVERSION.'" onerror="this.src=&#39;/_res/images/missing/Placeholder-Image-1920x1080.png&#39;" alt="N/A">';
				}
			
				echo '<div>';
					echo '<h3><b>'.$row['pageTitle'].'</b></h3>';
				echo '</div>';
				echo '<div>';
					echo str_replace('[END OF DESCRIPTION]', ' ', $row['pageContent']);
				echo '</div>';
                
                echo '<hr/>';
			echo '</div>';
		}
	?>
</div>
<!-- END   - Left Column: Blog Post Column -->