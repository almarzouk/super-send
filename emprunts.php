<?php session_start();


// ouverture de session
// si pas de session - retour a l'index 
if (!$_SESSION['nom_user']) {
	header('../index.php');
}

// si session ok, je vois le contenu
else {
	include('inc/connection.php');
	include 'inc/header.php';
	include 'inc/navbar.php';

	// page d'option , historique ou emprunts en cours
	if (isset($_GET['option_page'])) {
		$option_page = $_GET['option_page'];
	} else {
		$option_page = 0;
	}

	if ($_SESSION['auth'] == 1) {


		$requete = "SELECT * FROM emprunts,users,objets,category,sub_category WHERE emprunts.encours=$option_page AND emprunts.id_emprunteur=users.id_user AND emprunts.id_objet=objets.id_objet AND objets.id_category_objet=category.id_category AND objets.id_subcategory=sub_category.id_subcategory";
		$rendre_materiel = "Annuler l'emprunt";
	} else {

		$id_user = $_SESSION['id_user'];
		$requete = "SELECT * FROM emprunts,users,objets,category,sub_category WHERE emprunts.id_emprunteur=$id_user AND emprunts.encours=$option_page AND emprunts.id_emprunteur=users.id_user AND emprunts.id_objet=objets.id_objet AND objets.id_category_objet=category.id_category AND objets.id_subcategory=sub_category.id_subcategory";
		$rendre_materiel = "Restitution du matériel";
	}


?>
	<div class="container mt-5 min-vh-100">
		<?php
		if ($option_page == 0) {
			echo "<h3>Historique</h3>";
		} else {
			echo "<h3>Emprunts en cours</h3>";
		}


		$query = $pdo->query($requete);
		$resultat = $query->fetchAll();
		?>
		<div class="row justify-content-between">
			<?php foreach ($resultat as $key => $variable) : ?>
				<?php
				$id_emprunt = $resultat[$key]['id_emprunt'];
				$nom_objet = $resultat[$key]['model_objet'];
				$marque_objet = $resultat[$key]['marque_objet'];
				$categorie = $resultat[$key]['nom_category'];
				$subcategorie = $resultat[$key]['nom_subcategory'];
				$photo = $resultat[$key]['photo_objet'];
				$nom_user = $resultat[$key]['nom_user'];
				$mail_user = $resultat[$key]['mail_user'];
				$date_emprunt = $resultat[$key]['date_emprunt'];
				$date_restitution = $resultat[$key]['date_restitution'];
				$date_now = date("Y-m-d  h:m:s");
				$d1 = new DateTime("$date_now");
				$d2 = new DateTime("$date_restitution 12:00:00");
				$diff = $d1->diff($d2);
				$nb_jours = $diff->d;
				$retard = $diff->invert;
				?>

				<div class="card bg-light mb-5 m-0 p-0" style="max-width: 40rem;">
					<div class="card-header m-0"><?= $nom_objet ?></div>
					<div class="card-body">
						<div class="d-flex">
							<div class="d-flex flex-column">
								<h5 class="card-text me-2">Nom: </h5>
								<h5 class="card-text me-2">Marque: </h5>
								<h5 class="card-text  me-2">Details: </h5>
							</div>
							<div class="d-flex flex-column">
								<h6 class=" mb-3"><?= $nom_objet ?></h6>
								<h6 class=" mb-2"><?= $marque_objet ?></h6>
								<p>Emprunté par <?= $nom_user ?><br />
									Mail emprunteur <?= $mail_user ?><br />
									Date d'emprunt : <?= $date_emprunt ?><br />
									Date de restitution <?= $date_restitution ?></p>
							</div>
						</div>
						<p class="badge bg-info text-dark text-start rounded-pill"><?= $categorie ?></p>
						<p class="badge bg-warning text-dark text-start rounded-pill"><?= $subcategorie ?></p>
						<!-- condition -->
						<?php
						if ($option_page == 1) {
							if ($retard > 0) {
								echo "<p class='badge bg-danger text-white text-center text-start rounded-pill'>Retard de $nb_jours jours</p>";
								echo "<a class='text-danger mb-2 text-decoration-none d-block w-50' href='admin/mail-alerte.php?mail-user=$mail_user&nom_objet=$nom_objet&date_restit=$date_restitution'>Relancer emprunteur (non fonctionnel)</a> ";
							} else {
								echo "<p class='badge bg-success text-white text-center text-start rounded-pill'>Il reste $nb_jours jours</p>";
							}
						?>

							<?php 	// demandé par Régis : l'utilisateur ne peut pas annuler l'emprunt sans l'avis de l'admin/delete-emprunt
							// Module n'apparaît plus pour l'emprunteur
							if ($_SESSION['auth'] == 1) {
							?>
								<form method='post' action='admin/delete-emprunt.php'>
									<div class="form-check form-switch  mb-3">
										<label class="form-check-label">Confirmer Annulation?</label>
										<input type='hidden' name='id_emprunt' value='<?= $id_emprunt ?>'>
										<input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name='confirm_annulation'>
									</div>
									<button class="btn btn-dark disBtn" type='submit'><?php echo $rendre_materiel; ?></button>
								</form>
							<?php 	} // fin module annuler emprunt
							?>

						<?php 	} // fin option 1 
						?>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	</div>


	<!-- <script>
		let switcher = document.querySelectorAll('.form-check-input');
		let disBtn = document.querySelectorAll('.disBtn');
		switcher.forEach((btn) => {
			btn.addEventListener('click', function() {
				if (btn.checked == true) {
					disBtn.forEach((btn) => {
						btn.disabled = false;
					})
				} else {
					disBtn.forEach((btn) => {
						btn.disabled = true;
					})

				}
			})
		})
	</script> -->

	<?php include './inc/footer.php' ?>

<?php
} // FIN SESSION
?>