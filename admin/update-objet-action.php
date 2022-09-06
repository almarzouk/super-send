<?php
session_start(); 


// ouverture de session
// si pas de session - retour a l'index 
    if (!$_SESSION['nom_user'])
    {
    header('location: ../index.php');	
    }

    // si session ok, je vois le contenu
    else
    {
		
		if (!isset($_POST['id_objet'])) // condition sur le post
		{
		header('location: ../list-objet.php');
		}
		else
		{
		include('../inc/connection.php');
        include '../inc/functions.php' ;
		
		$id_objet=$_POST['id_objet'];
		$marque=$_POST['marque'];
		$model=$_POST['model'];
		$description=$_POST['description'];
		$photo=$_POST['photo'];
		$id_category=$_POST['category'];
		$id_subcategory=$_POST['subcategory'];
		$quantite=$_POST['quantite'];


	$stmt=$pdo->prepare("UPDATE `objets` SET `marque_objet`= :marque,`model_objet`= :model,
	`photo_objet`= :photo,`description_objet`= :description,`id_category_objet`= :id_category,`id_subcategory`= :id_subcategory,`quantite`= :quantite WHERE `id_objet`= :id_objet ");
	
			$stmt->bindValue(':id_objet',$id_objet,PDO::PARAM_STR);
			$stmt->bindValue(':marque',$marque,PDO::PARAM_STR);
			$stmt->bindValue(':model',$model,PDO::PARAM_STR);
			$stmt->bindValue(':description',$description,PDO::PARAM_STR);
			$stmt->bindValue(':photo',$photo,PDO::PARAM_STR);
			$stmt->bindValue(':id_category',$id_category,PDO::PARAM_STR);
			$stmt->bindValue(':id_subcategory',$id_subcategory,PDO::PARAM_STR);
			$stmt->bindValue(':quantite',$quantite,PDO::PARAM_STR);
			
			
	if($stmt->execute())
	{
	echo "<p>Modification de la base de données effectuée</p>";
	// header("Location: update.php?info=ok&id_stag=$id_stag");
	header("Refresh:3;$url_standard/admin/update-objet.php?id_objet=$id_objet");
	}
	else
	{
	echo "<p>Modification de la base de données non effectuée</p>";
	// header("Location: update.php?info=ko&id_stag=$id_stag");
	header("Refresh:3;$url_standard/admin/update-objet.php?id_objet=$id_objet");
	}




// fermeture de la connexion
$pdo=null;

		} // fin si post isset
?>


<?php } //fin de session ?>