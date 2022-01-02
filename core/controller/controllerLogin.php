<?php 
require_once("modele/login.php");

class controllerLogin {


	public static function create() {
		require("view/loginTemp.php");
	}

	public static function created() {
		$nom = $_POST["nom"];
		$prenom = $_POST["prenom"];
		$email = $_POST["email"];
        $mdp =$_POST["mdp"];
		login::addUser($nom,$prenom,$email,$mdp);
	}
}
