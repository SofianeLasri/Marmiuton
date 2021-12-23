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
            <div class="logo">
            <img src="https://i.goopics.net/kn9pe.jpg" alt=""/>
</div>  
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
        <div class="flex-grow-1"style=background-image:url('https://media.istockphoto.com/photos/bowl-dish-with-brown-rice-cucumber-tomato-green-peas-red-cabbage-picture-id1047798504?k=20&m=1047798504&s=612x612&w=0&h=sXUN01Y_SuuTnHlgtAhnZEJmb_4blMk7bYWhyhNCNPI=');background-size:cover;background-position:;>
        </div>  
    </div>
</body>
</html>