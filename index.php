<?php
require_once "core/conf/Connexion.php";
require_once "core/controller/functions.php";

// On initialise la connexion à la base de donnée
Connexion::connect();

// On appelle la page demandée
loadPage();