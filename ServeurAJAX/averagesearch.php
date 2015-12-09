<?php


$tab_pos =$_POST['wanted_element'];
$tab_neg=$_POST['forbid_element'];
$conn = mysqli_connect("127.0.0.1", "root", "", "myDB");
mysqli_set_charset($conn,("UTF8"));
foreach($tab_pos as $d)
	{ $d=mysqli_real_escape_string($conn,$d);
	echo "<p class='test' >". $d."<p>";}

foreach($tab_neg as $d)
	{	$d=mysqli_real_escape_string($conn,$d);
		echo "<p class='test' >". $d."<p>";}

// recuperer les ID des aliments bons + leurs fils
// rechercher les fils des données en input et récupérer leurs ids
// compter récursivement les nombres de ligne dans est Pere pour savoir is i l y'a des fils
// trouver toutes les id recettes contenant les id des fils  
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
print_r($id_alim_pos);
// recuperer les ID des aliments mauvais
// rechercher les fils des données en input et récupérer leurs ids
// compter récursivement les nombres de ligne dans est Pere pour savoir is i l y'a des fils
// trouver toutes les id recettes contenant les id des fils  

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
print_r($id_alim_neg);


// faire une fonction qui check si les idaliment sont super catégorie 
// si oui récupérer les id des aliments fils dans un tableau
// et exectuer la fonction récursivement sur chaque fils.
// penser à vérifier l'existence du nbr de ligne dans ESTPERE pour chaque aliment concerné
// celà nous permet de savoir si ils sont Pere ou pas


// faire même chose pour aliments negatif


// Comparer score des recettes si celle ci sont visés par les aliments negatif et positifs
// sinon visé que par du positif = note positive
// sinon pesé le pour et le contre
// indexé les id de recette selon ces notes
// display selon les indices de recettes qui sont indexés dans l'ordre


//recuperer les id des recettes
mysqli_close($conn);

?>