<header>
	<div class="navbar managerHeader d-flex">
		<div class="brand d-flex">
			<div class="desktop-toggler mx-2">
				<a href="#" class="menu-toggler" data-action="toggle" data-side="left"><i class="fas fa-bars"></i></a>
			</div>
			<a href="/admin" class="brand-name">Marmiuton</a>
		</div>

		<div class="menu d-flex ml-auto justify-content-end">
			<div class="menu-item dropdown">
				<a href="#" class="menu-link" role="button" data-toggle="dropdown">
					<div class="menu-icon">
						<i class="fas fa-bell"></i>
					</div>
					<div id="notificationsNumber" class="menu-label">n</div>
				</a>
				<div id="notificationsDropdown" class="dropdown-menu notificationsDropdown" aria-labelledby="userProfileDD">					
					<!--<a class="dropdown-item" target="_blank" href="https://vbcms.net/manager/myaccount">
						<small><strong>vbcms-updater</strong> - 2021-05-10 08:55:29</small><br>
						Une mise à jour est disponible!
					</a>-->
				</div>
			</div>
			<div class="menu-item d-flex align-items-center dropdown">
				<a href="#" class="menu-link dropdown-toggle" role="button" id="userProfileDD" data-toggle="dropdown">
					<div class="menu-img">
						<img src="<?=$_SESSION['userProfilePic']?>">
					</div>
					<div class="menu-text align-content-center mx-2">
						<?=$_SESSION['userName']?>
					</div>
				</a>
				<div class="dropdown-menu userDropdown" aria-labelledby="userProfileDD">
				    <a class="dropdown-item" href="/logout">Se déconnecter</a>
				</div>
			</div>
		</div>
	</div>
</header>


<!-- barre lattérale de naviguation -->
<div class="sidebar sidebarminify">
	<div class="scrollLinks">
		<div class="menu" >
			<div class="menu-header">Tableau de board</div>
			<div class="menu-item">
				<a href="/vbcms-admin" class="menu-link">
					<span class="menu-icon"><i class="fas fa-home"></i></span>
					<span class="menu-text">Tableau de board</span>
				</a>
			</div>
			<div class="menu-item">
				<a href="/vbcms-admin/settings" class="menu-link">
					<span class="menu-icon"><i class="fas fa-wrench"></i></span>
					<span class="menu-text">Paramètres</span>
				</a>
			</div>
			<?php //if(verifyUserPermission($_SESSION['userId'], 'vbcms', 'updatePanel')) { ?>
			<div class="menu-item">
				<a href="/vbcms-admin/updater" class="menu-link">
					<span class="menu-icon"><i class="fas fa-cloud-download-alt"></i></span>
					<span class="menu-text">Mises à jour</span>
				</a>
			</div>
			<?php //} ?>

			<?php /*
			if(VBcmsGetSetting("debugMode") == "1" && verifyUserPermission($_SESSION['userId'], 'vbcms', 'accessDebug')){
				echo '<div class="menu-item">
				<a href="/vbcms-admin/debug" class="menu-link">
					<span class="menu-icon"><i class="fas fa-bug"></i></span>
					<span class="menu-text">Debug</span>
				</a>
			</div>';
			}*/
			?>
			
			<?php //if(verifyUserPermission($_SESSION['userId'], 'vbcms', 'manageExtensions')) { ?>
			<div class="menu-divider"></div>
			<div class="menu-header">Workshop</div>
			<div class="menu-item">
				<a href="/vbcms-admin/workshop/manage" class="menu-link">
					<span class="menu-icon"><i class="fas fa-wrench"></i></span>
					<span class="menu-text">Gérer les extensions</span>
				</a>
			</div>
			<?php //} ?>

			<!-- Insérer les liens ici -->
			

		</div>
	</div>
</div>
<!-- FIN barre lattérale de naviguation -->

<script type="text/javascript">
	var pathname = window.location.pathname;
	if (pathname.slice(-1)=="/") {
		pathname = pathname.substring(0, pathname.length - 1);
	}
	$('a[href="'+pathname+'"]').addClass( "active" );

	$(".menu-toggler" ).click(function() {
		if ($(".sidebarminify").css("left") == "0px") {
			$(".sidebarminify").css("left", "-240px");
			resizePageContent(0,"left");
		}else{
			$(".sidebarminify").css("left", "0px");
			resizePageContent(240,"left");
		}
	});
	async function loadNotifications(){
		await $.get("/admin/backTasks/?getNotifications", function(data){
			var notifications = JSON.parse(data);
			if (notifications.length!=0) {
				$("#notificationsNumber").html(notifications.length);
				jQuery.each(JSON.parse(data), function(index){
					$("#notificationsDropdown").append('<a class="dropdown-item" href="'+notifications[index]["link"]+'">\
						<small><strong>'+JSON.parse(notifications[index]["origin"])[0]+'</strong> - '+notifications[index]["date"]+'</small><br>\
						'+notifications[index]["content"]+'\
					</a>');
				});
			} else {
				$("#notificationsNumber").remove();
				$("#notificationsDropdown").html("<div class='text-center text-muted'>Vous n'avez aucune notification <i class=\"far fa-smile\"></i></div>");
			}
			
		});
	}
	loadNotifications();
</script>