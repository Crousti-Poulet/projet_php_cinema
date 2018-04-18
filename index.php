<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Main  Page</title>
	<link href="https://fonts.googleapis.com/css?family=Cinzel:700" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<<<<<<< HEAD:index.php
	<link href="https://fonts.googleapis.com/css?family=EB+Garamond" rel="stylesheet"> 
=======

	<link rel="stylesheet" type="text/css" href="css/header.css">
>>>>>>> d4ee21656aa0a110980337d1ff5ac0af6b0caa8c:index.php
	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
	<!-- ajout du header -->
	<?php include 'header.php' ?>

	<main class="">

		<h1 class="main-title mt-sm-5">Les films du moments!</h1>

		<div class="row justify-content-center">
			<div id="carouselExampleIndicators" class="carousel slide col-10" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
				</ol>
				<div class="carousel-inner">
					<div class="carousel-item active">
						<img class="d-block w-100" src="img/700x300.png" alt="First slide">
						<div class="carousel-caption d-none d-md-block">
				    		<h5>film 1</h5>
				    		<p>petit commentaire sur le film</p>
						</div>
					</div>

				    <div class="carousel-item">
				      	<img class="d-block w-100" src="img/700x300.png" alt="Second slide">
						<div class="carousel-caption d-none d-md-block">
							<h5>film 2</h5>
							<p>petit commentaire sur le film</p>
						</div>
				    </div>

				    <div class="carousel-item">
				      	<img class="d-block w-100" src="img/700x300.png" alt="Second slide">
						<div class="carousel-caption d-none d-md-block">
							<h5>film 5</h5>
							<p>petit commentaire sur le film</p>
						</div>
				    </div>

				    <div class="carousel-item">
				      	<img class="d-block w-100" src="img/700x300.png" alt="Second slide">
						<div class="carousel-caption d-none d-md-block">
							<h5>film 4</h5>
							<p>petit commentaire sur le film</p>
						</div>
				    </div>

			 	</div>

				<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>

		<div class="container">
			<div class="row art">
				<div class="col-lg-9 border ">
					<h5 class="article-title">titre de l'actu</h5>
					<p class="article-p">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</div>
				<div class="col-lg-3">
					<img src="img/200x300.png">
				</div>
			</div>

			<div class="row art">
				<div class="col-3">
					<img src="img/200x300.png">
				</div>
				<div class="col-9 border">
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
				<div class="col-9 border">
					<h5 class="article-title">titre de l'actu</h5>
					<p class="article-p">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</div>
				<div class="col-3">
					<img src="img/200x300.png">
				</div>
			</div>

			<div class="row art">
				<div class="col-3">
					<img src="img/200x300.png">				
				</div>
				<div class="col-9 border">
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