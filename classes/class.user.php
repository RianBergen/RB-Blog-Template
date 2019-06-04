<?php
// User Class
class User {
	// Class Variables
	private $connection;
	
	// Constructor
	function __construct($connection) {
		$this->connection = $connection;
	}
	
	// Check If User Is Logged In
	public function isLoggedIn(){
		if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true) {
			return true;
		}
	}
	
	// Create Password Hash
	function createHash($password) {
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		
		return $hashed_password;
	}
	
	// Retrieve The User Information
	private function getUserDBInfo($username_or_email) {
		try {
			$statement = $this->connection->prepare('
                SELECT
                    memberID,
                    memberUsername,
                    memberPassword,
                    memberEmail,
                    memberDateJoin
                FROM
                    blog_members
                WHERE
                    (memberEmail = :username_or_email)
                    OR (memberUsername = :username_or_email)'
            );
			$statement->execute(array(
                'username_or_email' => $username_or_email
            ));
			
			return $statement->fetch();
		} catch(PDOException $e) {
			echo '<p class="rb-error">'.$e->getMessage().'</p>';
		}
	}

	// Login
	public function login($email, $password) {
		// Retrieve The User Information
		$userInformation = $this->getUserDBInfo($email);
		
		// Check User Hash
		if(password_verify($password, $userInformation['memberPassword'])) {
			$_SESSION['isLoggedIn'] = true;
			$_SESSION['memberID'] = $userInformation['memberID'];
			$_SESSION['memberUsername'] = $userInformation['memberUsername'];
			$_SESSION['memberEmail'] = $userInformation['memberEmail'];
			$_SESSION['memberDateJoined'] = $userInformation['memberDateJoined'];
			return true;
		}else {
			return false;
		}
		
	}
	
	// Logout
	public function logout(){
		session_destroy();
	}
}
?>
