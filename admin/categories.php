<?php
// Include Config File
require_once('../includes/config.php');

// If Not Logged In, Redirect To Login Page
if(!$user->isLoggedIn()) {
	// Redirect To Login
	header('Location: login.php');
}

// Delete Category From Confirmation In Javascript Below
if(isset($_GET['delcat'])) { 
	$statement = $connection->prepare('
        DELETE FROM
            blog_categories
        WHERE
            categoryID = :categoryID
    ');
	$statement->execute(array(
        ':categoryID' => $_GET['delcat'])
    );
	
	header('Location: categories.php?action=deleted');
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
	
	<title><?php echo ''.HTMLTITLE.'';?> - Category Admin Index</title>
	<meta name="description" content=<?php echo '"'.HTMLDECRIPTION.'"';?>>
	<link rel="icon" sizes="16x16" href="/_res/images/16x16-Logo.png">
	<link rel="icon" sizes="32x32" href="/_res/images/32x32-Logo.png">
	<link rel="icon" sizes="192x192" href="/_res/images/192x192-Logo.png">
	
	<link id="theme-style" rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.light.css">
    <link rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.css">
	
	<script language="JavaScript" type="text/javascript">
		// Confirm Delete Category
		function delcat(id, title) {
			if (confirm("Are You Sure You Want To Delete '" + title + "'?")) {
				window.location.href = 'categories.php?delcat=' + id;
			}
		}
	</script>
</head>
<body>
<div class="rb-admin-container">
	<div class="rb-card rb-admin-content">
        <h1>Categories</h1>
	<?php
		// Display Menu
		include('menu.php');
		
		// Show Message From Add/Edit Page
		if(isset($_GET['action'])){
			echo '<p>Category '.$_GET['action'].'.</p>';
		}
	?>
	
	<!-- Table Containg Database Content -->
    <div class="rb-admin-content-table-container">
        <table class="rb-admin-content-table">
            <tr>
                <th class="rb-admin-content-table-header">Title</th>
                <th class="rb-admin-content-table-header">Action</th>
            </tr>
            
            <?php
                try {
                    // Get SQL Data
                    $stmt = $connection->query('
                        SELECT
                            categoryID,
                            categoryTitle,
                            categorySlug
                        FROM
                            blog_categories
                        ORDER BY
                            categoryTitle DESC
                    ');
                    while($row = $stmt->fetch()) {
                        echo '<tr class="rb-admin-content-table-row">';
                            echo '<td class="rb-admin-content-table-data">'.$row['categoryTitle'].'</td>';
                            echo '<td class="rb-admin-content-table-data">';
                                ?>
                                <a href="edit-category.php?id=<?php echo $row['categoryID'];?>">Edit</a> | 
                                <a href="javascript:delcat('<?php echo $row['categoryID'];?>','<?php echo $row['categorySlug'];?>')">Delete</a>
                                <?php
                            echo '</td>';
                        echo '</tr>';
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            ?>
        </table>
    </div>
	
	<p><a href='add-category.php'>Add Category</a></p>
	</div>
</div>

<!-- Light/Dark Mode Manager -->
<script src="/_res/js/rb-theme-manager.js"></script>
</body>
</html>