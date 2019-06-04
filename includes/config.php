<?php
// Start Session
ob_start();
session_start();

// Include Credentials
require_once('credentials/credentials.php');

// Create Database Connection
$connection = new PDO('mysql:host='.DBHOST.';port='.DBPORT.';dbname='.DBNAME, DBUSER, DBPASS);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Set Timezone
date_default_timezone_set('America/New_York');

// Load Classes When Needed
function __autoload($class) {
	// Make Class Name Lowercase
	$class = strtolower($class);
	
	// If Call Comes From WWWROOT
	$classpath = 'classes/class.'.$class.'.php';
	if ( file_exists($classpath)) {
		require_once $classpath;
	}
	
	// If Call Comes From Folders Within WWWROOT
	$classpath = '../classes/class.'.$class.'.php';
	if ( file_exists($classpath)) {
		require_once $classpath;
	}
	
	// If Call Comes From Folders Within Folders
	$classpath = '../../classes/class.'.$class.'.php';
	if ( file_exists($classpath)) {
		require_once $classpath;
	}
}

// Define How Many Posts Are Allowed Per Page
define('POSTSPERPAGE', '7');

// Include User Class And Create New User
$user = new User($connection);

// Include Special Functions
include('functions.php');
?>