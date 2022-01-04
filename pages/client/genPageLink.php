<?php
    echo "<h3>Zone de test pour genPageLink:</h3>";
    // Attention, il ne reconnait pas les paramètres de l'url s'il n'y a pas de / devant le ?
    echo "<br>/admin/test?info=value - ".genPageLink("/admin/test?info=value");
    // Là ça marche
    echo "<br>/admin/test/?info=value - ".genPageLink("/admin/test/?info=value");
    echo "<br>/recettes?search=valeur - ".genPageLink("/recettes?search=valeur");
    echo "<br>/recettes/?search=valeur - ".genPageLink("/recettes/?search=valeur");
    echo "<br>/login - ".genPageLink("/login");
?>
<h3>Cas concret en HTML:</h3>

<p>Eh salut, clique sur <a href="<?=genPageLink("/recettes/?search=patate")?>">ce lien</a> pour chercher des recettes de patate.</p>