<?php
// Ici on commence par intégrer les différents fichiers qui nous serviront à faire fonctionner le site
require_once "core/conf/ConfigurationGenerale.php"; // Ce fichier contient divers paramètres
require_once "core/conf/Connexion.php"; // Ce fichier se charge de la connexion à la base de donnée

// On initialise la connexion à la base de données
Connexion::connect();
// On récupère la durée de la session en secondes
$cookieDuration = Connexion::pdo()->query("SELECT value FROM m_siteSetting WHERE name='cookieDuration'")->fetchColumn();
// On change la durée de la session
ini_set('session.gc_maxlifetime', $cookieDuration);
// On demande au client de garder l'id de la sesssion aussi longtemps que sa durée
session_set_cookie_params($cookieDuration);
// Et on démarre la session
session_start();

require_once "core/controller/variables.php"; // Ce fichier se charge de récupérer les variables globales
require_once "core/controller/functions.php"; // Et celui-ci des différentes fonctions

// Enfin on appelle la page demandée
loadPage();