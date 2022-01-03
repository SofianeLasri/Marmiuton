<?php
// Ce fichier a une position un peu embêtante
// Faut-il le mettre en view? Non, il possède du code logique.
// Faut-il le mettre en classe? Non, ça serait inutile. En plus il est géré comme une page  par le site.
// Faut-il alors intégrer son code au fichier fonction? Bah c'est compliqué car il compare pas mal de choses avant d'executer ces fonctions...
// ----- / Il sert donc de passerelle entre fonctions.php et les pages.

echo "test";
if(isset($_GET["checkUsernameEmail"]) && !empty($_GET["checkUsernameEmail"])){
    // Cette fonction va vérifier si un username ou un email existe déjà dans la bdd
    echo checkUsernameEmail($_GET["checkUsernameEmail"]);
}