<?php


$tab_pos=$_POST['wanted_element'];
$tab_neg=$_POST['forbid_element'];


$conn = mysqli_connect("127.0.0.1", "root", "", "myDB");
mysqli_set_charset($conn,("UTF8"));

/*======================

	FONCTION D'EXPLORATION DES FILS SUR LA BASE DONNEE

======================*/
function check_and_count_child(&$tab)
{	$conn = mysqli_connect("127.0.0.1", "root", "", "myDB");
	mysqli_set_charset($conn,("UTF8"));

	$size=count($tab);
	$result_find=array();

	for ($i=0;$i<$size;$i++)	
	{
	$data=$tab[$i];
	$data=mysqli_real_escape_string($conn,$data);
	$sql="SELECT `idAliment` 
	FROM `ESTPERE`
	WHERE `id_SuperCat`='$data'";
	$query=mysqli_query($conn,$sql);

	$nb_rows=mysqli_num_rows($query);
		if($nb_rows>0)
		{	while($id_result_temp=mysqli_fetch_assoc($query))
			{
				$result_find_temp=$id_result_temp['idAliment'];
				array_push($result_find,$result_find_temp);
			}

			check_and_count_child($result_find);

			$result_find=array_unique($result_find);
			$result_find=array_values($result_find);
			$size_result_find=count($result_find);

			for($j=0;$j<$size_result_find;++$j)
			{	array_push($tab,$result_find[$j]);
			}
		}
	}	
mysqli_close($conn);
}


/*
	AFFICHAGE  des resultats d'autocomplétion

	Faire les contrôles de saisies,
	si wanted_element[i]=forbid_element[i] remplacer par "";
	si wanted_element[i] ou forbid_element[i] = Aliment remplacer par "";
*/

foreach($tab_pos as $d)
	{ $d=mysqli_real_escape_string($conn,$d);
	echo "<p class='test' >". $d."<p>";}

foreach($tab_neg as $d)
	{	$d=mysqli_real_escape_string($conn,$d);
		echo "<p class='test' >". $d."<p>";}

$id_alim_pos=array();
$size=count($tab_pos);
for( $i=0;  $i<$size ; ++$i)
{	
	if($tab_pos[$i]!="")	
	{	$data=$tab_pos[$i];
		$data=mysqli_real_escape_string($conn,$data);
		$sql="SELECT `idAliment`
		FROM `ALIMENT`
		WHERE `LibAliment`='$data'";
		$query=mysqli_query($conn,$sql);
		
		while($id_alim_trouve=mysqli_fetch_assoc($query))
		{
			$result=$id_alim_trouve['idAliment'];
			array_push($id_alim_pos,$result);
		}

		
	}

}

$id_alim_neg=array();
$size=count($tab_neg);
for( $i=0;  $i<$size ; ++$i)
{	if($tab_neg[$i]!="")
	{	$data=$tab_neg[$i];
		$data=mysqli_real_escape_string($conn,$data);

		$sql="SELECT `idAliment`
		FROM `ALIMENT`
		WHERE `LibAliment`='$data'";
		$query=mysqli_query($conn,$sql);

		while($id_alim_trouve=mysqli_fetch_assoc($query))
		{
			$result=$id_alim_trouve['idAliment'];
			array_push($id_alim_neg,$result);
		}
			
	}
}
/*$id_alim_neg=array_unique($id_alim_neg);*/

check_and_count_child($id_alim_pos);
$id_alim_pos=array_unique($id_alim_pos);
$id_alim_pos=array_values($id_alim_pos);

echo "<br>";
check_and_count_child($id_alim_neg);
$id_alim_neg=array_unique($id_alim_neg);
$id_alim_neg=array_values($id_alim_neg);

echo"<br>";

$tab_res_final=array_diff($id_alim_pos,$id_alim_neg);

// fonction qui cherche les recettes potentiellement acceptable
// génère des doublons dans le tableau
function check_recette($id_alim)
{
	$conn = mysqli_connect("127.0.0.1", "root", "", "myDB");
	mysqli_set_charset($conn,("UTF8"));

	$recette_find=array();
	$size=count($id_alim);

	for($i=0;$i<$size;$i++)
	{
		$data=$id_alim[$i];
		$data=mysqli_real_escape_string($conn,$data);

		$sql="SELECT `idRecette`
		FROM CONTIENT
		WHERE `idAliment`='$data'";
		$query=mysqli_query($conn,$sql);

		while($id_recette_trouve=mysqli_fetch_assoc($query))
		{	$result=$id_recette_trouve['idRecette'];
			array_push($recette_find,$result);
		}
	}
	mysqli_close($conn);
	return $recette_find;
}

//Fonction qui retire les recettes qui possèdent des aliments non désiré du tableau recette
function validation_recette(&$id_recette,$id_forbid_alim)
{	$conn = mysqli_connect("127.0.0.1", "root", "", "myDB");
	mysqli_set_charset($conn,("UTF8"));

	$size_forbid_alim=count($id_forbid_alim);
	$size_recette=count($id_recette);
	
	for($i=0;$i<$size_recette;$i++)
	{	
			
				$tab_alim_recette=array();
				$data=mysqli_real_escape_string($conn,$id_recette[$i]);

				$sql="SELECT `idAliment`
					FROM CONTIENT
					WHERE `idRecette`='$data'";
					$query=mysqli_query($conn,$sql);

				while($id_alim_recette=mysqli_fetch_assoc($query))
				{	$result=$id_alim_recette['idAliment'];
					array_push($tab_alim_recette,$result);
				}

				for($j=0;$j<$size_forbid_alim;$j++)
				{	
					if(in_array($id_forbid_alim[$j],$tab_alim_recette))
					{		//array_splice($id_recette,1,2);
							unset($id_recette[$i]);
							$id_recette=array_values($id_recette);
							$size_recette=count($id_recette);
					}
				}	

				

			//array_values($id_recette);	
	}
	mysqli_close($conn);
}
$tab_res_final=array_values($tab_res_final);
$recette=check_recette($tab_res_final);
$recette=array_unique($recette);
$recette=array_values($recette);

echo"<br>";
print_r($recette);
validation_recette($recette,$id_alim_neg);

echo"<br>";
print_r($recette);

//$recette contient les recettes propres
// fonction qui recoit l'id d'un recette 
// attribuant une note selon la proportion d'élément présent et voulue dans la recette
/*
function put_notation($recette)
{

}*/

// Comparer score des recettes si celle ci sont visés par les aliments negatif et positifs
// sinon visé que par du positif = note positive
// sinon pesé le pour et le contre
// indexé les id de recette selon ces notes
// display selon les indices de recettes qui sont indexés dans l'ordre


//recuperer les id des recettes
mysqli_close($conn);

?>