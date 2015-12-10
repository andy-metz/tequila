<?php
$id_recette=1;
$id_aliment=25;
// Create connection
$conn = mysqli_connect("127.0.0.1", "root", "", "myDB");
mysqli_set_charset($conn,("UTF8"));

// Create connection



$sql = "select * from recette where idRecette = '".$id_recette."';";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
    $row = $result->fetch_assoc();
    echo $row["LibRecette"];
} 
else 
{
    echo "Pas de résultat";
}
$conn->close();
?> 