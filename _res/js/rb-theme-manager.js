// Initialize
var IsDark = getDarkThemeFromCookie(); // Retrieve Light/Dark Theme Setting From Cookie
theme_SetButtonText(IsDark); // Overwrite HTML Button Based On Result



// Called By HTML Button: Switches Between Light/Dark Theme
function SwitchTheme() {
	// Invert The Theme
	IsDark = !IsDark;

	// Overwrite CSS Styles And HTML Button
	theme_SetCssTheme(IsDark);
    theme_SetButtonText(IsDark);

	// Set/Update The Cookie
	setDarkThemeInCookie(IsDark, 30);
}



// Overwrites The CSS Styles Based On Input Variable
function theme_SetCssTheme(dark) {
    if (dark) { // If Input Variable Is True: Dark Mode
		// Main Stylesheet
		document.getElementById("theme-style").setAttribute("href", "/_res/styles/rb-engine.dark.css");

		// HashOver Comments StyleSheet
		if(document.getElementById("theme-style-comments")) {
			document.getElementById("theme-style-comments").setAttribute("href", "/hashover/themes/default-dark-borderless/comments.css");
		}

		// TinyMCE StyleSheet
		if(document.getElementById("tinyMCE")) {
			// Remove All Editors
			tinymce.remove("#tinyMCE");

			// Initialize Editor
			InitTinyMCE_Dark();
		}
    } else { // If Input Variable Is False: Light Mode
		// Main Stylesheet
		document.getElementById("theme-style").setAttribute("href", "/_res/styles/rb-engine.light.css");

		// HashOver Comments StyleSheet
		if(document.getElementById("theme-style-comments")) {
			document.getElementById("theme-style-comments").setAttribute("href", "/hashover/themes/default-borderless/comments.css");
		}

		// TinyMCE StyleSheet
		if(document.getElementById("tinyMCE")) {
			// Remove All Editors
			tinymce.remove("#tinyMCE");

			// Initialize Editor
			InitTinyMCE_Light();
		}
    }
}



// Overwrites The HTML Button Based On Input Variable
function theme_SetButtonText(dark) {
    if (dark) { // If Input Variable Is True: Dark Mode
        document.getElementById("theme-change-button").innerHTML = "Disable Dark Mode";
    } else { // If Input Variable Is False: Light Mode
        document.getElementById("theme-change-button").innerHTML = "Enable Dark Mode";
    }
}



// Retrieve Light/Dark Theme Setting From Cookie
function getDarkThemeFromCookie() {
	var name = "DarkThemeOn" + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return (c.substring(name.length, c.length) == 'true')
		}
	}
	return false;
}



// Set/Update The Cookie
function setDarkThemeInCookie(cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires=" + d.toUTCString();
	document.cookie = "DarkThemeOn" + "=" + cvalue + ";" + expires + ";path=/";
}