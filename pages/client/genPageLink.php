<?php
    echo "<h3>Zone de test pour genPageLink:</h3>";
    // Attention, il ne reconnait pas les paramètres de l'url s'il n'y a pas de / devant le ?
    echo "<br>/admin/test?info=value - ".genPageLink("/admin/test?info=value");
    // Là ça marche
    echo "<br>/admin/test/?info=value - ".genPageLink("/admin/test/?info=value");
    
    // Pareil
    echo "<br>/recettes?search=valeur - ".genPageLink("/recettes?search=valeur");
    // Là c'est bon
    echo "<br>/recettes/?search=valeur - ".genPageLink("/recettes/?search=valeur");
    echo "<br>/login - ".genPageLink("/login");

    // Cela implique que l'on ne peut pas avoir autre que chose que soit du vide, soit des paramètres dans l'alias qui défini la page
    // ex:
    // /recettes/patate/?key=value     Ne marchera pas car /patate prend l'emplacement des paramètres

    // En fait cette fonction n'est utile que pour faire fonctionner le site avec le mode "paramètres". Elle ne s'active pas en mode alias.
?>
<h3>Cas concret en HTML:</h3>

<p>Eh salut, clique sur <a href="<?=genPageLink("/recettes/?search=patate")?>">ce lien</a> pour chercher des recettes de patate.</p>