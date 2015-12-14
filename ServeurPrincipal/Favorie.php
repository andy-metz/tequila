<?php
	$user=$_SESSION['nom'];
	echo "<p> Cliquer sur le bouton pour ajouter vos favoris </p>"."<div class='iduserfavori'><p>".$user."</p></div>";
	echo "<div><input type='text' name='SearchInputFavori' class='autocomplete_button'></div>";

	echo"<div><input type='submit' value='Ajouter au favoris' id='SubmitFavori' ></div>";


	$class="display_div_favori";
	echo "<div class=".$class.">";
	$conn = mysqli_connect($servername, $username, $password,$db);
	mysqli_set_charset($conn,("UTF8"));
	


	$sql="SELECT `LibRecette` FROM `FAVORI` WHERE `idUser`='$user'";

	$query=mysqli_query($conn,$sql);
	echo "Vos favoris";
	while($result=mysqli_fetch_assoc($query))
	{	
		echo"<p>";
		$display=$result['LibRecette'];
		echo $display;
		echo"</p>";
	}


	echo "<div><input type='submit' value='Supprimer un favoris' id='DeleteFavori'></div>";
	echo "<div><input type='text' name='SearchInputDeleteFavori' class='autocomplete_button'></div>";

  	mysqli_close($conn);

	echo"</div>";
?>