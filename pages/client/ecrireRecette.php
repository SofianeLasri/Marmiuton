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
                    <input type="text" class="form-control my-2" id="recetteTitle" placeholder="Une superbe recette">
                </div>
                
                <textarea required id="summernote" name="recetteContent"></textarea>
            </div>
            <div class="col-6 col-editor-sidebar">
                <div class="card vbcard">
                    <h6 class="card-header">Publier</h6>
                    <div class="card-body">
                        <button type="button" onclick="autoSave(0)" class="btn btn-orange btn-sm"><i class="fas fa-save"></i> Brouillon</button>
                        <button type="button" onclick="preview()" class="btn btn-outline-orange btn-sm"><i class="fas fa-eye"></i> Prévisualiser</button>
                        <p class="card-text mt-2"><strong>Choisir une image d'entête</strong></p>
                        <a href="#" onclick="openGallery()" class="text-dark"><div id="editor-headerPic" class="editor-headerPic border rounded"><i class="fas fa-image"></i>Ajouter</div></a>
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
    </script>
</body>
</html>