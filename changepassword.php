<?php

use App\Helpers\Hash;
use App\Helpers\Token;
use App\Controllers\User;
use App\Helpers\Redirect;
use App\Helpers\Validate;
use App\Controllers\Input;
use App\Controllers\Session;

require_once './src/core/bootstrap.php';

$user = new User();

if (!$user->isLoggedIn()) {
	Redirect::to('index');
}

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'old_password' => array(
				'required' => true,
				'min' => 6
			),
			'new_password' => array(
				'required' => true,
				'min' => 6
			),
			'confirm_password' => array(
				'required' => true,
				'min' => 6,
				'matches' => 'new_password'
			)
		));

		if ($validation->passed()) {
			if (!Hash::check(Input::get('old_password'), $user->data()->password)) {
				echo 'Your current password is wrong!';
			} else {
				$user->update(array(
					'password' => Hash::create(Input::get('new_password'))
				));

				Session::flash('home', 'Your password has been change!');
				Redirect::to('index');
			}
		} else {
			foreach ($validation->errors() as $error) {
				echo $error, '<br>';
			}
		}
	}
}
?>

<form method="post">
	<div class="field">
		<label for="old_password">Old Password</label>
		<input type="password" name="old_password" id="current_password">
	</div>
	<div class="field">
		<label for="new_password">New Password</label>
		<input type="password" name="new_password" id="new_password">
	</div>
	<div class="field">
		<label for="confirm_password">Re-enter Password</label>
		<input type="password" name="confirm_password" id="confirm_password">
	</div>
	<div class="field">
		<input type="submit" value="Change">
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	</div>
</form>