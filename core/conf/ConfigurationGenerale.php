<?php
// Ça aurait été sympa de tout regrouper ici, mais le fait que la classe Connnexion ne puisse inclure de fichiers et que cela reviendrait à s'écarter du cours de faire autre chose....
// C'est pas très propre mais bon, ça fonctionne

// Cette variable défini le mode de reconnaissance des url
// Sur le serveur de l'IUT, on ne peut pas utiliser les alias de l'url pour détecter les pages, vu que nous ne sommes pas sur la racine du domaine
// Il faut donc fonctionner avec les paramètres de l'url.
$localSettings["urlMode"] = "alias"; // "parameters" ou "alias" -> fonctionne avec les alias par défaut (c'est plus joli)