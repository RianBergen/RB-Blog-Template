<?php
// Get Post Data
if ($id != NULL) {
	$statement = $connection->prepare('
        SELECT
            pageID,
            pageTitle,
            pageContent,
            pageSlug
        FROM
            blog_pages
        WHERE
            pageSlug = :pageSlug'
    );
	$statement->execute(array(
        ':pageSlug' => $id
    ));
	$row = $statement->fetch();
}
?>

<!-- START - Left Column: Blog Post Column -->
<div class="rb-main-flex-grid-left-column"  style="width: 100%;">
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
		if($row['pageID'] == "") {
			// Card
			echo '<div class="rb-card" style="width: 100%;">';
				echo '<div>';
					echo '<h3><b>Page Was Not Found, Or Is Empty!</b></h3>';
				echo '</div>';
				echo '<div>';
					echo '<p>Please type in a different URL, or select a different Page.</p>';
				echo '</div>';
			echo '</div>';
		} else {
			echo '<div class="rb-card">';
				echo '<div>';
					echo ''.$row['pageContent'].'';
				echo '</div>';
                
                echo '<hr/>';
			echo '</div>';
		}
	?>
</div>
<!-- END   - Left Column: Blog Post Column -->