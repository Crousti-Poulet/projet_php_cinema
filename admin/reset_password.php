<?php  
session_start();

require '../includes/connect.php'; // pour se connecter à la BD
require '../vendor/autoload.php'; // permet de charger toutes les dépendances de composer

use Respect\Validation\Validator as v;

$sth = $bdd->prepare('SELECT email, token FROM reset_password WHERE email = :email AND token = :token ' );//meliode dynamique
$sth->bindValue(':email' , $_GET['email'], PDO::PARAM_INT); 
$sth->bindValue(':token' , $_GET['token'], PDO::PARAM_INT); 

//Execution de la requete SQL
$sth->execute();

//récupération des données
$reset = $sth->fetch();


// verification
if(isset($reset) && !empty($reset)){
		// verification
	$errors = []; // Contiendra les erreurs
	$post = []; // Contiendra mes données nettoyées (sans espace, ni balise html / php)
	$minPassword = 8;
	$maxPassword = 16;
	


	if(!empty($_POST)){ 
	//nettoyage des données saisies
		// trim() retire les espaces en début et fin de chaine
		// strip_tags() retire les balises html & php. /!\ Important pour la sécurité
		foreach($_POST as $key => $value){
			// $post[$key] = $value permet de préserver l'association clé / valeur
			$post[$key] = trim(strip_tags($value));
		}


	// On effectue nos vérifications
	
		if(!v::stringType()->length($minPassword,$maxPassword)->validate($post['password'])){
				$errors[] = 'Le mot de passe doit contenir entre '.$minPassword.' et '.$maxPassword.' caractères';
			}
		
		if(count($errors) === 0){
			
			$formValid = true;

			/*Preparation de l'update*/

			
			$sth = $bdd->prepare('UPDATE users SET password = :new_password  WHERE email = :email ');
			
			$sth->bindValue(':new_password' , password_hash($post['password'], PASSWORD_DEFAULT), PDO::PARAM_STR); 
			$sth->bindValue(':email' , $reset['email'], PDO::PARAM_INT);
			
			/* Execution de la requete SQL */
			// on effectue l'insertion
			$success = $sth->execute();	
		}
		
		else {
			
			$formValid = false;
		}
		

	} // fin if(!empty($_POST))
} // fin if (isset($user) && !empty($user))


else{
	header('Location: ../index.php');
		die();
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Recuperation mot de passe utilisateur</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
		<link rel="stylesheet" href="../css/style.css">

		<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
</head>
<body>
	
	
	 
 				
	<main class="container">

		<h2 class="text-center">Recuperation/Modification du mot de passe</h2>

		<?php 
			// afficher le formulaire seulement si utilisateur trouvé
			if(isset($reset) && !empty($reset)):
		 ?>



			<p class="text-center text-danger"> Vous êtes sur le point de modifier votre mot de passe !</p>
			<div class="d-flex justify-content-center">
			
				<form  class="col-sm-10 col-md-6 d-flex justify-content-center "method="post" id="formUser">
									
					<div class="form-group col-6 text-center">
						<input type="password" class="form-control" name="password" id="password" placeholder=" Nouveau Mot de passe">
					</div>
					
					<!-- bouton valider -->
					<div class="d-flex justify-content-center col-4 ">
						<button type="submit" class="btn btn-success col-12" >Enregistrer</button>
					</div>
				</form>
			</div>
		<?php 
				else: echo '<p style="color:red;">Cet utilisateur n\'existe pas !</p>';
			?>
		<?php endif ?>

			<!-- affichage du message de confirmation ou des erreurs -->
				<?php if(isset($formValid) && $formValid == true && $success):?>

					<p style="color:green;">Mot de passe modifié avec succès !</p>
			
				<?php elseif(isset($formValid) && $formValid == true && !$success):?>
			
					<p style="color:red;">Erreur, mot de passe non modifié</p>
			
				<?php elseif(isset($formValid) && $formValid == false):?>
			
					<p style="color:red; text-align:center;">
						<?=implode('<br>', $errors);?>
					</p>
				<?php endif;?>
			
	</main>

	<script  src="http://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
 	crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>