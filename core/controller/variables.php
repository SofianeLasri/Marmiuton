<?php
// Ce fichier ne contient que les variables qui seront constament utilisées

// On récupère l'ip
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

// Vérifie le type de connexion
if(isset($_SERVER['HTTPS'])) $http = "https"; else $http = "http";

// Variables permettant la gestion des pages à afficher
$url = parse_url("$http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");	
$urlPath = explode("/", $url["path"]);
array_shift($urlPath); // Je suprime le premier élément car il sera toujours vide pour une raison que j'ignore