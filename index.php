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
	
    <title>Rian Bergen</title>
    <meta name="description" content="The official home for everything related to Rian-Pascal Bergen!">
    <link rel="icon" sizes="16x16" href=<?php echo '"'.DIR.'_res/images/16x16-Logo.png"';?>>
    <link rel="icon" sizes="32x32" href=<?php echo '"'.DIR.'_res/images/32x32-Logo.png"';?>>
    <link rel="icon" sizes="192x192" href=<?php echo '"'.DIR.'_res/images/192x192-Logo.png"';?>>
    
    <link rel="stylesheet" type="text/css" onload="this.media='all'" href=<?php echo '"'.DIR.'_res/styles/rb-engine.css"';?>>
</head>
<body>
<div class="rb-main-flex-grid-initializer">
	<div class="rb-main-flex-grid-container">
    
	<?php
		// Include Page Header
		include 'pagecomp-header.php';
		
		// Check Variables And Include The Left Column
		if ($page == NULL) {
			// Inlclude Posts
			include 'pagecomp-posts.php';
		} else if ($page == 'post') {
			include 'pagecomp-viewpost.php';
		} else if ($page == 'category') {
			include 'pagecomp-categories.php';
		} else if ($page == 'archive') {
			include 'pagecomp-archives.php';
		} else if ($page == 'tag') {
            include 'pagecomp-tags.php';
        } else if ($page == 'action') {
            // TO DO: MUST FINISH
        } else if ($page == 'info') {
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

<?php
// Disqus Comment Count
if ($page != 'post') {
    echo '<script id="dsq-count-scr" src="//rianbergen.disqus.com/count.js" async></script>';
}
?>
</body>
</html>