<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- Dépendances -->
    <?=getDepedencies()?>
    <link rel="stylesheet" href="pages/assets/css/connexion.css">
    <title>Marmiuton</title>
</head>
<body>

    <div class="d-flex p-2">
        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex flex-column justify-content-center"style="width=500 ">
            <form action="routeur.php" method="get">
                <input type="hidden" name="action" value="created">
                
                    <label>Nom d'utilisateur :</label>
                    <p>
                    <input type="text" name="nomUser" required>
                </p>
                
                    <label>Mot de passe :</label>
                    <p>
                    <input type="text" name="mdp" required>
                </p>
               
                <p>
                    <input type="submit" name="creer un compte" value="créer un compte">       
                    <input type="submit" name="connexion" value="se connecter">
                </p>
            </form>
            </div>
        </div>
        <div class="flex-grow-1"style=background-image:url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQyEBn2SuvbAPpPuLCV9WYCcc0cIb1pBWD0jA&usqp=CAU');>
        </div>  
    </div>
</body>
</html>