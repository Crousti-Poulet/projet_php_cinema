<?php

session_start();

require '../includes/connect.php'; // pour se connecter à la BD

if(isset($_GET['logout']) && $_GET['logout'] == 'yes'){
	$_SESSION['user'] = []; 
	header('Location: ../index.php');
	die();
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Deconnexion admin</title>

	<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
		<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	
	<header>
		<nav class="container-fluid">
			<div id="logo" class="menu-left">
			</div>
			<ul id="menu" class="menu-right">
				<li class="menu-item"><a href="movie_list.php">Films</a></li>
				<li class="menu-item"><a href="news_list.php">Actualités</a></li>
				<li class="menu-item"><a href="users_list.php">Utilisateurs</a></li>
				<li class="menu-item"><a href="add_user.php">Créer utilisateur</a></li>
				<li class="menu-item"><a href="deconnexion.php">Deconnexion</a></li>
			</ul>
		</nav>
	</header>

	<main>

		<h2>Deconnexion admin</h2>

		<div >

			<?php if(!empty($_SESSION['user']) && isset($_SESSION['user'])): ?>
				<p style="text-align:center;">
					<?php echo $_SESSION['user']['firstname']; ?>, voulez-vous vous déconnecter ?

					<br><br>
					<img src="http://ronron.e-monsite.com/medias/images/chaton-triste.jpg" style="height:200px;border-radius:10px;">
				
					<br><br>

					<a href="deconnexion.php?logout=yes">Oui, je veux me déconnecter</a>
				</p>

			<?php else: ?>
				<p style="text-align:center;">
					Vous êtes  déjà déconnecté !

					<br><br>
					<img src="http://captainquizz.s3.amazonaws.com/quizz/551aeb19366880.99678770.jpg" style="height:200px;border-radius:10px;">
				</p>
			<?php endif; ?>
			
		</div>
	</main>


</body>
</html>