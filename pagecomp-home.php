<?php
// Get Post Data
$statement = $connection->prepare('
    SELECT
        pageID,
        pageTitle,
        pageContent,
        pageSlug
    FROM 
        blog_pages
    WHERE
        pageSlug = :pageSlug
');
$statement->execute(array(
    ':pageSlug' => 'home'
));
$row = $statement->fetch();
?>

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
				echo '<div>';
					echo '<h3><b>'.$row['pageTitle'].'</b></h3>';
				echo '</div>';
				echo '<div>';
					echo ''.$row['pageContent'].'';
				echo '</div>';
                
                echo '<hr/>';
                
                echo' <div id="disqus_thread"></div>';
                echo '<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>';
			echo '</div>';
		}
	?>
    
    <!-- View Timeline -->
	<div class="rb-nav-flex-grid">
		<div>
			<a href="/feed/" class="rb-button rb-button-border rb-padding-1rem-2rem rb-margin-2rem-left" style="margin-bottom: 0rem !important;"><b>View All Posts</b></a>
		</div>
		<div>
		</div>
	</div>
    
</div>
<!-- END   - Left Column: Blog Post Column -->