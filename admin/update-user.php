<?php
session_start();

// ouverture de session
// si pas de session - retour a l'index 
if (!$_SESSION['nom_user']) {
	header('location:../index.php');
}

// si session ok, je vois le contenu
else {
	//je rajoute une condition
	// si je suis admin, je vois le contenu destiné à l'admin


	if ($_SESSION['auth'] != 1) {
		// l'utilisateur peut modifier ses données y compris son propre mot de passe

		include '../inc/connection.php';
		include '../inc/header.php';
		include '../inc/navbar.php';
		$id_user = $_SESSION['id_user'];

		// echo "<h3>Module Emprunteur</h3>";
	} else {
		// l'administrateur peut modifier les données de tout le monde à l'exception du mot de passe
		include '../inc/connection.php';
		include '../inc/header.php';
		include '../inc/navbar.php';
		$id_user = $_GET['id_user'];

		// echo "<h3>Module d'administration</h3>";
	}
	$query = $pdo->query("SELECT * FROM `users` WHERE id_user=$id_user");
	$resultat = $query->fetchAll();
?>

	<?php
	//Afficher les résultats dans un tableau
	foreach ($resultat as $key => $variable) {
		echo "<tr>";
		$id_user = $resultat[$key]['id_user'];
		$nom = $resultat[$key]['nom_user'];
		$prenom = $resultat[$key]['prenom_user'];
		$adresse = $resultat[$key]['adresse_user'];
		$mail = $resultat[$key]['mail_user'];
		$pass = $resultat[$key]['pass_user'];
		$auth = $resultat[$key]['auth_user'];
		$type = $resultat[$key]['type_user'];
	}

	?>
	<div class="container mt-5 min-vh-100">
		<form class="mb-5 w-50 p-5 m-auto" action="update-user-action.php" method="post">
			<h4>Modification des données utilisateur</h4>
			<div class="mb-3">
				<input type="hidden" name="id_user" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $id_user ?>">

				<label for="exampleInputEmail1" class="form-label">Nom</label>
				<input type="text" name="nom_user" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $nom ?>">
			</div>
			<div class="mb-3">
				<label for="exampleInputEmail1" class="form-label">prénom</label>
				<input type="text" name="prenom_user" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $prenom ?>">
			</div>
			<div class="mb-3">
				<label for="exampleInputEmail1" class="form-label">adresse</label>
				<input type="text" name="adresse_user" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $adresse ?>">
			</div>
			<div class="mb-3">
				<label for="exampleInputEmail1" class="form-label">mail</label>
				<input type="email" name="mail_user" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $mail ?>">
			</div>
			<?php
			if ($_SESSION['id_user'] == $id_user) // changement de mot de passe uniquement pour l'utilisateur 
			{
			?>
				<div class="mb-3">
					<label for="exampleInputPassword1" class="form-label">mot de passe</label>
					<input type="password" name="pass_user" class="form-control" id="exampleInputPassword1" value="<?php echo $pass ?>">
				</div>
			<?php
			} else {
				// ATTENTION BUG AVEC LE MOT DE PASSE QUI APPARAIT EN CLAIR 
				echo "<input type='hidden' name='pass_user' class='form-control' id='exampleInputPassword1' value='$pass'>";
			}

			?>
			<div class="mb-3">
				<p>Profil</p>
				<?php // permet de choisir le profil prof ou eleve , préselection fonctionne
				if ($type == 1) {
					$checked_0 = "";
					$checked_1 = "checked";
				}
				if ($type == 0) {
					$checked_0 = "checked";
					$checked_1 = "";
				}

				?>

				<input class="form-check-input" type="radio" name="type_user" id="flexRadioDefault2" value="1" <?php echo $checked_1; ?>>
				<label class="form-check-label" for="flexRadioDefault2">Professeur</label>&nbsp; &nbsp; &nbsp;
				<input class="form-check-input" type="radio" name="type_user" id="flexRadioDefault2" value="0" <?php echo $checked_0; ?>>
				<label class="form-check-label" for="flexRadioDefault2">Elève</label>
			</div>

			<?php
			// module pour administrateur - attribue le niveau d'autorisation 
			if ($_SESSION['auth'] == 1) {
			?>
				<div class="mb-3">
					<p>Niveau d'autorisation</p>
					<?php
					if ($auth == 1) {
						$checked_0 = "";
						$checked_1 = "checked";
					}
					if ($type == 0) {
						$checked_0 = "checked";
						$checked_1 = "";
					}

					?>

					<input class="form-check-input" type="radio" name="auth_user" id="flexRadioDefault2" value="1" <?php echo $checked_1; ?>>
					<label class="form-check-label" for="flexRadioDefault2">Administrateur</label>&nbsp; &nbsp; &nbsp;
					<input class="form-check-input" type="radio" name="auth_user" id="flexRadioDefault2" value="0" <?php echo $checked_0; ?>>
					<label class="form-check-label" for="flexRadioDefault2">Utilisateur</label>
				</div>
			<?php
			} else // si page emprunteur , passe directement le niveau d'autorisation à la page action
			{
			?>
				<input type="hidden" name="auth_user" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $auth ?>">
			<?php } ?>
			<button type="submit" class="btn btn-dark">Update</button>
		</form>
	</div>

<?php include '../inc/footer.php';
} //Fermeture session 

?>