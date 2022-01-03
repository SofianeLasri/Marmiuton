<?php
//Chargement des pages
function loadPage(){
    global $ip;
    global $localSettings, $urlPath;
    // S'il existe un paramètre on l'affecte à pageName

    // Ici on va vérifier le mode de récupération de l'url
    if($localSettings["urlMode"] == "parameters"){
        // Ici on fonctionne en mode paramètres, on va donc reconstruire l'alias

        $alias = array();
        // Si le paramètre admin existe (pas besoin qu'il ai de valeur)
        if(isset($_GET['admin'])){
            $alias[] = "admin"; // Alors on l'ajoute à l'alias
        }
        // Pareil pour les pages
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $alias[] = $_GET['page'];
        }else{
            // Maisi ici on va donner une valeur par défaut
            $alias[] = "vitrine";
        }
    }else{
        // Si on est en mode alias, alors on récupère directement la variable $urlPath
        $alias = $urlPath;
    }

    if(empty($alias[0])){
        // Si le premier alias est vide, on va donc charger la page vitrine
        $alias[0] = "vitrine";
    }

    // Maintenant qu'alias[0] aura toujours une valeur, on peut commencer à la comparer
    if($alias[0]=="backTasks"){
        // Si le premier alias est backTasks, on va donc charger la page backTasks
        // backTasks est un alias que l'on appel pour toutes requêtes Javascript ex: vérification de l'existence d'un email dans la bdd
        require "core/controller/backTasks.php";
    }elseif($alias[0]=="admin"){
        // Si le premier alias est admin, on va donc appeller la fonction qui se charge de gérer les pages admin
        array_shift($alias); // On supprime le /admin pour que la fonction loadAdminPage puisse directement vérifier les pages
        loadAdminPage($alias);
    }else{
        // Il s'agit d'une page client
        // On va vérifier que la page existe
        if(file_exists('pages/client/'.$alias[0].'.php')){
            require 'pages/client/'.$alias[0].'.php';
        }else{
            // Si elle n'existe pas, on va charger la page 404
            show404($alias[0]);
        }
    }
}
// Pages admins uniquement
function loadAdminPage($alias){
    
}

// Afficher la page 404
function show404($pageName){
    require 'pages/client/404.php';
}
function ShowConnexion($pageName){
    require 'pages/Connexion.php';
}
// Récupérer les dépendances
function getDepedencies(){
    require 'core/conf/dependencies.php';
}

//récupère la barre de navigation
function getNavbar(){
    require 'pages/includes/navbar.php';
}
//récupère le footer
function getFooter(){
    require 'pages/includes/footer.php';
}

// Vérifie si un username ou un email existe dans la bdd
function checkUsernameEmail($data){
	$pos = strpos($data, "@");
	if ($pos !== false) {
		$response = Connexion::pdo()->prepare("SELECT * FROM m_userSetting WHERE name='email' AND value=?");
		$response->execute([strtolower($data)]);
		if (empty($response->fetch())) {
			return false;
		} else {
			return true;
		}
	} else {
		$response = Connexion::pdo()->prepare("SELECT * FROM m_utilisateur WHERE username=?");
		$response->execute([strtolower($data)]);
		if (empty($response->fetch())) {
			return false;
		} else {
			return true;
		}
	}
}