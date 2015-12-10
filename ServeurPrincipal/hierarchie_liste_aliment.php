<?php
$id_recette=0;
// Create connection
$conn = mysqli_connect("127.0.0.1", "root", "", "myDB");
mysqli_set_charset($conn,("UTF8"));

// Create connection



$sql = "select af.libaliment
from aliment af, aliment a, estfils f
where  
f.idaliment = a.idaliment 
and a.libaliment = 'Aliment' 
and f.id_souscat = af.idaliment order by af.libaliment";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
	echo "<table>\n";
    while($row = $result->fetch_assoc()) 
	{
		echo "<tr><td><a href='#ah_liste_recettes'>".$row["libaliment"]."</a></td></tr>\n";
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