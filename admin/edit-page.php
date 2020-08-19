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
	
	<title><?php echo ''.HTMLTITLE.'';?> - Edit Page</title>
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
            image_list: [
                <?php
                    $stmt2 = $connection->query('
                        SELECT
                            imageID,
                            imageTitle,
                            imagePath
                        FROM
                            blog_images
                        ORDER BY
                            imageTitle
                    ');
                    while($row2 = $stmt2->fetch()) {
                        echo "{title: '".$row2['imageTitle']."', value: '../".$row2['imagePath']."'},";
                    }
                ?>
                {title: 'Placeholder Image', value: '../_res/images/missing/Placeholder-Image-1920x1080.png'}
            ],
            height : "500px"
		});
	</script>
</head>
<body class="rb-admin-body">
<div class="rb-admin-container">
	<div class="rb-card rb-admin-content">
    
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
            
			if($pageContent == '') {
				$error[] = 'Please Enter The Content';
			}
            
            // Form Handling
			if(!isset($error)) {
				try {
					// Create Post Slug
					$pageSlug = createCategorySlug($pageTitle);
					
					// Insert Data Into Database
					$stmt = $connection->prepare('
                        UPDATE
                            blog_pages
                        SET
                            pageContent = :pageContent,
                            pageExtra = :pageExtra
                        WHERE
                            pageID = :pageID
                    ');
					$stmt->execute(array(
						':pageID' => $pageID,
						':pageContent' => $pageContent,
                        ':pageExtra' => $pageExtra
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
			$stmt = $connection->prepare('
                SELECT
                    pageID,
                    pageTitle,
                    pageContent,
                    pageExtra
                FROM
                    blog_pages
                WHERE
                    pageID = :pageID
            ');
			$stmt->execute(array(
                ':pageID' => $_GET['id']
            ));
			$row = $stmt->fetch(); 
		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	
	<!-- Edit Post Form -->
	<form action='' method='post'>
		<input type='hidden' name='pageID' value='<?php echo $row['pageID'];?>'>
        
		<p><label>Content</label><br />
		<textarea name='pageContent' cols='60' rows='10'><?php echo $row['pageContent'];?></textarea></p>
        
        <p><label>Extra Field</label><br />
		<input type='text' name='pageExtra' value='<?php echo $row['pageExtra'];?>'></p>
        
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