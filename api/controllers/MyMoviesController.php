<?php

class MyMoviesController{

	private $db;
	public function __construct(){
		$this->model_likes = new likes();
		$this->model_users = new users();
	}

	# LIKE #
	// Afficher tous les films aimés par l'utilisateur
	public function actionLikedFindOne(){
		$id_user = F3::get('PARAMS.id');

		$user = $this->model_users->getUser($id_user);

		if (!empty($user)):
			$data = $this->model_likes->getLikes($id_user);

			if (!empty($data)):
				Api::response(200, $data);
			else:
				Api::response(204, 'No content liked by this user');
			endif;

		else:
			Api::response(400, 'Bad ID : this user doesn\'t exist');
		endif;
	}


	// Créer un film que l'utilisateur a aimé
	public function actionLikedCreate(){
		$id_user  = f3::get('POST.user');
		$id_movie = f3::get('POST.movie');

		if (!empty($id_user) && !empty($id_movie)):
			$check_like = $this->model_likes->checkLike($id_user, $id_movie);

			if (empty($check_like)):
				$this->model_likes->createLike($id_user, $id_movie);
				Api::response(200, 'Content added');
			else:
				$this->model_likes->updateLike($id_user, $id_movie, $statut = '');
				Api::response(200, 'Content updated');
			endif;

		else:
			Api::response(400, 'Bad Request');
		endif;
	}

	// Mettre à jour ("supprimer") un film que l'utilisateur a aimé
	public function actionLikedUpdate(){
		$data = Put::get();

		if (!empty($data['user']) && !empty($data['movie'])):
			$this->model_likes->updateLike($data['user'], $data['movie'], $statut = 'delete');
			Api::response(200, 'Content updated');;
		else:
			Api::response(204, 'No Content');
		endif;
	}
	# FIN LIKE # 


	# A VU # 
	// Afficher tous les films vus par l'utilisateur
	public function actionSeeFindOne(){
		$id_user = F3::get('PARAMS.id');

		$user = $this->model_users->getUser($id_user);

		if (!empty($user)):
			$data = $this->model_likes->getLikes($id_user);

			if (empty($data)):
				Api::response(200, $data);
			else:
				Api::response(204, 'No content seen by this user');
			endif;

		else:
			Api::response(400, 'Bad ID : this user doesn\'t exist');
		endif;
	}

	// L'utilisateur a vu un film 
	public function actionSeeCreate(){
		$id_user  = f3::get('POST.user');
		$id_movie = f3::get('POST.movie');

		if (!empty($id_user) && !empty($id_movie)):
			$check_like = $this->model_likes->checkLike($id_user, $id_movie);

			if (empty($check_like)):
				$this->model_likes->createSee($id_user, $id_movie);
				Api::response(200, 'Content added');
			else:
				$this->model_likes->updateSee($id_user, $id_movie, $statut = '');
				Api::response(200, 'Content updated');
			endif;

		else:
			Api::response(400, 'Bad Request');
		endif;
	}

	// Mettre à jour ("supprimer") un film que l'utilisateur a vu
	public function actionSeeUpdate(){
		$data = Put::get();

		if (!empty($data['user']) && !empty($data['movie'])):
			$this->model_likes->updateSee($data['user'], $data['movie'], $statut = 'delete');
			Api::response(200, 'Content updated');;
		else:
			Api::response(204, 'No Content');
		endif;
	}
	# FIN A VU # 


	# VOUDRAIT VOIR # 
	// Afficher tous les films que l'utilisateur voudrait voir
	public function actionWould_seeFindOne(){
		$id_user = F3::get('PARAMS.id');

		$user = $this->model_users->getUser($id_user);

		if (!empty($user)):
			$data = $this->model_likes->getWouldSee($id_user);

			if (!empty($data)):
				Api::response(200, $data);
			else:
				Api::response(204, 'No content would see by this user');
			endif;

		else:
			Api::response(400, 'Bad ID : this user doesn\'t exist');
		endif;
	}

	// Créer un film que l'utilisateur voudrait voir
	public function actionWould_seeCreate(){
		$id_user  = f3::get('POST.user');
		$id_movie = f3::get('POST.movie');

		if (!empty($id_user) && !empty($id_movie)):
			$check_like = $this->model_likes->checkLike($id_user, $id_movie);
			
			if (empty($check_like)):
				$this->model_likes->createWouldSee($id_user, $id_movie);
				Api::response(200, 'Content added');
			else:
				$this->model_likes->updateWouldSee($id_user, $id_movie, $statut = '');
				Api::response(200, 'Content updated');
				
			endif;

		else:
			Api::response(400, 'Bad Request');
		endif;
	}

	// Mettre à jour ("supprimer") un film que l'utilisateur voudrait voir
	public function actionWould_seeUpdate(){
		$data = Put::get();

		if (!empty($data['user']) && !empty($data['movie'])):
			$this->model_likes->updateWouldSee($data['user'], $data['movie'], $statut = 'delete');
			Api::response(200, 'Content updated');;
		else:
			Api::response(204, 'No Content');
		endif;
	}
	# FIN VOUDRAIT VOIR # 

}