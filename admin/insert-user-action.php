<?php
session_start ();

include('../inc/connection.php');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$adresse = $_POST['adresse'];
$mail = $_POST['mail'];
$pass = $_POST['pass'];
$auth = 0;
$type = 0;
$req = $pdo->prepare('INSERT INTO `users` (`nom_user`, `prenom_user`, `adresse_user`, `mail_user`,`auth_user`, `pass_user`,`type_user`)
                                      VALUES (:nom, :prenom, :adresse, :mail, :auth, :pass, :type)');
$req->bindValue(':nom', $nom, PDO::PARAM_STR);
$req->bindValue(':prenom', $prenom, PDO::PARAM_STR);
$req->bindValue(':adresse', $adresse, PDO::PARAM_STR);
$req->bindValue(':mail', $mail, PDO::PARAM_STR);
$req->bindValue(':auth', $auth, PDO::PARAM_STR);
$req->bindValue(':type', $type, PDO::PARAM_STR);
$req->bindValue(':pass', $pass, PDO::PARAM_STR);

if ($req->execute()) {
    echo ("les données ont bien été enregistrées dans la base de données!");
	
	if (isset ($_SESSION['nom_user']))
	{
		header('Refresh: 3; ../landing.php');
	}
    else
	{
		header('Refresh: 3; ../index.php');
	}
}

//Fermeture de la connexion
$pdo = null;
