<?php
session_start();
// ouverture de session
// si pas de session - retour a l'index 
if (!$_SESSION['nom_user']) {
	header('location:../index.php');
}

// si session ok, je vois le contenu
else {
	if ($_SESSION['auth'] != 1) {
		header("location:../landing.php");
	} else {

		include '../inc/connection.php';
		include '../inc/header.php';
		include '../inc/navbar.php';

?>

		<div class="container min-vh-100">
			<form action="insert-objet-action.php" method="post" class="mb-5 w-50 p-5 m-auto">
				<?= "<h3>Module d'administration</h3>"; ?>
				<h4>Ajouter un objet</h4>
				<div class="mb-3">
					<label for="exampleInputEmail1" class="form-label">Choisissez une catégorie :</label><br />

					<?php
					// FAIRE APPARAITRE CATEGORIE ET SOUS CATEGORIE POUR BIEN PLACER L'OBJET

					$requete = "SELECT * FROM category";
					//requête pour tester la connexion
					$query = $pdo->query($requete);
					$resultat = $query->fetchAll();
					foreach ($resultat as $key => $variable) {
						$id_category = $resultat[$key]['id_category'];
						$nom_category = $resultat[$key]['nom_category'];

						// pas réussi avec des select dynamiques propres, je passe sur des liens dynamiques
						if (isset($_GET['cat']) && ($_GET['cat']) == $id_category) {
							$style = "class='badge text-bg-success text-decoration-none fs-6 me-3'";
						} else {
							$style = "class='badge text-bg-dark text-decoration-none fs-6 me-3'";
						}
						echo "<a $style href='insert-objet?cat=$id_category'>$nom_category</a>";
					}
					?>

				</div>

				<?php if (isset($_GET['cat'])) {	?>
					<input name="category" type="hidden" value="<?php echo $_GET['cat']; ?>">
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label">Sous-Categorie</label>
						<select name="subcategory" class="form-select mb-4" aria-label="Default select example">
							<?php
							// FAIRE APPARAITRE CATEGORIE ET SOUS CATEGORIE POUR BIEN PLACER L'OBJET
							$category_select = $_GET['cat'];
							$requete = "SELECT * FROM sub_category WHERE id_category=$category_select";
							//requête pour tester la connexion
							$query = $pdo->query($requete);
							$resultat = $query->fetchAll();
							foreach ($resultat as $key => $variable) {
								$id_sub_category = $resultat[$key]['id_subcategory'];
								echo "<option value='$id_sub_category'>";
								echo $resultat[$key]['nom_subcategory'];
								echo "</option>";
							}

							?>

						</select>
					</div>
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label">Marque</label>
						<input name="marque" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
					</div>
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label">Modèle</label>
						<input name="modele" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
					</div>
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label">Descriptif</label>
						<textarea name="descriptif" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"></textarea>
					</div>
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label">photo</label>
						<input name="photo" type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
					</div>

					<div class="mb-3">
						<label>Quantité entrée en stock </label>&nbsp;
						<input name="quantite" type="texte">
					</div>
				<?php } // isset get cat
				?>

				<button type="submit" class="btn btn-dark">Valider</button>
			</form>
		</div>

		<?php include '../inc/footer.php' ?>
<?php
	} // fermeture de session admin
} // fermeture de session 
?>