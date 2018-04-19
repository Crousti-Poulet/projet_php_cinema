<?php 

	session_start();

	require '../includes/connect.php'; // On inclut le fichier "connect" servant à se connecter à la base de données.

	//Vérifie que l'utilisateur a bien cliqué sur le boutton "Supprimer"
	if(!empty($_POST['submit'])) {

		var_dump($_POST);

	    $delete = $bdd->prepare('DELETE FROM news WHERE id = :id');
	    $delete->bindValue(':id', $_POST['articleId'], PDO::PARAM_INT); 
		$delete->execute();

		header('Location: news_list.php');
		die();
	}

	//Vérifie si l'id est bien présent dans le $_GET
	if(!empty($_GET['id'])) {

		$sth = $bdd->prepare('SELECT * FROM news WHERE id = :id');
		
		$sth->bindValue(':id', $_GET['id'], PDO::PARAM_INT); 

		$sth->execute();

		$article = $sth->fetch(PDO::FETCH_ASSOC);
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
		<title>Confirmation de suppression</title>
	</head>
	<body>
			
		<!--Main start-->
		<main class="container">
				
			<h1>Voulez-vous vraiment supprimer l'article "<?php if(isset($article['title']) && !empty($article['title'])) {echo $article['title'];}else{echo '?';} ?>" ?</h1>
			
			<form method="POST">
				
				<!-- Champ caché permettant de transmettre l'id de l'article à supprimer -->
				<input type="hidden" name="articleId" value="<?php echo $article['id']; ?>" />

				<br>

				<input class="btn" type="submit" name="submit" value="Supprimer">

			</form>
			
			<br>
			<a href="news_list.php">Retour à la liste</a>

		</main>
		<!-- Main end -->
	</body>
</html>