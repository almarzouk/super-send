<?php session_start();
// ouverture de session
// si pas de session - retour a l'index 

include '../inc/header.php';
include '../inc/navbar.php';

?>

<div class="container  min-vh-100">
    <form class="mb-5 w-50 p-5 m-auto" action="insert-user-action.php" method="post">
        <h3>S'inscrire</h3>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nom</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="nom">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">prénom</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="prenom">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">adresse</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="adresse">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">mail</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="mail">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">mot de pass</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="pass">
        </div>

        <button class="btn btn-dark" type='submit'>Envoyer</button>
    </form>
</div>

<?php include '../inc/footer.php' ?>