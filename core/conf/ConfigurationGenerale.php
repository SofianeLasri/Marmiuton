<?php
// attributs de la classe Connexion paramètres de connexion à la base
$bddHost = 'localhost';
$bddName = 'marmiuton';
$bddUsername = 'marmiuton';
$bddUserPassword = 's6rqTiA0hNKmcgy7';

// Cette variable défini le mode de reconnaissance des url
// Sur le serveur de l'IUT, on ne peut pas utiliser les alias de l'url pour détecter les pages, vu que nous ne sommes pas sur la racine du domaine
// Il faut donc fonctionner avec les paramètres de l'url.
$localSettings["urlMode"] = "alias"; // "parameters" ou "alias" -> fonctionne avec les alias par défaut (c'est plus joli)