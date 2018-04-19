<?php 

	session_start();

	require '../includes/connect.php'; // On inclut le fichier "connect" servant à se connecter à la base de données.

	if (!isset($_SESSION['user']) || empty($_SESSION['user'])){ // utilisateur non connecté

		header('Location: connexion.php');
		die();
	}
	else // utilisateur déjà connecté
	{
		//Vérifie que l'utilisateur a bien cliqué sur le boutton "Supprimer"
		if(!empty($_POST['submit'])) {

			var_dump($_POST);

		    $delete = $bdd->prepare('DELETE FROM opening_times WHERE day = :day');
		    $delete->bindValue(':day', $_POST['delete_day']); 
			$delete->execute();

			header('Location: opening_times_list.php');
			die();
		}

		//Vérifie si le jour est bien présent dans le $_GET
		if(!empty($_GET['day'])) {

			$sth = $bdd->prepare('SELECT * FROM opening_times WHERE day = :day');
			
			$sth->bindValue(':day', $_GET['day']); 

			$sth->execute();

			$days = $sth->fetch(PDO::FETCH_ASSOC);
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
		<title>Confirmation de suppression</title>
	</head>
	<body>
			
		<!--Main start-->
		<main class="container">
				
			<h1>Voulez-vous vraiment supprimer les données correspondant au jour "<?php if(isset($days['day']) && !empty($days['day'])) {echo $days['day'];}else{echo '?';} ?>" ?</h1>
			
			<form method="POST">
				
				<!-- Champ caché permettant de transmettre le jour à supprimer -->
				<input type="hidden" name="delete_day" value="<?php echo $days['day']; ?>" />

				<br>

				<input class="btn" type="submit" name="submit" value="Supprimer">

			</form>
			
			<br>
			<a href="opening_times_list.php">Retour à la liste</a>

		</main>
		<!-- Main end -->
	</body>
</html>