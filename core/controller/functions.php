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
        // Si l'alias est vide, on va donc charger la page vitrine
        $alias[0] = "vitrine";
    }
    
    // On vérifie le type de page que l'on souhaite afficher
    if($alias[0]!="admin"){
        // Il s'agit d'une page client
        if(file_exists('pages/client/'.$alias[0].'.php')){
            require 'pages/client/'.$alias[0].'.php';
        }else{
            show404($alias[0]);
        }
    }else{
        array_shift($alias); // On supprime le /admin pour que la fonction loadAdminPage puisse directement vérifier les pages
        loadAdminPage($alias);
    }
}
// Pages admins uniquement
function loadAdminPage($alias){
    
}

// Afficher la page 404
function show404($pageName){
    require 'pages/404.php';
}

// Récupérer les dépendances
function getDepedencies(){
    require 'core/conf/dependencies.php';
}