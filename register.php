<?php

use App\Helpers\Hash;
use App\Helpers\Token;
use App\Helpers\Validate;
use App\Controllers\User;
use App\Helpers\Redirect;
use App\Controllers\Input;
use App\Controllers\Session;

require_once './src/core/bootstrap.php';

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username' => array(
				'required' => true,
				'min' => 2,
				'max' => 20,
				'unique' => 'users'
			),

			'password' => array(
				'required' =>  true,
				'min' => 6
			),

			'confirm_password' => array(
				'required' => true,
				'min' => 6,
				'matches' => 'password'
			),

			'full_name' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			)
		));

		if ($validation->passed()) {
			$user = new User();
			try {
				$user->create(array(
					'username' => Input::get('username'),
					'password' => Hash::create(Input::get('password')),
					'name' => Input::get('full_name'),
					'joined' => date('Y-m-d H:i:s'),
					'role_id' => 1
				));

				Session::flash('home', 'You have been registered and can now login!');
				Redirect::to('index');
			} catch (Exception $e) {
				die($e->getMessage());
			}
		} else {
			foreach ($validation->errors() as $error) {
				echo $error . '<br>';
			}
		}
	}
}

?>

<form method="post" action="">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" value="<?php echo escape(Input::get('username')); ?>" id="username">
	</div>
	<div class="field">
		<label for="password">Enter a passwprd</label>
		<input type="password" name="password" id="password" value="">
	</div>
	<div class="field">
		<label for="confirm_password">Re-enter password</label>
		<input type="password" name="confirm_password" value="" id="confirm_password">
	</div>
	<div class="field">
		<label for="full_name">Full name</label>
		<input type="text" name="full_name" id="full_name" value="<?php echo escape(Input::get('full_name')); ?>">
	</div>
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<div>
		<input type="submit" value="Register">
	</div>
</form>