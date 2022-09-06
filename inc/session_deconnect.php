<?php
session_start();

// on détruit les variables de session courante
session_unset();
// on détruit notre session
session_destroy();

header('location:../index.php');

?>