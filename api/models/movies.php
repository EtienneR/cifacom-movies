<?php

class movies{
 	
	private function db(){
		return new DB\SQL(
			'mysql:host=localhost;port=3306;dbname=api',
			'root',
			''
		);
	}

	function getMovies(){
		$db = $this->db();
		$db->begin();
		$data = $db->exec('SELECT * FROM movies');

		return $data;
	}

	function getMovie($id_movie){
		$db = $this->db();
		$db->begin();
		$data = $db->exec('SELECT * FROM movies WHERE id_movie = ' . $id_movie .' LIMIT 1');

		return $data;
	}

	function createMovie($name, $author, $date){
		$db = $this->db();
		$db->begin();
		$data = $db->exec("INSERT INTO movies (name_movie, author_movie, date_movie) 
						   VALUES ('" . $name . "', '" . $author . "', '" . $date . "')");
		$db->commit();

		return $data;
	}

	function updateMovie($name, $author, $date, $id_movie){
		$db = $this->db();
		$db->begin();
		$data = $db->exec("UPDATE movies
						   SET name_movie = '" . $name . "', author_movie = '" . $author . "', date_movie = '" . $date . "'
						   WHERE id_movie = " . $id_movie);
		$db->commit();

		return $data;
	}

	function deleteMovie($id_movie){
		$db = $this->db();
		$db->begin();
		$data = $db->exec('DELETE FROM movies WHERE id_movie = ' . $id_movie);
		$db->commit();

		return $data;
	}

}