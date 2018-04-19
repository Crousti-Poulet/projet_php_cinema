<?php

	session_start();

	require '../includes/connect.php'; // pour se connecter à la BD

	$maxLengthStoryline = 110;

	if (!isset($_SESSION['user']) || empty($_SESSION['user'])){ // utilisateur non connecté

		header('Location: connexion.php');
		die();
	}
	else // utilisateur déjà connecté
	{
		// nécessaire de récuperer l'ID mais inutile de l'afficher
		$res = $bdd->prepare('SELECT id, firstname, lastname, email, password, role, date_created, date_updated FROM users ORDER BY date_created DESC'); 
		$res->execute();
		$users = $res->fetchAll();

	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>liste utilisateur</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
		<link rel="stylesheet" href="../css/style.css">

		<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
</head>
<body>
	
	<?php include 'navbar.php' ?>

	<main>

		<h2>Liste des films</h2>


		<div>
			<table class="table table-striped table-hover" id="listeResas">
				<thead class="thead-dark">
					<tr>
						<th>Modifier</th>
						<th>Supprimer</th>
						<th>Prénom</th>
						<th>Nom</th>
						<th>Email</th>
						<th>role</th>
						<th>date de création</th>
						<th>date de modification</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($users as $user){
							echo '<tr>';
								echo '<td><a href="update_user.php?id='.$user['id'].'"><i class="fas fa-search"></i></a></td>';
								echo '<td><a href="delete_user.php?id='.$user['id'].'"><i class="fas fa-trash-alt"></i></a></td>';
								echo '<td><b>'.$user['firstname'].'</b></td>';
								echo '<td>'.$user['lastname'].'</td>';
								echo '<td>'.$user['email'].'</td>';
								echo '<td>'.$user['role'].'</td>';
								echo '<td>'.date('d/m/Y H:i', strtotime($user['date_created'])).'</td>';
								echo '<td>'.date('d/m/Y H:i', strtotime($user['date_updated'])).'</td>';
								
							echo '</tr>';
						}
					?>
				</tbody>
			</table>

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