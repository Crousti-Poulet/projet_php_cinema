<?php 
	session_start();



	require 'includes/connect.php'; // pour se connecter à la BD
		/*Preparation de la requête*/ 
		$sth = $bdd->prepare('SELECT id, title, length, date_release, genre, country, director, actors, storyline, poster_img_path, date_created, date_updated FROM movies WHERE date_release = CURDATE() LIMIT 4');

		/* Execution de la requete SQL */
		// on effectue l'insertion
		$sth->execute();


		//lecture des données
		$movies = $sth->fetchAll(PDO::FETCH_ASSOC);
	



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

	<main class="">

		<!-- SLIDER -->
		<h2 class="main-title mt-5 mb-2 text-center">Les films du moments!</h2>

		<div class="row justify-content-center">
			<div id="carouselExampleIndicators" class="carousel slide col-10" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
				</ol>
				<div class="carousel-inner ">
					<div class="carousel-item active  text-center">
						<img class="w-25 " src="<?php echo $movies[0]['poster_img_path']  ?>" alt="First slide">
						
					</div>
	
				    <div class="carousel-item text-center">
				      	<img class="w-25 " src="<?php echo $movies[1]['poster_img_path']  ?>" alt="Second slide">
						<div class="carousel-caption d-none d-md-block">
							<h5>film 2</h5>
							<p>petit commentaire sur le film</p>
						</div>
				    </div>

				    <div class="carousel-item text-center">
				      	<img class="w-25 " src="<?php echo $movies[2]['poster_img_path']  ?>" alt="Second slide">
						<div class="carousel-caption d-none d-md-block">
							<h5>film 5</h5>
							<p>petit commentaire sur le film</p>
						</div>
				    </div>

				    <div class="carousel-item text-center">
				      	<img class="w-25 " src="<?php echo $movies[3]['poster_img_path']  ?>" alt="Second slide">
						<div class="carousel-caption d-none d-md-block">
							<h5>film 4</h5>
							<p>petit commentaire sur le film</p>
						</div>
				    </div>

			 	</div>

				<a class="carousel-control-prev bg-dark" href="#carouselExampleIndicators" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon arrow-prev" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next bg-dark" href="#carouselExampleIndicators" role="button" data-slide="next">
					<span class="carousel-control-next-icon arrow-next" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>

		<!-- ACTUS -->

		<div class="container">
			<h2 class="actu-title mb-5 mt-5 text-center">Les actus !!</h2>

			<div class="row art">
				<div class="col-sm-6 order-2 order-lg-1 col-md-6 col-lg-9  mt-3 border ">
					<h5 class="article-title">titre de l'actu</h5>
					<p class="article-p">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</div>
				<div class="col-sm-6 order-1 order-lg-2 col-md-6 col-lg-3 d-flex justify-content-center">
					<img src="img/200x300.png">
				</div>
			</div>

			<div class="row art">
				<div class="col-sm-6 col-md-6 col-lg-3 d-flex justify-content-center">
					<img src="img/200x300.png">
				</div>
				<div class="col-sm-6  col-md-6 col-lg-9  mt-3 border "">
					<h5 class="article-title">titre de l'actu</h5>
					<p class="article-p">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</div>
			</div>


		<div class="row art">
				<div class="col-sm-6 order-2 order-lg-1 col-md-6 col-lg-9  mt-3 border "">
					<h5 class="article-title">titre de l'actu</h5>
					<p class="col-sm-12 article-p">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</div>
				<div class="col-sm-6 order-1 order-lg-2 col-md-6 col-lg-3 d-flex justify-content-center">
					<img src="img/200x300.png">
				</div>
			</div>

			<div class="row art">
				<div class="col-sm-6  col-md-6 col-lg-3 d-flex justify-content-center">
					<img src="img/200x300.png">				
				</div>
				<div class="col-sm-6  col-md-6 col-lg-9 mt-3 border "">
					<h5 class="article-title">titre de l'actu</h5>
					<p class="article-p">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</div>
			</div>
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