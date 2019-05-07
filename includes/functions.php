<?php
// Trim Slug Text
function trimSlugText($text) {
	// Replace Non-Letter/Digits With -
	$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	
	// Trim
	$text = trim($text, '-');
	
	// Transliterate
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	
	// Lowercase
	$text = strtolower($text);
	
	// Remove Unwanted Characters
	$text = preg_replace('~[^-\w]+~', '', $text);
	
	// Return Trimmed Text
	return $text;
}

// Create Slug For Posts
function createPostSlug($text) {
	// Trim Slug Text
	$text = trimSlugText($text);
	
	// Test If Text Is Empty
	if (empty($text)) {
		// Return N-A For Not Available
		return $text;
	}
	
	// Add Current Date To Post Slug
	$text = date('Y-m-d').'-'.$text;
	
	// Return Finished Result
	return $text;
}

// Create Slug For Categories
function createCategorySlug($text) { 
	// Trim Slug Text
	$text = trimSlugText($text);
	
	// Return Finished Result
	return $text;
}

// Test Input Function
function testInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>