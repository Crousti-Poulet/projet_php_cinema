<?php 




	require 'includes/connect.php'; // pour se connecter à la BD
		/*Preparation de la requête*/ 
		$sth = $bdd->prepare('SELECT id, title, length, date_release, genre, country, director, actors, storyline, poster_img_path, date_created, date_updated FROM movies ORDER BY date_created DESC');

		/* Execution de la requete SQL */
		// on effectue l'insertion
		$sth->execute();


		//lecture des données
		$movies = $sth->fetchAll(PDO::FETCH_ASSOC);


		// nécessaire de récuperer l'ID mais inutile de l'afficher
		$res = $bdd->prepare('SELECT id, title, user_id, content, img_path, date_created, date_updated FROM news ORDER BY date_created DESC LIMIT 4'); 
		$res->execute();
		$news = $res->fetchAll();
	

 ?>




<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Main  Page</title>
	<link href="https://fonts.googleapis.com/css?family=Cinzel:700" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<link href="https://fonts.googleapis.com/css?family=EB+Garamond" rel="stylesheet"> 


	<link rel="stylesheet" type="text/css" href="css/header.css">

	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
	<!-- ajout du header -->
	<?php include 'header.php' ?>

	<main class="mainFront">

		<!--les 4 film de la première page-->
		<h2 class="main-title mt-5 mb-2 text-center">Les films du moments!</h2>

		<div id="topmovie">
			<?php foreach ($movies as $movie) {
				echo '<a href=""><img src="'.$movie['poster_img_path'].'"></a>';
		} ?>
		</div>



		<!-- ACTUS -->

		<div class="container">
			<h2 class="actu-title mb-5 mt-5 text-center">Les actus !!</h2>
			<?php 
			foreach ($news as $new) {
				
			
				 echo '<div class="row art">';
					echo '<div class="col-sm-6 order-2 order-lg-1 col-md-6 col-lg-9  mt-3 border ">';
						echo '<h5 class="article-title">'.$new['title'].'</h5>';
						echo '<p class="article-p">'.$new['content'].'</p>';
					echo'</div>';
					echo'<div class="col-sm-6 order-1 order-lg-2 col-md-6 col-lg-3 d-flex justify-content-center">';
						echo '<img src="'.$new['img_path'].'">';
				echo '</div>';
				echo '</div>';
			}?>

		</div>

	</main>


	<!-- ajout du footer -->
	<?php  include 'footer.php' ?>


	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script  src="http://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
 	crossorigin="anonymous"></script>
 	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</body>
</html>