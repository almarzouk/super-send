<?php
session_start();

// ouverture de session
// si pas de session - retour a l'index 
if (!$_SESSION['nom_user']) {
	header('../index.php');
}

// si session ok, je vois le contenu
else {
	include "../inc/functions.php";
	include "../inc/connection.php";

	// temps de rafraîchissement après action bdd
	$refresh = 3;
	// ajouter les sessions pour récupérer l'id de l'emprunteur
	$id_emprunteur = $_SESSION['id_user'];

	// récupérer les données du matériels à louer

	$id_objet = $_POST["id_objet"];

	if (isset($_POST['confirm_emprunt'])) {
		$confirm_emprunt = $_POST['confirm_emprunt'];
	} else {
		$confirm_emprunt = 'off';
	}

	// si confirmation off, je reviens à la page précédente par header
	if ($confirm_emprunt == 'off') {
		// retour page précédente avec $_GET['id_objet'];
		header("Location: ../single.php?id_objet=$id_objet");
		exit;
	} else {

		// si confirmation on, je continue
		// echo "id objet $id_objet";
		// echo "<br />";
		// echo "confirmation $confirm_emprunt";
		// echo "<br />";
		// récupérer date du jour + date dans 7jour

		$date_emprunt = date("Y-m-d");
		$date_restit = date_outil($date_emprunt, 7);
		$encours = 1;
		$date_retour_reel = "";

		// echo "aujourd'hui $date_emprunt";
		// echo "<br/>";
		// echo "dans une semaine $date_restit";
		// écrire une fiche emprunt
		// contenant date d'emprunt - date de restitution - id emprunter - id objet 
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $pdo->prepare('INSERT INTO `emprunts`( `id_emprunteur`, `id_objet`, `date_emprunt`, `date_restitution`,`encours`,`date_retour_reel`) VALUES (:id_emprunteur,:id_objet,:date_emprunt,:date_restit,:encours,:date_retour_reel)');
		$stmt->bindValue(':id_emprunteur', $id_emprunteur, PDO::PARAM_STR);
		$stmt->bindValue(':id_objet', $id_objet, PDO::PARAM_STR);
		$stmt->bindValue(':date_emprunt', $date_emprunt, PDO::PARAM_STR);
		$stmt->bindValue(':date_restit', $date_restit, PDO::PARAM_STR);
		$stmt->bindValue(':encours', $encours, PDO::PARAM_STR);
		$stmt->bindValue(':date_retour_reel', $date_emprunt, PDO::PARAM_STR);
		//$stmt->execute();

		//écrire dans la base de données puis retour

		if ($stmt->execute()) {
			echo "<p>Votre emprunt de matériel est validé.</p>";
			echo "<p>Pensez à le restituer sous une semaine</p>";
			echo "<p>La date de retour prévue est le $date_restit</p>";
			header("Refresh:$refresh;../send");
			// header("Location: new.php?info=ok&id_stag=$id_stag&label_change=green");
		} else {
			echo "<p>Insertion non faite dans la BDD.</p>";
			header("Refresh:$refresh;../single.php?id_objet=$id_objet");
		}

		// revenir sur la liste des objets (ajouter sur la liste : '1 emprunté')
	}
} // fin de session	
