<!-- This File Stores All Credentials For https://www.rianbergen.com/ -->
<?php
// Database Credentials
define('DBHOST', 'hostname');
define('DBPORT', 'port');
define('DBNAME', 'database');
define('DBUSER', 'user');
define('DBPASS', 'password');

// TinyMCE Credentials
// Replace 'key' With Your TinyMCE Link (Which Includes The API Key)
// Example: define('TINYMCE', 'https://cloud.tinymce.com/5/tinymce.min.js?apiKey=000000000000000000000000000000000000000000000000');
define('TINYMCE', 'key');

// Absolute URL
// Replace 'absolute' With Your Websites Absolute URL
// Example: define('URL', 'https://www.rianbergen.com/');
define('URL', 'absolute');

// CSS File Version - This is used to circumnavigate css file caching. Changing this value will force the user to re-download the css files.
define('CSSVERSION', '1.0.0');

// HTML Values
// This Fills Out The HTML Title And Description Tags
define('HTMLTITLE', 'title');
define('HTMLDESCRIPTION', 'description');

// Titlebar Values
// These Fill Out The Header And Footer Values Located At The Top And Bottom Of The Page
define('TITLE', 'title');
define('DESCRIPTION', 'description');
define('COPYRIGHT', 'copyright');

// Administrator Email Address: This email address will recieve all of the contact requests
define('ADMINEMAIL', 'email-address@email.com');
define('ADMINNAME', 'admin name');
?>
