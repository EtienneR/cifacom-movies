<?php

class UsersController{

	private $model = null;
	public function __construct(){
		$this->model = new users();
	}

	// Display all users
	public function actionFind(){
		$pass = F3::get('GET.token');
		$token = $this->model->getToken($pass);

		if(!empty($token)):

			$data = $this->model->getUsers();

			if (!empty($data)):
				Api::response(200, $data);
			else:
				Api::response(204, 'No users');
			endif;

		elseif(empty($pass)):
			Api::response(401, 'Hum... you need a token');
		else:
			Api::response(403, 'Invalid token');
		endif;
	}

	// Display an user
	public function actionFindOne(){
		$id_user = F3::get('PARAMS.id');

		$data = $this->model->getUser($id_user);

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
			$this->model->createUser($email, $pass);
			Api::response(200, 'User created');
		else:
			Api::response(400, 'Bad Request');
		endif;
	}

	// Update an user
	public function actionUpdate(){
		$id_user = F3::get('PARAMS.id');
		$data 	 = Put::get();

		$user = $this->model->getUser($id_user);

		if (!empty($user)):

			if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)):
				Api::response(400, 'Bad email');
			elseif (!empty($id_user) && !empty($data['email']) && !empty($data['pass'])):
				$this->model->updateUser($data['email'], $data['pass'], $id_user);
				Api::response(200, 'Content updated');
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
		$query = $this->model->deleteUser($id_user);

		if (!empty($query)):
			Api::response(200, 'Content deleted');
		else:
			Api::response(404, 'No Content');
		endif;
	}

}