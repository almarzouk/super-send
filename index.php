<?php include './inc/header.php';
include './inc/navbar.php';
require_once "./inc/connection.php";

if (!isset($_POST['mail']) && !isset($_POST['pwd'])) {
    $_POST['mail'] = '';
    $_POST['pwd'] = '';
} else {

    $mail = $_POST['mail'];
    $pwd = $_POST['pwd'];
    $requete = "SELECT * FROM users WHERE `mail_user`= '" . $mail . "' AND `pass_user`= '" . $pwd . "' ";
    //requête pour tester la connexion
    $query = $pdo->query($requete);
    $resultat = $query->fetchAll();
    $count = $query->rowCount();


    if ($count == 0) {
        echo "Mauvais identifiant";
        header("refresh:2;url=index.php");
    } elseif ($count == 1) {
        session_start();

        foreach ($resultat as $key => $variable) {
            $_SESSION['id_user'] = $resultat[$key]['id_user'];
            $_SESSION['nom_user'] = $resultat[$key]['nom_user'];
            $_SESSION['prenom_user'] = $resultat[$key]['prenom_user'];
            $_SESSION['mail_user'] = $resultat[$key]['mail_user'];
            $_SESSION['pwd'] = $resultat[$key]['pass_user'];
            $_SESSION['auth'] = $resultat[$key]['auth_user'];
        }

        header('location: landing.php');
    }
}


?>

<div class="container text-center">
    <h3 class="text-center m-5">
        Welcome to super Website, votre site de location de materiel photo, vidéo, et accessoires.
    </h3>
    <!-- Carusel start -->
    <div class="container mt-5">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./assets/images/carusel/01.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="./assets/images/carusel/02.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="./assets/images/carusel/03.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
        </div>
    </div>
    <!-- Carusel End -->
    <!-- Form Connection start -->

    <form action="index.php" method="post" class="w-50 m-auto mt-5 text-start mb-5">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input name="mail" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input name="pwd" type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-dark d-block mb-2">Valider</button>
        <a href="./admin/insert-user.php" class="m-2 ms-auto">You don't have account?</a>
    </form>
    <!-- Form Connection End -->

</div>
<?php include './inc/footer.php' ?>