<?php

class UsersController{

	private $db;
	public function __construct(){

		$this->db=new DB\SQL(
			'mysql:host=localhost;port=3306;dbname=api',
			'root',
			''
		);

	}

	// Display all users
	public function actionFind(){
		$this->db->begin();
		$data = $this->db->exec('SELECT * FROM users');

		if (!empty($data)):
			Api::response(200, $data);
		else:
			Api::response(204, 'No Content');
		endif;
	}

	// Display one movie
	public function actionFindOne(){
		$id_user = F3::get('PARAMS.id');

		$this->db->begin();
		$data = $this->db->exec('SELECT * FROM users WHERE id_user = ' . $id_user .' LIMIT 1');

		if (!empty($data)):
			Api::response(200, $data);
		else:
			Api::response(404, 'Error 404');
		endif;
	}

	// Create an user
	public function actionCreate(){
		$email = F3::get('POST.email');
		$pass  = F3::get('POST.pass');

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)):
			Api::response(400, 'Bad email');
		elseif (!empty($email) && !empty($pass)):
			$this->db->begin();
			$insert = $this->db->exec("INSERT INTO users (email_user, pass_user) 
										VALUES ('" . $email . "', '" . $pass . "')");
			$this->db->commit();
			Api::response(200, $insert);
		else:
			Api::response(400, 'Bad Request');
		endif;
	}

	// Update an user
	public function actionUpdate(){
		$id_user   = F3::get('PARAMS.id');
		$data 	   = Put::get();

		$user = $this->db->exec('SELECT * FROM users WHERE id_user = ' . $id_user . ' LIMIT 1');

		if (!empty($user)):
			if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)):
				Api::response(400, 'Bad email');
			elseif (!empty($id) && !empty($data['email']) && !empty($data['pass'])):
				$this->db->begin();
				$update = $this->db->exec("UPDATE users 
											SET email_user = '" . $data['email'] . "', pass_user= '" . $data['pass'] . "' 
											WHERE id_user = '" . $id_user . "'");
				$this->db->commit();
				Api::response(200, $update);
			else:
				Api::response(400, 'Bad Request');
			endif;

		else:
			Api::response(404, 'User doesn\'t exist');
		endif;
	}

	// Delete an user
	public function actionDelete(){
		$id_user = F3::get('PARAMS.id');

		$this->db->begin();
		$query = $this->db->exec('DELETE FROM users WHERE id_user = ' . $id_user . '');
		$this->db->commit();

		if (!empty($query)):
			Api::response(200, 'Content deleted');
		else:
			Api::response(204, 'No Content');
		endif;
	}
}