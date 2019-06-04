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
	<link rel="icon" sizes="16x16" href="../_res/images/16x16-Logo.png">
	<link rel="icon" sizes="32x32" href="../_res/images/32x32-Logo.png">
	<link rel="icon" sizes="192x192" href="../_res/images/192x192-Logo.png">
    
	<link rel="stylesheet" href="../_res/styles/rb-engine.css">
</head>
<body>
<div id="rb-login-container">
	<div class="rb-card" id="rb-login-content">
		
	<?php
		// Process Login From If Submitted
		if(isset($_POST['submit'])) {
			$username = testInput($_POST['username']);
			$password = testInput($_POST['password']);
			
			if($user->login($username, $password)){
				// Login Worked
				header('Location: index.php');
				exit;
			} else {
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
			<p><h1>Login</h1></p>
			<p><label>Username/Email:</label></br><input type="text" name="username" value=""/></p>
			<p><label>Password:</label></br><input type="password" name="password" value=""/></p>
			<p><label></label><input class="rb-button rb-button-border" type="submit" name="submit" value="Login"/></p>
		</form>
	</div>
</div>
</body>
</html>
