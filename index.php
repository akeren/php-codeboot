<?php

use App\Controllers\User;
use App\Controllers\Session;

require_once './src/core/bootstrap.php';

if (Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User();

if ($user->isLoggedIn()) {
?>
	<p>Hello <a href="profile?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a></p>
	<ul>
		<li><a href="logout">Log out</a></li>
		<li><a href="update">Update details</a></li>
		<li><a href="changepassword">Change password</a></li>
	</ul>
<?php
	if ($user->hasPermission('admin')) {
		echo 'You login as an Administartor!';
	}
} else {
	echo '<p>You need to <a href="login">login</a> or <a href="register">Register</a> first!</p>';
}
