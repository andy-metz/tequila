<?php 

	$servername ="127.0.0.1";
	$username ="root";
	$password ="";
	$db="myDB";

	$conn = mysqli_connect($servername, $username, $password,$db);

	mysqli_set_charset($conn,("UTF8"));

	$data_recette=$_POST['insertrecette'];

	$data_recette=mysqli_real_escape_string($conn,$data_recette);
	$data_name=$_POST['userinsert'];


	if($data_recette!="")
		{	echo $data_name;
			$sql="INSERT INTO FAVORI (idUser,LibRecette) Values('$data_name','$data_recette')";
			echo $sql;
		}	

	mysqli_query($conn,$sql);

	mysqli_close($conn);

?>