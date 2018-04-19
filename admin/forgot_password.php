<?php  
session_start();
require '../vendor/autoload.php'; //Afin de pouvoir utiliser Respect/Validation
require '../includes/connect.php'; //Afin de pouvoir utiliser l'élément v de Respect/Validation
use Respect\Validation\Validator as v; // Connexion à la base de donnée 
use PHPMailer\PHPMailer\PHPMailer;

$errors = []; // Contiendra les erreurs
$post = []; // Contiendra mes données nettoyées (sans espace, ni balise html / php)
$token = bin2hex(random_bytes(64));//creation de token crypté
if(!empty($_POST)){ 

	//Nettoyage des données
	foreach($_POST as $key => $value){
		// $post[$key] = $value permet de préserver l'association clé / valeur
		$post[$key] = trim(strip_tags($value));
	}

	//verification
	if (!v::email()->validate($post['email'])){
		$errors[] = 'L\'adresse email est invalide';
	}
  
	if(count($errors) === 0){
		$formValid = true;

		$sth = $bdd->prepare('INSERT INTO reset_password (email, token) VALUES (:data_email, :data_token)');

		
		$sth->bindValue(':data_email',$post['email']);
		$sth->bindValue(':data_token',$token );
		$sth->execute();
	

	// envoi du mail

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

		
		$mail->setFrom('contact@monresto.fr');//addresse de l'expediteur
		$mail->addAddress('contact@monresto.fr');

		$mail->Subject = 'Mot de pass oublié ';//sujet du message
		$content_mail = '<a href="http://localhost/php/GitHub/projet_php_cinema/admin/reset_password.php?email=' . $post['email'] . '&token=' . $token.'"> Modifier mon mot de passe </a>';
		var_dump($content_mail);
		$mail->msgHTML($content_mail);//message en lui même, la fonction 'nl2br' permet d'enregistrer les retour à la ligne dans le message et de les convertir au format html afin de les conser

		if (!$mail->send()){
			echo "Mailer Error" . $mail->ErrorInfo;
		}
	}

	else{
		$formValid = false;
	}	
}
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
		
	<main>

		<h2>Mot de passe oublié : </h2>


		<!-- affichage du message de confirmation ou des erreurs -->
		<?php if(isset($formValid) && $formValid == true):?>

		<p style="color:green;">mail envoyé avec succès !</p>
	
		<?php elseif(isset($formValid) && $formValid == false):?>
	
		<p style="color:red;">
			<?=implode('<br>', $errors);?>
		</p>
		<?php endif;?>

		
		<div >
			<form method="post" id="formUser">
				
				<div class="form-group d-flex justify-content-center">
					<input type="email" class="form-control col-3" name="email" id="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
				</div>
				<div class="d-flex justify-content-center">
					<button type="submit" class="btn">Recevoir mon nouveau mot de passe</button>
				</div>
			</form>
		</div>
	</main>

	<script  src="http://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
 	crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

 	


</body>
</html>