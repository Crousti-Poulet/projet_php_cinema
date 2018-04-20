<?php

	require 'includes/connect.php'; // pour se connecter à la BD

	$maxLengthStoryline = 110;


		// liste de tous les films avec une séance le jour même
		$sth = $bdd->prepare('SELECT DISTINCT id, title, length, date_release, genre, country, director, actors, storyline, poster_img_path, date_created, date_updated FROM movies m INNER JOIN showtimes s ON m.id = s.id_movie WHERE DATE(s.showtime) = CURDATE() ORDER BY date_created DESC'); 
		$sth->execute();
		$movies = $sth->fetchAll();


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Films du jour</title>

	<link href="https://fonts.googleapis.com/css?family=Cinzel:700" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<link href="https://fonts.googleapis.com/css?family=EB+Garamond" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">

		

</head>
<body>
	
	<?php include 'header.php' ?>

	<main class="mainFront">

		<h2 class="main-title">Films du jour</h2>



		<div>
			<table class="table table-striped table-hover" id="listeResas">

		<div >
			<table class="table table-striped table-hover" id="movieList">

				<thead class="thead-dark">
					<tr>
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
								echo '<td><b>'.$m['title'].'</b></td>';
								echo '<td>'. floor($m['length'] / 60) .'h'. sprintf('%02d', $m['length'] % 60 ) .'</td>'; // sprintf pour afficher '2h03' au lieu de 2h3'
								echo '<td>'.date('d/m/Y', strtotime($m['date_release'])).'</td>';
								echo '<td>'.$m['genre'].'</td>';
								echo '<td>'.$m['country'].'</td>';
								echo '<td>'.$m['director'].'</td>';
								echo '<td>'.$m['actors'].'</td>';
								echo '<td>'.substr($m['storyline'],0,$maxLengthStoryline).(strlen($m['storyline']) > $maxLengthStoryline ? '...' : '').'</td>';
								echo '<td><img class="photoThumb" src="'.$m['poster_img_path'].'"></td>';
								echo '<td>'.date('d/m/Y H:i', strtotime($m['date_created'])).'</td>';
								echo '<td>'.date('d/m/Y H:i', strtotime($m['date_updated'])).'</td>';
								
							echo '</tr>';
						}
					?>
				</tbody>
			</table>

		</div>
	</main>

		<?php include 'footer.php' ?>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script  src="http://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
 	crossorigin="anonymous"></script>
 	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


</body>
</html>