<?php

    include_once 'loginconfig.php';



    function sessionFillDefault()
    {
        global $varNames;
        foreach($varNames as $name)
            $_SESSION[$name]="Vide";
        $_SESSION["connu"]=false;// connu indique si l'utilisateur est enregistr� dans la bdd ou non.
        $_SESSION["prenom"]="Inconnu(e)";
    }




    // Cr�ee une session si il n'y en a pas
    // D�marre la session si elle est inactive
    function startSession()
    {
        $ss=session_status();
        if($ss===PHP_SESSION_DISABLED)
        { // Cas de la 1ere connection
            //echo"Session DISABLED</br>\n";
            session_start();
            sessionFillDefault();
        }
        // Si il y a une session non active, on la d�marre
        else if($ss===PHP_SESSION_NONE)
        { // Cas des autres connections
            //echo"Session NONE</br>\n";
            session_start();
            if(!isset($_SESSION["connu"]))
                $_SESSION["connu"]=false;
            if($_SESSION["connu"]===false)
            {
                sessionFillDefault();
            }
        }
        // Sinon
        else if($ss===PHP_SESSION_ACTIVE);
        //echo"Session ACTIVE</br>\n";
        // rien � faire
        // cas o� cette fonction est appell�e 2 fois dans le m�me fichier.
    }


    // Affiche un petit truc pour indiquer � l'utilisateur son statut de connexion.
    function printSession()
    {
        startSession();
        echo '<div id ="idsession">'."</br>\n";
            echo "Bienvenue ".$_SESSION["prenom"];
            if($_SESSION["connu"]===true)
                echo " ".$_SESSION["nom"];
            echo "</br>\n";
            if($_SESSION["connu"]===true)
                echo "connect&eacute;</br>\n";
            else
                echo "d&eacute;connect&eacute;</br>\n";
        echo "</div>\n";
    }


    // Rempli le tableau $_SESSION � partir de $array si possible
    // Sinon retourne le message d'arreur
    // D�marre la session si n�c�ssaire
    // Renvoir "" en cas de succ�s, un message d'erreur sinon.
    function fillSession($array)
    {
        startSession();
        $err=fullCheck($array);
        if($err!="")
            return $err;

        if(!isset($array["connu"])){
            sessionFillDefault();
            return "Pofil inconnu.</br>\n";
        }

        if($array["connu"]===false)
        {
            sessionFillDefault();
            return;
        }

        foreach($varNames as $name){
            //echo '$_SESSION['.$name.'] = $array['.$name.'];</br>\n';
            $_SESSION[$name]=$array[$name];
        }
        $_SESSION["connu"]=$array["connu"];

        return "";
    }



?>
