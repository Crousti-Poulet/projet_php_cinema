<?php

	session_start();

	//Afin de pouvoir utiliser Respect/Validation
	require '../vendor/autoload.php';

	//Afin de pouvoir utiliser l'élément v de Respect/Validation
	use Respect\Validation\Validator as v;

	require '../includes/connect.php'; // pour se connecter à la BD

	if (!isset($_SESSION['user']) || empty($_SESSION['user'])){ // utilisateur non connecté

		header('Location: ../connexion.php');
		die();
	}
	else // utilisateur déjà connecté
	{

		if (isset($_GET['id']) && is_numeric($_GET['id'])){
			$idMovie =  $_GET['id'];
			//récuperer les informations du film en question
			$res = $bdd->prepare('SELECT id, title, length, date_release, genre, country, director, actors, storyline, poster_img_path, date_created, date_updated FROM movies WHERE id = :idMovie'); 
			$res->bindValue(':idMovie', $idMovie, PDO::PARAM_INT);
			$res->execute();
			$movie = $res->fetch(); 

			// on autorise la mise à jour d'un film seulement s'il existe
			if (isset($movie) && !empty($movie)){

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

					//écraser l'image seulement s'il y en a une nouvelle'
					if(){
							XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX TO DO
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

							$sth = $bdd->prepare('UPDATE movies set title = :title, date_release = :date_release, actors = :actors, director = :director, length = :length, country = :country, genre = :genre, storyline = :storyline, poster_img_path = :pathname, date_updated=now()');

							$sth->bindValue(':title', $post['title']);
							$sth->bindValue(':date_release', $post['date_release']);
							$sth->bindValue(':actors', $post['actors']);
							$sth->bindValue(':director', $post['director']);
							$sth->bindValue(':length', $post['length']);
							$sth->bindValue(':country', $post['country']);
							$sth->bindValue(':genre', $post['genre']);
							$sth->bindValue(':storyline', $post['storyline']);
							$sth->bindValue(':pathname',substr($pathname,3));

							$success = $sth->execute();

						} // fin du if(move_uploaded_file($_FILES['picture']['tmp_name'], $pathname))
						else{
							$errors[] = 'Erreur lors de l\'enregistrement de l\'image !';
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
		<title>Modifier une fiche de film</title>
	</head>
	<body>

	<header>
		<nav class="container-fluid">
			<div id="logo" class="menu-left">
			</div>
			<ul id="menu" class="menu-right">
				<li class="menu-item"><a href="movie_list.php">Films</a></li>
				<li class="menu-item"><a href="news_list.php">Actualités</a></li>
				<li class="menu-item"><a href="users_list.php">Utilisateurs</a></li>
				<li class="menu-item"><a href="add_user.php">Créer utilisateur</a></li>
				<li class="menu-item"><a href="deconnexion.php">Deconnexion</a></li>
			</ul>
		</nav>
	</header>

	<main class="container">

		<h2>Modification d'une fiche de film</h2>


		<?php 
			// afficher le formulaire seulement si film trouvé
			if (isset($movie) && !empty($movie)):
		 ?>

			<!-- affichage du message de confirmation ou des erreurs -->
			<?php if(isset($formValid) && $formValid == true && $success):?>

			<p style="color:green;">Fiche de film modifiée avec succès !</p>
		
			<?php elseif(isset($formValid) && $formValid == true && !$success):?>
		
			<p style="color:red;">Erreur, fiche non modifiée</p>
		
			<?php elseif(isset($formValid) && $formValid == false):?>
		
			<p style="color:red;">
				<?=implode('<br>', $errors);?>
			</p>
			<?php endif;?>


			<div>
				<form class="mx-auto" method="POST" id="formUpdateMovie" enctype="multipart/form-data">
							
					<div class="form-group">
						<label for="title">Titre :</label>
						<input class="form-control" type="text" name="title" id="title" value="<?php echo isset($movie['title']) ? $movie['title'] : '' ?>" >
					</div>

					<div class="form-group">
						<label for="date_release">Date de sortie :</label>
						<input class="form-control" type="date" name="date_release" id="date_release" value="<?php echo isset($movie['date_release']) ? $movie['date_release'] : '' ?>" >
					</div>

					<div class="form-group">
						<label for="actors">Acteurs :</label>
						<input class="form-control" type="text" name="actors" id="actors" value="<?php echo isset($movie['actors']) ? $movie['actors'] : '' ?>" >
					</div>

					<div class="form-group">
						<label for="director">Réalisateur :</label>
						<input class="form-control" type="text" name="director" id="director" value="<?php echo isset($movie['director']) ? $movie['director'] : '' ?>" >
					</div>

					<div class="form-group">
						<label for="length">Durée (en minutes) :</label>
						<input class="form-control" type="text" name="length" id="length" value="<?php echo isset($movie['length']) ? $movie['length'] : '' ?>" >
					</div>

					<div class="form-group">
						<label for="country">Pays :</label>
						<input class="form-control" type="text" name="country" id="country" value="<?php echo isset($movie['country']) ? $movie['country'] : '' ?>" >
					</div>

					<div class="form-group">	
						<label for="genre">Genre :</label>
						<select class="form-control" name="genre" id="genre">
							<!-- <option value="select">-Sélectionner-</option> -->
							<option <?php if (isset($movie['genre']) && $movie['genre']=="Comédie") echo 'selected'; ?> value="Comédie">Comédie</option>
							<option <?php if (isset($movie['genre']) && $movie['genre']=="Science-fiction") echo 'selected'; ?> value="Science-fiction">Science-fiction</option>
							<option <?php if (isset($movie['genre']) && $movie['genre']=="Horreur") echo 'selected'; ?> value="Horreur">Horreur</option>
							<option <?php if (isset($movie['genre']) && $movie['genre']=="Romance") echo 'selected'; ?> value="Romance">Romance</option>
							<option <?php if (isset($movie['genre']) && $movie['genre']=="Action") echo 'selected'; ?> value="Action">Action</option>
							<option <?php if (isset($movie['genre']) && $movie['genre']=="Thriller") echo 'selected'; ?> value="Thriller">Thriller</option>
							<option <?php if (isset($movie['genre']) && $movie['genre']=="Drame") echo 'selected'; ?> value="Drame">Drame</option>
							<option <?php if (isset($movie['genre']) && $movie['genre']=="Mystère") echo 'selected'; ?> value="Mystère">Mystère</option>
							<option <?php if (isset($movie['genre']) && $movie['genre']=="Policier") echo 'selected'; ?> value="Policier">Policier</option>
							<option <?php if (isset($movie['genre']) && $movie['genre']=="Animation") echo 'selected'; ?> value="Animation">Animation</option>
							<option <?php if (isset($movie['genre']) && $movie['genre']=="Aventure") echo 'selected'; ?> value="Aventure">Aventure</option>
							<option <?php if (isset($movie['genre']) && $movie['genre']=="Fantastique") echo 'selected'; ?> value="Fantastique">Fantastique</option>
							<option <?php if (isset($movie['genre']) && $movie['genre']=="Comédie romantique") echo 'selected'; ?> value="Comédie romantique">Comédie romantique</option>
							<option <?php if (isset($movie['genre']) && $movie['genre']=="Comédie d'action") echo 'selected'; ?> value="Comédie d'action">Comédie d'action</option>
							<option <?php if (isset($movie['genre']) && $movie['genre']=="Superhero") echo 'selected'; ?> value="Superhero">Superhero</option>
						</select>
					</div>

					<div class="form-group">
						<label for="storyline">Synopsis :</label>
						<textarea class="form-control" name="storyline" id="storyline" rows="6"><?php echo isset($movie['storyline']) ? $movie['storyline'] : '' ?></textarea>
					</div>
					
					<div class="form-group">
						<label for="picture">Affiche du film :</label>
						<?php echo '<td><img class="photoThumb" src="../'.$movie['poster_img_path'].'">'; ?>
						<input class="form-control" type="file" name="picture" id="picture">
					</div>

					<button type="submit" class="btn">Enregistrer</button>

				</form>
			</div>

			<?php 
				else: echo '<p style="color:red;">Ce film n\'existe pas !</p>';
			?>
			<?php endif ?>
	</main>

</body>
</html>