<?php

	$servername ="127.0.0.1";
	$username ="root";
	$password ="";
	$db="myDB";
//	$sql = "CREATE DATABASE IF NOT EXISTS myDB";

    include'Donnees.inc.php';

	$conn = mysqli_connect($servername, $username, $password);

mysqli_set_charset($conn,("UTF8"));
// Check connection
if (!$conn) {
    die(" Echec connection : " . mysqli_connect_error());
}

// creation base de données

$sql = "CREATE DATABASE IF NOT EXISTS myDB ;";

if(!mysqli_query($conn,$sql))
{/*echo '<p class="erreur" >'."erreur creation database" . mysqli_error($conn) .'</p>';*/
} 

$conn = mysqli_connect($servername, $username, $password,$db);


//changement de la base en utf 8
$sql="ALTER DATABASE myDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
if (!mysqli_query($conn, $sql)){
 /*echo " erreur utf 8 " . mysqli_error($conn);*/
}

//===============
//
// Creation table recette + INDEX+ UTF8+ gestion erreur
//
//===============

$sql ="CREATE TABLE IF NOT EXISTS RECETTE(
idRecette int NOT NULL AUTO_INCREMENT PRIMARY KEY,     
LibRecette VARCHAR(100) NOT NULL UNIQUE,
ingredients VARCHAR(250) NOT NULL,
preparation VARCHAR(1000) NOT NULL
)
";
if (!mysqli_query($conn, $sql)) {
    /* echo '<p class="erreur" >'."Erreur creation RECETTE: " . mysqli_error($conn).'</p>';*/
} 

$sql="CREATE INDEX index_recette ON RECETTE (LibRecette)";

if (!mysqli_query($conn, $sql)) {
     /*echo '<p class="erreur" >'."Erreur INDEX RECETTE: " . mysqli_error($conn).'</p>';*/
} 

$sql="ALTER TABLE RECETTE CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
if (!mysqli_query($conn, $sql)){
  /*echo " erreur utf 8 " . mysqli_error($conn);*/
} 
//===============
//
// Creation table Aliment + INDEX + gestion utf8 +gestion erreur
//
//===============

$sql="CREATE TABLE  IF NOT EXISTS ALIMENT(
idAliment int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
LibAliment VARCHAR(40) NOT NULL UNIQUE 
)";

if (!mysqli_query($conn, $sql)) {
    /* echo '<p class="erreur">'."Erreur creation ALIMENT: " . mysqli_error($conn).'</p>';*/
} 

$sql="CREATE INDEX index_aliment on ALIMENT (LibAliment)";

if (!mysqli_query($conn, $sql)) {
  /* echo '<p class="erreur" >'."Erreur INDEX ALIMENT: " . mysqli_error($conn).'</p>';*/
} 

// Changement de la table en utf 8
$sql="ALTER TABLE ALIMENT CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

if (!mysqli_query($conn, $sql)){
/* echo " erreur utf 8 " . mysqli_error($conn)*/;
} 

//===============
//
// Creation table Contient + gestion erreur
// 
//===============

$sql="CREATE TABLE  IF NOT EXISTS CONTIENT(
idAliment int REFERENCES ALIMENT(idAliment),
idRecette int REFERENCES RECETTE(idRecette),
CONSTRAINT recette_a_pour_aliment PRIMARY KEY(idAliment, idRecette)
)
";
if (!mysqli_query($conn, $sql)) {
    /* echo '<p class="erreur">'."Erreur creation CONTIENT: " . mysqli_error($conn).'</p>'*/;
} 

//===============
//
// Creation table ESTFILS + gestion erreur
//
//===============

$sql="CREATE TABLE IF NOT EXISTS ESTFILS(
idAliment int REFERENCES ALIMENT(idAliment),
id_SousCat int,
CONSTRAINT alim_a_pour_pere PRIMARY KEY(idAliment, id_SousCat)
)
";

if (!mysqli_query($conn, $sql)) {
   /*echo '<p class="erreur">'."Erreur creation ESTFILS: " . mysqli_error($conn).'</p>'*/;
}


//===============
//
// Creation table ESTPERE + gestion erreur
//
//===============

$sql="CREATE TABLE IF NOT EXISTS ESTPERE(
idAliment int ,
id_SuperCat int,
/*FOREIGN KEY(idAliment) REFERENCES ALIMENT(idAliment),    complété l'intégrité de la base*/
CONSTRAINT alim_a_pour_fils PRIMARY KEY(idAliment, id_SuperCat)
)
";

if (!mysqli_query($conn, $sql)) {
   /* echo '<p class="erreur">'."Erreur creation ESTFILS: " . mysqli_error($conn).'</p>'*/;
} 


$sql ="CREATE TABLE IF NOT EXISTS FAVORI(
	idUser VARCHAR(100) NOT NULL REFERENCES UTILISATEUR(nom),     
	LibRecette VARCHAR(200) NOT NULL REFERENCES RECETTE(LibRecette),
	CONsTRAINT user_a_pour_favori PRIMARY KEY (idUser,LibRecette) 
	)
	";
if(!mysqli_query($conn,$sql)){
	/* echo '<p class="erreur">'."Erreur creation ESTFILS: " . mysqli_error($conn).'</p>'*/;
}


//on parcourt $hierarchie ( le tableau d'aliment)
foreach($Hierarchie as $nom =>$description_categorie){

    $nomalim=mysqli_real_escape_string($conn,utf8_decode($nom));  
    // Insertion des aliments dans ALIMENT
    $sql="INSERT IGNORE INTO ALIMENT (LibAliment) VALUES('$nomalim');";

    if(!mysqli_query($conn, $sql))
    {  /* echo'<p class="erreur" >'." Erreur Insertion ALiment " . mysqli_error($conn).'</p>';*/ }    

}


foreach($Hierarchie as $nom =>$description_categorie)
{    
    $nomalim=mysqli_real_escape_string($conn,utf8_decode($nom));
    $tab_description_categorie=array($description_categorie);
  
    foreach($tab_description_categorie as $tab_categories)
    {   // on parcourt les deux sous tableaux de categories grâce à $tab_categories
        //====        
        foreach($tab_categories as $type_categorie => $info_categorie)
        { 
        // typ_categorie contient sous-categorie ou super -categorie
        //======
        // info categorie est le tableau qui contient les aliments
        // qui sont des sous cateogire/supercategories
        //===
        // on va voir dans $info_categorie qui est le tableau qui contient 
        // les super ou les sous categorie selon le tableau où l'on se trouve
       
            $sql="SELECT idAliment , LibAliment
            FROM  `aliment` 
            WHERE LibAliment = '$nomalim'";
            
            $id_alim = mysqli_query($conn, $sql);     
            // à faire seulement si $id_alima au moins un colonne mysqli_num_rows($id_alim) > 0
            $res_id = mysqli_fetch_assoc($id_alim) ;  
            $id_trouve=$res_id['idAliment'];

            if(strcmp($type_categorie,'sous-categorie')==0)
            {   
                foreach($info_categorie as $nom_ss_categorie)
                {
                 $nom_ss_categorie=mysqli_real_escape_string($conn,utf8_decode($nom_ss_categorie));                      
                 $sql="SELECT idAliment,LibAliment
        		    FROM ALIMENT
         		   WHERE LibAliment='$nom_ss_categorie'";
         		   $id_ss_cat=mysqli_query($conn,$sql);

         		   $res_id_cat=mysqli_fetch_assoc($id_ss_cat);

         		   $id_cat=$res_id_cat['idAliment'];

                 $sql="INSERT IGNORE INTO ESTFILS (idAliment,id_SousCat) VALUES ( '$id_trouve' ,'$id_cat')";

                    if(!mysqli_query($conn,$sql))
                    {   /* echo  '<p class="erreur">' . mysqli_error($conn).'</p>'*/;                          
                    }                                                       
                }
            }  
            if(strcmp($type_categorie,'super-categorie')==0)  
            {
                foreach($info_categorie as $nom_sp_categorie)
                {	
                	$nom_sp_categorie=mysqli_real_escape_string($conn,utf8_decode($nom_sp_categorie));
                	$sql="SELECT idAliment,LibAliment
        		    FROM ALIMENT
         		   WHERE LibAliment='$nom_sp_categorie'";

         		   $id_sp_cat=mysqli_query($conn,$sql);
         		   $res_id_cat=mysqli_fetch_assoc($id_sp_cat);
         		   $id_cat=$res_id_cat['idAliment'];
                    

                    $sql="INSERT IGNORE INTO ESTPERE(idAliment,id_SuperCat) VALUES('$id_trouve','$id_cat') ";

                    if(!mysqli_query($conn,$sql))
                    {   /* echo  '<p class="erreur">' . mysqli_error($conn).'</p>'*/;                          
                    }    
                }    
            } 
        } 
    }
} 

// fonction pour recette

foreach($Recettes as $array_recette_courante)
{
	$recette=array($array_recette_courante);
	
		foreach($recette as $contenu)
		{		$titre="";
				$ingredients="";
				$preparation="";
					foreach($contenu as $libelle=>$info)
					{
					//$libelle représente le type d' information titre||ingredients||preparations||titre
								if(strcmp($libelle,'titre')==0)
								{ // recuperation pour variable $titre
									$titre=mysqli_real_escape_string($conn,utf8_decode($info));								
								}
								if(strcmp($libelle,'ingredients')==0)
								{// recuperation pour variable $ingredients	
									$ingredients=mysqli_real_escape_string($conn,utf8_decode($info));
								}	
								if(strcmp($libelle,'preparation')==0)
								{	// recuperation pour variable $preparation
									$preparation=mysqli_real_escape_string($conn,utf8_decode($info));
								}
					}	
		$sql="INSERT IGNORE INTO RECETTE (LibRecette,ingredients,preparation) VALUES('$titre','$ingredients','$preparation')";	
			if(!mysqli_query($conn,$sql));
			{	/* echo  '<p class="erreur">' . mysqli_error($conn).'</p>'*/; 				
			}
		}
}  


// fonction pour remplir contient

foreach($Recettes as $array_recette_courante) 
{
	$recette=array($array_recette_courante);
	
	foreach($recette as $contenu)
	{	
		
		foreach($contenu as $libelle => $array_aliment_recette)
		{//$libelle représente le type d' information titre||ingredients||preparations||titre
		
			if((strcmp($libelle,'titre')==0))
			{ //recuperation pour variable $titre		  
			$titre=mysqli_real_escape_string($conn,utf8_decode($array_aliment_recette));		
			$LibRecette=$titre;	
			$sql="SELECT idRecette , LibRecette
            FROM  `RECETTE` 
            WHERE LibRecette = '$LibRecette'";
			
			$id_recette=mysqli_query($conn,$sql);
			$res_id_recette = mysqli_fetch_assoc($id_recette) ;  
            $id_recette_trouve=$res_id_recette['idRecette'];
					
			}
		
			if(strcmp($libelle,'index')==0)
			{		
				foreach($array_aliment_recette as $aliment_recette)
				{
					$LibAliment=mysqli_real_escape_string($conn,utf8_decode($aliment_recette));
					
					
					$sql="SELECT idAliment , LibAliment
					FROM ALIMENT
					WHERE LibALiment='$LibAliment'";
					
					
					$id_aliment= mysqli_query($conn,$sql);
					$res_id_aliment= mysqli_fetch_assoc($id_aliment);
					$id_aliment_trouve=$res_id_aliment['idAliment'];
					
					$sql="INSERT IGNORE INTO CONTIENT(idALiment,idRecette) VALUES('$id_aliment_trouve','$id_recette_trouve')";
					
					if(!mysqli_query($conn,$sql))
					{	/* echo  '<p class="erreur">' . mysqli_error($conn).'</p>'*/; 				
					}
				}
			}			
		}
	}	
}
/*
$sql="DROP DATABASE myDB";
 mysqli_query($conn,$sql);*/

mysqli_close($conn);

	
?>