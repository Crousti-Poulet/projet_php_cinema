<?php

	session_start();

	require '../includes/connect.php'; // pour se connecter à la BD

	if (!isset($_SESSION['user']) || empty($_SESSION['user'])){ // utilisateur non connecté

		header('Location: ../connexion.php');
		die();
	}
	else // utilisateur déjà connecté
	{

		$res = $bdd->prepare('SELECT * FROM booking ORDER BY date_booking DESC'); 
		$res->execute();
		$bookings = $res->fetchAll();

	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Réservation de restaurant</title>

	<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
		<link rel="stylesheet" href="../css/style.css">

		<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
</head>
<body>
	
	<header>

		<nav class="container-fluid">
			<div id="logo" class="menu-left">
				<a class="menu-logo" href="index.php">Le gras c'est la vie</a>
			</div>
			<ul id="menu" class="menu-right">
				<li class="menu-item"><a href="../index.php">Accueil</a></li>
				<li class="menu-item"><a href="reservations.php">Réservations</a></li> <!-- # = page actuelle -->
				<li class="menu-item"><a href="new_user.php">Créer utilisateur</a></li>
				<li class="menu-item"><a href="users.php">Utilisateurs</a></li>
				<li class="menu-item"><a href="add_picture.php">Ajout image</a></li>
				<li class="menu-item"><a href="add_options.php">MAJ adresse</a></li>
				<li class="menu-item"><a href="deconnexion.php">Deconnexion</a></li>
				<li class="menu-item menu-mobile"><a href="#"><i class="fas fa-bars"></i></a></li>
			</ul>
			<!-- <li class="menu-item"><a href="#"><i class="fas fa-shopping-cart"></i><div class="counter"><span class="fa-layers-counter" style="background:Tomato">1,419</span></div></a></li> -->
		</nav>
	</header>

	<main>

		<!-- section container fluid avec bandeau pour avoir 100%, reste dans container -->
		<!-- <section id="bandeau" class="container-fluid"> -->
			<!-- <div class="row no-gutters"> row obligatoire pour insérer des colonnes, no-gutters pour supprimer les marges horizontales -->
				<!-- <div class="col-12"> -->
					<!-- <img id="img_bandeau" src="img/bandeau.jpg" alt="avocat bacon egg"> -->
					<!-- <h1>Le gras c'est la vie</h1> -->
				<!-- </div> -->
			<!-- </div> -->
		<!-- </section> -->

		<h2>Liste des réservations</h2>


		<div >
			<table class="table table-striped table-hover" id="listeResas">
				<thead class="thead-dark">
					<tr>
						<th>ID</th>
						<th>Prénom</th>
						<th>Nom</th>
						<th>Téléphone</th>
						<th>Email</th>
						<th>Date</th>
						<th>Détail</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($bookings as $b){
							echo '<tr>';
								echo '<td>'.$b['id'].'</td>';
								echo '<td>'.$b['firstname'].'</td>';
								echo '<td>'.$b['lastname'].'</td>';
								echo '<td>'.$b['phone'].'</td>';
								echo '<td>'.$b['email'].'</td>';
								echo '<td>'.date('d/m/Y H:i', strtotime($b['date_booking'])).'</td>';
								echo '<td><a href="detail_reservation.php?id='.$b['id'].'"><i class="fas fa-search"></i></a></td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>


		


		</div>
	</main>


</body>
</html>