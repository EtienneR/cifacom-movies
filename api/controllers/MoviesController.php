<?php

class MoviesController{

	private $db;
	public function __construct(){

		$this->db=new DB\SQL(
			'mysql:host=localhost;port=3306;dbname=api',
			'root',
			''
		);

	}

	// Display all movies
	public function actionFind(){
		$this->db->begin();
		$data = $this->db->exec('SELECT * FROM movies');

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
		$data = $this->db->exec('SELECT * FROM movies WHERE id_movie = ' . $id_user);

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
			$this->db->begin();
			$insert = $this->db->exec("INSERT INTO movies (name_movie, author_movie, date_movie) 
										VALUES ('" . $name . "', '" . $author . "' , '" . $date . "' )");
			$this->db->commit();
			Api::response(200, $insert);
		else:
			Api::response(400, 'Bad Request');
		endif;
	}

	// Update a movie
	public function actionUpdate(){
		$id_movie = F3::get('PARAMS.id');
		$data 	  = Put::get();

		$movie = $this->db->exec('SELECT * FROM users WHERE id_user = ' . $id);

		if (!empty($movie)):
			if (!empty($id) && !empty($data['name']) && !empty($data['author'])):
				$this->db->begin();
				$update = $this->db->exec("UPDATE movies 
											SET name_movie = '" . $data['name'] . "', author_movie= '" . $data['author'] . "' 
											WHERE id_movie = '" . $id_movie);
				$this->db->commit();
				Api::response(200, $update);
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

		$this->db->begin();
		$query = $this->db->exec('DELETE FROM movies WHERE id_movie = ' . $id_movie . '');
		$this->db->commit();

		if (!empty($query)):
			Api::response(200, 'Content deleted');
		else:
			Api::response(204, 'No Content');
		endif;
	}
}