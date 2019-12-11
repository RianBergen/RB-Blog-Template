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
            pageSlug = :pageSlug
    ');
	$statement->execute(array(
        ':pageSlug' => $id
    ));
	$row = $statement->fetch();
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
    
<!-- DISQUS COMMENTS -->
<script>
    /**
     *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT 
     *  THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR 
     *  PLATFORM OR CMS.
     *  
     *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: 
     *  https://disqus.com/admin/universalcode/#configuration-variables
     */
    
    var disqus_config = function () {
        // Replace PAGE_URL with your page's canonical URL variable
        <?php echo 'this.page.url = "/page/'.$id.'";';?>
        
        // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        <?php echo 'this.page.identifier = '.$row["pageID"].';';?>
    };
    
    
    (function() {    // REQUIRED CONFIGURATION VARIABLE: EDIT THE SHORTNAME BELOW
        var d = document, s = d.createElement('script');
        
        // IMPORTANT: Replace EXAMPLE with your forum shortname!
        <?php echo 's.src = "https://'.DISQUS.'.disqus.com/embed.js";';?>
        
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();
</script>
</div>
<!-- END   - Left Column: Blog Post Column -->