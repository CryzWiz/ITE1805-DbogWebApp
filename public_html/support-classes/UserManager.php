<?php

/**
 * Created by PhpStorm.
 * User: Chexxor
 * Date: 4/21/2017
 * Time: 7:23 PM
 */

/**
 * Class UserManager = Users.php
 *
 * This class should have been placed in its corresponding class file under generated-classes.
 * But is located here to make a clear separation on our files and the generated files.
 */
class UserManager
{
	private $users = array();
	private $userDetails = array();

	public function getUser(String $email) : Users {
		if(!isset($users[$email])){
			$this->users[$email] = UsersQuery::create()->findOneByEmail($email);
		}
		return $this->users[$email];
	}

	public function getUserDetails(String $email) : Users {
		if(!isset($this->users[$email])){
			$this->userDetails[$email] = UsersQuery::create()->findOneByEmail($email);
		}
		return $this->userDetails[$email];

	}

	public function getFullName(String $email) : String {

		$details = $this->getUser($email);
		return $details->getFirstname() . " " . $details->getLastname();

	}
}