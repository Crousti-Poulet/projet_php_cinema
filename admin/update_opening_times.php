<?php

	session_start();

	//Afin de pouvoir utiliser Respect/Validation
	require '../vendor/autoload.php';

	//Afin de pouvoir utiliser l'élément v de Respect/Validation
	use Respect\Validation\Validator as v;

	require '../includes/connect.php'; // pour se connecter à la BD

	if (!isset($_SESSION['user']) || empty($_SESSION['user'])){ // utilisateur non connecté

		header('Location: ../connexion.php');
		die();
	}
	// vérifier que l'utilisateur a le droit d'accéder à cette page : Admin = OK, Editeur = KO
	elseif ($_SESSION['user']['role']!='Admin') {
		header('Location: private.php');
		die();
	}
	else // utilisateur déjà connecté
	{

		if (isset($_GET['day']) && !is_numeric($_GET['day'])){

			//récuperer les informations de la table
			$res = $bdd->prepare('SELECT * FROM opening_times WHERE day = :day'); 
			$res->bindValue(':day', $_GET['day']);
			$res->execute();
			$opening_day = $res->fetchAll(); 

			if (isset($opening_day) && !empty($opening_day)){

				$errors = [];
				$post = [];

				// Si le formulaire a été soumis, la superglobale $_POST n'est pas vide
				if(!empty($_POST)){ 

					if(empty($_GET['day']) || $_GET['day'] !== $opening_day[0]['day']) {
						$errors[] = 'Veuillez choisir un jour défini dans la base de donné.';
					}

					if(!is_numeric($_POST['opening_hour']) || !is_numeric($_POST['opening_minute'])) {
						$errors[] = 'Veuillez choisir une heure d\'ouverture valide.';
					}

					if(!is_numeric($_POST['closing_hour']) || !is_numeric($_POST['closing_minute'])) {
						$errors[] = 'Veuillez choisir une heure de fermeture valide.';
					}
				
					if(count($errors) === 0){

						$formValid = true;

						//Variable permettant de reconstituer l'horaire sous forme d'une chaine de caractère.
						$times = $_POST['opening_hour'].' h '.$_POST['opening_minute'].' ~ '.$_POST['closing_hour'].' h '.$_POST['closing_minute'];

						$sth = $bdd->prepare('UPDATE opening_times SET times = :times WHERE day = :day');

						$sth->bindValue(':day', $_GET['day']);
						$sth->bindValue(':times', $times);
						var_dump($_GET['day']);

						//Varibale permettant de vérifier si un jour a déjà été défini dans la table.
						$success = $sth->execute();

						header('Location: opening_times_list.php');
						die();

						}  
						else {
						$formValid = false;
					}
					
				} // fin du if(!empty($_POST))

			} // fin du if (isset($movie) && !empty($movie))

		} // fin du if (isset($_GET['id']) && is_numeric($_GET['id']))

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
		<title>Modifier une fiche de film</title>
	</head>
	<body>

	<?php include 'navbar.php' ?>

	<main class="container">

		<h2>Modification des horaires d'ouverture</h2>


		<?php 
			// afficher le formulaire seulement si le jour est trouvé
			if (isset($_GET['day']) && !is_numeric($_GET['day'])):
		 ?>

			<!-- affichage du message de confirmation ou des erreurs -->
			<?php if(isset($formValid) && $formValid == true && $success):?>

			<p style="color:green;">Fiche de film modifiée avec succès !</p>
		
			<?php elseif(isset($formValid) && $formValid == true && !$success):?>
		
			<p style="color:red;">Erreur, fiche non modifiée</p>
		
			<?php elseif(isset($formValid) && $formValid == false):?>
		
			<p style="color:red;">
				<?=implode('<br>', $errors);?>
			</p>
			<?php endif;?>


			<div>
				<form class="mx-auto" method="POST" id="formNewMovie" enctype="multipart/form-data">
					
					<!-- Horaire d'ouverture -->
					<div class="form-group">
						<label for="opening_hour">Horaire d'ouverture : </label>					
						<select class="form-control form-inline col-3" name="opening_hour" id="opening_hour">
							<option value="open_h">heure</option>	
							<?php for ($heure = 00 ; $heure <= 23 ; $heure++):
								$hour = sprintf("%02d", $heure);
							?>
							<option value="<?php echo $hour ?>"><?=$hour;?></option>
							<?php endfor; ?>							
						</select>

						<select class="form-control form-inline col-3" name="opening_minute" id="opening_minute">
							<option value="open_m">minute</option>	
							<?php for ($minutes = 00 ; $minutes <= 59 ; $minutes++):
								$min = sprintf("%02d", $minutes);
							?>
							<option value="<?=$min ?>"><?=$min;?></option>
						<?php endfor; ?>							
						</select>					
					</div>
					
					<!-- Horaire de fermeture -->
					<div class="form-group">
						<label for="closing_hour">Horaire de fermeture : </label>			
						<select class="form-control form-inline col-3" name="closing_hour" id="closing_hour">
							<option value="close_h">heure</option>	
							<?php for ($heure = 00 ; $heure <= 23 ; $heure++):
								$hour = sprintf("%02d", $heure);
							?>
							<option value="<?php echo $hour ?>"><?=$hour;?></option>
							<?php endfor; ?>							
						</select>

						<select class="form-control form-inline col-3" name="closing_minute" id="closing_minute">
							<option value="close_m">minute</option>	
							<?php for ($minutes = 00 ; $minutes <= 59 ; $minutes++):
								$min = sprintf("%02d", $minutes);
							?>
							<option value="<?=$min ?>"><?=$min;?></option>
						<?php endfor; ?>							
						</select>					
					</div>

					<button type="submit" class="btn">Valider</button>

				</form>
			</div>

			<?php 
				else: echo '<p style="color:red;">Les horaires de ce jour n\'ont pas encore été définis.</p>';
			?>
			<?php endif ?>
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