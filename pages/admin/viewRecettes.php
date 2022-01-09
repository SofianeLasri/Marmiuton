<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- Dépendances -->
    <?=Client::getDependencies()?>
    <title><?=getWebsiteSetting("websiteName")?> | Liste des recettes</title>
    
    <!-- Embed -->
    <meta content="<?=getWebsiteSetting("websiteName")?>" property="og:title" />
    <meta content="<?=getWebsiteSetting("websiteDescription")?>" property="og:description" />
    <meta content="<?=getWebsiteSetting("websiteUrl")?>" property="og:url" />
    <meta content="<?=getWebsiteSetting("websiteUrl")?>data/images/logo/favicon.png" property="og:image" />
    <meta content="<?=getWebsiteSetting("mainColor")?>" data-react-helmet="true" name="theme-color" />
</head>
<body>
	<?=Admin::getNavbar()?>

	<!-- Contenu -->
	<div leftSidebar="240" rightSidebar="0" class="page-content">
		<h3>Liste des recettes</h4>
        <p>Ici vous pouvez visualiser l'ensemble des recettes du site.</p>

        <div class="d-flex flex-column" id="page-content">
            <div class="d-flex flex-wrap">
            <?php
                $recettes = getRecettes();
                foreach($recettes as $recette){
                    echo('<div class="recette-card border rounded mx-1 my-1" style="background-image: url(\''.$recette["image"].'\');">
                    <div class="recette-card-content p-2">
                        <span><strong>'.utf8_decode($recette["nom"]).'</strong></span>
                        <a href="'.genPageLink("/admin/editRecette/").'?recetteId='.$recette["id"].'" class="btn btn-sm btn-orange float-right">Modifier</a>
                    </div>
                </div>');
                }
            ?>
            </div>
        </div>
        
	</div>
<script type="text/javascript">
function saveChanges(){
    $.post( "<?=genPageLink("/admin/backTasks/")?>?saveSettings", $( "#settingsForm" ).serialize() )
    .done(function( data ) {
        if(data!=""){
            SnackBar({
                message: data,
                status: "danger",
                timeout: false
            });
        } else {
            SnackBar({
                message: 'Sauvegarde réussie',
                status: "success"
            });
        }
    });
}
</script>
</body>
</html>