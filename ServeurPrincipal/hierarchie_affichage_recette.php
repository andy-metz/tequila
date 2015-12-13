<?php


if(isset($_POST['librecette']))
{
$librecette = $_POST['librecette'];
// Create connection
$conn = mysqli_connect("127.0.0.1", "root", "", "myDB");
mysqli_set_charset($conn,("UTF8"));

// Create connection



$sql = "select * from recette r where LibRecette = '".$librecette."';";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
    $row = $result->fetch_assoc();
    echo "<h1>".$row["LibRecette"]."</h1>";
    $ingredients = str_replace("|", "<br>", $row["ingredients"]);
    echo $ingredients."<br><br>";    
    echo $row["preparation"]."<br>"; 
    $path_photo = str_replace(" ", "_", $row["LibRecette"]);
    echo "<img src='Photos/".$path_photo.".jpg' alt='cocktail' style='width:304px;height:228px;'>";

} 
else 
{
    echo "Pas de résultat";
}
$conn->close();
}
?> 