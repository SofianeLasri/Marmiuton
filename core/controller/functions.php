<?php
//Chargement des pages
function loadPage($alias = ["vitrine"]){
    // S'il existe un paramètre on l'affecte à pageName

    // Ici on va vérifier le mode de récupération de l'url
    if($localSettings["urlMode"] == "parameters"){
        if(isset($_GET['admin'])){
            $alias[] = "admin";
        }
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $alias[] = $_GET['page'];
        }
    }else{
        $alias = $urlPath;
    }
    
    /*
    if(file_exists('pages/'.$pageName.'.php')){
        require 'pages/'.$pageName.'.php';
    }else{
        show404($pageName);
    }*/
    var_dump($alias);
}

// Afficher la page 404
function show404($pageName){
    require 'pages/404.php';
}

// Récupérer les dépendances
function getDepedencies(){
    require 'core/conf/dependencies.php';
}