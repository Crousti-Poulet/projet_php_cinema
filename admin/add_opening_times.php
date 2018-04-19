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

			foreach($_POST as $key => $value){
				$post[$key] = trim(strip_tags($value));
			}
			
			if(empty($_POST['day'])) {
				$errors[] = 'Veuillez choisir un jour.';
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

				$sth = $bdd->prepare('INSERT INTO opening_times (day, times) VALUES(:day, :times)');

				$sth->bindValue(':day', $_POST['day']);
				$sth->bindValue(':times', $times);

				//Varibale permettant de vérifier si un jour a déjà été défini dans la table.
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
			
			<h2>Ajouter un horaire</h2>
				
			<!-- Affichage des messages d'erreur ou de confirmation -->
			<?php if(isset($formValid) && $formValid == true && $success):?>

			<p style="color:green;">Le nouvel horaire a bien été enregistré</p>
			
			<!-- Affichage d'un message d'erreur si le formulaire est valide mais que le jour est déjà présent dans la table -->
			<?php elseif(isset($formValid) && $formValid == true && !$success):?>
			
			<p style="color:red;">Horaire du jour déjà défini (pour toutes modifications, veuillez vous rendre sur la page de modification des horaires d'ouverture.</p>

			<?php elseif(isset($formValid) && $formValid == false):?>
			
			<p style="color:red;"><?=implode('<br>', $errors);?></p>
			<?php endif;?>

			<div>
				<form class="mx-auto" method="POST" id="formNewMovie" enctype="multipart/form-data">
							
					<div class="form-group">
						<label for="day">Jour :</label>
						<select class="form-control col-3" name="day" id="day">
							<option <?php if (isset($_POST['day']) && $_POST['day']=="Lundi") echo 'selected'; ?> value="Lundi">Lundi</option>
							<option <?php if (isset($_POST['day']) && $_POST['day']=="Mardi") echo 'selected'; ?> value="Mardi">Mardi</option>
							<option <?php if (isset($_POST['day']) && $_POST['day']=="Mercredi") echo 'selected'; ?> value="Mercredi">Mercredi</option>
							<option <?php if (isset($_POST['day']) && $_POST['day']=="Jeudi") echo 'selected'; ?> value="Jeudi">Jeudi</option>
							<option <?php if (isset($_POST['day']) && $_POST['day']=="Vendredi") echo 'selected'; ?> value="Vendredi">Vendredi</option>
							<option <?php if (isset($_POST['day']) && $_POST['day']=="Samedi") echo 'selected'; ?> value="Samedi">Samedi</option>
							<option <?php if (isset($_POST['day']) && $_POST['day']=="Dimanche") echo 'selected'; ?> value="Dimanche">Dimanche</option>
							<option <?php if (isset($_POST['day']) && $_POST['day']=="Férié") echo 'selected'; ?> value="Férié">Férié</option>
						</select>
					</div>

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