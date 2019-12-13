<!doctype html> 
<html>
	<head> 
		<meta charset="utf-8">
		<link rel="stylesheet" href="comment.css">
		<link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
		<title>Commentaires</title>
	</head> 
	<body>

		<?php
			$lien=mysqli_connect("localhost","root","","tp_commentaires");

			if(isset($_POST['envoyer']))
			{
				$nom=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['nom'])));
				$contenu=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['contenu'])));
				$req="INSERT INTO comment VALUES (NULL,'$nom','$contenu')";
				$res=mysqli_query($lien,$req);
				if(!$res)
				{
					echo "Erreur SQL:$req<br>".mysqli_error($lien);
				}
			}
			
			if(!isset($_GET['page']))
			{
				$page=1;
			}
			else
			{
				$page=$_GET['page'];
			}
			$commparpage=4;
			$premiercomm=$commparpage*($page-1);
			$req="SELECT * FROM comment ORDER BY id LIMIT $premiercomm,$commparpage";/* LIMIT dit ou je commence et combien j'en prends*/
			$res=mysqli_query($lien,$req);
			
			if(!$res)
			{
				echo "erreur SQL:$req<br>".mysqli_error($lien);
			}
			else
			{
				echo "<img src='affiche.png'>
				<p id='synopsis'>Le Titan Thanos, ayant réussi à s'approprier les six Pierres d'Infinité et à les réunir sur le Gantelet doré, a pu réaliser son objectif de pulvériser la moitié de la population de l'Univers. Cinq ans plus tard, Scott Lang, alias Ant-Man, parvient à s'échapper de la dimension subatomique où il était coincé. Il propose aux Avengers une solution pour faire revenir à la vie tous les êtres disparus, dont leurs alliés et coéquipiers : récupérer les Pierres d'Infinité dans le passé.</p>";
				while($tableau=mysqli_fetch_array($res))
				{
					echo "<div class='comment'><h2>".$tableau['nom']." <span class='text'>a écrit :</span></h2>";
					echo "<p>".$tableau['contenu']."</p></div>";
				}
			}
			
			$req="SELECT * FROM comment";
			$res=mysqli_query($lien,$req);
			$nbcomm=mysqli_num_rows($res); // Retourne le nombre de lignes dans un résultat. 
			$nbpages=ceil($nbcomm/$commparpage); /*Ceil arrondit a l'entier supérieur*/

			if(!$res) {
				echo "Erreur SQL:$req<br>".mysqli_error($lien);
			}
			else {
				echo "<div id='pages'>Page <b>".$page."</b>/".$nbpages;
				echo "<div id='pagination'>";

				if ($page >= 2) {
					echo "<b><a href='commentaires.php?page=1'> << </a>";
					echo "<a href='commentaires.php?page=".($page-1)."'> < </a></b>";
				}

				for($i=($page-2);$i<=($page+2);$i++) {

					if ($i >= 1 & $i <= $nbpages){

						if($i == $page) {
							echo "<strong>".$i."</strong>";
						}
						else {
							echo "<a href='commentaires.php?page=$i'> $i </a>";
						}
					}
				}

				if ($page <= ($nbpages-1)) {
					echo "<b><a href='commentaires.php?page=".($page+1)."'> > </a>";
					echo "<a href='commentaires.php?page=$nbpages'> >> </a></b></div></div>";
				}

			}

			

			
			mysqli_close($lien);
		?>	
		<div id="form">
			<h2 class="center">Laissez votre avis :</h2>
			<form method="POST">
				<label>Votre nom : <br><input type="text" name="nom"></label><br>
				<label>Votre commentaire : <br><textarea name="contenu"></textarea></label><br>
				<input type="submit" value="Envoyer" name="envoyer">
			</form>
		</div>

	</body>
</html>