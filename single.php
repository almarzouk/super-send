<?php
session_start();
// ouverture de session
// si pas de session - retour a l'index 
if (!$_SESSION['nom_user']) {
	header("location:$url_standard/index.php");
}

// si session ok, je vois le contenu
else {

	if (($_SESSION['auth'] == 1) or ($_SESSION['auth'] == 1)) {
		header("location:$url_standard/landing.php");
	} else {
		include 'inc/header.php';
		include 'inc/navbar.php';
?>

		<div class="container min-vh-100">
			<?php include "inc/connection.php";
			// La catégorie a été choisie, je peux choisir la sous-catégorie
			$id_objet = $_GET['id_objet'];
			$requete = "SELECT * FROM objets,category,sub_category WHERE id_objet=$id_objet AND objets.id_category_objet=category.id_category AND objets.id_subcategory=sub_category.id_subcategory";
			//requête pour tester la connexion
			$query = $pdo->query($requete);
			$resultat = $query->fetchAll();
			//afficher le résultat dans un tableau
			?>
			<?php foreach ($resultat as $key => $variable) : ?>
				<?php
				$category_res = $resultat[$key]['nom_category'];
				$subcategory_res = $resultat[$key]['nom_subcategory'];
				$id_category = $resultat[$key]['id_category'];
				$id_subcategory = $resultat[$key]['id_subcategory'];
				$id_objet = $resultat[$key]['id_objet'];
				$modele = $resultat[$key]['model_objet'];
				$marque = $resultat[$key]['marque_objet'];
				$description = $resultat[$key]['description_objet'];
				$quantite = $resultat[$key]['quantite'];
				$photo = $resultat[$key]['photo_objet'];
				?>
				<!--  -->
				<div class="container mt-5 border border-3 rounded">
					<div class="row align-items-center mt-0 justify-content-center">
						<div class="col-img border-bottom col-12 col-lg-6 d-flex justify-content-center align-items-center mb-5">
							<img src='assets/thumbs/<?= $category_res ?>/<?= $subcategory_res ?>/<?= $photo . ".png" ?>' alt=<?= $photo . ".png" ?> class="w-75 h-75 img-fluid">
						</div>
						<div class="col-12 col-lg-6 m-0 border-start mb-5 mt-5">
							<p class="m-0 mb-2"><strong>Marque:</strong> <?= $resultat[$key]['marque_objet'] ?></p>
							<p class="m-0 mb-2"><strong>Modèle:</strong> <?= $resultat[$key]['model_objet'] ?></p>
							<p class="m-0 mb-5"><strong>Description:</strong> <?= $resultat[$key]['description_objet'] ?></p>
							<?php
							// gestion de l'affichage de la quantité et de la disponibilité
							//calcul de la quantité réelle
							$requete_compte = "select * from objets,emprunts where objets.id_objet=$id_objet AND objets.id_objet=emprunts.id_objet;";
							$query5 = $pdo->query($requete_compte);
							$resultat5 = $query5->fetchAll();
							$count = $query5->rowCount();
							$quantitereelle = $quantite - $count;

							if ($quantitereelle == 0) {
								echo "<div class='d-flex justify-content-center align-items-center'>";
								echo "<span class='dot me-2'>";
								echo "</span>";
								echo "Non disponibe";
								echo "</div>";
							}

							if ($quantitereelle > 0) {
								if ($quantitereelle == 1) {
									$pluriel = '';
								}
								if ($quantitereelle > 1) {
									$pluriel = 's';
								}

								echo "<div class='d-flex justify-content-center align-items-center'>";
								echo "<span class='dot-1 me-2'>";
								echo "</span>";
								echo "$quantitereelle disponible$pluriel";
								echo "</div>";
							}
							// fin gestion quantité
							?>
							<div class="form-check form-switch  mb-3">
								<form action="admin/insert-emprunt.php" method="post">
									<input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name='confirm_emprunt'>
									<input type="hidden" name="id_objet" value="<?php echo "$id_objet"; ?>">
									<label class="form-check-label" for="flexSwitchCheckDefault">cocher pour confirmer</label>
							</div>
							<button class="btn disBtn btn-dark mb-3 d-block" type="submit" disabled>Emprunter ce matériel</button>
							</form>
							<a class="btn btn-dark" href='<?= "landing.php?recup_id_cat=$id_category&recup_id_subcat=$id_subcategory" ?>'>Revenir à la liste</a>
						</div>
					</div>
				</div>
			<?php endforeach ?>
			<div class="container flex-column flex-md-row d-flex mt-5 ps-0 justify-content-center">
				<p>Catégorie: <span class='badge bg-warning text-dark rounded-pill me-3'> <?= $resultat[$key]['nom_category'] ?> </span></p>
				<p>Sous-Catégorie: <span class='badge bg-info text-dark rounded-pill'> <?= $resultat[$key]['nom_subcategory'] ?> </span></p>
			</div>
		</div>
		<script>
			let switcher = document.querySelector('.form-check-input');
			switcher.addEventListener('click', function newfun() {
				let disBtn = document.querySelector('.disBtn');
				if (switcher.checked === true) {
					disBtn.disabled = false;
				} else {
					disBtn.disabled = true;
				}
			})
		</script>
		<?php include './inc/footer.php' ?>


<?php } // fin de session admin

} // fin de session	
?>