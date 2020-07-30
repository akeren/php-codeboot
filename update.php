<?php

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
			'name' => array(
				'required' => true,
				'min' => 2
			)
		));

		if ($validation->passed()) {
			$user = new User();
			$user->update(array(
				'name' => Input::get('name')
			));

			Session::flash('home', 'Your name has been change.');
			Redirect::to('index');
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
		<label for="name">Name</label>
		<input type="text" name="name" id="name" value="<?php echo escape($user->data()->name); ?>">
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		<input type="submit" value="Update">
	</div>
</form>