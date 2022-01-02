<?php
if(Connexion::pdo()->query("SELECT COUNT(*) FROM m_utilisateur")->fetchColumn() == 0){
    $hasUserInDB = false;
}else {
    $hasUserInDB = true;
}
?>
Wesh mon pote komen sa va? Tu veu te connecté? Ah...  bon ok alors attend 🤔
<br>Accès à la bdd: check
<br>Y a des utilisateurs dans la bdd:
<?php
if($hasUserInDB){
    echo "check";
}else{
    echo "<b>pas check!</b>";
}