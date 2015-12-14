<?php

    include_once 'loginconfig.php';

    $servname="localhost";
    $dbname="myDB";
    $user="root";
    $mdp="";

    $tablename="utilisateur";

    $creationRequest=
    // CREATE DATABASE IF NOT EXISTS ".$dbname.";
    "
        CREATE TABLE IF NOT EXISTS ".$tablename."
        (
            mail VARCHAR(".$MINMAX["mail"]["max"].") NOT NULL,
            mdp VARCHAR(64) NOT NULL,

            nom VARCHAR(".$MINMAX["nom"]["max"].") NOT NULL,
            prenom VARCHAR(".$MINMAX["prenom"]["max"].") NOT NULL,
            sexe ".$sexeSqlType." NOT NULL,
            naissance DATE NOT NULL,
            adresse VARCHAR(".$MINMAX["adresse"]["max"].") NOT NULL,
            codepostal VARCHAR(".$MINMAX["code postal"]["max"].") NOT NULL,
            ville VARCHAR(".$MINMAX["ville"]["max"].") NOT NULL,
            PRIMARY KEY(mail)
        )
    ";

    function customHash($value){
        return hash("sha256",$value,false);
    }


    function createUserTable(){
        global $servname,$user, $mdp, $dbname,$creationRequest;
        $mysqli = new mysqli($servname, $user, $mdp, $dbname);
        if($mysqli->connect_errno > 0){
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }
        if($mysqli->query($creationRequest)===null);
        //    print_r($mysqli->array_list);

        $mysqli->close();
    }


    function resetUserTable(){
        global $tablename,$servname,$user, $mdp, $dbname;
        $request="DROP TABLE ".$tablename.";";
        $mysqli = new mysqli($servname, $user, $mdp, $dbname);
        if($mysqli->connect_errno > 0){
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }
        if($mysqli->query($request)===null);
            //print_r($mysqli->array_list);
        $mysqli->close();
    }




    // met $_SESSION["connu"] à true en cas de succès.
    function login($mail,$usermdp)
    {
        global $varNames, $servname, $user, $mdp, $dbname, $tablename;
        // inutile
        //foreach($varNames as $name)
        //    $_SESSION[$name]=html_entity_decode($_SESSION[$name]);
        $query="SELECT * FROM ".$tablename." WHERE ".
        'mail="'.$mail.'" AND mdp="'.customHash($usermdp).'";';
        createUserTable();
        $mysqli = new mysqli($servname, $user, $mdp, $dbname);
        if($mysqli->connect_errno > 0){
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $resultat=$mysqli->query($query);
        if($resultat===false){
            echo"Error: query failed. contact your administrator. (Or stop trying hacking database)</br>\n    ";
            //echo $query."</br>\n";
            //print_r($mysqli->error_list);
            return;
        }

        /*echo "login debug infos:</br>\n";
        echo "login with ".$mail." and ".$usermdp."</br>\n";
        echo $query."</br>\n";
        echo "Login found with ".($resultat->field_count)." fields, got ".($resultat->num_rows)." rows: ";*/

        if($resultat->num_rows>1){
            echo "Database collision error, ask your administrator.</br>\n";
            $mysqli->close();
            return false;
        }

        if($resultat->num_rows<1){
            //echo "Mauvais login et/ou mot de passe.</br>\n";
            $mysqli->close();
            return false;
        }

        $ligne=$resultat->fetch_assoc();
        //print_r($ligne);




        $mysqli->close();


        if($ligne==false) // échec de connection
            return false; // mauvais pseudo et/ou mot de passe

        // Connection réussie
        $_SESSION["mail"]=$ligne["mail"];
        $_SESSION["connu"]=true;
        $_SESSION["nom"]=$ligne["nom"];
        $_SESSION["prenom"]=$ligne["prenom"];
        $_SESSION["sexe"]=$ligne["sexe"];
        $_SESSION["naissance"]=$ligne["naissance"];
        $_SESSION["adresse"]=$ligne["adresse"];
        $_SESSION["codepostal"]=$ligne["codepostal"];
        $_SESSION["ville"]=$ligne["ville"];

        return true;
    }





    function addRowToUserTable($array)
    {   print_r($array);

        global $varNames, $servname, $user, $mdp, $dbname, $tablename;
        foreach($varNames as $name)
            $array[$name]=htmlentities($array[$name]);
        createUserTable();
        $mysqli = new mysqli($servname, $user, $mdp, $dbname);
        if($mysqli->connect_errno > 0){
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }
        $query="INSERT INTO ".$tablename.
        "(mail,mdp,nom,prenom,sexe,naissance,adresse,codepostal,ville)".
        "VALUES ('".
        $array["mail"]."','".
        customHash($array["mdp"])."','".
        $array["nom"]."','".
        $array["prenom"]."','".
        $array["sexe"]."','".
        $array["naissance"]."','".
        $array["adresse"]."','".
        $array["codepostal"]."','".
        $array["ville"].
        "')";

        //echo "addRowToUserTable got </br>".$array["mdp"]." and set </br>\n".customHash($array["mdp"])." in the database.</br>\n";


        $result=$mysqli->query($query);
        if($result===false)
        {
            echo "Unable to add user tu user table.</br>\n";
            //echo "query: ".$query;
            //print_r($mysqli->error_list);
        }
        login($array["mail"],$array["mdp"]);
    }

 ?>
