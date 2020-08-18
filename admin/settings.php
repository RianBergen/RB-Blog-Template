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
	
	<title><?php echo ''.HTMLTITLE.'';?> - Settings</title>
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
        <h1>Settings</h1>
        
	<!-- Admin Page Link -->
	<?php
		// Display Menu
		include('menu.php');
		
		// Show Message From Edit Settings
		if(isset($_GET['action'])){
			echo '<p>Settings '.$_GET['action'].'.</p>';
		}
	?>
    
	<?php
		// Process Submitted Form
		if(isset($_POST['submit'])) {
			// Collect Form Data
			extract($_POST);
            
            /*
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
            */
            // Form Handling
			if(!isset($error)) {
				try {
					// Insert Checkbox Data Into Database
                    if(isset($_POST['settingsID'])) {
                        if(is_array($_POST['settingsID'])) {
                            $i = 0;
                            
                            foreach($_POST['settingsID'] as $value){
                                $i++;
                                
                                if($value == true) {
                                    $value = 1;
                                } else {
                                    $value = 0;
                                }
                                
                                $stmt = $connection->prepare('
                                    UPDATE
                                        blog_settings
                                    SET
                                        settingsValue = :settingsValue
                                    WHERE
                                        settingsID = :settingsID
                                ');
                                $stmt->execute(array(
                                    ':settingsID' => $i,
                                    ':settingsValue' => $value
                                ));
                            }
                        }
                    }
                    
					/*
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
					*/
					// Redirect To Settings Page
					header('Location: settings.php?action=updated');
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
            // Get SQL Data
            $statement = $connection->query('
                SELECT
                    settingsID,
                    settingsName,
                    settingsValue,
                    settingsImage
                FROM
                    blog_settings
                ORDER BY
                    settingsID
            ');
            
            $rows = array();
            
            while($row = $statement->fetch()) {
                array_push($rows, $row);
            }
		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	
	<!-- Edit Post Form -->
	<form action='' method='post'>
        <!-- Sidebar Enable/Disable Checkboxes -->
        <p><input type="hidden" name="settingsID[0]" value="0"><input type="checkbox" name="settingsID[0]" <?php if($rows[0][2] == 1){echo 'checked';} else {echo '';}?>><label> Enable/Disable About In Sidebar (Checked = Enabled)</label></p>
        <p><input type="hidden" name="settingsID[1]" value="0"><input type="checkbox" name="settingsID[1]" <?php if($rows[1][2] == 1){echo 'checked';} else {echo '';}?>><label> Enable/Disable Recent In Sidebar (Checked = Enabled)</label></p>
        <p><input type="hidden" name="settingsID[2]" value="0"><input type="checkbox" name="settingsID[2]" <?php if($rows[2][2] == 1){echo 'checked';} else {echo '';}?>><label> Enable/Disable Categories In Sidebar (Checked = Enabled)</label></p>
        <p><input type="hidden" name="settingsID[3]" value="0"><input type="checkbox" name="settingsID[3]" <?php if($rows[3][2] == 1){echo 'checked';} else {echo '';}?>><label> Enable/Disable Tags In Sidebar(Checked = Enabled)</label></p>
        <p><input type="hidden" name="settingsID[4]" value="0"><input type="checkbox" name="settingsID[4]" <?php if($rows[4][2] == 1){echo 'checked';} else {echo '';}?>><label> Enable/Disable Archives In Sidebar (Checked = Enabled)</label></p>
        <p><input type="hidden" name="settingsID[5]" value="0"><input type="checkbox" name="settingsID[5]" <?php if($rows[5][2] == 1){echo 'checked';} else {echo '';}?>><label> Sidebar Left or Right? (Unchecked = Left, Checked = Right)</label></p>
        <p><input type="hidden" name="settingsID[6]" value="0"><input type="checkbox" name="settingsID[6]" <?php if($rows[6][2] == 1){echo 'checked';} else {echo '';}?>><label> Use Background Image? (Checked = Yes)</label></p>
        <p><input type="hidden" name="settingsID[7]" value="0"><input type="checkbox" name="settingsID[7]" <?php if($rows[7][2] == 1){echo 'checked';} else {echo '';}?>><label> Show Complete Timeline or Home Page (Unchecked = 1 Home Page, Checked = Complete Timeline)</label></p>
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