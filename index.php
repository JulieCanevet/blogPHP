<?php

try //Connexion a la base de donnees
{
	$bdd = new PDO('mysql:host=localhost;dbname=blogPHP;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
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