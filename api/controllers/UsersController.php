<?php

class UsersController{

	public function __construct(){
		$this->model_users = new users();
	}

	// Display all users
	public function actionFind(){
		$data = $this->model_users->getUsers();

		if (!empty($data)):
			Api::response(200, $data);
		else:
			Api::response(204, 'No users into the database');
		endif;
	}

	// Display an user
	public function actionFindOne(){
		$id_user = F3::get('PARAMS.id');

		$data = $this->model_users->getUser($id_user);

		if (!empty($data)):
			Api::response(200, $data);
		else:
			Api::response(404, 'Error 404 : this user doesn\'t exist');
		endif;
	}

	// Create an user
	public function actionCreate(){
		$email = F3::get('POST.email');
		$pass  = F3::get('POST.pass');
		$token = F3::get('GET.token');

		$getToken = $this->model_users->getToken($token);

		if (!empty($getToken)):

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)):
				Api::response(400, 'Bad email, impossible to create a new user');
			elseif (!empty($email) && !empty($pass)):
				$this->model_users->createUser($email, $pass);
				Api::response(200, 'User created');
			else:
				Api::response(400, 'Bad Request');
			endif;

		elseif (empty($token)):
			Api::response(401, 'Hum... you need a token');
		else:
			Api::response(403, 'Invalid token');
		endif;
	}

	// Update an user
	public function actionUpdate(){
		$id_user = F3::get('PARAMS.id');
		$data 	 = Put::get();
		$token   = F3::get('GET.token');

		$getToken = $this->model_users->getToken($token);

		if (!empty($getToken)):
			$user = $this->model_users->getUser($id_user);

			if (!empty($user)):

				if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)):
					Api::response(400, 'Bad email, impossible to create a new user');
				elseif (!empty($id_user)):
					$this->model_users->updateUser($data['email'], $data['pass'], $id_user);
					Api::response(200, 'User ' . $id_user . ' updated');
				else:
					Api::response(400, 'Bad Request');
				endif;

			else:
				Api::response(404, 'User ' . $id_user . ' doesn\'t exist');
			endif;

		elseif (empty($token)):
			Api::response(401, 'Hum... you need a token');
		else:
			Api::response(403, 'Invalid token');
		endif;
	}

	// Delete an user
	public function actionDelete(){
		$id_user = F3::get('PARAMS.id');
		$token   = F3::get('GET.token');

		$getToken = $this->model_users->getToken($token);
		
		if (!empty($getToken)):
			$query = $this->model_users->deleteUser($id_user);

			if (!empty($query)):
				Api::response(200, 'User ' . $id_user . ' deleted');
			else:
				Api::response(404, 'User doesn\'t exist');
			endif;

		elseif (empty($token)):
			Api::response(401, 'Hum... you need a token');
		else:
			Api::response(403, 'Invalid token');
		endif;
	}

}