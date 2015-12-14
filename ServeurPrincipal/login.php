<?php

    $utilisateurtablename="utilisateur";
    $PSEUDO_MAX_CHAR=20;
    $PSEUDO_MIN_CHAR=3;
    $MDP_MAX_CHAR=48;
    $MDP_MIN_CHAR=8;

    include_once 'loginconfig.php';
    include_once 'session.php';
    include_once 'loginsql.php';

    createUserTable();


    // Première chose à faire:
    // Démarrer la session.
    // L'utilisateur pourras utiliser les services sans avoir besoin de compte'
    startSession();

    // Sert à remplir un champ dans "form login.php" et "form register.php"
    function PostToField($varname)
    {
        if(isset($_POST[$varname]))
        {
            echo '"'.$_POST[$varname].'"';
        }
        else echo '""';
    }

    // permet de traiter les inputs
    foreach($_POST as $input){
        $input=trim($input);
    }

    // Affiche le formulaire de login
    function print_login_form(){
        include 'formlogin.php';
    }

    // Affiche le formulaire d'inscription'
    function print_register_form(){
        include 'formregister.php';
    }


    function formulaireEnregistrement()
    {
        startSession();
        if($_SESSION["connu"]===true){
            printSession();
            echo "Vous &ecirc;tes d&eacute;j&agrave; connect&eacute;(e).</br>\n";
        }
        else{
            if(!isset($_POST["submit_register"]))
            {
                // Afficher le formulaire d'enregistrement
                echo '<div id="form">'."\n";
                        print_register_form();
                echo "</div>";
            }
            else{
                $err=fullCheck($_POST);

                if($err!=""){
                    echo " COUCOU LES AMIS";
                    echo '<div id="form">'."\n";
                            print_register_form();
                            echo $err;
                    echo "</div>";
                }
                else{

                    addRowToUserTable($_POST);
                    login($_POST["mail"],$_POST["mdp"]);
                    printSession();
                }
            }
        }
    }

    // Affiche la session si elle est active
    // Sinon récupère et traite les infos du formulaire de login
    // sinon affiche le formulaire pour s'identifier
    function formulaireIdentification()
    {
        startSession();
        if($_SESSION["connu"]===true)
            printSession();
        else
        {
            if(!isset($_POST["submit_login"]))
                print_login_form();
            else
            {
                $resultat=login($_POST["mail"],$_POST["mdp"]);
                if($resultat===true){
                    printSession();
                    echo "Authentification r&eacute;ussie.</br>\n";
                }
                else{
                    print_login_form();
                    echo "Mauvais mail ou mot de passe.</br>";
                }
            }
        }
    }



    // permet d'afficher les inputs de manière sécurisée.
    // trim déjà réalisé.
    /*foreach($_POST as $input){
        $input=htmlentities($input,ENT_QUOTES|ENT_HTML401);
    }*/


?>
