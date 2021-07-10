<?php

class WrongModel extends Model {
	public function checkUser () {
		
		$email = $_POST['email'] ?? '';
		$password = $_POST['password'] ?? '';

			$resultchkuser = array();

			$sql = "SELECT `id`,`First name`,`Last name`,`status` FROM `users` WHERE `email` = :email and `pass` = :password ";

			$smtpc = $this->db->prepare($sql);
			$smtpc->bindValue(":email", $email, PDO::PARAM_STR);
			$smtpc->bindValue(":password", $password, PDO::PARAM_STR);
			$smtpc->execute();

			$resc=$smtpc->fetch(PDO::FETCH_ASSOC);

			if ($smtpc->rowCount() != 0){
				$_SESSION['user_id'] = $resc['id'];
				$_SESSION['first-name'] = $resc['First name'];
				$_SESSION['last-name'] = $resc['Last name'];
				$_SESSION['status'] = $resc['status'];
				return $resc;
			}
		
    }
}