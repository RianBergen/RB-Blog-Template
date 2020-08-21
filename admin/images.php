<?php
// Include Config File
require_once('../includes/config.php');

// If Not Logged In, Redirect To Login Page
if(!$user->isLoggedIn()) {
	// Redirect To Login
	header('Location: login.php');
}

// Delete Image Form Confirmation In Javascript Below
if(isset($_GET['delimage'])) {
    try {
        // Retrieve Image Path
        $stmt = $connection->prepare('
            SELECT
                imagePath
            FROM
                blog_images
            WHERE
                imageID = :imageID
        ');
        $stmt->execute(array(
            ':imageID' => $_GET['delimage']
        ));
        $row = $stmt->fetch(); 

        // Delete Image
        unlink('../'.$row['imagePath']);

        // Remove Image Database Entry
        $statement = $connection->prepare('
            DELETE FROM
                blog_images
            WHERE
                imageID = :imageID'
        );
	    $statement->execute(array(':imageID' => $_GET['delimage']));
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

	//header('Location: images.php?action=deleted');
	//exit;
}
?>
<!-- HTML CODE -->
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<title><?php echo ''.HTMLTITLE.'';?> - Images Admin Index</title>
	<meta name="description" content=<?php echo '"'.HTMLDECRIPTION.'"';?>>
	<link rel="icon" sizes="16x16" href="/_res/images/16x16-Logo.png">
	<link rel="icon" sizes="32x32" href="/_res/images/32x32-Logo.png">
	<link rel="icon" sizes="192x192" href="/_res/images/192x192-Logo.png">
	
	<link id="theme-style" rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.<?php echo ''.ISDARKMODE.'';?>.css?v=<?php echo ''.CSSVERSION.'';?>">
    <link rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.css?v=<?php echo ''.CSSVERSION.'';?>">
    
    <meta name="theme-color" content="#242424">
	
	<script language="JavaScript" type="text/javascript">
		// Confirm Delete Image
		function delimage(id, title) {
			if (confirm("Are You Sure You Want To Delete '" + title + "'?")) {
				window.location.href = 'images.php?delimage=' + id;
			}
		}
	</script>
</head>
<body class="rb-admin-body">
<div class="rb-admin-container">
	<div class="rb-card rb-admin-content">
        <h1>Images</h1>
	<?php
		// Display Menu
		include('menu.php');
		
		// Show Message From Add/Edit Image
		if(isset($_GET['action'])){
			echo '<p>Image '.$_GET['action'].'.</p>';
		}
	?>
	
	<!-- Table Containg Database Content -->
    <div class="rb-admin-content-table-container">
        <table class="rb-admin-content-table" style="margin-bottom: 1rem;">
            <tr>
                <th class="rb-admin-content-table-header">Preview</th>
                <th class="rb-admin-content-table-header">Title</th>
                <th class="rb-admin-content-table-header">Path</th>
                <th class="rb-admin-content-table-header">Action</th>
            </tr>
            
            <?php
                try {
                    // Get SQL Data
                    $statement = $connection->query('
                        SELECT
                            imageID,
                            imageTitle,
                            imagePath
                        FROM
                            blog_images
                        ORDER BY
                            imageID DESC'
                    );
                    while($row = $statement->fetch()) {
                        echo '<tr class="rb-admin-content-table-row">';
                            echo '<td width="150" class="rb-admin-content-table-data"><img src="../'.$row['imagePath'].'" alt="'.$row['imageTitle'].'" width="100%"></td>';
                            echo '<td class="rb-admin-content-table-data">'.$row['imageTitle'].'</td>';
                            echo '<td class="rb-admin-content-table-data">'.$row['imagePath'].'</td>';
                            echo '<td class="rb-admin-content-table-data">';
                                ?>
                                <a href="edit-image.php?id=<?php echo $row['imageID'];?>">Edit</a> | 
                                <a href="javascript:delimage('<?php echo $row['imageID'];?>','<?php echo $row['imageTitle'];?>')">Delete</a>
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

    <p><a href='add-image.php'>Add Image</a></p>
	</div>
</div>

<?php
	// Include Page Footer
	include '../pagecomp-footer.php';
?>

<!-- Light/Dark Mode Manager -->
<script src="../_res/js/rb-theme-manager.js?v=<?php echo ''.CSSVERSION.'';?>"></script>
</body>
</html>
