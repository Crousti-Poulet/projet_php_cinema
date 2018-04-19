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
	else // utilisateur déjà connecté
	{
		// instanciation de la classe finfo
		$finfo = new finfo();

		$mimeTypeAllow = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
		$dirUpload = '../uploads/'; // répertoire de stockage des affiches de films
		$search = [' ', 'é', 'è', 'à', 'ù'];
		$replace = ['-', 'e', 'e', 'a', 'u'];

		$errors = [];
		$post = [];
		$date = date('Y-m-d');
		$hour = date('H');
		$minutes = date('i');
		$seconds = date('s');

		

		// Si le formulaire a été soumis, la superglobale $_POST n'est pas vide
		if(!empty($_POST)){ 

			foreach($_POST as $key => $value){
				$post[$key] = trim(strip_tags($value));
			}
			
			if(!v::stringType()->length(1, 255)->validate($post['title'])) {
				$errors[] = 'Le titre doit comporter entre 1 et 255 caractères)';
			}

			if(!v::stringType()->length(50, null)->validate($post['content'])) {
				$errors[] = 'Le contenu de l\'actualité doit comporter au moins 50 caractères)';
			}

			//Vérifier que l'image a bien été uploadée
			if (empty($_FILES['picture'])){
				$errors[] = 'Erreur inexpliquée sur l\'image!';
			}
			if ($_FILES['picture']['error']==4 ){
				$errors[] = 'Vous n\'avez pas selectionné d\'image !';
			}
			elseif (empty($_FILES['picture']) || $_FILES['picture']['error']!=0 ){
				$errors[] = 'Erreur sur l\'envoi de l\'image !';
			}
			
			else{

				//vérification du mime type du fichier uploadé
				$mimeType = $finfo->file($_FILES['picture']['tmp_name'], FILEINFO_MIME_TYPE);

				if (!in_array($mimeType, $mimeTypeAllow)) {
					$errors[] = 'Type de fichier non autorisé !';
				}
			}
				
			if(count($errors) === 0){

				$formValid = true;

				//enregistrer l'image
				$newFileName = str_replace($search, $replace, time().'-'.$_FILES['picture']['name']);

				// créer le répertoire s'il n'existe pas
				if(!is_dir($dirUpload)){
					mkdir($dirUpload,0755);
				}

				$pathname = $dirUpload.$newFileName;

				if(move_uploaded_file($_FILES['picture']['tmp_name'], $pathname)){
					
					$formValid = true;

					// image uploadée avec succès, on enregistre la fiche dans la base

					var_dump($_SESSION);

					$sth = $bdd->prepare('INSERT INTO news (title, user_id, content, img_path, date_created) VALUES(:title, :user_id, :content, :img_path, :date_created)');

					$sth->bindValue(':title', $post['title']);
					$sth->bindValue(':user_id', $_SESSION['user']['id']);
					$sth->bindValue(':content', $post['content']);
					$sth->bindValue(':img_path',substr($pathname,3));
					$sth->bindValue(':date_created',date('c'));

					$sth->execute();

					header('Location: news_list.php');
					die();
				} // fin du if(move_uploaded_file($_FILES['picture']['tmp_name'], $pathname))
				else{
					$errors[] = 'Erreur lors de l\'enregistrement de l\'image !';
				}
				
			} // fin du if(count($errors) === 0)
			else {
				$formValid = false;
			}
			
		} // fin du if(!empty($_POST))

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
		<title>Ajouter une actualité</title>
	</head>
	<body>
  
	<?php include 'navbar.php' ?>
			
		<main class="container" id="main_bloc">
			
			<h2>Ajouter un actualité</h2>
				
			<!-- Affichage des messages d'erreur ou de confirmation -->
			<?php if(isset($formValid) && $formValid == true):?>

			<p style="color:green;">La fiche de l'actualité a bien été enregistrée</p>
		
			<?php elseif(isset($formValid) && $formValid == false):?>
			
			<p style="color:red;"><?=implode('<br>', $errors);?></p>
			<?php endif;?>

			<div>
				<form class="mx-auto" method="POST" id="formNewMovie" enctype="multipart/form-data">
							
					<div class="form-group">
						<label for="title">Titre :</label>
						<input class="form-control" type="text" name="title" id="title" value="<?php if (isset($post['title'])){echo $post['title'];} ?>" >
					</div>

					<div class="form-group">
						<label for="content">Contenu :</label>
						<textarea class="form-control" name="content" id="content" rows="6"><?php if (isset($post['content'])){echo $post['content'];} ?></textarea>
					</div>
					
					<div class="form-group">
						<label for="picture">Image :</label>
						<input class="form-control" type="file" name="picture" id="picture">
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