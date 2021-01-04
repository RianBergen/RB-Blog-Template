<?php
// Include Config File
require_once('../includes/config.php');

// Check If User Is Already Logged In
if($user->isLoggedIn()) {
	// Redirect To Index If Yes
	header('Location: index.php');
}
?>



<!-- HTML CODE -->
<!DOCTYPE html>
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<title><?php echo ''.HTMLTITLE.'';?> - User Login</title>
	<meta name="description" content=<?php echo '"'.HTMLDECRIPTION.'"';?>>
	<link rel="icon" sizes="16x16" href="/_res/images/16x16-Logo.png<?php echo CSSVERSION;?>">
	<link rel="icon" sizes="32x32" href="/_res/images/32x32-Logo.png<?php echo CSSVERSION;?>">
	<link rel="icon" sizes="192x192" href="/_res/images/192x192-Logo.png<?php echo CSSVERSION;?>">
    
	<link id="theme-style" rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.<?php echo ''.ISDARKMODE.'';?>.css?v=<?php echo ''.CSSVERSION.'';?>">
    <link rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.css?v=<?php echo ''.CSSVERSION.'';?>">
    
    <meta name="theme-color" content="#242424">
</head>
<body>
<div class="rb-login-container">
	<div class="rb-login-form">
		
	<?php
		// Process Login From If Submitted
		if(isset($_POST['submit'])) {
            // Honeypot
            if (testInput($_POST['id1']) == "") {
                // Test The Input For Username and Password
                $username = testInput($_POST['id2']);
                $password = testInput($_POST['id3']);
                
                // Login The User
                if($user->login($username, $password)){
                    // Login Worked
                    header('Location: index.php');
                    exit;
                } else {
                    // Login Failed
                    $message = '<p class="rb-error">Wrong Username/Email or Password</p>';
                }
            }  else {
                // Login Failed
                $message = '<p class="rb-error">Wrong Username/Email or Password</p>';
            }
		}
		
		if(isset($message)) {
			echo $message;
		}
	?>
		
		<!-- Login Form -->
        <form action="" method="post">
            <h1>Login</h1>
            <label for="id1" class="rb-id1">Honeypot: Do Not Fill Out!</label>
            <input class="rb-input-field rb-id1" style="width: 100%;" type="text" id="id1" name="id1" placeholder="id1">
            <label>Username/Email:</label></br><input class="rb-input-field" style="width: 100%;" type="text" name="id2" value=""/>
            <label>Password:</label></br><input class="rb-input-field" style="width: 100%;" type="password" name="id3" value=""/>
            <input class="rb-button rb-button-border" type="submit" name="submit" value="Login"/>
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