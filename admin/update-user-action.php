<?php
include '../inc/header.php';
session_start();


// ouverture de session
// si pas de session - retour a l'index 
if (!$_SESSION['nom_user']) {
	header('location: ../index.php');
}

// si session ok, je vois le contenu
else {

	if (!isset($_POST['id_user'])) // condition sur le post
	{
		header('location: ../landing.php');
	} else {
		include('../inc/connection.php');
		include '../inc/functions.php';


		$id_user = $_POST['id_user'];
		$nom = $_POST['nom_user'];
		$prenom = $_POST['prenom_user'];
		$adresse = $_POST['adresse_user'];
		$mail = $_POST['mail_user'];
		$pass_user = $_POST['pass_user'];
		$auth_user = $_POST['auth_user'];
		$type_user = $_POST['type_user'];



		// écrire dans la base de données si confirm =1 puis retour à l'index

		$stmt = $pdo->prepare("UPDATE `users` SET `nom_user`= :nom,`prenom_user`= :prenom,
	`adresse_user`= :adresse,`mail_user`= :mail,`pass_user`= :pass,`auth_user`= :auth,`type_user`= :type WHERE `id_user`= :id_user ");

		$stmt->bindValue(':id_user', $id_user, PDO::PARAM_STR);
		$stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
		$stmt->bindValue(':prenom', $prenom, PDO::PARAM_STR);
		$stmt->bindValue(':adresse', $adresse, PDO::PARAM_STR);
		$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
		$stmt->bindValue(':pass', $pass_user, PDO::PARAM_STR);
		$stmt->bindValue(':auth', $auth_user, PDO::PARAM_STR);
		$stmt->bindValue(':type', $type_user, PDO::PARAM_STR);

		if ($stmt->execute()) {
			echo "<div class='alert alert-success text-center' role='alert'>";
			echo "<p>Modification de la base de données effectuée</p>";
			echo "</div>";
			//header("Location: update.php?info=ok&id_stag=$id_stag");
			header("Refresh:3;$url_standard/admin/update-user.php?id_user=$id_user");
		} else {
			echo "<div class='alert alert-danger text-center' role='alert'>";
			echo "<p>Modification de la base de données non effectuée</p>";
			echo "</div>";
			//header("Location: update.php?info=ko&id_stag=$id_stag");
			header("Refresh:3;$url_standard/admin/update-user.php?id_user=$id_user");
		}




		// fermeture de la connexion
		$pdo = null;
	} // fin si post isset
?>


<?php } //fin de session 
?>