<?php 
if(isset($_GET['recetteId']) && !empty($_GET['recetteId'])){
    $recetteId=$_GET['recetteId'];
    $recette=Recette::getRecette($recetteId);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?=utf8_decode($recette["nom"])?></title>
    <!-- Dépendances -->
	<?=Client::getDependencies()?>
    <link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/css/recette.css">
 
	<!-- Embed -->
	<meta content="<?=utf8_decode($recette["nom"])?>" property="og:title" />
	<meta content="<?=utf8_decode($recette["description"])?>" property="og:description" />
	<meta content="<?=getWebsiteSetting("websiteUrl")?>" property="og:url" />
	<meta content="<?=getWebsiteSetting("websiteUrl")?>data/images/logo/favicon.png" property="og:image" />
	<meta content="<?=getWebsiteSetting("mainColor")?>" data-react-helmet="true" name="theme-color" />
</head>
<body>
    <!-- Inclusion dynamique de la navbar -->
    <?=Client::getNavbar()?>
      
    <div class="receipe-content-area">
        <div class="container">

        <!-- Image de la recette -->
        <div class="recetteHeaderPic" style="background-image:url('<?=$recette["image"]?>');"></div>

            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="receipe-headline my-5">
                        <?php 
                        echo "<h2>".utf8_decode($recette["nom"])."</h2>";
                        echo "<span>".$recette["dateModif"]."</span>";
                        ?>
                        <div class="receipe-duration">
                            <?php
                            echo"<h6>Prep: ".$recette["tempsPreparation"]." mins</h6>"
                            ?>
                        </div>
                    </div>
                </div>

                    <div class="col-12 col-md-4">
                        <div class="receipe-ratings text-right my-5">
                            <div class="ratings">
                                <?php
                                for ($i = 0; $i < $recette["difficulte"]; $i++){
                                 echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                }
                            echo '</div>';
                                 if($recette["difficulte"]<3){
                                 echo'<a href="#" class="btn delicious-btn">For Begginers</a>';
                                 }
                                 else {
                                     if($recette["difficulte"]==3){
                                        echo'<a href="#" class="btn delicious-btn">For Medium</a>';
                                     }
                                     else {
                                        echo'<a href="#" class="btn delicious-btn">For advanced pvp player</a>';
                                     }
                                    }
                                ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-8">
                        <!-- Single Preparation Step -->
                        <div class="single-preparation-step">
                            <h4>Detail de la préparation</h4>
                            <?php 
                            echo "<p>".htmlspecialchars_decode(utf8_decode($recette["contenu"]))."</p>";
                            ?>
                            
                        </div>
                    </div>

                    <!-- Ingredients -->
                    <div class="col-12 col-lg-4">
                        <div class="ingredients">
                            <h4>Ingredients</h4>
                                    <?php 
                                    $ingredient=Recette::getIngredients($recetteId);
                                    $i=0 ;
                                    foreach($ingredient as $valeur){
                                       $i++;
                                     echo "<div class='custom-control custom-checkbox'>";
                                     echo "<input type='checkbox' class='custom-control-input' id='customCheck".$i."'>";
                                    echo" <label class='custom-control-label' >".$valeur["nom"]."</label>";
                                    echo"</div>";
                                    }
                                    ?>
                        </div>
                    </div>
                </div>

                <?php
                if(isset($_SESSION["userId"])){
                    echo('<div class="row">
                    <div class="col-12">
                        <div class="section-heading text-left">
                            <h3>Envoyer un commentaire</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="contact-form-area">
                            <form action="#" method="post">
                                <div class="row">
                                    <div class="col-12">
                                        <textarea name="message" class="form-control" id="message" cols="30" rows="10" placeholder="Message"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-orange mt-3" type="submit">Envoyer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>');
                }
                ?>
                
            </div>
        </div>
    </div>
    <?=Client::getFooter()?>
</body>
</html>