<?php


	require 'includes/connect.php'; // pour se connecter à la BD


		// nécessaire de récuperer l'ID mais inutile de l'afficher
		$res = $bdd->prepare('SELECT id, title, user_id, content, img_path, date_created, date_updated FROM news ORDER BY date_created DESC'); 
		$res->execute();
		$news = $res->fetchAll();


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Liste des actualités</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<!-- les lien pour les css-->
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/header.css">
		<!--lien pour les fonts-->
		<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
</head>
<body>
	
	<?php include 'header.php' ?>

	<main class="mainFront">

		<h2>Liste des actualités</h2>


		<div>
			<table class="table table-striped table-hover" id="listeResas">
				<thead class="thead-dark">
					<tr>
						<th>Détail</th>
						<th>Titre</th>
						<th>Auteur</th>
						<th>Contenu</th>
						<th>Image</th>
						<th>Date création</th>
						<th>Date modif.</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($news as $new){
							echo '<tr>';
								echo '<td><a href="detail_news.php?id='.$new['id'].'"><i class="fas fa-search"></i></a></td>';
								echo '<td><b>'.$new['title'].'</b></td>';
								echo '<td><b>'.$new['title'].'</b></td>';
								echo '<td>'.$new['user_id'].'</td>';
								echo '<td>'.$new['content'].'</td>';
								echo '<td><img src="'.$new['img_path'].'"></td>';
								echo '<td>'.date('d/m/Y H:i', strtotime($new['date_created'])).'</td>';
								echo '<td>'.date('d/m/Y H:i', strtotime($new['date_updated'])).'</td>';
								
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

