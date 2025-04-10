<?php
// On redirige si l'utilisateur est déjà connecté
if(isset($_SESSION['userId'])){
	header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="fr">
    
<head>
    <meta charset="UTF-8">
    <!-- Dépendances -->
	<?=Client::getDependencies()?>
    <link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/css/connexion.css">
    <title>Inscription</title>

	<!-- Embed -->
    <meta content="<?=getWebsiteSetting("websiteName")?>" property="og:title" />
    <meta content="<?=getWebsiteSetting("websiteDescription")?>" property="og:description" />
    <meta content="<?=getWebsiteSetting("websiteUrl")?>" property="og:url" />
    <meta content="<?=getWebsiteSetting("websiteUrl")?>data/images/logo/favicon.png" property="og:image" />
    <meta content="<?=getWebsiteSetting("mainColor")?>" data-react-helmet="true" name="theme-color" />

    <!-- Recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    <script type="text/javascript">
      var onloadCallback = function() {
        grecaptcha.render('g-recaptcha', {
          'sitekey' : '6Ld3jukdAAAAAFLO9t2Uyc3c9bru4kTcwffcG3mE'
        });
      };
    </script>
</head>

<body style="background-image:url('<?=getWebsiteSetting("websiteUrl")?>/data/images/planche-bois-aliments.jpg');background-size:cover;">
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="https://marmiuton.sl-projects.com/data/images/logo/favicon.png" class="brand_logo" alt="Logo">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container" id="container">

                    <!-- Formulaire d'enregistrement -->
                    <form method="post" class="mt-3 needs-validation" novalidate id="registerForm">
                        <div class="form-group">
                            <label>Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="registerUsername" name="registerUsername" placeholder="GordonFreeman" required value="<?php if (isset($_POST['registerUsername'])) echo $_POST['registerUsername']; ?>">
                            <div class="invalid-feedback" id="registerUsernameAlert">
                                Il paraît qu'avec un identifiant ça serait pas mal :p
                            </div>
                            <div class="valid-feedback">
                                Très beau pseudo
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Adresse email</label>
                            <input type="email" class="form-control" id="registerEmail" name="registerEmail" placeholder="gordon.freeman@blackmesa.us" required value="<?php if (isset($_POST['registerEmail'])) echo $_POST['registerEmail']; ?>">
                            <div class="invalid-feedback" id="registerEmailAlert">
                                Vous n'avez pas d'adresse mail? 🤔
                            </div>
                            <div class="valid-feedback">
                                Nickel 👌
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input type="password" class="form-control" id="registerPassword1" name="registerPassword1" placeholder="tut@p3str0v1te!" required value="<?php if (isset($_POST['registerPassword1'])) echo $_POST['registerPassword1']; ?>">
                            <div class="invalid-feedback" id="registerPassword1Alert">
                                Vous créez un compte sans mot de passe vous?
                            </div>
                            <div class="valid-feedback">
                                Nickel 👌
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Répètes ton mot de passe stp</label>
                            <input type="password" class="form-control" id="registerPassword2" name="registerPassword2" placeholder="tut@p3str0v1te!" required value="<?php if (isset($_POST['registerPassword2'])) echo $_POST['registerPassword2']; ?>">
                            <div class="invalid-feedback" id="registerPassword2Alert">
                                Re-écrivez votre mdp svp
                            </div>
                            <div class="valid-feedback">
                                Nickel 👌
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="registerTos" required>
                                <label class="form-check-label">
                                    J'ai lu et j'accepte les <a href="#" class="text-light">conditions d'utilisation</a>.
                                </label>
                                <div class="invalid-feedback">
                                    De toute façon vous êtes obligé pour continuer
                                </div>
                            </div>
                        </div>

						<div id="g-recaptcha"></div>
      					<br/>
                        <button type="button" id="registerBtn" class="btn btn-orange">S'inscrire</button>
                        <a href="<?=genPageLink("/login")?>" class="text-light">Déjà inscrit? 🌈</a>
                    </form>
				</div>
			</div>
		</div>
	</div>

    <script type="text/javascript">
		(function() {
		  'use strict';
		  window.addEventListener('load', function() {
		    // Fetch all the forms we want to apply custom Bootstrap validation styles to
		    var forms = document.getElementsByClassName('needs-validation');
		    // Loop over them and prevent submission
			var validation = Array.prototype.filter.call(forms, function(form) {
				document.getElementById("registerBtn").addEventListener("click", function() {
					if(form.checkValidity() === false){

					}else{
						sendFormData();
					}
					form.classList.add('was-validated');
				});
		    });
		  }, false);
		})();

		$("#registerUsername").change(function() {
			$.get("<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("/backTasks/?checkUsernameEmail=")?>="+encodeURI($("#registerUsername").val()), function(data) {
				if (data=="true") {
					$("#registerUsernameAlert").html("Nom d'utilisateur déjà utilisé.");
					$("#registerUsernameAlert").css("display","block");
					$("#registerBtn").attr("disabled", "");
				} else {
					$("#registerUsernameAlert").html("Il paraît qu'avec un identifiant ça serait pas mal :p");
					$("#registerUsernameAlert").css("display","");
					$("#registerBtn").removeAttr("disabled");
				}
			});
		});

		$("#registerEmail").change(function() {
			$.get("<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("/backTasks/?checkUsernameEmail")?>="+encodeURI($("#registerEmail").val()), function(data) {
				if (data=="true") {
					$("#registerEmailAlert").html("Email déjà utilisée.");
					$("#registerEmailAlert").css("display","block");
					$("#registerBtn").attr("disabled", "");
				} else {
					$("#registerEmailAlert").html("Vous n'avez pas d'adresse mail? 🤔");
					$("#registerEmailAlert").css("display","");
					$("#registerBtn").removeAttr("disabled");
				}
			});
		});

		$("#registerPassword1").change(function() {
			checkPassword();
		});
		$("#registerPassword2").change(function() {
			checkPassword();
		});

		function checkPassword(){
			if ($("#registerPassword1").val()!=$("#registerPassword2").val()) {
				$("#registerPassword1Alert").html("Les mots de passse ne correspondent pas");
				$("#registerPassword1Alert").css("display","block");
				$("#registerPassword2Alert").html("Les mots de passse ne correspondent pas");
				$("#registerPassword2Alert").css("display","block");
				$("#registerBtn").attr("disabled", "");
			} else {
				var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}$/;
				if($("#registerPassword1").val().match(passw)) { 
					$("#registerPassword1Alert").html('Vous créez un compte sans mot de passe vous?');
					$("#registerPassword1Alert").css("display","");
					$("#registerPassword2Alert").html('Re-écrivez votre mdp svp');
					$("#registerPassword2Alert").css("display","");
					$("#registerBtn").removeAttr("disabled");
				} else { 
					$("#registerPassword1Alert").html("Votre mot de passe doit être long d'au moins 8 caractères et doit contenir au moins 1 majuscule, 1 minuscule et 1 nombre.");
					$("#registerPassword1Alert").css("display","block");
					$("#registerPassword2Alert").html("Votre mot de passe doit être long d'au moins 8 caractères et doit contenir au moins 1 majuscule, 1 minuscule et 1 nombre.");
					$("#registerPassword2Alert").css("display","block");
					$("#registerBtn").attr("disabled", "");
				}
				
			}
		}
		
		function sendFormData(){
			$.post( "<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("/backTasks/?handleLoginAndRegisterForm")?>", $( "#registerForm" ).serialize() )
            .done(function( data ) {
				grecaptcha.reset()
				console.log(data);
				if(isJson(data)){
					let json = JSON.parse(data);
					if(json.success){
						SnackBar({
							message: json.success,
							status: "success"
						});
						$("#container").html("<p>Redirection...<br><a href='<?=genPageLink("/login")?>' class='text-light'>Cliquez ici</a> si vous n'êtes pas automatiquement redirigé.</p>");
						// On redirige après 2s
						setTimeout(function(){
							window.location.href = '<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("/login")?>';
						}, 2000);
					}else{
						SnackBar({
							message: json.error,
							status: "danger",
							timeout: false
						});
					}
				}else{
					SnackBar({
						message: data,
						status: "danger",
						timeout: false
					});
				}
            });
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