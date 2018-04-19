<?php 

	session_start();

	//Afin de pouvoir utiliser Respect/Validation
	require '../vendor/autoload.php';

	//Afin de pouvoir utiliser l'élément v de Respect/Validation
	use Respect\Validation\Validator as v;

	require '../includes/connect.php'; // On inclut le fichier "connect" servant à se connecter à la base de données.

	if (!isset($_SESSION['user']) || empty($_SESSION['user'])){ // utilisateur non connecté

		header('Location: connexion.php');
		die();
	}
	// vérifier que l'utilisateur a le droit d'accéder à cette page : Admin = OK, Editeur = KO
	elseif ($_SESSION['user']['role']!='Admin') {
		header('Location: private.php');
		die();
	}
	else // utilisateur déjà connecté
	{
		
		$errors = [];
		$post = [];

		// Si le formulaire a été soumis, la superglobale $_POST n'est pas vide
		if(!empty($_POST)){ 
			
			if(empty($_POST['movie'])) {
				$errors[] = 'Veuillez choisir un film.';
			}

			if(count($errors) === 0){

				$formValid = true;

				$sth = $bdd->prepare('INSERT INTO showtimes (id_movie, showtime) VALUES(:idMovie, :showtime)');

				$sth->bindValue(':idMovie', $_POST['movie']);
				$sth->bindValue(':showtime', $_POST['showtime']);

				$success = $sth->execute();

				}  
				else {
					$formValid = false;
			}
		}

	} // fin du else du if (!isset($_SESSION['user']) || empty($_SESSION['user']))

 ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<!-- Bootstrap start --> 
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<!-- Bootstrap end -->
		<link rel="stylesheet" href="../css/style.css">
		<!-- fonts start -->
		<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
		<!-- fonts end -->
		<title>Ajouter un horaire</title>
	</head>
	<body>
  
	<?php include 'navbar.php' ?>
			
		<main class="container" id="main_bloc">
			
			<h2>Ajouter une séance de film</h2>
				
			<!-- Affichage des messages d'erreur ou de confirmation -->
			<?php if(isset($formValid) && $formValid == true && $success):?>

			<p style="color:green;">L'horaire de la séance a bien été enregistrée</p>
			
			<?php elseif(isset($formValid) && $formValid == true && !$success):?>
			
			<p style="color:red;">Erreur SQL</p>

			<?php elseif(isset($formValid) && $formValid == false):?>
			
			<p style="color:red;"><?=implode('<br>', $errors);?></p>
			<?php endif;?>

			<div>
				<form class="mx-auto" method="POST" id="formNewShowtime" enctype="multipart/form-data">
						
					<div class="form-group">
						<!-- affichage de la liste des films à partir de la base -->
						<?php
							$res = $bdd->prepare('SELECT id, title FROM movies ORDER BY date_created DESC'); 
							$res->execute();
							$movies = $res->fetchAll(); 
						?>

						<select  class="form-control col-3" name="movie" id="movie">
						<?php 

						foreach($movies as $m){
							echo '<option value="'.$m['id'].'">'.$m['title'].'</option>';
						}

						?>        
						</select>
					</div>

					<div class="form-group">
						<label for="showtime">Date de la séance :</label>
						<input class="form-control col-3" type="date" name="showtime" id="showtime" value="<?php if (isset($_POST['showtime'])){echo $_POST['showtime'];} ?>">
					</div>

					<button type="submit" class="btn">Enregistrer</button>

				</form>
			</div>




					
					

					
				</form>
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