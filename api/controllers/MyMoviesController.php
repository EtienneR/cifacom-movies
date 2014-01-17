<?php

class MyMoviesController{

	private $db;
	public function __construct(){
		$this->model_likes = new likes();
		$this->model_users = new users();
	}


	// Displaying all movies liked by all users
	public function actionLikedFind(){
		$data = $this->model_likes->getUserAction($id_user = '', $action = 'like');

		if (!empty($data)):
			Api::response(200, $data);
		else:
			Api::response(204, 'No movies liked');
		endif;
	}

	// Displaying all movies liked by the user
	public function actionLikedFindOne(){
		$id_user = F3::get('PARAMS.id');

		$user = $this->model_users->getUser($id_user);

		if (!empty($user)):
			$data = $this->model_likes->getUserAction($id_user, $action = 'like');

			if (!empty($data)):
				Api::response(200, $data);
			else:
				Api::response(204, 'No movies liked by this user');
			endif;

		else:
			Api::response(400, 'Bad ID : this user doesn\'t exist');
		endif;
	}


	// Create a movie liked by the the user
	public function actionLikedCreate(){
		$id_user  = F3::get('POST.user');
		$id_movie = F3::get('POST.movie');
		$token    = F3::get('GET.token');

		$getToken = $this->model_users->getToken($token);

		if (!empty($getToken)):

			if (!empty($id_user) && !empty($id_movie)):
				$check_like = $this->model_likes->checkLike($id_user, $id_movie);

				if (empty($check_like)):
					$this->model_likes->createLike($id_user, $id_movie);
					Api::response(200, 'Movie added as liked');
				else:
					$this->model_likes->updateLike($id_user, $id_movie, $statut = '');
					Api::response(200, 'Movie updated as liked');
				endif;

			else:
				Api::response(400, 'Bad Request');
			endif;

		elseif (empty($token)):
			Api::response(401, 'Hum... you need a token');
		else:
			Api::response(403, 'Invalid token');
		endif;
	}

	// "Delete" a movie liked by the user
	public function actionLikedUpdate(){
		$data  = Put::get();
		$token = F3::get('GET.token');

		$getToken = $this->model_users->getToken($token);

		if (!empty($getToken)):

			if (!empty($data['user']) && !empty($data['movie'])):
				$this->model_likes->updateLike($data['user'], $data['movie'], $statut = 'delete');
				Api::response(200, 'Movies updated liked to unliked');;
			else:
				Api::response(204, 'No movies');
			endif;

		elseif (empty($token)):
			Api::response(401, 'Hum... you need a token');
		else:
			Api::response(403, 'Invalid token');
		endif;
	}


	// Displaying all see liked by all users
	public function actionSeeFind(){
		$data = $this->model_likes->getUserAction($id_user = '', $action = 'see');

		if (!empty($data)):
			Api::response(200, $data);
		else:
			Api::response(204, 'No movies seen');
		endif;
	}

	// Displaying all movies see by all users
	public function actionSeeFindOne(){
		$id_user = F3::get('PARAMS.id');

		$user = $this->model_users->getUser($id_user);

		if (!empty($user)):
			$data = $this->model_likes->getUserAction($id_user, $action = 'see');

			if (!empty($data)):
				Api::response(200, $data);
			else:
				Api::response(204, 'No movies seen by this user');
			endif;

		else:
			Api::response(400, 'Bad ID : this user doesn\'t exist');
		endif;
	}

	// Create a movie see by the user
	public function actionSeeCreate(){
		$id_user  = F3::get('POST.user');
		$id_movie = F3::get('POST.movie');
		$token 	  = F3::get('GET.token');

		$getToken = $this->model_users->getToken($token);

		if (!empty($getToken)):

			if (!empty($id_user) && !empty($id_movie)):
				$check_like = $this->model_likes->checkLike($id_user, $id_movie);

				if (empty($check_like)):
					$this->model_likes->createSee($id_user, $id_movie);
					Api::response(200, 'Movie added as see');
				else:
					$this->model_likes->updateSee($id_user, $id_movie, $statut = '');
					Api::response(200, 'Movie updated as see');
				endif;

			else:
				Api::response(400, 'Bad Request');
			endif;

		elseif (empty($token)):
			Api::response(401, 'Hum... you need a token');
		else:
			Api::response(403, 'Invalid token');
		endif;
	}

	// "Delete" a movie see by the user
	public function actionSeeUpdate(){
		$data  = Put::get();
		$token = F3::get('GET.token');

		$getToken = $this->model_users->getToken($token);

		if (!empty($getToken)):

			if (!empty($data['user']) && !empty($data['movie'])):
				$this->model_likes->updateSee($data['user'], $data['movie'], $statut = 'delete');
				Api::response(200, 'Movie updated see to unsee this user');;
			else:
				Api::response(204, 'No movies');
			endif;

		elseif (empty($token)):
			Api::response(401, 'Hum... you need a token');
		else:
			Api::response(403, 'Invalid token');
		endif;
	}


	// Displaying all movies that users would see
	public function actionWouldSeeFind(){
		$data = $this->model_likes->getUserAction($id_user = '', $action = 'would_see');

		if (!empty($data)):
			Api::response(200, $data);
		else:
			Api::response(204, 'No movies');
		endif;
	}

	// Displaying all movies that the user would see
	public function actionWouldSeeFindOne(){
		$id_user = F3::get('PARAMS.id');

		$user = $this->model_users->getUser($id_user);

		if (!empty($user)):
			$data = $this->model_likes->getUserAction($id_user, $action = 'would_see');

			if (!empty($data)):
				Api::response(200, $data);
			else:
				Api::response(204, 'No movies would see by this user');
			endif;

		else:
			Api::response(400, 'Bad ID : this user doesn\'t exist');
		endif;
	}

	// Creating a movie that the user would see
	public function actionWouldSeeCreate(){
		$id_user  = F3::get('POST.user');
		$id_movie = F3::get('POST.movie');
		$token    = F3::get('GET.token');

		$getToken = $this->model_users->getToken($token);

		if (!empty($getToken)):

			if (!empty($id_user) && !empty($id_movie)):
				$check_like = $this->model_likes->checkLike($id_user, $id_movie);
				
				if (empty($check_like)):
					$this->model_likes->createWouldSee($id_user, $id_movie);
					Api::response(200, 'Movie would see added');
				else:
					$this->model_likes->updateWouldSee($id_user, $id_movie, $statut = '');
					Api::response(200, 'Movie would see updated');
				endif;

			else:
				Api::response(400, 'Bad Request');
			endif;

		elseif (empty($token)):
			Api::response(401, 'Hum... you need a token');
		else:
			Api::response(403, 'Invalid token');
		endif;
	}

	// "Delete" a movie that the user would see
	public function actionWouldSeeUpdate(){
		$data  = Put::get();
		$token = F3::get('GET.token');

		$getToken = $this->model_users->getToken($token);

		if (!empty($getToken)):

			if (!empty($data['user']) && !empty($data['movie'])):
				$this->model_likes->updateWouldSee($data['user'], $data['movie'], $statut = 'delete');
				Api::response(200, 'Movie updated would see to no would see');;
			else:
				Api::response(204, 'No movie');
			endif;

		elseif (empty($token)):
			Api::response(401, 'Hum... you need a token');
		else:
			Api::response(403, 'Invalid token');
		endif;
	}

}