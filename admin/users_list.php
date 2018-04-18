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


</body>
</html>