<?php
if(!isset($_POST['libaliment']))
{
	$libaliment = 'aliment';
	$chemin = 'aliment';
}
else
{
	$libaliment = $_POST['libaliment'];

	$chemin = $_POST['libaliment'];	
}

// Create connection
$conn = mysqli_connect("127.0.0.1", "root", "", "myDB");
mysqli_set_charset($conn,("UTF8"));

// DSINTGNER DEUX BOUTONS : 1 DIAPLY PERE, 1 DISPLAY COURANT, + AFFICHAGE LISTE_FILS(DEJA IMPLEMENTE)

// requete pour trouver les sous-aliments
$sql = "select af.libaliment
from aliment af, aliment a, estfils f
where  
f.idaliment = a.idaliment 
and a.libaliment = '".$libaliment."' 
and f.id_souscat = af.idaliment order by af.libaliment";
$result = $conn->query($sql);

// Bouton pour remonter d'un niveau
echo "<button type='button' class='id_super_categorie'>".$chemin."</button>";

if ($result->num_rows > 0) 
{	$id=0;

	echo "<table>\n";
    while($row = $result->fetch_assoc()) 
	{	$id=$id+1;
		$id_button="sous_categorie".$id;
		echo "<tr><td><a class='".$id_button."' href='#ah_liste_recettes'>".$row["libaliment"]."</a></td><td><button type='button' class='".$id_button."'>Voir les sous-catégories</button></td></tr>\n";
	}	
	echo "</table>";	
} 
else 
{
    echo "Pas de résultat";
}
$conn->close();
?> 
