<?php

include "../inc/connection.php";
include "../inc/functions.php";

$to=$_GET['mail-user'];
$nom_objet=$_GET['nom_objet'];
$date_restitution=$_GET['date_restit'];


if (mail_alerte($to,$nom_objet,$date_restitution))
{
	echo "mail envoyé";
}
else
{
	echo "Erreur";
}

?>