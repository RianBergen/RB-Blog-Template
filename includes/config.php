<?php
// Start PHP Session
ob_start();
session_start();

// Retrieve/Create DarkTheme Cookie
$cookie_name = 'DarkThemeOn';    // Cookie Name
$cookie_defaultvalue = 'false';    // Default Cookie Value: false = light mode, true = dark mode
$cookie_expirationtime = 30;    // Time Until Cookie Expires (In Amount of Days): 30 = 30 Days From Now

// Check If Cookie Exists
if(!isset($_COOKIE[$cookie_name])) {
    // Cookie Doesn't Exist, So We Create One With The Default Value
    setcookie($cookie_name, $cookie_defaultvalue, time() + (86400 * $cookie_expirationtime), '/');
    
    // Save Cookie Data
    define('ISDARKMODE', 'light');
} else {
    // Cookie Exists, So We Reset The Expiration Date But Keep The Original Value
    setcookie($cookie_name, $_COOKIE[$cookie_name], time() + (86400 * $cookie_expirationtime), '/');
    
    // Save Cookie Data
    if($_COOKIE[$cookie_name] == 'false') {
        define('ISDARKMODE', 'light');
    } else {
        define('ISDARKMODE', 'dark');
    }
}

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