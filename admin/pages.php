<?php
// Include Config File
require_once('../includes/config.php');

// If Not Logged In, Redirect To Login Page
if(!$user->isLoggedIn()) {
	// Redirect To Login
	header('Location: login.php');
}

// Delete Post From Confirmation In Javascript Below
if(isset($_GET['delpage'])) {
	$statement = $connection->prepare('
        DELETE FROM
            blog_pages
        WHERE
            pageID = :pageID'
    );
	$statement->execute(array(':pageID' => $_GET['delpage']));
	
	header('Location: pages.php?action=deleted');
	exit;
}
?>
<!-- HTML CODE -->
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<title><?php echo ''.HTMLTITLE.'';?> - Pages Admin Index</title>
	<meta name="description" content=<?php echo '"'.HTMLDECRIPTION.'"';?>>
	<link rel="icon" sizes="16x16" href="/_res/images/16x16-Logo.png">
	<link rel="icon" sizes="32x32" href="/_res/images/32x32-Logo.png">
	<link rel="icon" sizes="192x192" href="/_res/images/192x192-Logo.png">
	
	<link id="theme-style" rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.<?php echo ''.ISDARKMODE.'';?>.css?v=<?php echo ''.CSSVERSION.'';?>">
    <link rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.css?v=<?php echo ''.CSSVERSION.'';?>">
    
    <meta name="theme-color" content="#242424">
	
	<script language="JavaScript" type="text/javascript">
		// Confirm Delete Post
		function delpage(id, title) {
			if (confirm("Are You Sure You Want To Delete '" + title + "'?")) {
				window.location.href = 'pages.php?delpage=' + id;
			}
		}
	</script>
</head>
<body class="rb-admin-body">
<div class="rb-admin-container">
	<div class="rb-card rb-admin-content">
        <h1>Pages</h1>
	<?php
		// Display Menu
		include('menu.php');
		
		// Show Message From Add/Edit Page
		if(isset($_GET['action'])){
			echo '<p>Page '.$_GET['action'].'.</p>';
		}
	?>
	
	<!-- Table Containg Database Content -->
    <div class="rb-admin-content-table-container">
        <table class="rb-admin-content-table" style="margin-bottom: 1rem;">
            <tr>
                <th class="rb-admin-content-table-header">Title</th>
                <th class="rb-admin-content-table-header">Action</th>
            </tr>
            
            <?php
                try {
                    // Get SQL Data
                    $statement = $connection->query('
                        SELECT
                            pageID,
                            pageTitle
                        FROM
                            blog_pages
                        ORDER BY
                            pageID DESC'
                    );
                    while($row = $statement->fetch()) {
                        echo '<tr class="rb-admin-content-table-row">';
                            echo '<td class="rb-admin-content-table-data">'.$row['pageTitle'].'</td>';
                            echo '<td class="rb-admin-content-table-data">';
                                ?>
                                <a href="edit-page.php?id=<?php echo $row['pageID'];?>">Edit</a>
                                <?php
                            echo '</td class="rb-admin-content-table-data">';
                        echo '</tr>';
                    }
                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
            ?>
        </table>
    </div>
	</div>
</div>

<?php
	// Include Page Footer
	include '../pagecomp-footer.php';
?>

<!-- Light/Dark Mode Manager -->
<script src="/_res/js/rb-theme-manager.js"></script>
</body>
</html>
