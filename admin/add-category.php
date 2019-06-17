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
	
	<title><?php echo ''.HTMLTITLE.'';?> - Add Category</title>
	<meta name="description" content=<?php echo '"'.HTMLDECRIPTION.'"';?>>
	<link rel="icon" sizes="16x16" href="/_res/images/16x16-Logo.png">
	<link rel="icon" sizes="32x32" href="/_res/images/32x32-Logo.png">
	<link rel="icon" sizes="192x192" href="/_res/images/192x192-Logo.png">
	
	<link id="theme-style" rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.light.css?v=<?php echo ''.CSSVERSION.'';?>">
    <link rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.css?v=<?php echo ''.CSSVERSION.'';?>">
    
    <meta name="theme-color" content="#242424">
</head>
<body>
<div class="rb-admin-container">
	<div class="rb-card rb-admin-content">
    
	<!-- Admin Page Link -->
	<p><a href="categories.php">Go Back</a></p>
	<h2>Add Category</h2>
	
	<?php
		// Process Submitted Form
		if(isset($_POST['submit'])) {
			// Collect Form Data
			extract($_POST);
			
			// Very Basic Validation
			if($categoryTitle == '') {
				$error[] = 'Please Enter The Category';
			}
			
			if(!isset($error)) {
				try {
					// Create Category Slug
					$categorySlug = createCategorySlug($categoryTitle);
					
					// Insert Data Into Database
					$stmt = $connection->prepare('
                        INSERT INTO
                            blog_categories (categoryTitle, categorySlug)
                        VALUES
                            (:categoryTitle, :categorySlug)
                    ');
					$stmt->execute(array(
                        ':categoryTitle' => $categoryTitle,
                        ':categorySlug' => $categorySlug)
                    );
					
					// Redirect To Admin Page
					header('Location: categories.php?action=added');
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
	?>
	
	<!-- Add Category Form -->
	<form action='' method='post'>
		<p><label>Title</label><br/>
		<input type='text' name='categoryTitle' value='<?php if(isset($error)){echo $_POST['categoryTitle'];}?>'></p>
		
		<p><input type='submit' name='submit' value='Submit'></p>
	</form>
	</div>
</div>

<!-- Light/Dark Mode Manager -->
<script src="/_res/js/rb-theme-manager.js"></script>
</body>
</html>