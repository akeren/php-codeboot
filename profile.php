<?php

use App\Controllers\User;
use App\Helpers\Redirect;
use App\Controllers\Input;

require_once './src/core/bootstrap.php';

if (!$username = Input::get('user')) {
	Redirect::to('index');
} else {
	$user = new User($username);
	if (!$user->exists()) {
		Redirect::to(404);
	} else {
		$data = $user->data();
	}

	echo '<h3>' . escape($data->username) . '</h3>';
	echo '<p> Full name :' . escape($data->name) . '</p>';
}
