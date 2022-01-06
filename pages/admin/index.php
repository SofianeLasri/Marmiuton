<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Marmiuton | Administration</title>
	<?=Admin::getDependencies()?>
</head>
<body>
	<?=Admin::getNavbar()?>

	<!-- Contenu -->
	<div class="dashboardTopCard" leftSidebar="240" rightSidebar="0">
		<div class="d-flex">
			<div class="userLogo" style="background-image: url('<?=$_SESSION['userProfilePic']?>');"></div>
			<div class="ml-5">
				<h3>Bienvenue <?=$_SESSION["userName"]?>!</h3>
				<br><strong>Vous êtes sur une version de développement de VBcms.</strong></p>
			</div>
		</div>
	</div>
	<div class="page-content notTop" leftSidebar="240" rightSidebar="0">
		<h3>Tableau de bord</h3>
		<p>Bienvenu sur le paneau d’administration. Voici un bref résumé de l'activité de cette semaine.</p>
		
		<div class="mt-3">
			<h3>Merci de participer aux tests!</h3>
			<p>Salut et merci d'avoir accepté de participer aux tests de pré-sortie. Tu es là sur une version très primaire de ce que sera VBcms 2.0 à la fin, et comme tu l'as peut-être déjà remarqué, il n'y a pas grand chose de terminé.</p><br>
			<?php print_r($_SESSION); ?>
			
		</div>

		
		
	</div>
</body>
</html>