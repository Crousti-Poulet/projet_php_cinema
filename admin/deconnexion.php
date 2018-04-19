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
	
	<?php include 'navbar.php' ?>

	<main class="container">

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

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script  src="http://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
 	crossorigin="anonymous"></script>
 	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


</body>
</html>