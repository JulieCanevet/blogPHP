<!doctype html>
<html class="no-js" lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Article / commentaires</title>
        <link rel = "stylesheet" href = "font-awesome-4.7.0/css/font-awesome.min.css"> 
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
    	<section id="commentaire">
<?php

try //Connexion a la base de donnees
{
	$bdd = new PDO('mysql:host=localhost;dbname=blogPHP;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// AJOUT D'UN COMMENTAIRE
// on verifie que les champs soient remplis et on les securise
if(!empty($_POST['auteur']) && !empty($_POST['commentaire'])){

	$auteur = htmlspecialchars($_POST['auteur']);
	$com = htmlspecialchars($_POST['commentaire']);

	$req = $bdd -> prepare('INSERT INTO commentaires (id_billet, auteur, commentaire) VALUES (:id_billet, :auteur, :commentaire)');
	$req -> execute(array('id_billet' => $_GET['valId'],
							'auteur' => $_POST['auteur'],
							'commentaire' => $_POST['commentaire']
		));
	
	// mise a jour du champs nb_commentaires
	$req = $bdd -> prepare('UPDATE billets SET nb_commentaires=nb_commentaires+1 WHERE id = :id');
	$req -> execute(array ('id' => $_GET['valId']
		));
}

// verifie que les donnees existent
if ($_GET['valId']){

	//securise les donnees
	if(isset($_GET['valId'])){

		$valId = htmlspecialchars($_GET['valId']);

		// prepare l'article cible et execute
		$article = $bdd -> prepare('SELECT * FROM billets WHERE id=:id');
		$article -> execute(array('id' => $valId));
		
		//prepare les commentaires et execute
		$commentaires = $bdd ->prepare('SELECT auteur, DATE_FORMAT(date_commentaire, \'%Hh%i le %d/%m/%Y\') AS date_commentaire, commentaire FROM commentaires WHERE id_billet=:id ORDER BY date_commentaire');
		$commentaires -> execute(array('id' => $valId));
		
		//affiche l'article cible
		foreach ($article as $clef => $valeur) {?><div class="article"><h3><?php
			echo $valeur['titre'];?></h3><?php
			echo $valeur['contenu'];?><br></div><br><?php
		}
		//affiche les commentaires cibles
		foreach ($commentaires as $key => $value) {?><div class="com"><?php
			echo (htmlspecialchars($value['auteur'])) . ' : (à ' . $value['date_commentaire'] . ')'?><br><?php
			echo (htmlspecialchars($value['commentaire']));?></div><hr><br><?php
		}?><br><?php
	}	
}	
	else {
			echo 'Aucun article selectionné';
	}
?>

<!-- creation du formulaire pour commentaires -->
			<h4>Rédiger un commentaire</h4>
			<form method="post" action="commentaires.php?valId=<?= $_GET['valId'];?>">
				<label>Auteur : </label><input type="varchar" name="auteur">
				<label>Commentaire : </label><input type="text" name="commentaire">
				<input type="submit">
			</form>
			<a href="index.php" class="retour">Retour</a>
		</section>
    </body>
</html>