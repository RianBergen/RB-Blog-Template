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
	
	<title>Rian Bergen - Add Post</title>
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
	<h2>Add Page</h2>
	
	<?php
		// Process Submitted Form
		if(isset($_POST['submit'])) {
			// Collect Form Data
			extract($_POST);
			
			// Very Basic Vallidation
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
					$stmt = $connection->prepare('INSERT INTO blog_pages (pageTitle, pageSlug, pageContent) VALUES (:pageTitle, :pageSlug, :pageContent)') ;
					$stmt->execute(array(
						':pageTitle' => $pageTitle,
						':pageSlug' => $pageSlug,
						':pageContent' => $pageContent
					));
					
					$postID = $connection->lastInsertId();
					
					// Redirect To Admin Page
					header('Location: pages.php?action=added');
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
	
	<!-- Add Post Form -->
	<form action='' method='post' enctype="multipart/form-data">
		<p><label>Title</label><br />
		<input type='text' name='pageTitle' value='<?php if(isset($error)){echo $_POST['pageTitle'];}?>'></p>
        
		<p><label>Content</label><br />
		<textarea name='pageContent' cols='60' rows='10'><?php if(isset($error)){echo $_POST['pageContent'];}?></textarea></p>
        
		<p><input type='submit' name='submit' value='Submit'></p>
	</form>
	</div>
</div>
</body>
</html>