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
	$statement = $connection->prepare('DELETE FROM blog_categories WHERE categoryID = :categoryID') ;
	$statement->execute(array(':categoryID' => $_GET['delcat']));
	
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
	
	<title>Rian Bergen - Category Admin Index</title>
	<meta name="description" content="The official home for everything related to Rian-Pascal Bergen!">
	<link rel="icon" sizes="16x16" href="../_res/images/16x16-Logo.png">
	<link rel="icon" sizes="32x32" href="../_res/images/32x32-Logo.png">
	<link rel="icon" sizes="192x192" href="../_res/images/192x192-Logo.png">
	
	<link rel="stylesheet" href="../_res/styles/rb-engine.css">
	
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
<div id="rb-admin-container">
	<div class="rb-card" id="rb-admin-content">
	
	<?php
		// Display Menu
		include('menu.php');
		
		// Show Message From Add/Edit Page
		if(isset($_GET['action'])){
			echo '<p>Category '.$_GET['action'].'.</p>';
		}
	?>
	
	<!-- Table Containg Database Content -->
	<table>
		<tr>
			<th>Title</th>
			<th>Action</th>
		</tr>
		
		<?php
			try {
				// Get SQL Data
				$stmt = $connection->query('SELECT categoryID, categoryTitle, categorySlug FROM blog_categories ORDER BY categoryTitle DESC');
				while($row = $stmt->fetch()) {
					echo '<tr>';
						echo '<td>'.$row['categoryTitle'].'</td>';
						echo '<td>';
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
	
	<p><a href='add-category.php'>Add Category</a></p>
	</div>
</div>
</body>
</html>