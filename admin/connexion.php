<?php

session_start();

require '../includes/connect.php'; // pour se connecter à la BD

$errors = [];

if(!empty($_POST)){
	foreach($_POST as $key => $value){
		$post[$key] = trim(strip_tags($value));
	}

	if(empty($post['email'])){
		$errors[] = 'Veuillez saisir votre adresse email';
	}

	if(empty($post['password'])){
		$errors[] = 'Veuillez saisir votre mot de passe';
	}

	if(count($errors) === 0){	

		$res = $bdd->prepare('SELECT id, firstname, lastname, email, password, role FROM users WHERE email = :email LIMIT 1');
		$res->bindValue(':email', $_POST['email']);
		$res->execute();
		$user = $res->fetch(); 

		if(!empty($user)){
			if(password_verify($post['password'], $user['password'])){
				$_SESSION['user'] = array(
					'id' => $user['id'],
					'firstname' => $user['firstname'],
					'lastname' => $user['lastname'],
					'email' => $user['email'],
					'role' => $user['role']
				);
				//rediriger vers la page accueil admin
				header('Location: movie_list.php');
				die();
			}
			else { 
				$errorLogin = true;
			}
		}	
		else {
			$errorLogin = true; 
		}
	} // fin if(count($errors) === 0)

	else {
		$formError = true;
	}
} // fin if(!empty($_POST))

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Connexion admin</title>

	<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
		<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	
	<?php include 'navbar.php' ?>

	<main>

		<h2>Connexion admin</h2>

		<?php 
			if(isset($formError) && $formError){
				echo '<p class="error">'.implode('<br>', $err).'</p>';
			}
			if(isset($errorLogin) && $errorLogin){
				echo '<p class="error">Erreur d\'adresse email ou de mot de passe</p>';
			}

			if(isset($_SESSION['user']['firstname']) && isset($_SESSION['user']['email']) && isset($_SESSION['user']['lastname'])){
				echo '<p class="success">Bonjour '.$_SESSION['user']['firstname'].' '.$_SESSION['user']['lastname'];
				echo '<br>Vous êtes déjà connecté.</p>';
			}
		?>

		<div >

			<form method="post" id="formConnexion">
				<div class="form-group">
					<input type="email" id="email" name="email" placeholder="votre@email.fr">
				</div>
				
				<div class="form-group">
					<input type="password" id="password" name="password" placeholder="Votre mot de passe">
				</div>
				<button type="submit" class="btn">Se connecter</button>
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