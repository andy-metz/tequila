<?php

	$servername ="127.0.0.1";
	$username ="root";
	$password ="";
	$db="myDB";

	$conn = mysqli_connect($servername, $username, $password,$db);

	mysqli_set_charset($conn,("UTF8"));

	$rec_to_delete=mysqli_real_escape_string($conn,$_POST['recette_to_delete']);
	$in_user=$_POST['user_id'];


	$sql="DELETE FROM `FAVORI` WHERE idUser='$in_user' AND `LibRecette`='$rec_to_delete'";

	mysqli_query($conn,$sql);
	mysqli_close($conn);
?>