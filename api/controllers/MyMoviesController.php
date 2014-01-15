<?php

class MyMoviesController{

	private $db;
	public function __construct(){

		$this->db=new DB\SQL(
			'mysql:host=localhost;port=3306;dbname=api',
			'root',
			''
		);

	}

	# LIKE #
	// Afficher tous les films aimés par l'utilisateur
	public function actionLikedFindOne(){
		$id_user = F3::get('PARAMS.id');

		$this->db->begin();
		$user = $this->db->exec("SELECT id_user FROM users WHERE id_user = '" . $id_user . "' LIMIT 1");

		if (!empty($user)):
			$data = $this->db->exec('SELECT name_movie, author_movie, date_movie
									 FROM likes 
									 INNER JOIN movies ON likes.id_movie = movies.id_movie
									 INNER JOIN users ON likes.id_user = users.id_user
									 WHERE like_like = 1
									 AND users.id_user = ' . $id_user);

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
			$this->db->begin();
			$verif = $this->db->exec("SELECT id_like FROM likes WHERE id_user = " . $id_user . " AND id_movie = " . $id_movie . " LIMIT 1");

			if (!empty($verif)):
				$this->db->exec("UPDATE likes 
								 SET like_like = 1, seen_like = 1, would_see_like = 0 
								 WHERE id_user = " . $id_user . " AND id_movie = " . $id_movie);
				$this->db->commit();
				Api::response(200, 'Content updated');
			else:
				$this->db->exec("INSERT INTO likes (id_user, id_movie, like_like, seen_like)
								 VALUES ('" . $id_user . "', '" . $id_movie . "', 1, 1)");
				$this->db->commit();
				Api::response(200, 'Content added');
			endif;

		else:
			Api::response(400, 'Bad Request');
		endif;
	}

	// Mettre à jour ("supprimer") un film que l'utilisateur a aimé
	public function actionLikedUpdate(){
		$data = Put::get();

		if (!empty($data['user']) && !empty($data['movie'])):
			$this->db->begin();
			$this->db->exec("UPDATE likes SET like_like = 0 
									  WHERE id_user = " . $data['user'] . " AND id_movie = " . $data['movie']);
			$this->db->commit();
			Api::response(200, 'Content updated');
		else:
			Api::response(204, 'No Content');
		endif;
	}
	# FIN LIKE # 


	# A VU # 
	// Afficher tous les films vus par l'utilisateur
	public function actionSeeFindOne(){
		$id_user = F3::get('PARAMS.id');

		$this->db->begin();
		$user = $this->db->exec("SELECT id_user FROM users WHERE id_user = '" . $id_user . "' LIMIT 1");

		if (!empty($user)):
			$data = $this->db->exec('SELECT name_movie, author_movie, date_movie
									 FROM likes 
									 INNER JOIN movies ON likes.id_movie = movies.id_movie
									 INNER JOIN users ON likes.id_user = users.id_user
									 WHERE seen_like = 1
									 AND users.id_user = ' . $id_user);

			if (!empty($data)):
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
			$this->db->begin();
			$verif = $this->db->exec("SELECT id_like FROM likes WHERE id_user = " . $id_user . " AND id_movie = " . $id_movie . " LIMIT 1");

			if (!empty($verif)):
				$this->db->exec("UPDATE likes 
								    SET seen_like = 1, would_see_like = 0 
								  WHERE id_user = " . $id_user . " AND id_movie = " . $id_movie);
				$this->db->commit();
				Api::response(200, 'Content updated');
			else:
				$this->db->exec("INSERT INTO likes (id_user, id_movie, seen_like)
								 VALUES ('" . $id_user . "', '" . $id_movie . "', 1)");
				$this->db->commit();
				Api::response(200, 'Content added');
			endif;

		else:
			Api::response(400, 'Bad Request');
		endif;
	}

	// Mettre à jour ("supprimer") un film que l'utilisateur a vu
	public function actionSeeUpdate(){
		$data = Put::get();

		if (!empty($data['user']) && !empty($data['movie'])):
			$this->db->begin();
			$this->db->exec("UPDATE likes 
									  SET see_like = 0 
									  WHERE id_user = " . $data['user'] . "
									  AND id_movie = " . $data['movie']);
			$this->db->commit();
			Api::response(200, 'Content updated');
		else:
			Api::response(204, 'No Content');
		endif;
	}
	# FIN A VU # 


	# VOUDRAIT VOIR # 
	// Afficher tous les films que l'utilisateur voudrait voir
	public function actionWould_seeFindOne(){
		$id_user = F3::get('PARAMS.id');

		$this->db->begin();
		$user = $this->db->exec("SELECT id_user FROM users WHERE id_user = '" . $id_user . "' LIMIT 1");

		if (!empty($user)):
			$data = $this->db->exec('SELECT name_movie, author_movie, date_movie
									 FROM likes 
									 INNER JOIN movies ON likes.id_movie = movies.id_movie
									 INNER JOIN users ON likes.id_user = users.id_user
									 WHERE would_see_like = 1
									 AND users.id_user = ' . $id_user);

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
			$this->db->begin();
			$verif = $this->db->exec("SELECT id_like FROM likes WHERE id_user = " . $id_user . " AND id_movie = " . $id_movie . " LIMIT 1");

			if (!empty($verif)):
				$this->db->exec("UPDATE likes 
								 SET like_like = 0, seen_like = 0, would_see_like = 1 
								 WHERE id_user = " . $id_user . " AND id_movie = " . $id_movie);
				$this->db->commit();
				Api::response(200, 'Content updated');
			else:
				$this->db->exec("INSERT INTO likes (id_user, id_movie, would_see_like)
								 VALUES ('" . $id_user . "', '" . $id_movie . "', 1)");
				$this->db->commit();
				Api::response(200, 'Content added');
			endif;

		else:
			Api::response(400, 'Bad Request');
		endif;
	}

	// Mettre à jour ("supprimer") un film que l'utilisateur voudrait voir
	public function actionWould_seeUpdate(){
		$data = Put::get();

		if (!empty($data['user']) && !empty($data['movie'])):
			$this->db->begin();
			$this->db->exec("UPDATE likes 
							 SET would_see_like = 0 
							 WHERE id_user = " . $data['user'] . "
							 AND id_movie = " . $data['movie']);
			$this->db->commit();
			Api::response(200, 'Content updated');
		else:
			Api::response(204, 'No Content');
		endif;
	}
	# FIN VOUDRAIT VOIR # 

}