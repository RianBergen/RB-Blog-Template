<?php?>

<!-- START - Right Column: Navigation Column -->
<div class="rb-main-flex-grid-right-column">
	<!-- START - About Card -->
	<div class="rb-card">
		<!-- About Image -->
		<img class="rb-card-img" src="/_res/images/about/About-1920x1080.png" alt="N/A">
        
        <?php
        $stmt = $connection->prepare('
            SELECT
                pageTitle,
                pageContent
            FROM
                blog_pages
            WHERE
                pageTitle = :pageTitle
        ');
        $stmt->execute(array(
            ':pageTitle' => 'About'
        ));
        $row = $stmt->fetch();
        
        $string = explode(' </p>' , $row['pageContent']); //substr($row['pageContent'], 0, strpos($row['pageContent'], '</p>'));
        
		echo '<div>';
			echo $string[0];
            echo '<a href="/action/about" class="rb-button rb-button-border rb-padding-1rem-2rem"><b>READ MORE</b></a>';
		echo '</div>';
        ?>
	</div>
	<!-- END   - About Card -->
    
	<!-- START - Recent Posts -->
	<div class="rb-card">
		<div>
			<h3><b>Recent Posts</b></h3>
		</div>

		<hr/>

		<div class="rb-list">
			<?php
				$statement = $connection->query('
                    SELECT
                        postTitle,
                        postDate,
                        postSlug
                    FROM
                        blog_posts
                    ORDER BY
                        postID DESC LIMIT 5
                ');
				
                $increment = 1;
                
				while($row = $statement->fetch()){
					echo '<a href="/post/'.$row['postSlug'].'" class="rb-button rb-list-item">';
						echo '<img src="/_res/images/side/'.$increment.'.png" onerror="this.src=&#39;/_res/images/192x192-Logo.png&#39;" alt="N/A">';
						echo '<div class="rb-list-item-txt">';
							echo '<span class="rb-text-font-large">'.$row['postTitle'].'</span><br>';
							echo '<span>'.date('F d, Y', strtotime($row['postDate'])).'</span>';
						echo '</div>';
					echo '</a>';
                    
                    $increment = $increment + 1;
				}
			?>
		</div>
	</div>
	<!-- END   - Recent Posts -->

	<!-- START - Categories -->
	<div class="rb-card">
		<div>
			<h3><b>Categories</b></h3>
		</div>

		<hr/>

		<div>
			<p class="rb-link-tags-container">
				<a href="/" class="rb-text-black-tag">Back Home</a>
				
				<?php
					$statement = $connection->query('
                        SELECT
                            categoryTitle,
                            categorySlug
                        FROM
                            blog_categories
                        ORDER BY
                            categoryID DESC
                    ');
					while($row = $statement->fetch()){
						echo '<a href="/category/'.$row['categorySlug'].'" class="rb-text-grey-tag">'.$row['categoryTitle'].'</a>';
					}
				?>
			</p>
		</div>
	</div>
	<!-- END   - Categories -->
    
    <!-- START - Tags -->
	<div class="rb-card">
		<div>
			<h3><b>Tags</b></h3>
		</div>

		<hr/>

		<div>
			<p class="rb-link-tags-container">
				<a href="/" class="rb-text-black-tag">Back Home</a>
				
				<?php
                    $tagsArray = [];
                    $statement = $connection->query('
                        SELECT DISTINCT
                            LOWER(postTags) AS postTags
                        FROM
                            blog_posts
                        WHERE
                            postTags != ""
                        GROUP BY
                            postTags
                    ');
                    
                    while($row = $statement->fetch()){
                        $parts = explode(', ', $row['postTags']);
                        
                        foreach ($parts as $tag) {
                            $tagsArray[] = $tag;
                        }
                    }
                    
                    $finalTags = array_unique($tagsArray);
                    foreach ($finalTags as $tag) {
                        echo '<a href="/tag/'.$tag.'" class="rb-text-grey-tag">'.ucwords($tag).'</a>';
                    }
				?>
			</p>
		</div>
	</div>
    <!-- END   - Tags -->

	<!-- START - Archives -->
	<div class="rb-card">
		<div>
			<h3><b>Archives</b></h3>
		</div>

		<hr/>

		<div>
			<p class="rb-link-tags-container">
				<a href="/" class="rb-text-black-tag">Back Home</a>
				
				<?php
					$statement = $connection->query('
                        SELECT
                            Month(postDate) as Month,
                            Year(postDate) as Year
                        FROM
                            blog_posts
                        GROUP BY
                            Month(postDate),
                            Year(postDate)
                        ORDER BY
                            postDate DESC
                    ');
                    
					while($row = $statement->fetch()){
						$monthName = date("F Y", mktime(0, 0, 0, $row['Month'], 10));
						$slug = 'archive/'.$row['Month'].'-'.$row['Year'];
						echo '<a href="/'.$slug.'" class="rb-text-grey-tag">'.$monthName.'</a>';
					}
				?>
			</p>
		</div>
	</div>
	<!-- END   - Archives -->
</div>
<!-- END   - Right Column: Navigation Column -->