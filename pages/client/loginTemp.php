<?php
// Si l'utilisateur est déjà connecté
if (isset($_SESSION['userId']) && !empty($_SESSION['userId'])){
	header("Location: ".$redirect);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
    // Build POST request:
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = '6LdzDpUaAAAAANjaM4-6fqzuCh6nkZO99tJXk4Iv';
    $recaptcha_response = $_POST['recaptcha_response'];

    // Make and decode POST request:
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);
    // Take action based on the score returned:
    if ($recaptcha->score >= 0.5) {

    	if (isset($_POST['loginUsernameEmail'])) {
    		if (!empty($_POST['loginUsernameEmail'])) {
    			if (isset($_POST['loginPassword'])) {
    				if (!empty($_POST['loginPassword'])) {
    					$usernameEmail = strtolower($_POST['loginUsernameEmail']);
    					$pos = strpos($usernameEmail, "@");
						if ($pos !== false) {
							$response = $bdd->prepare("SELECT * FROM drm_accounts WHERE email=?");
							$response->execute([$usernameEmail]);
						} else {
							$response = $bdd->prepare("SELECT * FROM drm_accounts WHERE username=?");
							$response->execute([$usernameEmail]);
						}
						$user=$response->fetch(PDO::FETCH_ASSOC);
						if (!empty($user)) {
							if(password_verify($_POST['loginPassword'], $user["password"])){
								$response = $bdd->prepare("SELECT * FROM drm_accounts_ip WHERE userId=? AND ip=?");
								$response->execute([$user['id'], $ip]);
								if (empty($response->fetch())) {
									$response = $bdd->prepare("INSERT INTO drm_accounts_ip (`id`, `userId`, `ip`, `date`) VALUES (?,?,?,?)");
									$response->execute([null, $user['id'], $ip, date("Y-m-d")]);
								}

								$_SESSION['loginType'] = "vbcms-account";
								$_SESSION['user_id'] = $user['id'];
								$_SESSION['user_username'] = $user['username'];
								$_SESSION['user_role'] = "user";
								if (empty($user['profilePic'])) {
									$_SESSION['user_profilePic'] = $websiteUrl."vbcms-admin/images/misc/programmer.png";
								} else {
									$_SESSION['user_profilePic'] = $user['profilePic'];
								}
								$_SESSION['language'] = $user['language'];
								header('Location: '.$redirect);
							} else {
								$error = "Mauvais couple identifiant/mot de passe.";
							}
						} else {
							$error = "Mauvais couple identifiant/mot de passe.";
						}
						
    				} else {
    					$error = 'Donc tu te connectes à un compte sans mot de passe toi? <img height="16" src="https://dev.vbcms.net/vbcms-content/uploads/emoji/thinkingHard.png">';
    				}
    				
    			} else {
    				$error = 'Hmm c\'est embêtant ça... Il semblerait que le champ du mot de passe n\'est pas reconnu.';
    			}
    			
    		} else {
    			$error = 'Dit donc, tu n\'as pas rentré d\'identifiant là! <img height="16" src="https://dev.vbcms.net/vbcms-content/uploads/emoji/oiseau-pas-content.png">';
    		}
    		
    	} else {
    		if (isset($_POST['registerUsername'])) {
    			if (!empty($_POST['registerUsername'])) {
    				if (isset($_POST['registerEmail'])) {
    					if (!empty($_POST['registerEmail'])) {
    						if (isset($_POST['registerPassword1'])) {
    							if (!empty($_POST['registerPassword1'])) {
    								if (isset($_POST['registerPassword2'])) {
    									if (!empty($_POST['registerPassword2'])) {
    										if ($_POST['registerPassword1']==$_POST['registerPassword2']) {
    											if (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}$/', $_POST['registerPassword1'])==1) {
    												$username = strtolower($_POST['registerUsername']);
    												$email = strtolower($_POST['registerEmail']);
    												$password = password_hash($_POST['registerPassword1'], PASSWORD_DEFAULT);
    												$geoPlugin_array = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR']) );
													$language = $geoPlugin_array['geoplugin_countryCode'];
													$response = $bdd->prepare("INSERT INTO drm_accounts (`id`, `username`, `email`, `password`, `joinedDate`, `language`, `profilePic`, `statut`) VALUES (?,?,?,?,?,?,?,?)");
													$response->execute([null, $username, $email, $password, date("Y-m-d H:i:s"), $language, "", 0]);

													$success = "Inscription réussie, tu peux désormais te connecter! 🥳";
    											} else {
    												$error = 'Ton mot de passe doit être long d\'au moins 8 caractères et doit contenir au moins 1 majuscule, 1 minuscule et 1 nombre.';
    											}
    											
    										} else {
    											$error = 'Je sais pas comment  t\'as fais, <b>il faut que les deux mots de passe correspondent</b> <img height="16" src="https://dev.vbcms.net/vbcms-content/uploads/emoji/thinkingHard.png">';
    										}
    										
    									} else {
    										$error = 'Je sais pas comment  t\'as fais, mais stp rempli tous les champs. <b>Même celui du second mdp</b> <img height="16" src="https://dev.vbcms.net/vbcms-content/uploads/emoji/thinkingHard.png">';
    									}
    								} else {
    									$error = 'Hmm c\'est embêtant ça... Il semblerait que le champ du 2nd mot de passe n\'est pas reconnu.';
    								}
    							} else {
    								$error = 'Je sais pas comment  t\'as fais, mais stp rempli tous les champs. <b>Même celui du premier mdp</b> <img height="16" src="https://dev.vbcms.net/vbcms-content/uploads/emoji/thinkingHard.png">';
    							}
    						} else {
    							$error = 'Hmm c\'est embêtant ça... Il semblerait que le champ du 1er mot de passe n\'est pas reconnu.';
    						}
    					} else {
    						$error = 'Je sais pas comment  t\'as fais, mais stp rempli tous les champs. <b>Même celui de l\'adresse email</b> <img height="16" src="https://dev.vbcms.net/vbcms-content/uploads/emoji/thinkingHard.png">';
    					}
    				} else {
    					$error = 'Hmm c\'est embêtant ça... Il semblerait que le champ de l\'adresse email n\'est pas reconnu.';
    				}
    				
    			} else {
    				$error = 'Je sais pas comment  t\'as fais, mais stp rempli tous les champs. <b>Même celui de l\'identifiant</b> <img height="16" src="https://dev.vbcms.net/vbcms-content/uploads/emoji/thinkingHard.png">';
    			}
    		}
    		
    	}
    	
    } else {
    	$error = "Le reCAPTCHA t'as identifié comme un robot. Rejoins notre discord pour obtenir de l'aide.";
    }
}
?>
<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <!-- Dépendances -->
    <?=getDepedencies()?>
    <title>Inscription</title>

    <!-- Recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js?render=6LfuDOYdAAAAAEf8Ii1uzBXHVoUfeI2CK38US1-N"></script>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('6LfuDOYdAAAAAEf8Ii1uzBXHVoUfeI2CK38US1-N', { action: 'contact' }).then(function (token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });
    </script>
</head>

<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="https://marmiuton.sl-projects.com/data/images/logo/favicon.png" class="brand_logo" alt="Logo">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">

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
                                    J'ai lu et j'accepte les <a href="#" class="text-orange">conditions d'utilisation</a>.
                                </label>
                                <div class="invalid-feedback">
                                    De toute façon vous êtes obligé pour continuer
                                </div>
                            </div>
                        </div>

                        <button type="button" id="registerBtn" onclick="sendFormData()" class="btn btn-orange">S'inscrire</button>
                        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                        <a href="/Connexion" class="text-orange">Déjà inscrit? 🌈</a>
                    </form>
				</div>
			</div>
		</div>
	</div>

    <script type="text/javascript">
		// Example starter JavaScript for disabling form submissions if there are invalid fields
		(function() {
		  'use strict';
		  window.addEventListener('load', function() {
		    // Fetch all the forms we want to apply custom Bootstrap validation styles to
		    var forms = document.getElementsByClassName('needs-validation');
		    // Loop over them and prevent submission
		    var validation = Array.prototype.filter.call(forms, function(form) {
		      form.addEventListener('submit', function(event) {
		        if (form.checkValidity() === false) {
		          event.preventDefault();
		          event.stopPropagation();
		        }
		        form.classList.add('was-validated');
		      }, false);
		    });
		  }, false);
		})();

		function showRegisterForm(){
			$('#registerForm').css("display", "block");
			$('#loginForm').css("display", "none");
			$("#recaptchaResponse1").attr("value",$("#recaptchaResponse").val());
		}
		function showLoginForm(){
			$('#registerForm').css("display", "none");
			$('#loginForm').css("display", "block");
		}

		$("#registerUsername").change(function() {
			$.get("/backTasks/?checkUsernameEmail="+encodeURI($("#registerUsername").val()), function(data) {
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
			$.get("/backTasks/?checkUsernameEmail="+encodeURI($("#registerEmail").val()), function(data) {
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
			if($("#registerForm").isValid()){
				console.log("Formulaire validé");
			}else{
				console.log("Formulaire invalide");
			}
		}

	</script>
</body>
</html>