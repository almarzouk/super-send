<?php
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
		header("location:$url_standard/landing.php");
	} else {
		include '../inc/connection.php';
		include '../inc/header.php';
		include '../inc/navbar.php';

		$id_objet = $_GET['id_objet'];

		echo "<h3>Module d'administration</h3>";


		$query = $pdo->query("SELECT * FROM `objets` WHERE id_objet=$id_objet");
		$resultat = $query->fetchAll();
		echo "<tr>";
		//Afficher les résultats dans un tableau
		foreach ($resultat as $key => $variable) {

			$id_objet = $resultat[$key]['id_objet'];
			$marque_objet = $resultat[$key]['marque_objet'];
			$model_objet = $resultat[$key]['model_objet'];
			$photo_objet = $resultat[$key]['photo_objet'];
			$description_objet = $resultat[$key]['description_objet'];
			$id_category_objet = $resultat[$key]['id_category_objet'];
			$id_subcategory_objet = $resultat[$key]['id_subcategory'];
			$quantite = $resultat[$key]['quantite'];
		}

?>

		<div class="container ">
			<form action="update-objet-action.php" method="post" class="mb-5 w-75 p-5 m-auto">
				<h4>Modification des données de l'objet <?php echo $id_objet ?></h4>


				<div class="mb-3">
					<label for="exampleInputEmail1" class="form-label">Marque</label>
					<input type="text" name="marque" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $marque_objet ?>">
				</div>
				<div class="mb-3">
					<label for="exampleInputEmail1" class="form-label">Modèle</label>
					<input type="text" name="model" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $model_objet ?>">
				</div>
				<div class="mb-3">
					<label for="exampleInputEmail1" class="form-label">Descriptif</label>
					<textarea type="text" name="description" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" style="height: 200px;"><?php echo $description_objet ?></textarea>
				</div>
				<div class="mb-3">
					<label for="exampleInputEmail1" class="form-label">Quantité</label>
					<input type="text" name="quantite" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $quantite ?>">
				</div>
				<div class="mb-3">
					<label for="exampleInputEmail1" class="form-label">photo</label>
					<input type="file" name="photo" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $photo_objet ?>">
				</div>
				<div class="mb-3">
					<label for="exampleInputEmail1" class="form-label">Choisissez une catégorie (Confirmer si identique) :</label><br />


					<?php
					// FAIRE APPARAITRE CATEGORIE ET SOUS CATEGORIE POUR BIEN PLACER L'OBJET

					if (isset($_GET['cat'])) {
						$id_cat_choose = $_GET['cat'];
						$requete = "SELECT * FROM category WHERE id_category=$id_cat_choose";
						//requête pour tester la connexion
						$query = $pdo->query($requete);
						$resultat = $query->fetchAll();
						foreach ($resultat as $key => $variable) {
							$id_category_choose = $resultat[$key]['id_category'];
							$nom_category_choose = $resultat[$key]['nom_category'];
							echo "<a class='badge text-bg-success text-decoration-none fs-6 me-3' href='update-objet?id_objet=$id_objet&cat=$id_category_choose'>$nom_category_choose</a>";
						}
					} else {
						$requete = "SELECT * FROM category";
						//requête pour tester la connexion
						$query = $pdo->query($requete);
						$resultat = $query->fetchAll();
						foreach ($resultat as $key => $variable) {
							$id_category = $resultat[$key]['id_category'];
							$nom_category = $resultat[$key]['nom_category'];

							// pas réussi avec des select dynamiques propres, je passe sur des liens dynamiques
							if (isset($id_category_objet) && ($id_category_objet) == $id_category) {
								$style = "class='badge text-bg-success text-decoration-none fs-6 me-3'";
							} else {
								$style = "class='badge text-bg-dark text-decoration-none fs-6 me-3'";
							}

							echo "<a $style href='update-objet?id_objet=$id_objet&cat=$id_category'>$nom_category</a>";
						}
					}
					?>

				</div>
				<div class="mb-3">

					<?php
					// FAIRE APPARAITRE CATEGORIE ET SOUS CATEGORIE POUR BIEN PLACER L'OBJET
					if (isset($_GET['cat']) && isset($_GET['subcat'])) {
						$id_cat_choose = $_GET['cat'];
						$id_subcat_choose = $_GET['subcat'];
						$requete = "SELECT * FROM sub_category WHERE id_subcategory=$id_subcat_choose";
						//requête pour tester la connexion
						$query = $pdo->query($requete);
						$resultat = $query->fetchAll();
						foreach ($resultat as $key => $variable) {
							$id_sub_category_choose = $resultat[$key]['id_subcategory'];
							$nom_subcategory_choose = $resultat[$key]['nom_subcategory'];

							echo "<a class='badge text-bg-success text-decoration-none fs-6 me-3' href='update-objet?id_objet=$id_objet&cat=$id_cat_choose&subcat=$id_sub_category_choose'>$nom_subcategory_choose</a>";
						}
					}



					if (isset($_GET['cat']) && !isset($_GET['subcat'])) {
						$category_select = $_GET['cat'];
						$requete = "SELECT * FROM sub_category WHERE id_category=$category_select";
						//requête pour tester la connexion
						$query = $pdo->query($requete);
						$resultat = $query->fetchAll();
						foreach ($resultat as $key => $variable) {
							$id_sub_category = $resultat[$key]['id_subcategory'];
							$nom_subcategory = $resultat[$key]['nom_subcategory'];

							if ($id_sub_category == $id_subcategory_objet) {
								$style = "class='badge text-bg-success text-decoration-none fs-6 me-3'";
							} else {
								$style = "class='badge text-bg-dark text-decoration-none fs-6 me-3'";
							}

							echo "<a $style href='update-objet?id_objet=$id_objet&cat=$category_select&subcat=$id_sub_category'>$nom_subcategory</a>";
						}
					}

					if (isset($_GET['cat']) && isset($_GET['subcat'])) {
						$category_select = $_GET['cat'];
						$subcategory_select = $_GET['subcat'];

						echo "<input type='hidden' name='id_objet' value='$id_objet'>";
						echo "<input type='hidden' name='category' value='$category_select'>";
						echo "<input type='hidden' name='subcategory' value='$subcategory_select'>";
					}


					?>

					<a class="btn btn-danger d-block w-25 mt-3" href="update-objet.php?id_objet=<?php echo $id_objet ?>">Reset Choix catégorie<a>
				</div>



				<button type="submit" class="btn btn-dark">Update</button>

			</form>

		</div>
<?php

	} //Fin fermeture session admin


	include '../inc/footer.php';
} //fermeture session
?>