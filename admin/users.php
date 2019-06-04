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
	<link rel="icon" sizes="16x16" href="../_res/images/16x16-Logo.png">
	<link rel="icon" sizes="32x32" href="../_res/images/32x32-Logo.png">
	<link rel="icon" sizes="192x192" href="../_res/images/192x192-Logo.png">
	
	<link rel="stylesheet" href="../_res/styles/rb-engine.css">
	
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
<div id="rb-admin-container">
	<div class="rb-card" id="rb-admin-content">
	
	<?php
		// Display Menu
		include('menu.php');
		
		// Show Message From Add/Edit Page
		if(isset($_GET['action'])) {
			echo '<p>User '.$_GET['action'].'.</p>';
		}
	?>
	
	<!-- Table Containg Database Content -->
	<table>
		<tr>
			<th>Username</th>
			<th>Email</th>
			<th>Action</th>
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
					echo '<tr>';
						echo '<td>'.$row['memberUsername'].'</td>';
						echo '<td>'.$row['memberEmail'].'</td>';
						echo '<td>';
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

	<p><a href='add-user.php'>Add User</a></p>
	</div>
</div>
</body>
</html>
