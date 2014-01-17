<?php

class MoviesController{

	public function __construct(){
		$this->model_movies = new movies();
		$this->model_users = new users();
	}

	// Display all movies
	public function actionFind(){
		$data = $this->model_movies->getMovies();

		if (!empty($data)):
			Api::response(200, $data);
		else:
			Api::response(204, 'No movies into the database');
		endif;
	}

	// Display one movie
	public function actionFindOne(){
		$id_movie = F3::get('PARAMS.id');

		$data = $this->model_movies->getMovie($id_movie);

		if (!empty($data)):
			Api::response(200, $data);
		else:
			Api::response(404, 'Movie not found');
		endif;
	}

	// Create a movie
	public function actionCreate(){
		$name 	= F3::get('POST.name');
		$author = F3::get('POST.author');
		$date   = F3::get('POST.date');
		$token  = F3::get('GET.token');

		$getToken = $this->model_users->getToken($token);

		if (!empty($getToken)):

			if (!preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date)):
				Api::response(400, 'Bad date, impossible to add a new movie');
			elseif (!empty($name) && !empty($author) && !empty($date)):
				$this->model_movies->createMovie($name, $author, $date);
				Api::response(200, 'Movie added');
			else:
				Api::response(400, 'Bad request');
			endif;

		elseif (empty($token)):
			Api::response(401, 'Hum... you need a token');
		else:
			Api::response(403, 'Invalid token');
		endif;
	}

	// Update a movie
	public function actionUpdate(){
		$id_movie = F3::get('PARAMS.id');
		$data 	  = Put::get();
		$token    = F3::get('GET.token');

		$getToken = $this->model_users->getToken($token);

		if (!empty($getToken)):

			$movie = $this->model_movies->getMovie($id_movie);

			if (!empty($movie)):
				if (!empty($id_movie) && !empty($data['name']) && !empty($data['author']) && !empty($data['date'])):
					$this->model_movies->updateMovie($data['name'], $data['author'], $data['date'], $id_movie);
					Api::response(200, 'Movie updated');
				else:
					Api::response(400, 'Bad Request');
				endif;

			else:
				Api::response(404, 'Movie doesn\'t exist');
			endif;

		elseif (empty($token)):
			Api::response(401, 'Hum... you need a token');
		else:
			Api::response(403, 'Invalid token');
		endif;
	}

	// Delete a movie
	public function actionDelete(){
		$id_movie = F3::get('PARAMS.id');
		$token    = F3::get('GET.token');

		$getToken = $this->model_users->getToken($token);

		if (!empty($getToken)):
			$query = $this->model_movies->deleteMovie($id_movie);

			if (!empty($query)):
				Api::response(200, 'Movie deleted');
			else:
				Api::response(404, 'Movie doesn\'t exist');
			endif;	

		elseif (empty($token)):
			Api::response(401, 'Hum... you need a token');
		else:
			Api::response(403, 'Invalid token');
		endif;
	}

}