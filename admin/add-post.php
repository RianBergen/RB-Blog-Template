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
	
	<title><?php echo ''.HTMLTITLE.'';?> - Add Post</title>
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
            <?php if(ISDARKMODE == 'dark'){echo 'skin: "oxide-dark",content_css: "dark",';}else{echo '';}?>
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
	<p><a href="./">Go Back</a></p>
	<h2>Add Post</h2>
	
	<?php
		// Process Submitted Form
		if(isset($_POST['submit'])) {
			// Collect Form Data
			extract($_POST);
			
			// Very Basic Vallidation
			if($postTitle == '') {
				$error[] = 'Please Enter A Title';
			}
			
			if($postContent == '') {
				$error[] = 'Please Enter The Content';
			}
            
			// Form Handling
			if(!isset($error)) {
				try {
					// Create Post Slug
					$postSlug = createPostSlug($postTitle);
                    
					// Cleanup postComments Data
                    if($comments){
                        $comments = 1;
                    } else {
                        $comments = 0;
                    }
                    
					// Insert Data Into Database
					$stmt = $connection->prepare('
                        INSERT INTO
                            blog_posts (postTitle, postSlug, postContent, postDate, postTags, postComments)
                        VALUES
                            (:postTitle, :postSlug, :postContent, :postDate, :postTags, :postComments)
                    ');
					$stmt->execute(array(
						':postTitle' => $postTitle,
						':postSlug' => $postSlug,
						':postContent' => $postContent,
						':postDate' => date('Y-m-d H:i:s'),
                        ':postTags' => $postTags,
                        ':postComments' => $comments
					));
					
					$postID = $connection->lastInsertId();
					
                    // Add Image If Selected
                    if($postImage != '0') {
                        // Connect Image
                        $stmt2 = $connection->prepare('
                            UPDATE
                                blog_posts
                            SET
                                postImage = :postImage
                            WHERE
                                postID = :postID
                        ');
                        $stmt2->execute(array(
                            ':postID' => $postID,
                            ':postImage' => $postImage
                        ));
                    }
                    
                    // Notification System
                    if ($notify == true) {
                        $stmt3 = $connection->query('
                            SELECT
                                subscriberID,
                                subscriberEmail
                            FROM
                                blog_subscribers
                            ORDER BY
                                subscriberID
                        ');
                        
                        while($row3 = $stmt3->fetch()) {
                            // Retrieve Email Template
                            $statementemail = $connection->prepare('
                                SELECT
                                    pageTitle,
                                    pageContent,
                                    pageExtra
                                FROM
                                    blog_pages
                                WHERE
                                    pageTitle = :pageTitle
                            ');
                            $statementemail->execute(array(
                                ':pageTitle' => "New Post-Email Notification"
                            ));
                            $rowemail = $statementemail->fetch();
                            
                            // Format Template And Replace Tags With Information
                            $msg = '
                                <html>
                                <head>
                                    <title>Contact Request</title>
                                </head>
                                <body>
                            '.$rowemail['pageContent'].'
                                </body>
                                </html>
                            ';
                            
                            $msg = str_replace('[Title]', $postTitle, $msg);
                            $content = substr($postContent, 0, strpos($postContent, '</p>'));
                            $msg = str_replace('[Content]', $content, $msg);
                            $msg = str_replace('[Link]', URL."post/".$postSlug, $msg);
                            
                            // Add Headers
                            $headers = "MIME-Version: 1.0"."\r\n";
                            $headers .= "Content-Type: text/html; charset=ISO-8859-1"."\r\n";
                            $headers .= "From: ".ADMINNAME."<".ADMINEMAIL.">"."\r\n";
                            
                            // Send Message
                            mail($row3['subscriberEmail'], $rowemail['pageExtra'], $msg, $headers);
                        }
                    }

                     // Redirect To Admin Page
				    header('Location: index.php?action=added');
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
		<input type='text' name='postTitle' value='<?php if(isset($error)){echo $_POST['postTitle'];}?>'  style='width:400px;'></p>

        <p><label>Tags (Comma Seperated)</label><br />
        <input type='text' name='postTags' value='<?php if(isset($error)){ echo $_POST['postTags'];}?>' style='width:400px;'></p>
		
        <!-- Images -->
        <p><label>Banner Image</label><br />
        <select name="postImage" style='width:400px;'>
            <option value='0'>NONE</option>
            <?php
                $stmt2 = $connection->query('
                    SELECT
                        imageID,
                        imageTitle
                    FROM
                        blog_images
                    ORDER BY
                        imageTitle
                ');
                while($row2 = $stmt2->fetch()) {
                    if(isset($_POST['postImage'])) {
                        if($row2['imageID'] == $_POST['postImage']) {
                            $selected ="selected='selected'";
                        } else {
                            $selected = null;
                        }
                    }
                    echo "<option value='".$row2['imageID']."' ".$selected.">".$row2['imageTitle']."</option>";
                }
            ?>
        </select>

		<p><label>Content</label><br />
		<textarea name='postContent' cols='60' rows='10'><?php if(isset($error)){echo $_POST['postContent'];}?></textarea></p>
		
        <p><input type="checkbox" name="comments" <?php if(isset($error)){if($_POST['comments'] == true){echo 'checked';} else {echo '';}}else{echo 'checked';}?>><label> Enable/Disable Comments (Checked = Enabled)</label></p>
        
        <p><input type="checkbox" name="notify" <?php if(isset($error)){if($_POST['notify'] == true){echo 'checked';} else {echo '';}}else{echo '';}?>><label> Notify Subscribers (Checked = Yes)</label></p>
        
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