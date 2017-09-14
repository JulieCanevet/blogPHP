<?php

try //Connexion a la base de donnees
{
	$bdd = new PDO('mysql:host=localhost;dbname=blogPHP;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}


// verifie que les donnees existent
if ($_GET['valId']){

	//securise les donnees
	if(isset($_GET['valId'])){

		$valId = htmlspecialchars($_GET['valId']);

		//prepare les commentaires et execute
		$commentaires = $bdd ->prepare('SELECT * FROM commentaires WHERE id_billet=:id');
		$commentaires -> execute(array('id' => $valId));

		foreach ($commentaires as $key => $value) {
			echo $value['auteur'];?><br><?php
			echo $value['commentaire'];?><br><?php
		}
	}	
}	
	else {
			echo 'Aucun article selectionné';
	}
?>