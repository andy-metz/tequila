<?php
include_once 'session.php';
startSession();
if(!isset($_POST['libaliment']) )
{
	$libaliment = 'aliment';
	$_SESSION['chemin'] = array($libaliment);
	echo "<button type='button' class='id_super_categorie'>".$_SESSION['chemin'][0]."</button>";
}
else
{
	$libaliment = $_POST['libaliment'];

	$present = False;
	$liste = $_SESSION['chemin'];
	unset($_SESSION['chemin']);
	$_SESSION['chemin'] = array();
	foreach ($liste as $aliment) {

    	echo "<button type='button' class='id_super_categorie'>".$aliment."</button>";	
    	array_push($_SESSION['chemin'], $aliment);    	
		if ($libaliment == $aliment){
			$present = True;
			break;			
		}
	}

	if(!$present){
    	echo "<button type='button' class='id_super_categorie'>".$libaliment."</button>";	
    	array_push($_SESSION['chemin'], $libaliment);

    }

//	$chemin[count()] = $_POST['libaliment'];	
}

// Bouton pour remonter d'un niveau


// Create connection
$conn = mysqli_connect("127.0.0.1", "root", "", "myDB");
mysqli_set_charset($conn,("UTF8"));


function affiche_chemin($libelle)
{
	$conn = mysqli_connect("127.0.0.1", "root", "", "myDB");
	mysqli_set_charset($conn,("UTF8"));



	$conn->close();
}

// requete pour trouver les sous-aliments
$sql = "select af.libaliment
from aliment af, aliment a, estfils f
where  
f.idaliment = a.idaliment 
and a.libaliment = '".$libaliment."' 
and f.id_souscat = af.idaliment order by af.libaliment";
$result = $conn->query($sql);



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
