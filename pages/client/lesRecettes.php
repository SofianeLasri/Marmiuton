<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- Dépendances -->
    <?=Client::getDepedencies()?>
    <title>Marmiuton</title>
    
    <!-- Embed -->
    <meta content="Marmiuton" property="og:title" />
    <meta content="Retrouvez des milliers de recettes toutes plus délicieuses les unes des autres. Rejoignez la communauté des Marmiutons et  partagez vos recettes de grand-mère!" property="og:description" />
    <meta content="https://marmiuton.sl-projects.com/" property="og:url" />
    <meta content="https://marmiuton.sl-projects.com/data/images/logo/favicon.png" property="og:image" />
    <meta content="#ed8930" data-react-helmet="true" name="theme-color" />

    <body>
    <!-- Inclusion dynamique de la navbar -->
    <?=getNavbar()?>

    <div class="container">
    <?php 
        $lesRecette[][]=getRecettes($type);
        foreach($lesRecette as $Recette)
        echo "<div class=""row"">";
        echo"<div class=""col"">";
        echo "<img src="$Recette['imagePath']" class=""img-fluid"" alt=""Responsive image""> "  ;
        echo "</div>";
        echo<div class="col">;
        
        echo</div>
    <div class="w-100"></div>
    <div class="col">Column</div>
    <div class="col">Column</div>
  </div>
</div>



    <?=getFooter()?>

    <script src="/pages/assets/vendors/flickity/js/flickity.pkgd.min.js"></script>
    <script type="text/javascript">
        
    </script>
</body>
</html>