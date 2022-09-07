<?php
include "../inc/connection.php";
include '../inc/header.php';
include "../inc/functions.php";

// temps de rafraîchissement après action bdd
$refresh = 3;
// ajouter les sessions pour récupérer l'id de l'emprunteur
$id_emprunteur = 1;


// récupérer les données du matériels à louer

$id_emprunt = $_POST["id_emprunt"];

if (isset($_POST['confirm_annulation'])) {
	$confirm_annulation = $_POST['confirm_annulation'];
} else {
	$confirm_annulation = 'off';
}

// si confirmation off, je reviens à la page précédente par header
if ($confirm_annulation == 'off') {
	// retour page précédente avec $_GET['id_objet'];
	header("Location: ../emprunts.php");
	exit;
} else {
	$encours = 0;
	$date_retour_reel = date("Y-m-d");
	// confirmer l'annulaton de l'emprunt,
	// ne supprime pas la fiche de la bdd mais la passe en historique

	$requete = "UPDATE `emprunts` SET `encours`= ? ,`date_retour_reel`= ? WHERE `id_emprunt`= ? ";
	$pdo->prepare($requete)->execute([$encours, $date_retour_reel, $id_emprunt]);

	if ($pdo) {
		echo "<div class='alert alert-success text-center' role='alert'>";
		echo "<p>Modification de la base de données effectuée</p>";
		echo "</div>";

		header("Refresh:$refresh;../emprunts.php?option_page=1");
	} else {
		echo "<div class='alert alert-danger text-center' role='alert'>";
		echo "<p>Modification de la base de données non effectuée</p>";
		echo "</div>";

		header("Refresh:$refresh;../emprunts.php?option_page=1");
	}
}
