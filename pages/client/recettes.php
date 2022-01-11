<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- Dépendances -->
    <?=Client::getDependencies()?>
    <title>Marmiuton</title>
    
    <!-- Embed -->
    <meta content="Marmiuton" property="og:title" />
    <meta content="Retrouvez des milliers de recettes toutes plus délicieuses les unes des autres. Rejoignez la communauté des Marmiutons et  partagez vos recettes de grand-mère!" property="og:description" />
    <meta content="https://marmiuton.sl-projects.com/" property="og:url" />
    <meta content="https://marmiuton.sl-projects.com/data/images/logo/favicon.png" property="og:image" />
    <meta content="#ed8930" data-react-helmet="true" name="theme-color" />

    <body>
    <!-- Inclusion dynamique de la navbar -->
    <?=Client::getNavbar()?>

    <!-- Recettes -->
    <div class="container">
        <div class="block-titres">
            <h3><strong>Recettes</strong></h3>
            <span class="text-muted">Toutes nos recettes sont confectionnées avec <3.</span>
        </div>

        <div class="row pb-3">
            <?php
                $search=null;
                if(isset($_GET["categoryId"]) AND !empty($_GET["categoryId"])){
                    $search["categoryId"]=($_GET["categoryId"]);
                }
                if(isset($_GET["name"]) AND !empty($_GET["name"])){
                    $search["name"]=($_GET["name"]);
                }
                $recettes = getRecettes($search);
                foreach($recettes as $recette){
                    $array["userId"] = $recette["auteurId"];
                    $utilisateur = getUtilisateur($array);

                    echo('<!-- Carte recette -->
                    <div class="col-md-6">
                        <div class="carte-recette">
                            <a href="'.genPageLink("/recette/").'?recetteId='.$recette["id"].'">
                                <div class="carte-recette-img" style="background-image: url(\''.$recette["image"].'\');"></div>
                            </a>
                            <div class="carte-recette-infos">
                                <a href="'.genPageLink("/recette/").'?recetteId='.$recette["id"].'" class="text-dark">
                                    <h4><strong>'.utf8_decode($recette["nom"]).'</strong></h4>
                                </a>
                                <p>'.utf8_decode($recette["description"]).'</p>
                                <i><a href="'.genPageLink("/utilisateur/").'?id='.$recette["auteurId"].'" class="text-orange">'.$utilisateur['username'].'</a> <span class="text-muted"><i class="far fa-stopwatch"></i> '.$recette["tempsPreparation"].' minutes</span></i>
                            </div>
                        </div>
                    </div>
                    <!-- Fin -->');
                }
            ?>
        </div>
    </div>



    <?=Client::getFooter()?>

    <script src="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/flickity/js/flickity.pkgd.min.js"></script>
    <script type="text/javascript">
        
    </script>
</body>
</html>