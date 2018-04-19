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
		//securité supplémentaire
		if(isset($_SESSION['user']['id']) && is_numeric($_SESSION['user']['id'])){

			$idUser =  $_SESSION['user']['id'];
			// recupere un utilisateur par rapport a son id
			// $sth = $bdd->prepare('SELECT * FROM  user WHERE id=5'); // meliode statique
			$sth = $bdd->prepare('SELECT id, firstname, lastname, email, password, role, date_created, date_updated FROM users WHERE id = :idUser');//meliode dynamique
			$sth->bindValue(':idUser' , $idUser, PDO::PARAM_INT); //Recupere la valeur de ?id=X dans l'url et sécurise en INT 

			//Execution de la requete SQL
			$sth->execute();

			//récupération des données
			$user = $sth->fetch();

			// on autorise la mise à jour d'un utilisateur seulement s'il existe
			if (isset($user) && !empty($user)){


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

						//mon formulaire est valide ( pas d'erreur ) , je stock les informations saisies en base de donnée
						// on ne specifie pas l'ID car il est en AUTO INCREMENT et donc prendra sa valeur n umérique automatiquement
						$sth = $bdd->prepare('UPDATE users SET password = :new_password  WHERE id = :idUser ');
						
						$sth->bindValue(':new_password' , password_hash($post['password'], PASSWORD_DEFAULT), PDO::PARAM_STR); 
						$sth->bindValue(':idUser' , $idUser, PDO::PARAM_INT);
						
						/* Execution de la requete SQL */
						// on effectue l'insertion
						$success = $sth->execute();	
					}
					
					else {
						
						$formValid = false;
					}
					echo '<pre>';
					 var_dump($post['password']);
					 echo '</pre>';

				} // fin if(!empty($_POST))
			} // fin if (isset($user) && !empty($user))
		} // fin du if (!isset($_SESSION['user']) || empty($_SESSION['user']))
	} // fin du else du if (!isset($_SESSION['user']) || empty($_SESSION['user']))
?>





<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Modification mot de passe utilisateur</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
		<link rel="stylesheet" href="../css/style.css">

		<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
</head>
<body>
	
	<?php include 'navbar.php' ?>
	 
 				
	<main class="container">

		<h2 class="text-center">Modification du mot de passe</h2>

		<?php 
			// afficher le formulaire seulement si utilisateur trouvé
			if (isset($user) && !empty($user)):
		 ?>

			<!-- affichage du message de confirmation ou des erreurs -->
			<?php if(isset($formValid) && $formValid == true && $success):?>

				<p style="color:green;">Mot de passe modifié avec succès !</p>
		
			<?php elseif(isset($formValid) && $formValid == true && !$success):?>
		
				<p style="color:red;">Erreur, mot de passe non modifié</p>
		
			<?php elseif(isset($formValid) && $formValid == false):?>
		
				<p style="color:red;">
					<?=implode('<br>', $errors);?>
				</p>
			<?php endif;?>
		


			<p class="text-center text-danger"> Vous êtes sur le point de modifier votre mot de passe !</p>
			<div class="d-flex justify-content-center">
			
				<form  class="col-sm-8 col-md-6 d-flex justify-content-center "method="post" id="formUser">
									
					<div class="form-group col-4 text-center">
						<input type="password" class="form-control" name="password" id="password" placeholder=" Nouveau Mot de passe" value="<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>">
					</div>
					
					<!-- bouton valider -->
					<div class="d-flex justify-content-center col-2 ">
						<button type="submit" class="btn btn-success col-12" >Enregistrer</button>
					</div>
				</form>
			</div>
		<?php 
				else: echo '<p style="color:red;">Cet utilisateur n\'existe pas !</p>';
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