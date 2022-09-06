<?php
session_start();
include('../inc/connection.php');

// ouverture de session
// si pas de session - retour a l'index 
if (!$_SESSION['nom_user']) {
    header('../index.php');
}

// si session ok, je vois le contenu
else {

    if ($_SESSION['auth'] != 1) {
        header("location:../landing.php");
    } else {
        include '../inc/header.php';
        include '../inc/navbar.php';

        //je rajoute une condition
        // si je suis admin, je vois le contenu destiné à l'admin
?>
        <div class="container min-vh-100" style="
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
">

        <?php
        $id = $_GET['id_objet'];
        //echo $id;

        //Requete pour tester la connexion
        $query = $pdo->query("SELECT * FROM objets,category,sub_category WHERE id_objet=$id AND objets.id_category_objet=category.id_category AND sub_category.id_subcategory=objets.id_subcategory");
        $resultat = $query->fetchAll();

        echo "<div id='bloc1' class='container mt-5 border border-3 rounded w-50 d-flex justify-content-center align-items-center flex-column'>";
        echo "<p  class='align-self-start'><b>Etes vous certain de vouloir effacer les données de cet objet dans la base ?</b></br></p>";
        //Afficher les résultats dans un tableau
        foreach ($resultat as $key => $variable)
            //$id = $resultat[$key]['id_objet'];
            $marque = $resultat[$key]['marque_objet'];
        $model = $resultat[$key]['model_objet'];
        $photo = $resultat[$key]['photo_objet'];
        $description = $resultat[$key]['description_objet'];
        $path = "../assets/images/";
        $nom = $resultat[$key]['nom_category'];
        $nomsub = $resultat[$key]['nom_subcategory']; {
            echo "<h4 class='align-self-start'>";
            echo "Marque: $marque";
            echo "</h4>";
            echo "<h4 class='align-self-start'>";
            echo "Modele: $model";
            echo "</h4>";
            echo "<img class='w-50 h-50 img-fluid' src='$path$nom/$nomsub/$photo.jpg'>";
            echo "<p class='mb-3'>" . $resultat[$key]['description_objet'] . "</p>";
            echo "<td><a class='align-self-start mb-3' href='delete-objet-action.php?id=$id'><input class='btn btn-danger' type='submit' name='delete' value='Delete' id='button'></a></td>";
        }
        echo "</div>";
        //Fermeture de la connexion 
        $pdo = null;
    } // fermeture de session admin
        ?>

        </div>
    <?php } // fermeture de session 
    ?>