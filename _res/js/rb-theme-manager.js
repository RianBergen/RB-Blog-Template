
//Init. If is dark then initially change it to dark
var IsDark = !getDarkThemeFromCookie();
SwitchTheme();

function SwitchTheme() {

	//Change the style based on if the theme is currently dark
	if (IsDark) {
        document.getElementById("theme-style").setAttribute("href", "/_res/styles/rb-engine.light.css");
        document.getElementById("theme-change-button").innerHTML = "Enable Dark Mode";
	} else {
        document.getElementById("theme-style").setAttribute("href", "/_res/styles/rb-engine.dark.css");
        document.getElementById("theme-change-button").innerHTML = "Disable Dark Mode";
	}

	//Invert the theme boolean
	IsDark = !IsDark;

	//Update the cookie
	setDarkThemeInCookie(IsDark, 30);
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