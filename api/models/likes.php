<?php

class likes{
 	
	private function db(){
		return new DB\SQL(
			'mysql:host=localhost;port=3306;dbname=api',
			'root',
			''
		);
	}

	function checkLike($id_user, $id_movie){
		$db = $this->db();
		$db->begin();
		$data = $db->exec("SELECT id_like 
						   FROM likes 
						   WHERE id_user = " . $id_user . " 
						   AND id_movie = " . $id_movie . " 
						   LIMIT 1");

		return $data;
	}

	function getUserAction($id_user = '', $action = ''){
		if (!empty($id_user)):
			$params_user = 'AND likes.id_user = "' . $id_user . '"';
		else:
			$params_user = '';
		endif;

		switch ($action) {
			case 'like':
				$params_action = 'like_like = 1';
				break;
			case 'see':
				$params_action = 'like_like = 1';
				break;
			case 'would_see':
				$params_action = 'would_see_like = 1';
				break;
			default:
				$params_action = '';
				break;
		}

		$db = $this->db();
		$db->begin();
		$data = $db->exec('SELECT name_movie, author_movie, date_movie
						   FROM likes 
						   INNER JOIN movies ON likes.id_movie = movies.id_movie
						   INNER JOIN users ON likes.id_user = users.id_user
						   WHERE ' . $params_action. ' ' . $params_user);
		return $data;	
	}


	function createLike($id_user, $id_movie){
		$db = $this->db();
		$db->begin();
		$data = $db->exec("INSERT INTO likes (id_user, id_movie, like_like, seen_like)
						   VALUES ('" . $id_user . "', '" . $id_movie . "', 1, 1)");
		$db->commit();

		return $data;
	}


	function updateLike($id_user, $id_movie, $statut){
		if ($statut == 'delete'):
			$set = 'SET like_like = 0';
		else:
			$set = 'SET like_like = 1, seen_like = 1, would_see_like = 0';
		endif;

		$db = $this->db();
		$db->begin();

		$data = $db->exec("UPDATE likes 
						   " . $set . "
						   WHERE id_user = " . $id_user . " AND id_movie = " . $id_movie);

		$db->commit();

		return $data;
	}


	function createSee($id_user, $id_movie){
		$db = $this->db();
		$db->begin();
		$data = $db->exec("INSERT INTO likes (id_user, id_movie, seen_like)
						   VALUES ('" . $id_user . "', '" . $id_movie . "', 1)");
		$db->commit();

		return $data;
	}

	function updateSee($id_user, $id_movie, $statut){
		if ($statut == 'delete'):
			$set = 'SET seen_like = 0';
		else:
			$set = 'SET seen_like = 1, would_see_like = 0';
		endif;

		$db = $this->db();
		$db->begin();

		$data = $db->exec("UPDATE likes 
						   " . $set . "
						   WHERE id_user = " . $id_user . " AND id_movie = " . $id_movie);
		$db->commit();

		return $data;
	}


	function createWouldSee($id_user, $id_movie){
		$db = $this->db();
		$db->begin();
		$data = $db->exec("INSERT INTO likes (id_user, id_movie, would_see_like)
						   VALUES ('" . $id_user . "', '" . $id_movie . "', 1)");
		$db->commit();

		return $data;
	}

	function updateWouldSee($id_user, $id_movie, $statut){
		if($statut == 'delete'):
			$set = 'SET would_see_like = 0';
		else:
			$set = 'SET like_like = 0, seen_like = 0, would_see_like = 1';
		endif;

		$db = $this->db();
		$db->begin();

		$data = $db->exec("UPDATE likes 
						   " . $set . "
						   WHERE id_user = " . $id_user . " AND id_movie = " . $id_movie);
		$db->commit();

		return $data;
	}

}