<?php
// On redirige si l'utilisateur est déjà connecté
if(isset($_SESSION['userId'])){
	header('Location: '.getWebsiteSetting("websiteUrl"));
}
?>
<!DOCTYPE html>
<html lang="fr">
    
<head>
	<meta charset="UTF-8">
	<title>Connexion</title>

    <!-- Embed -->
    <meta content="<?=getWebsiteSetting("websiteName")?>" property="og:title" />
    <meta content="<?=getWebsiteSetting("websiteDescription")?>" property="og:description" />
    <meta content="<?=getWebsiteSetting("websiteUrl")?>" property="og:url" />
    <meta content="<?=getWebsiteSetting("websiteUrl")?>data/images/logo/favicon.png" property="og:image" />
    <meta content="<?=getWebsiteSetting("mainColor")?>" data-react-helmet="true" name="theme-color" />

    <!-- Dépendances -->
    <?=Client::getDependencies()?>
    <link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/css/connexion.css">

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

                    <!-- Formulaire de connexion -->
                    <form method="post" class="mt-3 needs-validation" novalidate id="loginForm">
						<div class="form-group">
							<label>Nom d'utilisateur/Email</label>
							<input type="text" class="form-control" name="loginUsernameEmail" placeholder="gordon.freeman@blackmesa.us" required>
							<div class="invalid-feedback">
								Il paraît qu'avec un identifiant ça serait pas mal :p
							</div>
							<div class="valid-feedback">
								Nickel 👌
							</div>
						</div>
						<div class="form-group">
							<label>Mot de passe</label>
							<input type="password" class="form-control" name="loginPassword" placeholder="tut@p3str0v1te!" required>
							<div class="invalid-feedback">
								T'as un compte sans mot de passe toi? 🤔
							</div>
							<div class="valid-feedback">
								Nickel 👌
							</div>
						</div>

						<div id="g-recaptcha"></div>
      					<br/>
						<button type="button" name="submit" id="loginBtn" class="btn btn-orange">Se connecter</button>
						<a href="<?=genPageLink("/register")?>" class="text-light">Pas encore inscrit? 😢</a>
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
				document.getElementById("loginBtn").addEventListener("click", function() {
					if(form.checkValidity() === false){

					}else{
						sendFormData();
					}
					form.classList.add('was-validated');
				});
		    });
		  }, false);
		})();

		function sendFormData(){
			$.post( "<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("/backTasks/?handleLoginAndRegisterForm")?>", $( "#loginForm" ).serialize() )
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
						SnackBar({
							message: "Redirection dans 3s...",
							status: "success"
						});
						$("#container").html("<p>Redirection...<br><a href='<?=getWebsiteSetting("websiteUrl")?>' class='text-light'>Cliquez ici</a> si vous n'êtes pas automatiquement redirigé.</p>");
						setTimeout(function(){
							window.location.href = '<?=getWebsiteSetting("websiteUrl")?>';
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