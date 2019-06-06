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
	
	<title><?php echo ''.HTMLTITLE.'';?> - Add User</title>
	<meta name="description" content=<?php echo '"'.HTMLDECRIPTION.'"';?>>
	<link rel="icon" sizes="16x16" href="/_res/images/16x16-Logo.png">
	<link rel="icon" sizes="32x32" href="/_res/images/32x32-Logo.png">
	<link rel="icon" sizes="192x192" href="/_res/images/192x192-Logo.png">
	
	<link id="theme-style" rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.light.css">
    <link rel="stylesheet" type="text/css" onload="this.media='all'" href="/_res/styles/rb-engine.css">
</head>
<body>
<div class="rb-admin-container">
	<div class="rb-card rb-admin-content">
    
	<!-- Admin Page Link -->
	<p><a href="users.php">Go Back</a></p>
	<h2>Add User</h2>

	<?php
		// Process Submitted Form
		if(isset($_POST['submit'])) {
			// Collect Form Data
			extract($_POST);
			
			// Very Basic Validation
			if($username =='') {
				$error[] = 'Please Enter A User Name';
			}
			
			if($password =='') {
				$error[] = 'Please Enter A Password';
			}
			
			if($passwordConfirm =='') {
				$error[] = 'Please Confirm The Password';
			}
			
			if($password != $passwordConfirm) {
				$error[] = 'Passwords Do Not Match';
			}
			
			if($email =='') {
				$error[] = 'Please Enter An Email';
			}
			
			// Add User If No Errors Found
			if(!isset($error)){
				// Hash Password
				$hashedpassword = $user->createHash($_POST['password']);
				
				try {
					// Insert Data Into Database
					$statement = $connection->prepare('
                        INSERT INTO
                            blog_members (memberUsername, memberPassword, memberEmail, memberDateJoin)
                        VALUES
                            (:username, :password, :email, :datejoined)
                    ');
					$statement->execute(array(
						':username' => $username,
						':password' => $hashedpassword,
						':email' => $email,
						':datejoined' => date('Y-m-d H:i:s')
					));

					// Redirect To Admin Page
					header('Location: users.php?action=added');
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
	
	<!-- Add User Form -->
	<form action='' method='post'>
		<p><label>Username</label><br />
		<input type='text' name='username' value='<?php if(isset($error)){ echo $_POST['username'];}?>' /></p>

		<p><label>Password</label><br />
		<input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>' /></p>

		<p><label>Confirm Password</label><br />
		<input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>' /></p>

		<p><label>Email</label><br />
		<input type='text' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>' /></p>

		<p><input type='submit' name='submit' value='Add User'></p>
	</form>
	</div>
</div>

<!-- Light/Dark Mode Manager -->
<script src="/_res/js/rb-theme-manager.js"></script>
</body>
</html>