<?php


if(isset($_POST['libaliment']))
{
$libaliment = $_POST['libaliment'];


// Create connection
$conn = mysqli_connect("127.0.0.1", "root", "", "myDB");
mysqli_set_charset($conn,("UTF8"));

// Create connection



$sql = "select r.librecette
from recette r, contient c, aliment a
where
r.idrecette = c.idrecette
and a.idaliment = c.idaliment
and a.libaliment = '".$libaliment."';";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
	echo "<table>\n";
    while($row = $result->fetch_assoc()) 
	{
		echo "<tr><td><a href='#ah_liste_recettes' class='affichage_recette'>".$row["librecette"]."</a></td></tr>\n";
		//echo "<option value='".$row["LibRecette"]."'></option>\n";
		//echo $row["LibRecette"];
	}	
	echo "</table>";	
} 
else 
{
    echo "Pas de résultat";
}
$conn->close();
}
?> 