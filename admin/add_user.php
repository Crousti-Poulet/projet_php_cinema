<?php

	session_start();

	require '../includes/connect.php'; // pour se connecter à la BD
	require '../vendor/autoload.php'; // permet de charger toutes les dépendances de composer

	use Respect\Validation\Validator as v;

	if (!isset($_SESSION['user']) || empty($_SESSION['user'])){ // utilisateur non connecté

		header('Location: connexion.php');
		die();
	}
	else // utilisateur déjà connecté
	{

		$errors = []; // Contiendra les erreurs
		$post = []; // Contiendra mes données nettoyées (sans espace, ni balise html / php)
		$minFirstName = 2;
		$maxFirstName = 50;
		$minLastame = 2;
		$maxLastName = 50;	
		$minPassword = 8;
		$maxPassword = 16;
		$maxEmail = 100;
		$maxLengthRole = 10;


		// Si le formulaire a été soumis, la superglobale $_POST n'est pas vide
		if(!empty($_POST)){ 

			// Permet de nettoyer les données saisies par l'utilisateur
			// La boucle foreach passera de ligne en ligne (une ligne correspond à une entrée du tableau)
			// $key : contiendra la clé
			// $value : contiendra la valeur 
			// trim() retire les espaces en début et fin de chaine
			// strip_tags() retire les balises html & php. /!\ Important pour la sécurité
			foreach($_POST as $key => $value){
				// $post[$key] = $value permet de préserver l'association clé / valeur
				$post[$key] = trim(strip_tags($value));
			}

			/*
			// Données nettoyées après passage dans le foreach
			*/

			// On effectue nos vérifications
			if(!v::stringType()->length($minFirstName,$maxFirstName)->alpha('éèëêçàäâïîüûôö')->validate($post['firstname'])){ // ->noWhitespace() pas utilisé, il peut y avoir des prénoms composés
				$errors[] = 'Le prénom doit contenir entre '.$minFirstName.' et '.$maxFirstName.' caractères';
			}

			if(!v::stringType()->length($minLastame,$maxLastName)->alpha('éèëêçàäâïîüûôö')->validate($post['lastname'])){ // ->noWhitespace() pas utilisé, il peut y avoir des prénoms composés
				$errors[] = 'Le nom doit contenir entre '.$minLastame.' et '.$maxLastName.' caractères';
			}

			if(!v::stringType()->length($minPassword,$maxPassword)->validate($post['password'])){
				$errors[] = 'Le mot de passe doit contenir entre '.$minPassword.' et '.$maxPassword.' caractères';
			}

			if (!v::email()->validate($post['email'])){
				$errors[] = 'L\'adresse email est invalide';
			}

			if(!v::length(null,$maxEmail)->validate($post['email'])){
				$errors[] = 'L\'adresse email doit contenir moins de  '.$maxEmail.' caractères';
			}

			if(!v::stringType()->length(null,$maxLengthRole)->alpha('éèëêçàäâïîüûôö')->validate($post['role'])){
				$errors[] = 'Le role doit contenir au maximum '.$maxLengthRole.' caractères';
			}

			if(count($errors) === 0){
				$formValid = true;

				// formulaire valide, enregistrement dans la base
				
				$sth = $bdd->prepare('INSERT INTO users (firstname, lastname, email, password, role) VALUES (:data_firstname, :data_lastname, :data_email, :data_password, :data_role)');

				// association des paramètres ":" aux valeurs saisies dans le formulaire (sécurise la requête, plutôt que d'avoir les variables directement dans l'insert)
				$sth->bindValue(':data_firstname',$post['firstname'], PDO::PARAM_STR); // PARAM_STR = valeur par défaut, peut être omise
				$sth->bindValue(':data_lastname',$post['lastname']);
				$sth->bindValue(':data_email',$post['email']);
				$sth->bindValue(':data_password',password_hash($post['password'], PASSWORD_DEFAULT));
				$sth->bindValue(':data_role',$post['role']);

				$sth->execute();		
			}
			else {
				$formValid = false;
			}

		} // fin if(!empty($_POST))
	} // fin du if(empty($_SESSION)) else

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Création utilisateur</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
		<link rel="stylesheet" href="../css/style.css">

		<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
</head>
<body>
	
	<?php include 'navbar.php' ?>

	<main>

		<h2>Création utilisateur</h2>


		<!-- affichage du message de confirmation ou des erreurs -->
		<?php if(isset($formValid) && $formValid == true):?>

		<p style="color:green;">Utilisateur créé avec succès !</p>
	
		<?php elseif(isset($formValid) && $formValid == false):?>
	
		<p style="color:red;">
			<?=implode('<br>', $errors);?>
		</p>
		<?php endif;?>


		<div >
			<form method="post" id="formUser">
				
				<div class="form-group">
					<input type="text" class="form-control" name="firstname" id="firstname" placeholder="Prénom" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>">
				</div>

				<div class="form-group">
					<input type="text" class="form-control" name="lastname" id="lastname" placeholder="Nom" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>">
				</div>

				<div class="form-group">
					<input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
				</div>

				<div class="form-group">
					<input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe" value="<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>">
				</div>
				
				<div class="form-group">
					<select name="role" class="form-control" id="role" value="<?php echo isset($_POST['role']) ? $_POST['role'] : '' ?>">
							<option <?php if (isset($_POST['role']) && $_POST['role']=="Admin")  echo 'selected'; ?> value="Admin">Admin</option>
							<option <?php if (isset($_POST['role']) && $_POST['role']=="Editeur")  echo 'selected'; ?> value="Editeur">Editeur</option>
					</select>
				</div>

				<button type="submit" class="btn">Enregistrer</button>

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