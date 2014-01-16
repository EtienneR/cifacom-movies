<?php

class MoviesController{

	private $model = null;
	public function __construct(){
		$this->model = new movies();
	}

	// Display all movies
	public function actionFind(){
		$data = $this->model->getMovies();

		if (!empty($data)):
			Api::response(200, $data);
		else:
			Api::response(204, 'No movies');
		endif;
	}

	// Display one movie
	public function actionFindOne(){
		$id_movie = F3::get('PARAMS.id');

		$data = $this->model->getMovie($id_movie);

		if (!empty($data)):
			Api::response(200, $data);
		else:
			Api::response(404, 'Error 404');
		endif;
	}

	// Create a movie
	public function actionCreate(){
		$name 	= F3::get('POST.name');
		$author = F3::get('POST.author');
		$date   = F3::get('POST.date');

		if (!preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date)):
			Api::response(400, 'Bad date');
		elseif (!empty($name) && !empty($author) && !empty($date)):
			$this->model->createMovie($name, $author, $date);
			Api::response(200, 'Movie added');
		else:
			Api::response(400, 'Bad Request');
		endif;
	}

	// Update a movie
	public function actionUpdate(){
		$id_movie = F3::get('PARAMS.id');
		$data 	  = Put::get();

		$movie = $this->model->getMovie($id_movie);

		if (!empty($movie)):
			if (!empty($id_movie) && !empty($data['name']) && !empty($data['author']) && !empty($data['date'])):
				$this->model->updateMovie($data['name'], $data['author'], $data['date'], $id_movie);
				Api::response(200, 'Movie updated');
			else:
				Api::response(400, 'Bad Request');
			endif;

		else:
			Api::response(404, 'Movie doesn\'t exist');
		endif;
	}

	// Delete a movie
	public function actionDelete(){
		$id_movie = F3::get('PARAMS.id');

		$query = $this->model->deleteMovie($id_movie);

		if (!empty($query)):
			Api::response(200, 'Movie deleted');
		else:
			Api::response(404, 'No Content');
		endif;
	}

}