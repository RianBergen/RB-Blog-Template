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
	
	<title><?php echo ''.HTMLTITLE.'';?> - Edit User</title>
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
    
    <!-- Admin Page Link -->
	<p><a href="users.php">Go Back</a></p>
	<h2>Edit User</h2>
	
	<?php
		// Process Submitted Form
		if(isset($_POST['submit'])) {
			// Collect Form Data
			extract($_POST);
			
			// Very Basic Validation
			if($username == '') {
				$error[] = 'Please Enter A User Name';
			}
			
			if(strlen($password) > 0) {
				if($password == '') {
					$error[] = 'Please Enter A Password';
				}
				
				if($passwordConfirm == '') {
					$error[] = 'Please Confirm The Password';
				}
				
				if($password != $passwordConfirm) {
					$error[] = 'Passwords Do Not Match';
				}
			}
			
			if($email == '') {
				$error[] = 'Please Enter An Email';
			}
			
			// Edit User If No Erros Found
			if(!isset($error)){
				try {
					if(strlen($password) > 0){
						// Hash Password
						$hashedpassword = $user->createHash($password);

						// Update Database
						$statement = $connection->prepare('
                            UPDATE
                                blog_members
                            SET
                                memberUsername = :username,
                                memberPassword = :password,
                                memberEmail = :email
                            WHERE
                                memberID = :memberID
                        ');
						$statement->execute(array(
							':username' => $username,
							':password' => $hashedpassword,
							':email' => $email,
							':memberID' => $memberID
						));
					} else {
						// Update Database
						$statement = $connection->prepare('
                            UPDATE
                                blog_members
                            SET
                                memberUsername = :username,
                                memberEmail = :email
                            WHERE
                                memberID = :memberID
                        ');
						$statement->execute(array(
							':username' => $username,
							':email' => $email,
							':memberID' => $memberID
						));
					}
					
					// Redirect To Admin Page
					header('Location: users.php?action=updated');
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

		// Retrieve Data
		try {
			$statement = $connection->prepare('
                SELECT
                    memberID,
                    memberUsername,
                    memberEmail
                FROM
                    blog_members
                WHERE
                    memberID = :memberID
            ') ;
			$statement->execute(array(
                ':memberID' => $_GET['id']
            ));
			$row = $statement->fetch(); 
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	?>
	
	<!-- Edit User Form -->
	<form action='' method='post'>
		<input type='hidden' name='memberID' value='<?php echo $row['memberID'];?>'>

		<p><label>Username</label><br />
		<input type='text' name='username' value='<?php echo $row['memberUsername'];?>'></p>

		<p><label>Password (only to change)</label><br />
		<input type='password' name='password' value=''></p>

		<p><label>Confirm Password</label><br />
		<input type='password' name='passwordConfirm' value=''></p>

		<p><label>Email</label><br />
		<input type='text' name='email' value='<?php echo $row['memberEmail'];?>'></p>

		<p><input type='submit' name='submit' value='Update User'></p>
	</form>
	</div>
</div>

<?php
	// Include Page Footer
	include '../pagecomp-footer.php';
?>

<!-- Light/Dark Mode Manager -->
<script src="/_res/js/rb-theme-manager.j?v=<?php echo ''.CSSVERSION.'';?>s"></script>
</body>
</html>