<?php
//Chargement des pages
function loadPage($pageName = "vitrine"){
    // S'il existe un paramètre on l'affecte à pageName
    if(isset($_GET['page']) && !empty($_GET['page'])){
        $pageName = $_GET['page'];
    }

    if(file_exists('pages/'.$pageName.'.php')){
        require 'pages/'.$pageName.'.php';
    }else{
        show404($pageName);
    }
}

// Afficher la page 404
function show404($pageName){
    require 'pages/404.php';
}

// Récupérer les dépendances
function getDepedencies(){
    require 'core/conf/dependencies.php';
}