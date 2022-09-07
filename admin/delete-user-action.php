<?php
include '../inc/header.php';
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
        header("location:../landing.php");
    } else {
        include('../inc/connection.php');
        include('../inc/functions.php');

        $id = $_GET['id_user'];
        //echo $id;

        //Requete pour supprimer la donnée
        $data = ['id => $id'];
        $sql = "DELETE FROM users WHERE id_user= :id";

        $statement = $pdo->prepare($sql);

        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        if ($statement->execute()) {
            echo "<div class='alert alert-success text-center' role='alert'>";
            echo "Suppression de la fiche utilisateur $id correctement effectuée dans la base de données!";
            echo "</div>";
            header("Refresh: 3; $url_standard/admin/list-user.php");
        }



        //Fermeture de la connexion
        $pdo = null;
    } //Fermeture session admin  

}//Fermeture session
