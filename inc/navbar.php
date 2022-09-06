<?php

include 'functions.php';

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $url_standard ?>/index.php" style="
    flex: 1;
">Super</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- condition-->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">


                <?php

                if ((isset($_SESSION['auth']) && $_SESSION['auth'] == 0)) {
                ?>


                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="<?php echo $url_standard; ?>/landing.php">Liste des objets</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="<?php echo $url_standard; ?>/emprunts.php?option_page=1">les emprunts en cours</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="<?php echo $url_standard; ?>/emprunts.php?option_page=0">Historique des emprunts</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="<?php echo $url_standard; ?>/admin/update-user.php">Modifier mes données personnelles</a>
                    </li>


                <?php
                }


                // liens administrateur 

                if (isset($_SESSION['auth']) && ($_SESSION['auth'] == 1)) {
                ?>

                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="<?php echo $url_standard ?>/landing.php">Dashboard </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item  me-4" aria-current="page" href="<?php echo $url_standard ?>/admin/insert-objet.php">Ajouter un objet </a>
                            </li>
                            <li>
                                <a class="dropdown-item  me-4" aria-current="page" href="<?php echo $url_standard ?>/admin/insert-user.php">Ajouter un utilisateur</a>
                            </li>
                            <li>
                                <a class="dropdown-item  me-4" aria-current="page" href="<?php echo $url_standard ?>/admin/list-objet.php">Modifier/Supprimer un objet</a>
                            </li>
                            <li>
                                <a class="dropdown-item  me-4" aria-current="page" href="<?php echo $url_standard ?>/admin/list-user.php">Modifier/Supprimer Données Utilisateur</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?php echo $url_standard; ?>/emprunts.php?option_page=1">les emprunts en cours</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="<?php echo $url_standard; ?>/emprunts.php?option_page=0">Historique des emprunts</a>
                    </li>

                <?php
                }

                ?>
            </ul>
        </div>
        <div class='text-white d-flex justify-content-center align-items-center me-3'>
            <?php

            //affichage des données de session dans un encart dédié
            if (isset($_SESSION['nom_user'])) {
                echo $_SESSION['nom_user'] . "<p class='me-2 ms-2 p-0 m-0'>connecté</p>";
                echo "<a class='btn btn-danger p-2' href='$url_standard/inc/session_deconnect.php' style='padding-block: 0 !important;'>x</a>";
            } else {
                echo "non connecté";
            }
            ?>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>