<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title><?=getWebsiteSetting("websiteName")?> | Liste des recettes</title>
	<?=Admin::getDependencies()?>
</head>
<body>
	<?=Admin::getNavbar()?>

	<!-- Contenu -->
	<div leftSidebar="240" rightSidebar="0" class="page-content">
		<h3>Liste des recettes</h4>
        <p>Ici vous pouvez visualiser l'ensemble des recettes du site.</p>

        <div class="d-flex flex-column" id="page-content">
            <div class="d-flex flex-wrap">
                <div class="recette-card border rounded mx-1 my-1" style="background-image: url('https://sofianelasri.mtxserv.com/vbcms-content/uploads/stayonline.jpg');">
                    <div class="recette-card-content p-2">
                        <span><strong>Un super loading screen</strong></span>
                        <a href="#" class="btn btn-sm btn-orange float-right">Modifier</a>
                    </div>
                </div>

                <div class="recette-card border rounded mx-1 my-1" style="background-image: url('https://sofianelasri.mtxserv.com/vbcms-content/uploads/doubleload.jpg');">
                    <div class="recette-card-content p-2">
                        <span><strong>Un super loading screen</strong></span>
                        <a href="#" class="btn btn-sm btn-orange float-right">Modifier</a>
                    </div>
                </div>

                <div class="recette-card border rounded mx-1 my-1" style="background-image: url('https://sofianelasri.mtxserv.com/vbcms-content/uploads/themeTopImage.jpg');">
                    <div class="recette-card-content p-2">
                        <span><strong>Un super loading screen</strong></span>
                        <a href="#" class="btn btn-sm btn-orange float-right">Modifier</a>
                    </div>
                </div>

                <div class="recette-card border rounded mx-1 my-1" style="background-image: url('https://sofianelasri.mtxserv.com/vbcms-content/uploads/scp2.jpg');">
                    <div class="recette-card-content p-2">
                        <span><strong>Un super loading screen</strong></span>
                        <a href="#" class="btn btn-sm btn-orange float-right">Modifier</a>
                    </div>
                </div>
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