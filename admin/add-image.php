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
	
	<title><?php echo ''.HTMLTITLE.'';?> - Add Image</title>
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
	<h2>Add Image</h2>
	
	<?php
		// Process Submitted Form
		if(isset($_POST['submit'])) {
			// Collect Form Data
			extract($_POST);
            
            // Image Validation
            if(isset($_FILES['imageImage'])) {
                // Find The Image Type
                switch ($_FILES["imageImage"]["type"]) {
                    case $_FILES["imageImage"]["type"] == "image/gif":
                        break;
                    case $_FILES["imageImage"]["type"] == "image/jpeg":
                        break;
                    case $_FILES["imageImage"]["type"] == "image/pjpeg":
                        break;
                    case $_FILES["imageImage"]["type"] == "image/jpg":
                        break;
                    case $_FILES["imageImage"]["type"] == "image/png":
                        break;
                    case $_FILES["imageImage"]["type"] == "image/x-png":
                        break;
                    default:
                        $error[] = 'Improper Image Upload: Not A JPG, JPEG, PNG Or GIF';
                }
            }

			// Very Basic Vallidation
			if($imageTitle == '') {
				$error[] = 'Please Enter A Title';
			}
            
			// Form Handling
			if(!isset($error)) {
				try {
                    // Add Image If Uploaded
                    if(file_exists($_FILES['imageImage']['tmp_name']) && is_uploaded_file($_FILES['imageImage']['tmp_name'])) {
                        // Select The New File Location For The Images
                        $target = "_res/images/uploaded/".$_FILES['imageImage']['name'];
                        $path = '../'.$target;
    
                        // Move Image
                        mkdir("../_res/images/uploaded/", 0705);
                        if (move_uploaded_file($_FILES["imageImage"]["tmp_name"], $path)) {
                            // echo "Success";
                            // Insert Data Into Database
					        $stmt = $connection->prepare('
                                INSERT INTO
                                    blog_images (imageTitle, imagePath, imageDate)
                                VALUES
                                    (:imageTitle, :imagePath, :imageDate)
                            ');
					        $stmt->execute(array(
						        ':imageTitle' => $imageTitle,
						        ':imagePath' => $target,
						        ':imageDate' => date('Y-m-d H:i:s')
					        ));
                        } else {
                            // echo "Failed";
                            $error[] = 'Image Failed To Upload';
                        }
                    }

                    // Redirect To Admin Page
				    header('Location: images.php?action=added');
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
        <!-- Images -->
        <p><label>Banner Image (Recommended Size: 1920x1080)(Recommended File Type: JPG, JPEG, PNG, GIF)</label><br />
        <input type='file' name='imageImage' multiple></p>

        <p><label>Title</label><br />
		<input type='text' name='imageTitle' value='<?php if(isset($error)){echo $_POST['imageTitle'];}?>'></p>
        
		<p><input type='submit' name='submit' value='Submit'></p>
	</form>
	</div>
</div>

<?php
	// Include Page Footer
	include '../pagecomp-footer.php';
?>

<!-- Light/Dark Mode Manager -->
<script src="/_res/js/rb-theme-manager.js"></script>
</body>
</html>