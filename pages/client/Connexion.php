<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<!-- Dépendances -->
<?=getDepedencies()?>
<link rel="stylesheet" href="pages/assets/css/Connexion.css">
<title>Marmiuton</title>
</head>
<body>
    <div class='d-flex p-2'>
        <div class='d-flex flex-column justify-content-center'>
            <div class='d-flex flex-column justify-content-center'style='width=50 rem'>
            <form action="routeur.php" method="get">
                <input type="hidden" name="action" value="created">
                <p>
                    <label>Nom d'utilisateur :</label>
                    <input type="text" name="nomUser" required>
                </p>
                <p>
                    <label>Mot de passe :</label>
                    <input type="text" name="mdp" required>
                </p>
               
                <p>
                    <input type="submit" name="creer un compte" value="créer un compte">       
                    <input type="submit" name="connexion" value="se connecter">
                </p>
            </form>
            </div>
        </div>
        <div class='flex-grow-1'style=background-image;url(https://www.google.com/url?sa=i&url=http%3A%2F%2Fcrookies.fr%2Fcomment-manger-bon-bien-et-malin-en-grece%2F&psig=AOvVaw3m2fyQdQWL_odEJBeKckyX&ust=1640299818343000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCLCLkt-x-PQCFQAAAAAdAAAAABAF);background-size:cover;background-size:cover;background-position:.>
        </div>  
    </div>
</body>
</html>