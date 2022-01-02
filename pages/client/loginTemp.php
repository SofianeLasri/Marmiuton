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
}else{ ?>

<b>pas check!</b>
<br>Bon t'est reloux toi. Rempli le formulaire ci-dessous

<form method="post" style="display:flex; flex-direction:column;width:50rem;">
    <input type="text" name="username" placeholder="nom d'utilisateur" required>
    <input type="password" name="password" placeholder="mot de passe" required>
    <input type="text" name="addresse" placeholder="addresse">
    <input type="text" name="numero" placeholder="numéro">
    <input type="text" name="ville" placeholder="ville">
    <input type="text" name="codepostal" placeholder="code postal">
    <input type="text" name="prefculinaire" placeholder="préférence culinaire">
    <input type="text" name="jesaispasquoimettre" placeholder="attirances particulières">
    <input type="text" name="aled" placeholder="age">
    <input type="text" name="moioui" placeholder="êtes-vous célibataire?">
    <input type="text" name="bofhein" placeholder="aimez-vous les moches?">
    <input type="text" name="persochocolat" placeholder="chocolat ou chocolatine?">
    <input type="submit" value="Connexion">
</form>

<?php }