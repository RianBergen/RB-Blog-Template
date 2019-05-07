<?php
// Include Config File
require_once('../includes/config.php');

// Log User Out
$user->logout();
header('Location: index.php');
?>