<?php
//Chargement des pages
function loadPage(){
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
function login($usernameEmail, $password){
    global $ip;
    $usernameEmail = strtolower($usernameEmail);
    $pos = strpos($usernameEmail, "@");
    if ($pos !== false) {
        $response = Connexion::pdo()->prepare("SELECT userId FROM m_userSetting WHERE name='email' AND value=?");
        $response->execute([$usernameEmail]);
        $supposedUserId = $response->fetchColumn();

        $response = Connexion::pdo()->prepare("SELECT * FROM m_utilisateur WHERE id=?");
        $response->execute([$supposedUserId]);
    } else {
        $response = Connexion::pdo()->prepare("SELECT * FROM m_utilisateur WHERE username=?");
        $response->execute([$usernameEmail]);
    }
    $user=$response->fetch(PDO::FETCH_ASSOC);
    if (!empty($user)) {
        if(password_verify($password, $user["password"])){
            // On vérifie l'ip
            $response = Connexion::pdo()->prepare("SELECT * FROM m_userSetting WHERE userId=? AND name='lastIp'");
            $response->execute([$user['id']]);
            $result = $response->fetch(PDO::FETCH_ASSOC);

            if (empty($result)) {
                // Aucun champ d'ip n'existe
                $response = Connexion::pdo()->prepare("INSERT INTO m_userSetting (`userId`, `name`, `value`) VALUES (?,?,?)");
                $response->execute([$user['id'], 'lastIp', $ip]);
            }else{
                if($result["value"]!=$ip){
                    // Il existe un champ, on va le comparer
                    $response = Connexion::pdo()->prepare("UPDATE m_userSetting SET `value`=? WHERE `userId`=?");
                    $response->execute($ip, $user['id']);
                }
                
            }

            $_SESSION['userId'] = $user['id'];
            $_SESSION['userName'] = $user['username'];
            $_SESSION['userGroupId'] = $user['groupId'];

            $userProfilPic = Connexion::pdo()->prepare("SELECT value FROM m_userSetting WHERE userId=? AND name='profilPic'");
            $userProfilPic->execute([$user['id']]);
            $userProfilPic = $userProfilPic->fetchColumn();

            if (empty($userProfilPic)) {
                $userProfilPic = "/data/images/misc/user.png";
            }
            
            $_SESSION['userProfilePic'] = $userProfilPic;
            $return["success"] = "Connexion réussie, bienvenue " . $_SESSION['userName'] . "! 🥳";
        } else {
            $return["error"] = "Mauvais couple identifiant/mot de passe.";
        }
    } else {
        $return["error"] = "Mauvais couple identifiant/mot de passe.";
    }
    return $return;
}

function registerUser($username, $password, $email){
    if (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}$/', $password)==1) {
        $username = strtolower($username);
        $email = strtolower($email); // ici on converti l'email donné en casse minuscule
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Ici on récupère l'id du groupe des utilisateurs
        $userGroupId = Connexion::pdo()->query("SELECT id FROM m_groupeUtilisateur WHERE nom='utilisateur'")->fetchColumn();

        // Là on va insérer l'utilisateur dans la table des utilisateurs
        $query = Connexion::pdo()->prepare("INSERT INTO m_utilisateur (id, groupId, username, password) VALUES (?,?, ?, ?)");
        $query->execute([null, $userGroupId, $username, $password]);

        // Maintenant on va récuper son id
        $query = Connexion::pdo()->prepare("SELECT id FROM m_utilisateur WHERE username=?");
        $query->execute([$username]);
        $userId = $query->fetchColumn();
        
        // On va insérer son adresse mail
        $query = Connexion::pdo()->prepare("INSERT INTO m_userSetting (`userId`, `name`, `value`) VALUES (?,?,?)");
        $query->execute([$userId, 'email', $email]);

        // Sa date d'inscription
        $query = Connexion::pdo()->prepare("INSERT INTO m_userSetting (`userId`, `name`, `value`) VALUES (?,?,?)");
        $query->execute([$userId, 'joinedDate', date("Y-m-d H:i:s")]);

        $return["success"] = "Inscription réussie, tu peux désormais te connecter! 🥳";
    } else {
        $return["error"] = 'Ton mot de passe doit être long d\'au moins 8 caractères et doit contenir au moins 1 majuscule, 1 minuscule et 1 nombre.';
    }
    return $return;
}

// Recettes
function getRecettes(){
    // return JSON
}

function getRecette($recetteId){
    // return JSON
}