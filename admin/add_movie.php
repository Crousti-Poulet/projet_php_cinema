<?php 

	session_start();

	//Afin de pouvoir utiliser Respect/Validation
	require '../vendor/autoload.php';

	//Afin de pouvoir utiliser l'élément v de Respect/Validation
	use Respect\Validation\Validator as v;

	require '../includes/connect.php'; // On inclut le fichier "connect" servant à se connecter à la base de données.

	$maxLength = 1500; // durée maximum autorisée en minutes

	$errors = [];
	$post = [];
	$date = date('Y-m-d');
	$hour = date('H');
	$minutes = date('i');
	$seconds = date('s');

	//Vérifier que l'image a bien été uploadé
	if(!empty($_FILES['picture'])){

		$finfo = new finfo();

		$mimeType = $finfo->file($_FILES['picture']['tmp_name'], FILEINFO_MIME_TYPE);

		$mimeTypeAllow = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];

		if(in_array($mimeType, $mimeTypeAllow)){

			$dirUpload = '../uploads/';
			$search = [' ', 'é', 'è', 'à', 'ù'];
			$replace = ['-', 'e', 'e', 'a', 'u'];
			$newFileName = str_replace($search, $replace, time().'-'.$_FILES['picture']['name']);
			$monImgUpload = $dirUpload.$newFileName;

			move_uploaded_file($_FILES['picture']['tmp_name'], $monImgUpload);
		}

		//Vérification du contenu du $_POST
		if(!empty($_POST)){

			var_dump($_POST['genre']);

			foreach($_POST as $key => $value){
				$post[$key] = trim(strip_tags($value));
			}
		
			
			if(!v::stringType()->length(1, 20)->validate($post['title'])) {
				$errors[] = 'Titre invalide (doit être compris entre 1 et 20 caractères)';

			}if(!v::stringType()->length(0, 255)->validate($post['actors'])) {
				$errors[] = 'Liste d\'acteurs invalide (doit comporter au maximum 255 caractères)';
			}

			if(!v::stringType()->length(1, 30)->validate($post['director'])) {
				$errors[] = 'Nom du réalisateur invalide (doit être compris entre 1 et 30 caractères)';
			}

			}if(!v::intVal()->max($maxLength)->validate($post['length']) ) {
				$errors[] = 'La durée doit être un entier inférieur à '.$maxLength;
			}

			if(!v::stringType()->length(50, 1000)->validate($post['storyline'])) {
				$errors[] = 'Synopsis invalide (doit être compris entre 50 et 1000 caractères)';
			}

			if(!v::stringType()->length(2, 20)->validate($post['country'])) {
				$errors[] = 'Pays invalide (doit être compris entre 2 et 20 caractères)';
			}

			if(count($errors) === 0){

				var_dump($post['genre']);

					$formValid = true;
					
					//Variable donnant la date et l'heure
					// $upload_date = $date.' '.$hour.':'.$minutes.':'.$seconds;

					$pathname = $dirUpload.$newFileName;
					//Stockage des informations après validation du formulaire.

					$sth = $bdd->prepare('INSERT INTO movies (title, date_release, actors, director, length, country, genre, storyline, poster_img_path) VALUES(:title, :date_release, :actors, :director, :length, :country, :genre, :storyline, :pathname)');

					$sth->bindValue(':title', $post['title']);
					$sth->bindValue(':date_release', $post['date_release']);
					$sth->bindValue(':actors', $post['actors']);
					$sth->bindValue(':director', $post['director']);
					$sth->bindValue(':length', $post['length']);
					$sth->bindValue(':country', $post['country']);
					$sth->bindValue(':genre', $post['genre']);
					$sth->bindValue(':storyline', $post['storyline']);
					$sth->bindValue(':pathname',$pathname);

					$sth->execute();
				}
				else {
					$formValid = false;
				}
			
	}
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
			
		<!--Main start-->
		<main class="container" id="main_bloc">
				
				<!-- Affichage des messages d'erreur -->
				<?php if(isset($formValid) && $formValid == true):?>
	
				<p style="color:green;">Votre réservation a été validée</p>
			
				<?php elseif(isset($formValid) && $formValid == false):?>
				
				<p style="color:red;"><?=implode('<br>', $errors);?></p>
				<?php endif;?>

			<!-- Form start -->
			<form class="mx-auto" method="POST" id="myForm" enctype="multipart/form-data">
				
				<br>
				<h1>Ajouter un film</h1>
				<br>
				
				<label for="title">Titre :</label>
				<input class="form-control" type="text" name="title" id="title" value="<?php if (isset($post['title'])){echo $post['title'];} ?>" ><br>

				<label for="date_release">Date de sortie :</label>
				<input class="form-control" type="date" name="date_release" id="date_release" value="<?php if (isset($_POST['date_release'])){echo $_POST['date_release'];} ?>"><br>
				
				<label for="actors">Acteurs :</label>
				<input class="form-control" type="text" name="actors" id="actors" value="<?php if (isset($_POST['actors'])){echo $_POST['actors'];} ?>" ><br>

				<label for="director">Réalisateur :</label>
				<input class="form-control" type="text" name="director" id="director" value="<?php if (isset($_POST['director'])){echo $_POST['director'];} ?>"><br>

				<label for="length">Durée (en minutes) :</label>
				<input class="form-control" type="text" name="length" id="length" value="<?php if (isset($_POST['length'])){echo $_POST['length'];} ?>"><br>
				
				<label for="country">Pays :</label>
				<input class="form-control" type="text" name="country" id="country" value="<?php if (isset($_POST['country'])){echo $_POST['country'];} ?>"><br>
				
				<label for="genre">Genre :</label>
				<select class="form-control" name="genre" id="genre value="<?php echo isset($_POST['genre']) ? $_POST['genre'] : '' ?>">

					<option value="select">-Sélectionner-</option>
					<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Comédie") echo 'selected'; ?> value="comedy">Comédie</option>
					<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Science fiction") echo 'selected'; ?> value="sci-fi">Science-fiction</option>
					<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Horreur") echo 'selected'; ?> value="horror">Horreur</option>
					<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Romance") echo 'selected'; ?> value="romance">Romance</option>
					<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Action") echo 'selected'; ?> value="action">Action</option>
					<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Thriller") echo 'selected'; ?> value="thriller">Thriller</option>
					<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Drame") echo 'selected'; ?> value="drama">Drame</option>
					<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Mistère") echo 'selected'; ?> value="mystery">Mistère</option>
					<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Policier") echo 'selected'; ?> value="Crime">Policier</option>
					<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Animation") echo 'selected'; ?> value="animation">Animation</option>
					<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Aventure") echo 'selected'; ?> value="adventure">Aventure</option>
					<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Fantastique") echo 'selected'; ?> value="Fantasy">Fantastique</option>
					<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Comédie romantique") echo 'selected'; ?> value="comedy_romance">Comédie romantique</option>
					<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Comédie d'action") echo 'selected'; ?> value="action_comedy">Comédie d'action</option>
					<option <?php if (isset($_POST['genre']) && $_POST['genre']=="Superhero") echo 'selected'; ?> value="superhero">Superhero</option>

				</select><br>

				<label for="storyline">Synopsis :</label>
				<textarea class="form-control" name="storyline" id="storyline" rows="6"><?php if (isset($post['storyline'])){echo $post['storyline'];} ?></textarea><br>

				<label for="picture">Image :</label>
				<input class="form-control" type="file" name="picture" id="picture"><br>

				<input class="btn" type="submit" name="submit" id="submit" value="Valider">

			</form><br><br>
			<!-- Form end -->

		</main>
		<!-- Main end -->
	</body>
</html>