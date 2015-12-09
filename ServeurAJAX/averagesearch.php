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
print_r($id_alim_pos);

check_and_count_child($id_alim_neg);
$id_alim_neg=array_unique($id_alim_neg);
$id_alim_neg=array_values($id_alim_neg);
print_r($id_alim_neg);

// Faire une intersection sur les tableaux , donne l'ensemble propre 
// des aliments voulue
// aller chercher les recettes 

// Comparer score des recettes si celle ci sont visés par les aliments negatif et positifs
// sinon visé que par du positif = note positive
// sinon pesé le pour et le contre
// indexé les id de recette selon ces notes
// display selon les indices de recettes qui sont indexés dans l'ordre


//recuperer les id des recettes
mysqli_close($conn);

?>