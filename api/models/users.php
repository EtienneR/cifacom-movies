<?php

class users{
 	
	private function db(){
		return new DB\SQL(
			'mysql:host=localhost;port=3306;dbname=api',
			'root',
			''
		);
	}

	function getToken($pass){
		$db = $this->db();
		$db->begin();
		$data = $db->exec('SELECT id_user, email_user, pass_user FROM users WHERE pass_user = "' . $pass . '"');
		return $data;	
	}


	function getUsers(){
		$db = $this->db();
		$db->begin();
		$data = $db->exec('SELECT id_user, email_user, pass_user FROM users');
		return $data;
	}

	function getUser($id_user){
		$db = $this->db();
		$db->begin();
		$data = $db->exec('SELECT id_user, email_user, pass_user FROM users WHERE id_user = "' . $id_user . '" LIMIT 1');

		return $data;
	}

	function createUser($email, $pass){
		$db = $this->db();
		$db->begin();
		$data = $db->exec("INSERT INTO users (email_user, pass_user) 
							VALUES ('" . $email . "', '" . $pass . "')");
		$db->commit();

		return $data;
	}

	function updateUser($email, $pass, $id_user){
		if(empty($email)):
			$email = '';
		else:
			$email = 'email_user = "'. $email . '", ';
		endif;

		if(empty($pass)):
			$pass = '';
		else:
			$pass = 'pass_user = "'. $pass . '"';
		endif;

		$params = $email.$pass;

		$db = $this->db();
		$db->begin();
		$data = $db->exec("UPDATE users 
						   SET " . $params . "
						   WHERE id_user = " . $id_user);
		$db->commit();

		return $data;
	}

	function deleteUser($id_user){
		$db = $this->db();
		$db->begin();
		$data = $db->exec('DELETE FROM users WHERE id_user = ' . $id_user);
		$db->commit();

		return $data;
	}

}