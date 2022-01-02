<!DOCTYPE html>
<html>
    
<head>
<title>My Awesome Login Page</title>
    <meta charset="UTF-8">
    <!-- Dépendances -->
    <?=getDepedencies()?>
    <link rel="stylesheet" href="pages/assets/css/connexion.css">
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
                <form action="index.php" method="POST">
                <input type="hidden" name="action" value="created">
						<div class="input-group mb-3">
                        <div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="nom" class="form-control input_user"  placeholder="nom" required>
						
							<input type="text" name="prenom" class="form-control input_user"  placeholder="prenom" required>
							<input type="email" name="email" class="form-control input_user"  placeholder="mail" required>
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="mdp" class="form-control input_pass"  placeholder="password" required>
						</div>
						<div class="form-group">
							<div class="d-flex justify-content-center mt-3 login_container">
				 	<button type="submit" name="button" class="btn login_btn">Creer le compte</button>
				   </div>
					</form>
				</div>
				</div>
			</div>
		</div>
	</div>
    <?=getFooter()?>

<script src="/pages/assets/vendors/flickity/js/flickity.pkgd.min.js"></script>
<script type="text/javascript">
    
</script>
</body>
</html>