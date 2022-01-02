<?php
require_once("./conf/Connexion.php");
Connexion::connect();
class Login {

	private $nom;
	private $prenom;
	private $email;
    private $mdp;
	// getter      
	public function getNom() {return $this->nom;}
	public function getPrenom() {return $this->prenom;}
	public function getEmail() {return $this->email;}
    public function getMdp() {return $this->mdp;}

	// setter 
	public function setNom($n) {$this->Nom = $n;}
	public function setPrenom($p) {$this->Prenom = $p;}
	public function setEmail($e) {$this->Email = $e;}
    public function setMdp($m) {$this->Mdp = $m;}
	// un constructeur
	public function __construct($n = NULL, $p = NULL, $e = NULL, $m = NULL)  {
		if (!is_null($n) && !is_null($p) && !is_null($e) && !is_null($m)) {
			$this->nom = $n;
			$this->prenom = $p;
			$this->email = $e;
            $this->mdp = $m;
		}
	} 
    public static function addLogin($nom,$prenom,$email,$mdp) {
		$requetePreparee = "INSERT INTO m_utilisateur (username,password) VALUES(:tag_username,:tag_password);";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_username" => $nom,
			"tag_password" => $mdp,
		);
		try {
			$req_prep->execute($valeurs);
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
	}