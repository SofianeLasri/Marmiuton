<?php isConnected(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- Dépendances -->
    <?=Client::getDependencies()?>
    <title><?=getWebsiteSetting("websiteName")?> | Écrire une recette</title>

    <!-- Summernote -->
	<link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/summernote/dist/summernote-bs4.css">
	<script type="text/javascript" src="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/summernote/dist/summernote-bs4.js"></script>
	<link href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/tam-emoji/css/emoji.css" rel="stylesheet">
	<script src="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/tam-emoji/js/config.js"></script>
  	<script src="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/tam-emoji/js/tam-emoji.min.js"></script>
    
    <!-- Embed -->
    <meta content="<?=getWebsiteSetting("websiteName")?>" property="og:title" />
    <meta content="<?=getWebsiteSetting("websiteDescription")?>" property="og:description" />
    <meta content="<?=getWebsiteSetting("websiteUrl")?>" property="og:url" />
    <meta content="<?=getWebsiteSetting("websiteUrl")?>data/images/logo/favicon.png" property="og:image" />
    <meta content="<?=getWebsiteSetting("mainColor")?>" data-react-helmet="true" name="theme-color" />

    <!-- Uniquement pour la vitrine -->
    <link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/flickity/css/flickity.css" media="screen">
</head>
<body>
    <!-- Inclusion dynamique de la navbar -->
    <?=Client::getNavbar()?>

    <!-- Recettes -->
    <div class="container mt-5">
        <h4>Écrire une recette</h4>

        <div class="row">
            <div class="col-sm-6 col-editor-content">
                <div class="form-group">
                    <label>Nom de la recette</label>
                    <input type="text" class="form-control" id="recetteTitle" placeholder="Une superbe recette">
                </div>
                
                <textarea required id="summernote" name="recetteContent"></textarea>

                <div class="row">
                    <div class="col-sm mt-3">
                        <div class="card">
                            <h6 class="card-header">Ingrédients de la recette</h6>
                            <div class="card-body">
                                <div class="form-group">
                                    <select multiple class="form-control" id="recetteIngredients">
                                        <?php
                                            $ingredients = Recette::getIngredients();
                                            foreach($ingredients as $ingredient) {
                                                echo '<option value="'.$ingredient['id'].'">'.$ingredient['nom'].' - '.$ingredient['calories'].' cal</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm mt-3">
                        <div class="card">
                            <h6 class="card-header">Ustensiles nécessaires</h6>
                            <div class="card-body">
                                <div class="form-group">
                                    <select multiple class="form-control" id="recetteUstensiles">
                                        <?php
                                            $ustensiles = Recette::getUstensiles();
                                            foreach($ustensiles as $ustensile) {
                                                echo '<option value="'.$ustensile['id'].'">'.$ustensile['nom'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm mt-3">
                        <div class="card">
                            <h6 class="card-header">Catégorie de la recette</h6>
                            <div class="card-body">
                                <div class="form-group">
                                    <select class="form-control" id="recetteCategory">
                                        <?php
                                            $categories = Recette::getCategories();
                                            foreach($categories as $category) {
                                                echo '<option value="'.$category['id'].'">'.$category['nom'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-editor-sidebar">
                <div class="card vbcard">
                    <h6 class="card-header">Publier</h6>
                    <div class="card-body">
                        <div class="form-group d-flex flex-column">
                            <label>Difficulté</label>
                            <input
                                id="recetteDifficulte"
                                class="rating rating--nojs"
                                max="5"
                                step="1"
                                type="range"
                                value="5">
                        </div>
                        <div class="form-group d-flex flex-column">
                            <label>Temps de préparation (min)</label>
                            <input type="number" id="recettePreparation" step="1" min="1" max="100" placeholder="15">
                        </div>
                        <p class="card-text mt-2"><strong>Choisir une image d'entête</strong></p>
                        <a href="#" onclick="chooseHeaderPic()" class="text-orange"><div id="editor-headerPic" class="editor-headerPic border rounded" headerPic=""><i class="fas fa-image"></i>Ajouter</div></a>
                        <a href="#" onclick="publish()" class="btn btn-orange" style="margin-top: .75rem;">Publier</a>
                        
                    </div>
                </div>

                <div class="card vbcard mt-3">
                    <h6 class="card-header">Description</h6>
                    <div class="card-body">
                        <p class="card-text"><strong>Une brève description du plat en question.</strong></p>
                        <textarea id="recetteDescription" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?=Client::getFooter()?>

    <!-- Modal -->
    <div class="modal fade" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Un titre d'exemple</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-orange" data-dismiss="modal" id="modalClose">Fermer</button>
                <button type="button" class="btn btn-orange" id="modalSave">Save changes</button>
            </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Initialise l'editeur
        document.emojiButton = 'far fa-smile'; // default: fa fa-smile-o
        document.emojiType = 'unicode'; // default: image
        document.emojiSource = '<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/tam-emoji/img';
        


        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: "Faire cuire les sardines 30 minutes au four à micro-ondes.",
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize', 'height', 'color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['insert', ['link', 'picture', 'video', 'emoji']],
                    ['view', ['fullscreen', 'codeview', 'undo', 'redo', 'help']]
                ]
            });
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        function chooseHeaderPic(){
            $("#modalTitle").html("Choisir une image d'entête");
            $("#modalBody").html('<div class="form-group"><label>Lien de l\'image (on a pas le temps de faire un envoie de fichier)</label><input type="text" id="headerPicInput" class="form-control-file"></div>');
            $("#modalSave").attr("onclick", "saveHeaderPic()");
            $("#modal").modal("show");
        }

        function saveHeaderPic(){
            var imageLink = $('input[id^="headerPicInput"]').val();
            $("#editor-headerPic").css("background", "linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('"+imageLink+"')");
            $("#editor-headerPic").html('<i class="fas fa-edit"></i> Modifier');
            $("#editor-headerPic").attr("headerPic", imageLink);
            $("#modal").modal("hide");
        }

        function publish(){
            // On va faire les vérifications
            var recetteTitle = $("#recetteTitle").val();
            var recetteContent = $("#summernote").val();
            var recetteDescription = $("#recetteDescription").val();
            var recetteCategory = $("#recetteCategory").val();
            var recetteHeaderPic = $("#editor-headerPic").attr("headerPic");
            var recetteIngredients = $("#recetteIngredients").val();
            var recetteUstensiles = $("#recetteUstensiles").val();
            var recetteDifficulte = $("#recetteDifficulte").val();
            var recettePreparation = $("#recettePreparation").val();

            if(recetteTitle == ""){
                SnackBar({
                    message: "Votre recette doit avoir un titre.",
                    status: "danger",
                    timeout: false
                });
            } else if(recetteContent == ""){
                SnackBar({
                    message: "Votre recette doit avoir des instructions.",
                    status: "danger",
                    timeout: false
                });
            } else if(recetteDescription == ""){
                SnackBar({
                    message: "Votre recette doit avoir une description.",
                    status: "danger",
                    timeout: false
                });
            } else if(recetteCategory == "0"){
                SnackBar({
                    message: "Votre recette doit avoir une catégorie.",
                    status: "danger",
                    timeout: false
                });
            } else if(recetteHeaderPic == ""){
                SnackBar({
                    message: "Votre recette doit avoir une image d'entête.",
                    status: "danger",
                    timeout: false
                });
            } else if(recetteIngredients == ""){
                SnackBar({
                    message: "Votre recette doit avoir des ingrédients.",
                    status: "danger",
                    timeout: false
                });
            } else if(recetteUstensiles == ""){
                SnackBar({
                    message: "Votre recette doit avoir des ustensiles.",
                    status: "danger",
                    timeout: false
                });
            } else if(recetteDifficulte == "0"){
                SnackBar({
                    message: "Votre recette doit avoir une difficulté.",
                    status: "danger",
                    timeout: false
                });
            } else if(recettePreparation == ""){
                SnackBar({
                    message: "Votre recette doit avoir un temps préparation.",
                    status: "danger",
                    timeout: false
                });
            } else {
                // On peut publier
                $.ajax({
                    url: '<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("backTasks")?>?Recette::sendRecette',
                    type: 'POST',
                    data: {
                        action: "publishRecette",
                        recetteTitle: recetteTitle,
                        recetteContent: recetteContent,
                        recetteDescription: recetteDescription,
                        recetteCategory: recetteCategory,
                        recetteHeaderPic: recetteHeaderPic,
                        recetteIngredients: recetteIngredients,
                        recetteUstensiles: recetteUstensiles,
                        recetteDifficulte: recetteDifficulte,
                        recettePreparation: recettePreparation
                    },
                    success: function(data){
                        if(isJson(data)){
                            var json = JSON.parse(data);
                        
                            if(json.success){
                                SnackBar({
                                    message: "Votre recette a bien été publiée.",
                                    status: "success",
                                    timeout: false
                                });
                                setTimeout(function(){
                                    window.location.href = "<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("recette")?>?id="+json.recetteId;
                                }, 2000);
                            } else {
                                SnackBar({
                                    message: "Une erreur est survenue: "+json.error,
                                    status: "danger",
                                    timeout: false
                                });
                            }
                        }else{
                            SnackBar({
                                message: "Une erreur est survenue:"+data,
                                status: "danger",
                                timeout: false
                            });
                        }
                    }
                });
            }
        }

        function isJson(str) {
			try {
				JSON.parse(str);
			} catch (e) {
				return false;
			}
			return true;
		}
    </script>
</body>
</html>