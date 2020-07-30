# PHP-Codeboot :sparkles:

PHP-Codeboot is obtainable, robust, and provides a set of scalable utilities that are required for large and optimal applications with a simple and workable design pattern using **PHP Object Oriented Paradigm and Singleton design pattern**.

## Server Requirements :white_check_mark:
> PHP version ^7.1.3. So, if you have been using PHP version less than that, kindly upgrade before using the project. PDO extension must be extensively enabled.

## Usage 

```PHP
	
	use App\Models\DB;
	use App\Controller\Input;
	use App\Helpers\Validate;
	use App\Helpers\Hash;
	use App\Helpers\Redirect as Direct;


	require_once './src/core/bootstrap.php';

	/**
	 * Using the generic query method to get records
	 */
		$users = DB::getInstance()->query(
		    "SELECT * FROM users WHERE username = ? OR username = ?",
		    array('kater', 'fabian')
		);

	/**
	 * How to check for errors
	 */
		if ($users->error()) {
		    echo 'No user!';
		} else {
		    foreach ($users->results() as $user) {
		        pretty($user);
		    }
		}


	/**
	 * Getting an individual record from the DB
	 */

		$user = DB::getInstance()->get('users', array('username', '=', 'kater'));
		pretty($user->results());

	
	/**
	 * Using the validation class to validate the user's 
	 * input data
	 */
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

	/**
	 * Insert data into the database
	 * 
	*/
		$createUser = DB::getInstance()->insert('users', array(
			'username' => Input::get('username'),
			'password' => Hash::create(Input::get('password')),
			'name' => Input::get('full_name'),
			'joined' => date('Y-m-d H:i:s'),
			'role_id' => 1
		));


	/**
	 * Update user's data based upon the provided userID
	 * 
	*/
		$UpdateUser = DB::getInstance()->update('users', '2', array(
			'name' => Input::get('name')
		));


	/**
	 * Delete user's data based upon the provided userID
	 * 
	*/
		$UpdateUser = DB::getInstance()->delete('users', array(
			'user_id', '=', '1'
		));

	/**
	 * Redirect a user
	 * 
	*/
		Direct::to('index');

```

## Note 

To get more insight into the work and how useful it requires you to play around with the Login and registration system that has been built using the **PHP-codeboot**. It will guide you on how to make extensive use of the min-framework and some helpers like flash messages, Cross site request forgery (CSRF), remember me, and et al to build your own application. 

You find the test database in the [:open_file_folder:db](https://github.com/akeren/php-codeboot/tree/master/db) 

# Contributing :computer:

You can fork the repository and send a pull request or reach out easily to me via twitter :point_right: [Kater Akeren](https://twitter.com/katerakeren). If you discover a security vulnerability within **PHP-Codeboot**, please :pray: create an issue. All security vulnerabilities will be promptly addressed and appreciated.


# License
**PHP-Codeboot** is an open-source curve for lovers :heart: of optimal and reusable codes. This project work is built and used with `GPL.3.0` license. You are free to integrate the codes to your application to build optimal, sustainable, and help many seasoned young and upcoming developers to write optimal codes and built real-life applications.