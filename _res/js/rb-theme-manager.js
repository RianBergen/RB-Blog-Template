//Init. If is dark then initially change it to dark
var IsDark = getDarkThemeFromCookie();
theme_SetCssTheme(IsDark);

function SwitchTheme() {
	//Change the style based on if the theme is currently dark
    theme_SetCssTheme(!IsDark);
    theme_SetButtonText(!IsDark);

	//Invert the theme
	IsDark = !IsDark;

	//Update the cookie
	setDarkThemeInCookie(IsDark, 30);
}

//Sets the theme based on an input boolean
function theme_SetCssTheme(dark) {
    if (dark) {
        document.getElementById("theme-style").setAttribute("href", "/_res/styles/rb-engine.dark.css");
    } else {
        document.getElementById("theme-style").setAttribute("href", "/_res/styles/rb-engine.light.css");
    }
}

//Sets the theme button text based on an input boolean
function theme_SetButtonText(dark) {
    if (dark) {
        document.getElementById("theme-change-button").innerHTML = "Disable Dark Mode";
    } else {
        document.getElementById("theme-change-button").innerHTML = "Enable Dark Mode";
    }
}

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

function setDarkThemeInCookie(cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires=" + d.toUTCString();
	document.cookie = "DarkThemeOn" + "=" + cvalue + ";" + expires + ";path=/";
}