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
<?php

try //Connexion a la base de donnees
{
	$bdd = new PDO('mysql:host=localhost;dbname=blogPHP;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
?>

<form method="post" action="index.php">
	<label>Titre : </label><input type="varchar" name="titre">
	<label>Article : </label><input type="text" name="contenu">
	<input type="submit">
</form>
<?php
if(!empty($_POST['titre']) && !empty($_POST['contenu'])){

$titre = htmlspecialchars($_POST['titre']);
$contenu = htmlspecialchars($_POST['contenu']);

	$req = $bdd -> prepare('INSERT INTO billets (id, titre, contenu, date_creation) VALUES ("", :titre, :contenu, "")');
	$req -> execute(array('titre' => $titre,
							'contenu' => $contenu
		));
}

// On récupere les 5 derniers articles
$articles = $bdd -> query('SELECT * FROM billets ORDER BY id DESC LIMIT 0, 5');
// On affiche les titres et le contenu des articles
	foreach ($articles as $key => $value) {

		?>
		<h3><?php echo $value['titre'];?></h3>
		<p><?php echo $value['contenu'];?></p>
		<a href="commentaires.php?valId=<?php echo $value['id']; ?>">Commentaires</a><br><br>
		<?php 
	}
?>
   </body>
</html>