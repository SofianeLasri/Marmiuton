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
            </div>
            <div class="col-6 col-editor-sidebar">
                <div class="card vbcard">
                    <h6 class="card-header">Publier</h6>
                    <div class="card-body">
                        <button type="button" class="btn btn-orange btn-sm" data-toggle="tooltip" data-placement="bottom" title="Pas eu le temps"><i class="fas fa-save"></i> Brouillon</button>
                        <button type="button" class="btn btn-outline-orange btn-sm" data-toggle="tooltip" data-placement="bottom" title="Pas eu le temps non plus"><i class="fas fa-eye"></i> Prévisualiser</button>
                        <p class="card-text mt-2"><strong>Choisir une image d'entête</strong></p>
                        <a href="#" onclick="chooseHeaderPic()" class="text-orange"><div id="editor-headerPic" class="editor-headerPic border rounded" attr="headerPic"><i class="fas fa-image"></i>Ajouter</div></a>
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

                <div class="card vbcard mt-3">
                    <h6 class="card-header">Catégorie de la recette</h6>
                    <div class="card-body">
                        <div class="form-group">
                            <select multiple class="form-control" id="recetteCategory">
                                <option value="0">Aucune</option>
                            </select>
                        </div>
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
            $("#modalSave").show();
            $("#modal").modal("hide");
        }

        function publish(){
            // On va faire les vérifications
            var recetteTitle = $("#recetteTitle").val();
            var recetteContent = $("#summernote").val();
            var recetteDescription = $("#recetteDescription").val();
            var recetteCategory = $("#recetteCategory").val();
            var recetteHeaderPic = $("#editor-headerPic").attr("headerPic");

            if(recetteTitle == ""){
                $("#modalTitle").html("Erreur");
                $("#modalBody").html("Vous n'avez pas entré de titre.");
                $("#modalSave").hide();
                $("#modal").modal("show");
            }
        }
    </script>
</body>
</html>