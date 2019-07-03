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
	
	<title><?php echo ''.HTMLTITLE.'';?> - Edit Post</title>
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
<body>
<div class="rb-admin-container">
	<div class="rb-card rb-admin-content">
    
	<!-- Admin Page Link -->
	<p><a href="./">Go Back</a></p>
	<h2>Edit Post</h2>
	<?php
		// Process Submitted Form
		if(isset($_POST['submit'])) {
			// Collect Form Data
			extract($_POST);
			
			// Very Basic Vallidation
			if($postID == '' ){
				$error[] = 'Invalid ID';
			}
		
			if($postTitle == '') {
				$error[] = 'Please Enter A Title';
			}
			
			if($postDescription == '') {
				$error[] = 'Please Enter A Description';
			}
			
			if($postContent == '') {
				$error[] = 'Please Enter The Content';
			}
            
            // Image Validation For Post Banner
            if(isset($_FILES['postImage'])) {
                // Find The Image Type
                switch ($_FILES["postImage"]["type"]) {
                    case $_FILES["postImage"]["type"] == "image/gif":
                        break;
                    case $_FILES["postImage"]["type"] == "image/jpeg":
                        break;
                    case $_FILES["postImage"]["type"] == "image/pjpeg":
                        break;
                    case $_FILES["postImage"]["type"] == "image/png":
                        break;
                    case $_FILES["postImage"]["type"] == "image/x-png":
                        break;
                    default:
                        $error[] = 'Improper Image Upload For Post: Not A JPG, PNG Or GIF';
                }
            }
            
            // Form Handling
			if(!isset($error)) {
				try {
					// Create Post Slug
					$postSlug = createPostSlug($postTitle);
					
					// Insert Data Into Database
					$stmt = $connection->prepare('
                        UPDATE
                            blog_posts
                        SET
                            postTitle = :postTitle,
                            postSlug = :postSlug,
                            postDescription = :postDescription,
                            postContent = :postContent,
                            postTags = :postTags
                        WHERE
                            postID = :postID
                    ');
					$stmt->execute(array(
						':postID' => $postID,
						':postTitle' => $postTitle,
						':postSlug' => $postSlug,
						':postDescription' => $postDescription,
						':postContent' => $postContent,
                        ':postTags' => $postTags
					));
					
					// Delete All Post Category Connections For Current Post
					$stmt = $connection->prepare('
                        DELETE FROM
                            blog_post_categories
                        WHERE
                            pcPostID = :postID
                    ');
					$stmt->execute(array(
                        ':postID' => $postID)
                    );
					
					// Attach Categories
					if(is_array($categoryID)) {
						foreach($_POST['categoryID'] as $categoryID) {
							$stmt = $connection->prepare('
                                INSERT INTO
                                    blog_post_categories (pcPostID, pcCategoryID)
                                VALUES
                                    (:postID, :categoryID)
                            ');
							$stmt->execute(array(
								':postID' => $postID,
								':categoryID' => $categoryID
							));
						}
					}
                    
                    // Add Image If Uploaded
                    if(file_exists($_FILES['postImage']['tmp_name']) && is_uploaded_file($_FILES['postImage']['tmp_name'])){
                        // Select The New File Location For The Images
                        $target = "_res/images/posts/".$postID."/".$_FILES['postImage']['name'];
                        $path = '../'.$target;
                        
                        // Move Image
                        mkdir("../_res/images/posts/".$postID."/", 0705);
                        move_uploaded_file($_FILES["postImage"]["tmp_name"], $path);
                        
                        // Connect Image
                        $stmt2 = $connection->prepare('
                            UPDATE
                                blog_posts
                            SET
                                postImage = :image
                            WHERE
                                postID = :postID
                        ');
                        $stmt2->execute(array(
                            ':postID' => $postID,
                            ':image' => $target
                        ));
                    }
					
					// Redirect To Admin Page
					header('Location: index.php?action=updated');
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
                    postID,
                    postTitle,
                    postDescription,
                    postContent,
                    postTags,
                    postImage
                FROM
                    blog_posts
                WHERE
                    postID = :postID
            ');
			$stmt->execute(array(
                ':postID' => $_GET['id']
            ));
			$row = $stmt->fetch(); 
		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	
	<!-- Edit Post Form -->
	<form action='' method='post'>
		<input type='hidden' name='postID' value='<?php echo $row['postID'];?>'>

		<p><label>Title</label><br />
		<input type='text' name='postTitle' value='<?php echo $row['postTitle'];?>'></p>

		<p><label>Description</label><br />
		<textarea name='postDescription' cols='60' rows='10'><?php echo $row['postDescription'];?></textarea></p>

		<p><label>Content</label><br />
		<textarea name='postContent' cols='60' rows='10'><?php echo $row['postContent'];?></textarea></p>
        
        <p><label>Tags (comma seperated)</label><br />
        <input type='text' name='postTags' value='<?php echo $row['postTags'];?>' style="width:400px;"></p>
		
		<!-- List Of All Categories -->
		<fieldset>
			<legend>Categories</legend>

			<?php
				$stmt2 = $connection->query('
                    SELECT
                        categoryID,
                        categoryTitle
                    FROM
                        blog_categories
                    ORDER BY
                        categoryTitle
                ');
				while($row2 = $stmt2->fetch()) {
					$stmt3 = $connection->prepare('
                        SELECT
                            pcCategoryID
                        FROM
                            blog_post_categories
                        WHERE
                            pcCategoryID = :categoryID
                        AND
                            pcPostID = :postID
                    ');
					$stmt3->execute(array(':categoryID' => $row2['categoryID'], ':postID' => $row['postID']));
					$row3 = $stmt3->fetch(); 
					if($row3['pcCategoryID'] == $row2['categoryID']) {
						$checked = 'checked=checked';
					} else {
						$checked = null;
					}
					echo "<input type='checkbox' name='categoryID[]' value='".$row2['categoryID']."' $checked> ".$row2['categoryTitle']."<br />";
				}
			?>
		</fieldset>
        
        <!-- Images -->
        <p><label>Banner Image (Recommended Size: 1920x1080)(Recommended File Type: JPEG, PNG, GIF)</label><br />
        <input type='file' name='postImage' multiple></p>
        <?php if ($row['postImage'] != '') { ?>
            <p><img class="rb-card-img" src="<?=URL.$row['postImage'];?>"></p>
        <?php } ?>
        
        
		<p><input type='submit' name='submit' value='Submit'></p>
		
	</form>
	</div>
</div>

<!-- Light/Dark Mode Manager -->
<script src="/_res/js/rb-theme-manager.js"></script>
</body>
</html>