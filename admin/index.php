<?php
// Include Config File
require_once('../includes/config.php');

// If Not Logged In, Redirect To Login Page
if(!$user->isLoggedIn()) {
	// Redirect To Login
	header('Location: login.php');
}

// Delete Post From Confirmation In Javascript Below
if(isset($_GET['delpost'])) {
	$statement = $connection->prepare('
        DELETE FROM
            blog_posts
        WHERE
            postID = :postID
    ');
	$statement->execute(array(
        ':postID' => $_GET['delpost'])
    );
	
	header('Location: index.php?action=deleted');
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
	
	<title><?php echo ''.HTMLTITLE.'';?> - Post Admin Index</title>
	<meta name="description" content=<?php echo '"'.HTMLDECRIPTION.'"';?>>
	<link rel="icon" sizes="16x16" href="/_res/images/16x16-Logo.png">
	<link rel="icon" sizes="32x32" href="/_res/images/32x32-Logo.png">
	<link rel="icon" sizes="192x192" href="/_res/images/192x192-Logo.png">
	
	<link rel="stylesheet" href="/_res/styles/rb-engine.css">
	
	<script language="JavaScript" type="text/javascript">
		// Confirm Delete Post
		function delpost(id, title) {
			if (confirm("Are You Sure You Want To Delete '" + title + "'?")) {
				window.location.href = 'index.php?delpost=' + id;
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
			echo '<p>Post '.$_GET['action'].'.</p>';
		}
	?>
	
	<!-- Table Containg Database Content -->
	<table>
		<tr>
			<th>Title</th>
			<th>Date</th>
			<th>Action</th>
		</tr>
		
		<?php
			try {
				// Get SQL Data
				$statement = $connection->query('
                    SELECT
                        postID,
                        postTitle,
                        postDate
                    FROM
                        blog_posts
                    ORDER BY
                        postID DESC
                ');
				while($row = $statement->fetch()) {
					echo '<tr>';
						echo '<td>'.$row['postTitle'].'</td>';
						echo '<td>'.date('M d, Y', strtotime($row['postDate'])).'</td>';
						echo '<td>';
							?>
							<a href="edit-post.php?id=<?php echo $row['postID'];?>">Edit</a> | 
							<a href="javascript:delpost('<?php echo $row['postID'];?>','<?php echo $row['postTitle'];?>')">Delete</a>
							<?php
						echo '</td>';
					echo '</tr>';
				}
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
		?>
	</table>
	
	<p><a href='add-post.php'>Add Post</a></p>
	</div>
</div>
</body>
</html>
