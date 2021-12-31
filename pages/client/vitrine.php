<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- Dépendances -->
    <?=getDepedencies()?>
    <link rel="stylesheet" href="pages/assets/css/styles.css">
    <title>Marmiuton</title>
    
    <!-- Embed -->
    <meta content="Marmiuton" property="og:title" />
    <meta content="Retrouvez des milliers de recettes toutes plus délicieuses les unes des autres. Rejoignez la communauté des Marmiutons et  partagez vos recettes de grand-mère!" property="og:description" />
    <meta content="https://marmiuton.sl-projects.com/" property="og:url" />
    <meta content="https://marmiuton.sl-projects.com/data/images/logo/favicon.png" property="og:image" />
    <meta content="#ed8930" data-react-helmet="true" name="theme-color" />

    <!-- Uniquement pour la vitrine -->
    <link rel="stylesheet" href="/pages/assets/vendors/flickity/css/flickity.css" media="screen">
</head>
<body>
    <!-- Barre du dessus pour les infos peu ou pas importantes -->
    <div id="topBarInfos" class="container-fluid mainColor-bg">
        <div class="container text-center py-2">
            <span class="badge badge-pill badge-danger">Spécial Noël</span> <span>Une sélection de recettes très spéciales pour les fêtes de Noël.</span> <a href="#" class="btn btn-outline-light btn-sm">Découvrir</a>
        </div>
    </div>
    <!-- Fin -->

    <!-- Inclusion dynamique de la navbar -->
    <?=getNavbar()?>

    <!-- Carroussel de la vitrine -->
    <div class="carrousselVitrine js-flickity" data-flickity-options='{ "wrapAround": true }'>
        <div class="gallery-cell">...</div>
        <div class="gallery-cell">...</div>
        <div class="gallery-cell">...</div>
    </div>

    <script src="/pages/assets/vendors/flickity/js/flickity.pkgd.min.js"></script>
    <script type="text/javascript">
        
    </script>
</body>
</html>