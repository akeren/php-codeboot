<?php

use App\Helpers\Token;
use App\Controllers\User;
use App\Helpers\Redirect;
use App\Helpers\Validate;
use App\Controllers\Input;

require_once './src/core/bootstrap.php';

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username' => array('required' => true),
			'password' => array('required' => true)
		));

		if ($validation->passed()) {
			$user = new User();

			$remember = (Input::get('remember') === 'on') ? true : false;
			$login = $user->login(Input::get('username'), Input::get('password'), $remember);
			if ($login) {
				Redirect::to('index');
			} else {
				echo '<p>Sorry, logging in failed.</p>';
			}
		} else {
			foreach ($validation->errors() as $error) {
				echo $error, '<br>';
			}
		}
	}
}
?>
<form method="post" action="">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username">
	</div>
	<div class="field">
		<label for="password">Password</label>
		<input type="password" name="password" id="password">
	</div>
	<div class="field">
		<label for="remember">
			<input type="checkbox" name="remember" id="remember"> Remember Me
		</label>
	</div>
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" value="Log In">
</form>