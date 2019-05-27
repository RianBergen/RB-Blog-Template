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
	
	<title>Rian Bergen - Edit Page</title>
	<meta name="description" content="The official home for everything related to Rian-Pascal Bergen!">
	<link rel="icon" sizes="16x16" href="../_res/images/16x16-Logo.png">
	<link rel="icon" sizes="32x32" href="../_res/images/32x32-Logo.png">
	<link rel="icon" sizes="192x192" href="../_res/images/192x192-Logo.png">
	
	<link rel="stylesheet" href="../_res/styles/rb-engine.css">
	
    <!-- TinyMCE Initialization Script -->
	<?php echo '<script src="'.TINYMCE.'"></script>';?>
	<script>
		tinymce.init({
			selector: "textarea",
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table paste"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            height : "500px"
		});
	</script>
</head>
<body>
<div id="rb-admin-container">
	<div class="rb-card" id="rb-admin-content">
	
	<?php
		// Display Menu
		include('menu.php');
	?>
	
	<!-- Admin Page Link -->
	<p><a href="pages.php">Go Back</a></p>
	<h2>Edit Page</h2>
	<?php
		// Process Submitted Form
		if(isset($_POST['submit'])) {
			// Collect Form Data
			extract($_POST);
			
			// Very Basic Vallidation
			if($pageID == '' ){
				$error[] = 'Invalid ID';
			}
		
			if($pageTitle == '') {
				$error[] = 'Please Enter A Title';
			}
            
			if($pageContent == '') {
				$error[] = 'Please Enter The Content';
			}
            
            // Form Handling
			if(!isset($error)) {
				try {
					// Create Post Slug
					$pageSlug = createCategorySlug($pageTitle);
					
					// Insert Data Into Database
					$stmt = $connection->prepare('UPDATE blog_pages SET pageTitle = :pageTitle, pageSlug = :pageSlug, pageContent = :pageContent WHERE pageID = :pageID') ;
					$stmt->execute(array(
						':pageID' => $pageID,
						':pageTitle' => $pageTitle,
						':pageSlug' => $pageSlug,
						':pageContent' => $pageContent
					));
					
					// Redirect To Admin Page
					header('Location: pages.php?action=updated');
					exit;
				} catch(PDOException $e) {
					echo $e->getMessage();
				}
			}
		}
		
		// Check For Errors
		if(isset($error)) {
			foreach($error as $error) {
				echo '<p class="rb-error">'.$error.'</p>';
			}
		}
		
		try {
			$stmt = $connection->prepare('SELECT pageID, pageTitle, pageContent FROM blog_pages WHERE pageID = :pageID') ;
			$stmt->execute(array(':pageID' => $_GET['id']));
			$row = $stmt->fetch(); 
		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	
	<!-- Edit Post Form -->
	<form action='' method='post'>
		<input type='hidden' name='pageID' value='<?php echo $row['pageID'];?>'>

		<p><label>Title</label><br />
		<input type='text' name='pageTitle' value='<?php echo $row['pageTitle'];?>'></p>
        
		<p><label>Content</label><br />
		<textarea name='pageContent' cols='60' rows='10'><?php echo $row['pageContent'];?></textarea></p>
        
		<p><input type='submit' name='submit' value='Submit'></p>
		
	</form>
	</div>
</div>
</body>
</html>