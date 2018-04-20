<?php

	session_start();

	//Afin de pouvoir utiliser Respect/Validation
	require '../vendor/autoload.php';

	//Afin de pouvoir utiliser l'élément v de Respect/Validation
	use Respect\Validation\Validator as v;
	use Intervention\Image\ImageManagerStatic as Image;


	require '../includes/connect.php'; // pour se connecter à la BD

	if (!isset($_SESSION['user']) || empty($_SESSION['user'])){ // utilisateur non connecté

		header('Location: ../connexion.php');
		die();
	}
	else // utilisateur déjà connecté
	{

		if (isset($_GET['id']) && is_numeric($_GET['id'])){
			$idNews =  $_GET['id'];
			//récuperer les informations de l'actualité en question
			$res = $bdd->prepare('SELECT id, title, user_id, content, img_path, date_created, date_updated FROM news WHERE id = :idNews'); 
			$res->bindValue(':idNews', $idNews, PDO::PARAM_INT);
			$res->execute();
			$news = $res->fetch(); 

			// on autorise la mise à jour de l'actualité seulement si elle existe
			if (isset($news) && !empty($news)){

				// instanciation de la classe finfo
				$finfo = new finfo();

				$mimeTypeAllow = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
				$dirUpload = '../uploads/'; // répertoire de stockage des images des actualités
				$search = [' ', 'é', 'è', 'à', 'ù'];
				$replace = ['-', 'e', 'e', 'a', 'u'];

				$errors = [];
				$post = [];
				$imgUpdated = false; // savoir si l'utilisateur a choisi une nouvelle image
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

					// vérifications sur l'image seulement s'il y en a une nouvelle (non obligatoire pour la modification du film)
					if (!empty($_FILES['picture'])){

						// si image selectionnée
						if ($_FILES['picture']['error']!=4 ){

							if ($_FILES['picture']['error']!=0 && $_FILES['picture']['error']!=4 ){
								$errors[] = 'Erreur sur l\'envoi de l\'image !';
							}
							else{
								// pas d'erreur sur l'image
								//vérification du mime type du fichier uploadé
								$mimeType = $finfo->file($_FILES['picture']['tmp_name'], FILEINFO_MIME_TYPE);

								if (!in_array($mimeType, $mimeTypeAllow)) {
									$errors[] = 'Type de fichier non autorisé !';
								}
								else{
									$imgUpdated = true;
								}
							}
						}
					}

					if(count($errors) === 0){

						$formValid = true;


						if($imgUpdated) // image modifiée
						{
							//enregistrer l'image
							$newFileName = str_replace($search, $replace, time().'-'.$_FILES['picture']['name']);
							$img = Image::make($_FILES['picture']['tmp_name']);
							$img->resize(250, 350);
							// créer le répertoire s'il n'existe pas
							if(!is_dir($dirUpload)){
								mkdir($dirUpload,0755);
							}

							$pathname = $dirUpload.$newFileName;
							//save image
							$img->save($pathname);
							$formValid = true;
							// if(move_uploaded_file($_FILES['picture']['tmp_name'], $pathname)){
							// 	$formValid = true;
							// } // fin du if(move_uploaded_file($_FILES['picture']['tmp_name'], $pathname))
							// else{
							// 	$errors[] = 'Erreur lors de l\'enregistrement de l\'image !';
							// 	$formValid = false;
							// }
						}

						if($formValid){ // pas d'image ou image uploadée avec succès
							
							//ecriture de la requete en fonction des champs à enregistrer
							$strReq = 'UPDATE news set title = :title, content = :content, date_updated=now()';
							if ($imgUpdated){
								$strReq .= ', img_path = :pathname';
							}
							$strReq .= ' WHERE id=:id';

							$sth = $bdd->prepare($strReq);

							$sth->bindValue(':id', $idNews, PDO::PARAM_INT);
							$sth->bindValue(':title', $post['title']);
							$sth->bindValue(':content', $post['content']);
							if ($imgUpdated){
								$sth->bindValue(':pathname',substr($pathname,3));
							}

							$success = $sth->execute();

							// afficher les nouvelles valeurs dans les champs du formulaire
							if($success){
								$res = $bdd->prepare('SELECT id, title, user_id, content, img_path, date_created, date_updated FROM news WHERE id = :idNews'); 
								$res->bindValue(':idNews', $idNews, PDO::PARAM_INT);
								$res->execute();
								$news = $res->fetch(); 
							}
						}
						
						
					} // fin du if(count($errors) === 0)
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
			<title>Modifier une actualité</title>
	</head>
	<body>

		<?php include 'navbar.php' ?>

		<main class="container" id="main_bloc">

			<h2>Modification d'une actualité</h2>

			<?php 
				// afficher le formulaire seulement si actualité trouvée
				if (isset($news) && !empty($news)):
			 ?>

			<!-- affichage du message de confirmation ou des erreurs -->
			<?php if(isset($formValid) && $formValid == true && $success):?>

			<p style="color:green;">Actualité modifiée avec succès !</p>
		
			<?php elseif(isset($formValid) && $formValid == true && !$success):?>
		
			<p style="color:red;">Erreur, actualité non modifiée</p>
		
			<?php elseif(isset($formValid) && $formValid == false):?>
		
			<p style="color:red;">
				<?=implode('<br>', $errors);?>
			</p>
			<?php endif;?>


				<div>
					<form class="mx-auto" method="POST" id="formUpdateNews" enctype="multipart/form-data">
						
						<div class="form-group">
							<label for="title">Titre :</label>
							<input class="form-control" type="text" name="title" id="title" value="<?php if (isset($news['title'])){echo $news['title'];} ?>" >
						</div>
				
						<div class="form-group">
							<label for="content">Contenu :</label>
							<textarea class="form-control" name="content" id="content" rows="6"><?php if (isset($news['content'])){echo $news['content'];} ?></textarea>
						</div>
						
						<div class="form-group">
						<label for="picture">Image :</label>
							<?php echo '<td><img class="photoThumb" src="../'.$news['img_path'].'">'; ?>
						<input class="form-control" type="file" name="picture" id="picture">
					</div>
				
						<button type="submit" class="btn">Valider</button>
						<br>
						<a href="news_list.php"> Retour à la liste d'actualités</a>
				
					</form>
				</div>

			<?php 
				else: echo '<p style="color:red;">Cette actualité n\'existe pas !</p>';
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