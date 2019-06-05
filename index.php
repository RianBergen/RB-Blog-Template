<?php
// Include Config
require_once 'includes/config.php';

// Get Variables
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = NULL;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = NULL;
}

if (isset($_GET['month'])) {
    $month = $_GET['month'];
} else {
    $month = NULL;
}

if (isset($_GET['year'])) {
    $year = $_GET['year'];
} else {
    $year = NULL;
}
?>

<!-- HTML CODE -->
<!DOCTYPE html>
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
	
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	
    <title><?php echo ''.HTMLTITLE.'';?></title>
    <meta name="description" content=<?php echo '"'.HTMLDECRIPTION.'"';?>>
    <link rel="icon" sizes="16x16" href=<?php echo '"/_res/images/16x16-Logo.png"';?>>
    <link rel="icon" sizes="32x32" href=<?php echo '"/_res/images/32x32-Logo.png"';?>>
    <link rel="icon" sizes="192x192" href=<?php echo '"/_res/images/192x192-Logo.png"';?>>
    
    <link id="theme-style" rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.light.css" />
    <link rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.css">
</head>
<body>
<div class="rb-main-flex-grid-initializer">
	<div class="rb-main-flex-grid-container">
   
	<?php
		// Include Page Header
		include 'pagecomp-header.php';
		
		// Check Variables And Include The Left Column
		if ($page == NULL) {
			// View All Posts
			include 'pagecomp-posts.php';
		} else if ($page == 'post') {
            // View Selected Post
			include 'pagecomp-viewpost.php';
		} else if ($page == 'category') {
            // View All Posts In Selected Category
			include 'pagecomp-categories.php';
		} else if ($page == 'archive') {
            // View All Posts In Selected Archive
			include 'pagecomp-archives.php';
		} else if ($page == 'tag') {
            // View All Posts In Selected Tag
            include 'pagecomp-tags.php';
        } else if ($page == 'action') {
            // TO DO: MUST FINISH: Contact Pages, etc.
        } else if ($page == 'info') {
            // View Selected Information Page
            include 'pagecomp-info.php';
        }

		// Include Sidebar
        if ($page != 'info') {
            include 'pagecomp-sidebar.php';
        }
	?>
		
	</div>

<?php
	// Include Page Footer
	include 'pagecomp-footer.php';
?>

</div>

<!-- Disqus Comment Count -->
<?php
if ($page != 'post') {
    echo '<script id="dsq-count-scr" src="//'.DISQUS.'.disqus.com/count.js" async></script>';
}
?>
<script src="/_res/js/rb-theme-manager.js"></script>
</body>
</html>