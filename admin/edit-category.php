<?php
// Include Config File
require_once('../includes/config.php');

// If Not Logged In, Redirect To Login Page
if(!$user->isLoggedIn()) {
	// Redirect To Login
	header('Location: login.php');
}
?>

<!-- HTML CODE -->
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<title><?php echo ''.HTMLTITLE.'';?> - Edit Category</title>
	<meta name="description" content=<?php echo '"'.HTMLDECRIPTION.'"';?>>
	<link rel="icon" sizes="16x16" href="/_res/images/16x16-Logo.png">
	<link rel="icon" sizes="32x32" href="/_res/images/32x32-Logo.png">
	<link rel="icon" sizes="192x192" href="/_res/images/192x192-Logo.png">
	
	<link rel="stylesheet" href="/_res/styles/rb-engine.css">
</head>
<body>
<div id="rb-admin-container">
	<div class="rb-card" id="rb-admin-content">
	
	<?php
		// Display Menu
		include('menu.php');
	?>
	
	<!-- Admin Page Link -->
	<p><a href="categories.php">Go Back</a></p>
	<h2>Edit Category</h2>
	
	<?php
		// Process Submitted Form
		if(isset($_POST['submit'])) {
			// Collect Form Data
			extract($_POST);
			
			// Very Basic Validation
			if($categoryID == '' ){
				$error[] = 'Invalid ID';
			}
			
			if($categoryTitle == '') {
				$error[] = 'Please Enter The Category';
			}
			
			if(!isset($error)) {
				try {
					// Create Category Slug
					$categorySlug = createCategorySlug($categoryTitle);
					
					$stmt = $connection->prepare('
                        UPDATE
                            blog_categories
                        SET
                            categoryTitle = :categoryTitle,
                            categorySlug = :categorySlug
                        WHERE
                            categoryID = :categoryID
                    ');
					$stmt->execute(array(
						':categoryTitle' => $categoryTitle,
						':categorySlug' => $categorySlug,
						':categoryID' => $categoryID
					));
					
					// Redirect To Admin Page
					header('Location: categories.php?action=updated');
					exit;
				} catch(PDOException $e) {
					echo $e->getMessage();
				}
			}
		}
		
		// Check For Any Errors
		if(isset($error)) {
			foreach($error as $error) {
				echo '<p class="rb-error">'.$error.'</p>';
			}
		}
		
		// Retrieve Data
		try {
			$stmt = $connection->prepare('
                SELECT
                    categoryID,
                    categoryTitle
                FROM
                    blog_categories
                WHERE
                    categoryID = :categoryID
            ');
			$stmt->execute(array(':categoryID' => $_GET['id']));
			$row = $stmt->fetch(); 
		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	
	<!-- Edit Category Form -->
	<form action='' method='post'>
		<input type='hidden' name='categoryID' value='<?php echo $row['categoryID'];?>'>

		<p><label>Title</label><br />
		<input type='text' name='categoryTitle' value='<?php echo $row['categoryTitle'];?>'></p>

		<p><input type='submit' name='submit' value='Update'></p>
	</form>
	</div>
</div>
</body>
</html>