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
    <meta content="<?=getWebsiteSetting("mainColor")?>" data-react-helmet="true" name="theme-color" />

    <body>
    <!-- Inclusion dynamique de la navbar -->
    <?=Client::getNavbar()?>

    <!-- Recettes -->
    <div class="container">

        <div class="filtreRecettes p-2 bg-light my-5">
            <h5><strong>Filtre</strong></h5>
            <form method="GET" action="<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("/recettes/")?>" class="row">
            <?php
                if($localSettings["urlMode"] == "parameters"){
                    echo ('<input name="page" type="hidden" value="recettes">');
                }
            ?>
                <div class="col-sm">
                    <div class="form-group">
                        <label>Catégorie</label>
                        <select class="form-control" name="categoryId">
                            <option value="">Non spécifié</option>
                            <?php
                                $categories = Recette::getCategories();
                                foreach($categories as $category) {
                                    if(isset($_GET['categoryId']) && !empty($_GET['categoryId']) && ($category['id'] == $_GET['categoryId'])){
                                        $selected = "selected";
                                    }else{
                                        $selected = "";
                                    }
                                    echo '<option value="'.$category['id'].'" '.$selected.'>'.$category['nom'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>Ingrédients</label>
                        <select multiple class="form-control" name="ingredients[]">
                            <?php
                                $ingredients = Recette::getIngredients();
                                foreach($ingredients as $ingredient) {
                                    echo '<option value="'.$ingredient['id'].'">'.$ingredient['nom'].' - '.$ingredient['calories'].' cal</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group d-flex flex-column">
                        <label>Difficulté</label>
                        <input
                            name="difficulte"
                            class="rating rating--nojs bg-light"
                            max="5"
                            step="1"
                            type="range"
                            value="<?= $_GET['difficulte'] ?? '5' ?>">
                    </div>
                    <div class="form-group d-flex flex-column">
                        <label>Temps de préparation (min)</label>
                        <input type="number" name="tempsPreparation" step="1" min="1" max="100" placeholder="15" value="<?= $_GET['tempsPreparation'] ?? '' ?>">
                    </div>
                    <button type="submit" class="btn btn-orange float-right">Filtrer</button>
                </div>
            </form>
        </div>

        <div class="block-titres">
            <h3><strong>Recettes</strong></h3>
            <span class="text-muted">Toutes nos recettes sont confectionnées avec ❤️</span>
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
                if(isset($_GET["difficulte"]) AND !empty($_GET["difficulte"])){
                    $search["difficulte"]=($_GET["difficulte"]);
                }
                if(isset($_GET["tempsPreparation"]) AND !empty($_GET["tempsPreparation"])){
                    $search["tempsPreparation"]=($_GET["tempsPreparation"]);
                }
                if(isset($_GET["ingredients"]) AND !empty($_GET["ingredients"])){
                    $search["ingredients"]=$_GET["ingredients"];
                }
                $recettes = Recette::getRecettes($search);
                foreach($recettes as $recette){
                    $array["userId"] = $recette["auteurId"];
                    $utilisateur = getUtilisateur($array);

                    echo('<!-- Carte recette -->
                    <div class="col-md-6">
                        <div class="carte-recette">
                            <a href="'.getWebsiteSetting("websiteUrl").genPageLink("/recette/").'?recetteId='.$recette["id"].'">
                                <div class="carte-recette-img" style="background-image: url(\''.$recette["image"].'\');"></div>
                            </a>
                            <div class="carte-recette-infos">
                                <a href="'.getWebsiteSetting("websiteUrl").genPageLink("/recette/").'?recetteId='.$recette["id"].'" class="text-dark">
                                    <h4><strong>'.utf8_decode($recette["nom"]).'</strong></h4>
                                </a>
                                <p>'.utf8_decode($recette["description"]).'</p>
                                <i><a href="'.getWebsiteSetting("websiteUrl").genPageLink("/utilisateur/").'?id='.$recette["auteurId"].'" class="text-orange">'.$utilisateur['username'].'</a> <span class="text-muted"><i class="far fa-stopwatch"></i> '.$recette["tempsPreparation"].' minutes</span></i>
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