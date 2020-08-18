<?php?>

<p>Logged in as <?=$_SESSION['memberUsername'];?></p>
<ul class='rb-admin-menu'>
	<li class="rb-admin-menu-item"><a href='index.php'>Blog</a></li>
	<li class="rb-admin-menu-item"><a href="images.php">Images</a></li>
    <li class="rb-admin-menu-item"><a href='pages.php'>Pages</a></li>
	<li class="rb-admin-menu-item"><a href='users.php'>Users</a></li>
    <li class="rb-admin-menu-item"><a href='settings.php'>Settings</a></li>
	<li class="rb-admin-menu-item"><a href="/" target="_blank">View Website</a></li>
	<li class="rb-admin-menu-item"><a href='logout.php'>Logout</a></li>
</ul>