<?php 

	session_start();

	//Afin de pouvoir utiliser Respect/Validation
	require '../vendor/autoload.php';

	//Afin de pouvoir utiliser l'élément v de Respect/Validation
	use Respect\Validation\Validator as v;
	use Intervention\Image\ImageManagerStatic as Image;


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
		// instanciation de la classe finfo
		$finfo = new finfo();

		$maxLength = 1500; // durée maximum autorisée en minutes
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

			}if(!v::stringType()->length(0, 255)->validate($post['actors'])) {
				$errors[] = 'La liste d\'acteurs doit comporter au maximum 255 caractères)';
			}

			if(!v::stringType()->length(1, 30)->validate($post['director'])) {
				$errors[] = 'Le nom du réalisateur doit comporter entre 1 et 30 caractères)';
			}

			if(!v::intVal()->max($maxLength)->validate($post['length']) ) {
				$errors[] = 'La durée doit être un entier inférieur à '.$maxLength;
			}

			if(!v::stringType()->length(50, 1000)->validate($post['storyline'])) {
				$errors[] = 'Le synopsis doit comporter entre 50 et 1000 caractères)';
			}

			if(!v::stringType()->length(2, 20)->validate($post['country'])) {
				$errors[] = 'Le pays doit comporter entre 2 et 20 caractères)';
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

				

				

			

				// enregistrer l'image :
				// modification du nom de l'image
				 $newFileName = str_replace($search, $replace, time().'-'.$_FILES['picture']['name']);
				// read image from temporary file
				$img = Image::make($_FILES['picture']['tmp_name']);
				// resize image instance
				$img->resize(350, 250);
				// créer le répertoire s'il n'existe pas
				if(!is_dir($dirUpload)){
					mkdir($dirUpload,0755);
				}

				$pathname = $dirUpload.$newFileName;

				// save image
				$img->save($pathname);

				// if(move_uploaded_file($_FILES['picture']['tmp_name'], $pathname)){
					
					$formValid = true;

					// image uploadée avec succès, on enregistre la fiche dans la base

					$sth = $bdd->prepare('INSERT INTO movies (title, date_release, actors, director, length, country, genre, storyline, poster_img_path) VALUES(:title, :date_release, :actors, :director, :length, :country, :genre, :storyline, :pathname)');

					$sth->bindValue(':title', $post['title']);
					$sth->bindValue(':date_release', $post['date_release']);
					$sth->bindValue(':actors', $post['actors']);
					$sth->bindValue(':director', $post['director']);
					$sth->bindValue(':length', $post['length']);
					$sth->bindValue(':country', $post['country']);
					$sth->bindValue(':genre', $post['genre']);
					$sth->bindValue(':storyline', $post['storyline']);
					$sth->bindValue(':pathname',substr($pathname,3));

					$sth->execute();
				// } // fin du if(move_uploaded_file($_FILES['picture']['tmp_name'], $pathname))
				// else{
				// 	$errors[] = 'Erreur lors de l\'enregistrement de l\'image !';
				// }
				
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
		<title>Ajouter un film</title>
	</head>
	<body>

	<?php include 'navbar.php' ?>
			
		<main class="container" id="main_bloc">
			
			<h2>Ajouter un film</h2>
				
			<!-- Affichage des messages d'erreur ou de confirmation -->
			<?php if(isset($formValid) && $formValid == true):?>

			<p style="color:green;">La fiche du film a bien été enregistrée</p>
		
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
						<label for="date_release">Date de sortie :</label>
						<input class="form-control" type="date" name="date_release" id="date_release" value="<?php if (isset($_POST['date_release'])){echo $_POST['date_release'];} ?>">
					</div>

					<div class="form-group">
						<label for="actors">Acteurs :</label>
						<input class="form-control" type="text" name="actors" id="actors" value="<?php if (isset($_POST['actors'])){echo $_POST['actors'];} ?>" >
					</div>

					<div class="form-group">
						<label for="director">Réalisateur :</label>
						<input class="form-control" type="text" name="director" id="director" value="<?php if (isset($_POST['director'])){echo $_POST['director'];} ?>">
					</div>

					<div class="form-group">
						<label for="length">Durée (en minutes) :</label>
						<input class="form-control" type="text" name="length" id="length" value="<?php if (isset($_POST['length'])){echo $_POST['length'];} ?>">
					</div>

					<div class="form-group">
						<label for="country">Pays :</label>
						<input class="form-control" type="text" name="country" id="country" value="<?php if (isset($_POST['country'])){echo $_POST['country'];} ?>">
					</div>

					<div class="form-group">	
						<label for="genre">Genre :</label>
						<select class="form-control" name="genre" id="genre" value="<?php echo isset($_POST['genre']) ? $_POST['genre'] : '' ?>">
							<!-- <option value="select">-Sélectionner-</option> -->
							<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Comédie") echo 'selected'; ?> value="Comédie">Comédie</option>
							<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Science-fiction") echo 'selected'; ?> value="Science-fiction">Science-fiction</option>
							<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Horreur") echo 'selected'; ?> value="Horreur">Horreur</option>
							<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Romance") echo 'selected'; ?> value="Romance">Romance</option>
							<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Action") echo 'selected'; ?> value="Action">Action</option>
							<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Thriller") echo 'selected'; ?> value="Thriller">Thriller</option>
							<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Drame") echo 'selected'; ?> value="Drame">Drame</option>
							<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Mystère") echo 'selected'; ?> value="Mystère">Mystère</option>
							<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Policier") echo 'selected'; ?> value="Policier">Policier</option>
							<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Animation") echo 'selected'; ?> value="Animation">Animation</option>
							<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Aventure") echo 'selected'; ?> value="Aventure">Aventure</option>
							<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Fantastique") echo 'selected'; ?> value="Fantastique">Fantastique</option>
							<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Comédie romantique") echo 'selected'; ?> value="Comédie romantique">Comédie romantique</option>
							<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Comédie d'action") echo 'selected'; ?> value="Comédie d'action">Comédie d'action</option>
							<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Superhero") echo 'selected'; ?> value="Superhero">Superhero</option>
						</select>
					</div>

					<div class="form-group">
						<label for="storyline">Synopsis :</label>
						<textarea class="form-control" name="storyline" id="storyline" rows="6"><?php if (isset($post['storyline'])){echo $post['storyline'];} ?></textarea>
					</div>
					
					<div class="form-group">
						<label for="picture">Affiche du film :</label>
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