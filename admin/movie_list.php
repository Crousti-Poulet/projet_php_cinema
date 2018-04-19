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
		$sth = $bdd->prepare('SELECT id, title, length, date_release, genre, country, director, actors, storyline, poster_img_path, date_created, date_updated FROM movies ORDER BY date_created DESC'); 
		$sth->execute();
		$movies = $sth->fetchAll();

	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Cinéma</title>

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

		<div >
			<table class="table table-striped table-hover" id="movieList">

				<thead class="thead-dark">
					<tr>
						<th>Modifier</th>
						<th>Supprimer</th>
						<th>Titre</th>
						<th>Durée</th>
						<th>Date de sortie</th>
						<th>Genre</th>
						<th>Pays</th>
						<th>Réalisateur</th>
						<th>Acteurs</th>
						<th>Synopsis</th>
						<th>Affiche</th>
						<th>Date création</th>
						<th>Date modif.</th>
						
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($movies as $m){
							echo '<tr>';
								echo '<td><a href="update_movie.php?id='.$m['id'].'"><i class="fas fa-search"></i></a></td>';
								echo '<td><a href="delete_movie.php?id='.$m['id'].'"><i class="fas fa-trash-alt"></i></a></td>';
								echo '<td><b>'.$m['title'].'</b></td>';
								echo '<td>'. floor($m['length'] / 60) .'h'. sprintf('%02d', $m['length'] % 60 ) .'</td>'; // sprintf pour afficher '2h03' au lieu de 2h3'
								echo '<td>'.date('d/m/Y', strtotime($m['date_release'])).'</td>';
								echo '<td>'.$m['genre'].'</td>';
								echo '<td>'.$m['country'].'</td>';
								echo '<td>'.$m['director'].'</td>';
								echo '<td>'.$m['actors'].'</td>';
								echo '<td>'.substr($m['storyline'],0,$maxLengthStoryline).(strlen($m['storyline']) > $maxLengthStoryline ? '...' : '').'</td>';
								echo '<td><img class="photoThumb" src="../'.$m['poster_img_path'].'"></td>';
								echo '<td>'.date('d/m/Y H:i', strtotime($m['date_created'])).'</td>';
								echo '<td>'.date('d/m/Y H:i', strtotime($m['date_updated'])).'</td>';
								
							echo '</tr>';
						}
					?>
				</tbody>
			</table>

		</div>
	</main>


</body>
</html>