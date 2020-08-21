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
        <p><input type="hidden" name="settingsID[2]" value="0"><input type="checkbox" name="settingsID[2]" <?php if($rows[2][2] == 1){echo 'checked';} else {echo '';}?>><label> Enable/Disable Tags In Sidebar(Checked = Enabled)</label></p>
        <p><input type="hidden" name="settingsID[3]" value="0"><input type="checkbox" name="settingsID[3]" <?php if($rows[3][2] == 1){echo 'checked';} else {echo '';}?>><label> Enable/Disable Archives In Sidebar (Checked = Enabled)</label></p>
        <p><input type="hidden" name="settingsID[4]" value="0"><input type="checkbox" name="settingsID[4]" <?php if($rows[4][2] == 1){echo 'checked';} else {echo '';}?>><label> Sidebar Left or Right? (Unchecked = Left, Checked = Right)</label></p>
        <p><input type="hidden" name="settingsID[5]" value="0"><input type="checkbox" name="settingsID[5]" <?php if($rows[5][2] == 1){echo 'checked';} else {echo '';}?>><label> Use Background Image? (Checked = Yes)</label></p>
        <p><input type="hidden" name="settingsID[6]" value="0"><input type="checkbox" name="settingsID[6]" <?php if($rows[6][2] == 1){echo 'checked';} else {echo '';}?>><label> Show Complete Timeline or Home Page (Unchecked = 1 Home Page, Checked = Complete Timeline)</label></p>
        <p><a href="../hashover/admin/settings">HashOver Comments Settings</a></p>
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