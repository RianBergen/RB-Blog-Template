<?php
// Include Config File
require_once('../includes/config.php');

// If Not Logged In, Redirect To Login Page
if(!$user->isLoggedIn()) {
	// Redirect To Login
	header('Location: login.php');
}

// Delete User From Confirmation In Javascript Below
if(isset($_GET['deluser'])) {
	if($_GET['deluser'] != '1') {
		$statement = $connection->prepare('
            DELETE FROM
                blog_members
            WHERE
                memberID = :memberID'
        );
		$statement->execute(array(':memberID' => $_GET['deluser']));
		
		header('Location: users.php?action=deleted');
		exit;
	}
}
?>
<!-- HTML CODE -->
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<title><?php echo ''.HTMLTITLE.'';?> - User Admin Index</title>
	<meta name="description" content=<?php echo '"'.HTMLDECRIPTION.'"';?>>
	<link rel="icon" sizes="16x16" href="/_res/images/16x16-Logo.png">
	<link rel="icon" sizes="32x32" href="/_res/images/32x32-Logo.png">
	<link rel="icon" sizes="192x192" href="/_res/images/192x192-Logo.png">
	
	<link id="theme-style" rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.light.css?v=<?php echo ''.CSSVERSION.'';?>">
    <link rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.css?v=<?php echo ''.CSSVERSION.'';?>">
    
    <meta name="theme-color" content="#242424">
	
	<script language="JavaScript" type="text/javascript">
		// Confirm Delete User
		function deluser(id, title) {
			if (confirm("Are You Sure You Want To Delete '" + title + "'?")) {
				window.location.href = 'users.php?deluser=' + id;
			}
		}
	</script>
</head>
<body>
<div class="rb-admin-container">
	<div class="rb-card rb-admin-content">
        <h1>Users</h1>
	<?php
		// Display Menu
		include('menu.php');
		
		// Show Message From Add/Edit Page
		if(isset($_GET['action'])) {
			echo '<p>User '.$_GET['action'].'.</p>';
		}
	?>
	
	<!-- Table Containg Database Content -->
    <div class="rb-admin-content-table-container">
        <table class="rb-admin-content-table">
            <tr>
                <th class="rb-admin-content-table-header">Username</th>
                <th class="rb-admin-content-table-header rb-admin-content-table-data-hidden">Email</th>
                <th class="rb-admin-content-table-header">Action</th>
            </tr>
            
            <?php
                try {
                    // Get SQL Data
                    $statement = $connection->query('
                        SELECT
                            memberID,
                            memberUsername,
                            memberEmail
                        FROM
                            blog_members
                        ORDER BY
                            memberUsername'
                    );
                    while($row = $statement->fetch()){
                        echo '<tr class="rb-admin-content-table-row">';
                            echo '<td class="rb-admin-content-table-data">'.$row['memberUsername'].'</td>';
                            echo '<td class="rb-admin-content-table-data rb-admin-content-table-data-hidden">'.$row['memberEmail'].'</td>';
                            echo '<td class="rb-admin-content-table-data">';
                                ?>
                                <a href="edit-user.php?id=<?php echo $row['memberID'];?>">Edit</a> | 
                                <a href="javascript:deluser('<?php echo $row['memberID'];?>','<?php echo $row['memberUsername'];?>')">Delete</a>
                                <?php
                            echo '</td>';
                        echo '</tr>';
                    }
                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
            ?>
        </table>
    </div>
	<p><a href='add-user.php'>Add User</a></p>
	</div>
</div>

<!-- Light/Dark Mode Manager -->
<script src="/_res/js/rb-theme-manager.js"></script>
</body>
</html>
