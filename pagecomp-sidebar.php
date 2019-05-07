<!-- START - Right Column: Navigation Column -->
<div class="rb-main-flex-grid-right-column">
	<!-- START - About Card -->
	<div class="rb-card">
		<!-- About Image -->
		<img class="rb-card-img" src=<?php echo '"'.DIR.'_res/images/about/About-1920x1080.png"';?> alt="N/A">

		<div>
			<h3><b>Rian-Pascal Bergen</b></h3>
			<p>Just a guy with a variety of interests. I like camping, hiking, kayaking, reading, learning new things, and many more things. I have been all over Europe and the United States of America, and would love to travel the world. My current goals are hiking the Appalachian (and Pacific Crest), learning 2 new languages, and "building a foundation".<br /><br />This blog will contain some of my everyday thoughts as well as documenting my journey in achieving some of those goals.</p>
		</div>
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
				$statement = $connection->query('SELECT postTitle, postDate, postSlug FROM blog_posts ORDER BY postID DESC LIMIT 5');
				
                $increment = 1;
                
				while($row = $statement->fetch()){
					echo '<a href="'.DIR.'post/'.$row['postSlug'].'" class="rb-button rb-list-item">';
						echo '<img src="'.DIR.'/_res/images/side/'.$increment.'.png" onerror="this.src=&#39;'.DIR.'_res/images/192x192-Logo.png&#39;" alt="N/A">';
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
				<a href=<?php echo '"'.DIR.'"'?> class="rb-text-black-tag">Back Home</a>
				
				<?php
					$statement = $connection->query('SELECT categoryTitle, categorySlug FROM blog_categories ORDER BY categoryID DESC');
					while($row = $statement->fetch()){
						echo '<a href="'.DIR.'category/'.$row['categorySlug'].'" class="rb-text-grey-tag">'.$row['categoryTitle'].'</a>';
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
				<a href=<?php echo '"'.DIR.'"'?> class="rb-text-black-tag">Back Home</a>
				
				<?php
                    $tagsArray = [];
                    $statement = $connection->query('select distinct LOWER(postTags) as postTags from blog_posts where postTags != "" group by postTags');
                    
                    while($row = $statement->fetch()){
                        $parts = explode(',', $row['postTags']);
                        
                        foreach ($parts as $tag) {
                            $tagsArray[] = $tag;
                        }
                    }
                    
                    $finalTags = array_unique($tagsArray);
                    foreach ($finalTags as $tag) {
                        echo '<a href="'.DIR.'tag/'.$tag.'" class="rb-text-grey-tag">'.ucwords($tag).'</a>';
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
				<a href=<?php echo '"'.DIR.'"'?> class="rb-text-black-tag">Back Home</a>
				
				<?php
					$statement = $connection->query('SELECT Month(postDate) as Month, Year(postDate) as Year FROM blog_posts GROUP BY Month(postDate), Year(postDate) ORDER BY postDate DESC');
					while($row = $statement->fetch()){
						$monthName = date("F Y", mktime(0, 0, 0, $row['Month'], 10));
						$slug = 'archive/'.$row['Month'].'-'.$row['Year'];
						echo '<a href="'.DIR.''.$slug.'" class="rb-text-grey-tag">'.$monthName.'</a>';
					}
				?>
			</p>
		</div>
	</div>
	<!-- END   - Archives -->
</div>
<!-- END   - Right Column: Navigation Column -->