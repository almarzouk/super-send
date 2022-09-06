<?php
session_start(); 
// ouverture de session
// si pas de session - retour a l'index 
    if (!$_SESSION['nom_user'])
    {
    header('location:../index.php');	
    }

    // si session ok, je vois le contenu
    else
    {		
		if ($_SESSION['auth']!=1)
		{
		header("location:../landing.php");	
		}
		else
		{
		
		include '../inc/connection.php' ;
		
		
		/*** écriture des données en base ***/
	
$marque=$_POST['marque'];
$modele=$_POST['modele'];
$photo=$_POST['photo'];
$descriptif=$_POST['descriptif'];
$category=$_POST['category'];
$subcategory=$_POST['subcategory'];
$quantite=$_POST['quantite'];	
		
       
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$req = $pdo->prepare('INSERT INTO `objets` (`marque_objet`, `model_objet`, `photo_objet`, `description_objet`,`id_category_objet`, `id_subcategory`,`quantite`) VALUES (:marque, :modele, :photo, :descriptif, :category, :subcategory, :quantite)');
$req->bindValue(':marque', $marque, PDO::PARAM_STR);
$req->bindValue(':modele', $modele, PDO::PARAM_STR);
$req->bindValue(':photo', $photo, PDO::PARAM_STR);
$req->bindValue(':descriptif', $descriptif, PDO::PARAM_STR);
$req->bindValue(':category', $category, PDO::PARAM_STR);
$req->bindValue(':subcategory', $subcategory, PDO::PARAM_STR);
$req->bindValue(':quantite', $quantite, PDO::PARAM_STR);

if ($req->execute()) {
    echo ("les données ont bien été enregistrées dans la base de données!");
	
	/*** écriture du fichier uploadé***/
	
	/** récupération des données de catégorie/sous catégorie pour écrire le chemin**/
	
	//Requete pour tester la connexion
        $query = $pdo->query("SELECT * FROM category,sub_category WHERE category.id_category=sub_category.id_category ");
        $resultat = $query->fetchAll();
		//Afficher les résultats dans un tableau
            foreach ($resultat as $key =>$variable)
				{
				        echo("<td>" .$resultat[$key]['id_category_objet']. "</td>");
                            echo("<td>" .$resultat[$key]['id_subcategory']. "</td>");  
					
                }
	
	
	if (isset($_FILES['photo'])&& $_FILES['photo']['error']==0)
{
	$format=array("jpg"=>"image/jpg","jpeg"=>"image/jpeg","gif"=>"image/gif","png"=>"image/png");
	$filename=$_FILES['photo']['name'];
	$filetype=$_FILES['photo']['type'];
	$filesize=$_FILES['photo']['size'];
	
	//vérifie l'extension fichier
	$ext=pathinfo($filename, PATHINFO_EXTENSION);
	if (!array_key_exists($ext,$format)) die("Erreur:Veuillez sélectionner un format de fichier valide.");
	{
	// vérifie la taille du fichier - 5mo max
	$maxsize=5*1024*1024;
		if($filesize>$maxsize)die("Erreur:La taille du fichier est supérieur à celle autorisée (5Mo).");
	
		//Vérifie le type MIME du fichier
		if(in_array($filetype,$format))
		{
			// vérifie si le fichier existe 
			if(file_exists($chemin.$_FILES['upload']['name']))
			{
			echo $_FILES['upload']['name']."existe déja.";
			}
			else
			{
			move_uploaded_file($_FILES['upload']['tmp_name'],$pref.$chemin.$_FILES['upload']['name']);
			echo "Votre fichier a été téléchargé avec succès";
			$file_dirname=$chemin.$_FILES['upload']['name'];
			}
		}
	
		else
		{
		echo "Erreur, Il y a eu un problème de téléchargement de votre fichier, veuillez réessayer.";
		}
	}
}
	else
	{
		echo "Error:".$_FILES['upload']['error'];
	}
	
	
	
	
    header('Refresh: 3; ../landing.php');
}

//Fermeture de la connexion
$pdo = null;

		} // fin session admin
		
	}// fin session
