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
	
	<title><?php echo ''.HTMLTITLE.'';?> - Edit Image</title>
	<meta name="description" content=<?php echo '"'.HTMLDECRIPTION.'"';?>>
	<link rel="icon" sizes="16x16" href="/_res/images/16x16-Logo.png">
	<link rel="icon" sizes="32x32" href="/_res/images/32x32-Logo.png">
	<link rel="icon" sizes="192x192" href="/_res/images/192x192-Logo.png">
	
	<link id="theme-style" rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.<?php echo ''.ISDARKMODE.'';?>.css?v=<?php echo ''.CSSVERSION.'';?>">
    <link rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.css?v=<?php echo ''.CSSVERSION.'';?>">
    
    <meta name="theme-color" content="#242424">
	
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
<body class="rb-admin-body">
<div class="rb-admin-container">
	<div class="rb-card rb-admin-content">
    
	<!-- Admin Page Link -->
	<p><a href="images.php">Go Back</a></p>
	<h2>Edit Image</h2>
	<?php
		// Process Submitted Form
		if(isset($_POST['submit'])) {
			// Collect Form Data
			extract($_POST);
			
			// Very Basic Vallidation
			if($imageTitle == '') {
				$error[] = 'Please Enter A Title';
			}
            
			// Form Handling
			if(!isset($error)) {
				try {
                    // Update Data
					$stmt = $connection->prepare('
                        UPDATE
                            blog_images
                        SET
                            imageTitle = :imageTitle
                        WHERE
                            imageID = :imageID
                    ');
                    $stmt->execute(array(
                        ':imageID' => $imageID,
                        ':imageTitle' => $imageTitle
                    ));

                    // Redirect To Admin Page
				    header('Location: images.php?action=updated');
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
        
        // Load Current Database
		try {
			$stmt = $connection->prepare('
                SELECT
                    imageID,
                    imageTitle,
                    imagePath
                FROM
                    blog_images
                WHERE
                    imageID = :imageID
            ');
			$stmt->execute(array(
                ':imageID' => $_GET['id']
            ));
			$row = $stmt->fetch(); 
		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	
	<!-- Edit Image Form -->
	<form action='' method='post'>
		<input type='hidden' name='imageID' value='<?php echo $row['imageID'];?>'>

        <!-- Display Image -->
        <p><img src="../<?php echo $row['imagePath'];?>" alt="<?php echo $row['imageTitle'];?>" width="500"></p>

        <!-- Edit Title -->
		<p><label>Title</label><br />
		<input type='text' name='imageTitle' value='<?php echo $row['imageTitle'];?>'></p>

		<p><input type='submit' name='submit' value='Submit'></p>
		
	</form>
	</div>
</div>

<?php
	// Include Page Footer
	include '../pagecomp-footer.php';
?>

<!-- Light/Dark Mode Manager -->
<script src="/_res/js/rb-theme-manager.js?v=<?php echo ''.CSSVERSION.'';?>"></script>
</body>
</html>