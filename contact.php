<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'includes/connect.php';

$post = [];
$error = [];

if (!empty($_POST)) {
	foreach ($_POST as $key => $value) {
		$post[$key] = trim(strip_tags($value));
	}

	if (strlen($post['lastname']) < 3 || strlen($post['lastname']) > 15) {
		$error[] = 'votre nom doit contenir entre 3 et 15 caracères';
	}

	if (strlen($post['firstname']) < 3 || strlen($post['firstname']) > 15) {
		$error[] = 'votre prénom doit contenir entre 3 et 15 caracères';
	}

	if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
		$error[] = 'L\'adresse email est invalide';
	}

	if(strlen($post['subject']) < 5 || strlen($post['subject']) > 50){
		$error[] = 'votre sujet doit comprendre entre 5 et 50 caractères';
	}

	if(strlen($post['message']) < 50 || strlen($post['message']) > 500){
		$error[] = 'votre message doit comprendre entre 50 et 500 caractères';
	}

	var_dump($error);

	if (count($error) === 0) {
		$formValid = true;

		//placer ici l'envoie du mail

		//crée une nouvelle instance de php mailer
		$mail = new PHPMailer;


		// dire à php mailer d'utiliser SMTP (qui est un protocole d'envoie de mail)
		$mail->isSMTP();
		//indique l'hote du serveur mail
		$mail->Host = 'smtp.mailtrap.io';

		//indique le port de l'hote
		$mail->Port = 465;
		//$mail->SMTPSecure = 'tls' ; //ajoute un encryptage pour la sécurité
		$mail->SMTPAuth = true; //permet d'utiliser l'autentification SMTP
		$mail->Username = '6887e3373ffc68'; //nom de l'utilisaateur de la boite recevante
		$mail->Password = '6e8ac501074bdf';//mdp de la boite recevante


		$mail->setFrom($post['email']);//addresse de l'expediteur
		$mail->addAddress('contact@monresto.fr');
		$mail->Subject = $post['subject'];//sujet du message
		$mail->msgHTML(nl2br($post['message']));//message en lui même, la fonction 'nl2br' permet d'enregistrer les retour à la ligne dans le message et de les convertir au format html afin de les conserver

		if (!$mail->send()){
			echo "Mailer Error" . $mail->ErrorInfo;
		}
	}


	else{ $formValid = false;}

}

$res = $bdd->prepare('SELECT id, day, times FROM opening_times'); 
$res->execute();
$days = $res->fetchAll();



 ?>


 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Informations</title>
 	<link href="https://fonts.googleapis.com/css?family=Cinzel:700" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 	<link rel="stylesheet" type="text/css" href="css/header.css">
 	<link rel="stylesheet" type="text/css" href="css/style.css">
 </head>
 <body>


	<main class="mainFront">

		<?php include 'header.php' ?>

	 	<?php if(isset($formValid) && $formValid == true):?>
			<p style="color:green">message envoyé !</p>

	 	<?php elseif(isset($formValid) && $formValid == false):?>
			<p style="color:red"><?=implode('<br>', $error);?></p>
		<?php endif; ?>


	 	<form method="post" class="contact container">
	 		<label>Contactez-nous</label>
	 		<fieldset class="contact offset-2 col-8 ">
	 			<div class="form-group">
		 			<label>Nom</label>
		 			<input type="text" name="lastname" class="form-control">
				</div>
				
				<div class="form-group">
	 				<label>Prénom</label>
	 				<input type="text" name="firstname" class="form-control">
				</div>

				<div class="form-group">
		 			<label>Adresse Mail</label>
		 			<input type="email" name="email" class="form-control">
				</div>
				
				<div class="form-group">
		 			<label>Sujet</label>
		 			<input type="text" name="subject" class="form-control">
		 		</div>

				<div class="form-group">
		 			<label>Message</label>
		 			<textarea type="text" name="message" class="form-control"></textarea>
	 			</div>

	 			<button type="submit" class="form-control button">Envoyer</button>

	 		</fieldset>
	 	</form>
		
		<h3 class="horraire">Jours et heures d'ouverture</h3>

		<ul class="horraires list-unstyled">

			<?php foreach ($days as $day) {
				echo '<li>'.$day['day'].' : '.$day['times'].'</li>';
			} ?>

		</ul>

	</main>


 	<?php include 'footer.php' ?>
 	

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script  src="http://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
 	crossorigin="anonymous"></script>
 	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 </body>
 </html>