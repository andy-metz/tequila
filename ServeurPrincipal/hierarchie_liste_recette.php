<?php
$id_recette=0;
$id_aliment=235;
// Create connection
$conn = mysqli_connect("127.0.0.1", "root", "", "myDB");
mysqli_set_charset($conn,("UTF8"));

// Create connection



$sql = "select r.librecette
from recette r, contient c
where
r.idrecette = c.idrecette
and c.idaliment = '".$id_aliment."';";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
	echo "<table>\n";
    while($row = $result->fetch_assoc()) 
	{
		echo "<tr><td><a href='#ah_liste_recettes'>".$row["librecette"]."</a></td></tr>\n";
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
?> 