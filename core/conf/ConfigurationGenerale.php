<?php
// attributs de la classe Connexion paramètres de connexion à la base
$bddHost = $_ENV['DB_HOST'] ?? 'localhost';
$bddPort = $_ENV['DB_PORT'] ?? '3306';
$bddName = $_ENV['DB_NAME'] ?? 'marmiuton';
$bddUsername = $_ENV['DB_USER'] ?? 'marmiuton_user';
$bddUserPassword = $_ENV['DB_PASSWORD'] ?? 'password';

// Cette variable défini le mode de reconnaissance des url
// Sur le serveur de l'IUT, on ne peut pas utiliser les alias de l'url pour détecter les pages, vu que nous ne sommes pas sur la racine du domaine
// Il faut donc fonctionner avec les paramètres de l'url.
$localSettings["urlMode"] = "alias"; // "parameters" ou "alias" -> fonctionne avec les alias par défaut (c'est plus joli)