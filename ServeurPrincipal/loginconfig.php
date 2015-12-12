<?php
    define('femme',"h");
    define('homme',"f");
    $sexeSqlType="VARCHAR(1)";

    // nom prenom mail sexe naissance adresse codepostal ville

    // Définit les tailles des chaines de caractères
    $MINMAX=array(
        "mot de passe"=>array("min"=>8,"max"=>20),
        "nom"=>array("min"=>2,"max"=>25),
        "prenom"=>array("min"=>2,"max"=>25),
        "mail"=>array("min"=>5,"max"=>100),
        "date de naissance"=>array("min"=>10,"max"=>10),
        "adresse"=>array("min"=>8,"max"=>40),
        "code postal"=>array("min"=>5,"max"=>5),
        "ville"=>array("min"=>2,"max"=>40)
    );
    $varNames=array(
        "mdp","mail","nom","prenom","sexe",
        "naissance","adresse","codepostal","ville"
    );



    $errmsg="";


    // Toute fonction de test qui renvoie false
    // laisse un message d'erreur dans errmsg,
    // plus pratique pour tester le résultat.

    function checkSize($value,$name)
    {
        global $MINMAX,$errmsg;
        $size=strlen($value);
        if($size>=$MINMAX[$name]["min"]||$size<=$MINMAX[$name]["max"])
            return true;
        $errmsg=$errmsg.$name." doit etre compris entre ".$MINMAX[$name]["min"].
                " et ".$size>$MINMAX[$name]["max"].".</br>\n";
        return false;
    }

    function testMotDePasse($mdp)
    {
        global $MINMAX,$errmsg;
        if(!checkSize($mdp,"mot de passe"))
            return false;
        if(!preg_match("#[a-z]#",$mdp))
        {
            $errmsg=$errmsg."Le mot de passe doit contenir au moins une majuscule.</br>\n";
            return false;
        }
        if(!preg_match("#[A-Z]#",$mdp))
        {
            $errmsg=$errmsg."Le mot de passe doit contenir au moins une minuscule.</br>\n";
            return false;
        }
        if(!preg_match("#[0-9]#",$mdp))
        {
            $errmsg=$errmsg."Le mot de passe doit contenir au moins un chiffre.</br>\n";
            return false;
        }
        if(preg_match("#[^a-zA-Z0-9]#",$mdp))
        {
            $errmsg=$errmsg."Le mot de passe ne doit pas contenir de caract&egrave;res sp&eacute;ciaux.</br>\n";
            return false;
        }
        return true;
    }

    function testNom($nom)
    {
        global $MINMAX,$errmsg;
        if(!checkSize($nom,"nom"))
            return false;
        if(preg_match("#^[A-Za-zéèêàâôöçäœù ]*$#",$nom))
            return true;
        $errmsg=$errmsg."Le nom ne doit pas contenir de caract&egrave;res sp&eacute;ciaux.</br>\n";
        return false;
    }

    function testPrenom($prenom)
    {
        global $MINMAX,$errmsg;
        if(!checkSize($prenom,"prenom"))
            return false;
        if(preg_match("#^[A-Za-zéèêàâôöçäœù ]*$#",$prenom))
            return true;
        $errmsg=$errmsg."Le pr&eacute;nom ne doit pas contenir de caract&egrave;res sp&eacute;ciaux.</br>\n";
        return false;
    }

    function testMail($mail)
    {
        global $MINMAX,$errmsg;
        if(!checkSize($mail,"mail"))
            return false;
        if(!(filter_var($mail,FILTER_VALIDATE_EMAIL,null)===false))
            return true;
        $errmsg=$errmsg."Adresse mail non valide. </br>\n";
        return false;
    }

    function testSexe($sexe)
    {
        global $errmsg;
        if($sexe==homme||$sexe==femme)
            return true;
        $errmsg=$errmsg."Sexe non valide. </br>\n";
        return false;
    }

    function testNaissance($naissance)
    {
        global $MINMAX,$errmsg;
        if(!checkSize($naissance,"date de naissance"))
            return false;
        if(in_array("/",$naissance)){
            $resultat=explode("/",$naissance);
            $jour  = $resultat[0];
            $mois  = $resultat[1];
            $annee = $resultat[2];
            if(checkdate($mois, $jour, $annee)===true)
                return true;
        }
        else if(in_array("-",$naissance)){
            $resultat=explode("-",$naissance);
            $annee = $resultat[0];
            $mois  = $resultat[1];
            $jour  = $resultat[2];
            if(checkdate($mois, $jour, $annee)===true)
                return true;
        }
        $errmsg=$errmsg."Date de naissance non valide.</br>\n";
        $errmsg=$errmsg."Formats autoris&eacute;s: jj/mm/aaaa ou aaaa-mm-jj</br>\n";
        return false;
    }

    function testAdresse($adresse)
    {
        global $MINMAX,$errmsg;
        if(!checkSize($adresse,"adresse"))
            return false;
        if(preg_match("#^[A-Za-z0-9\-éèêàâôöçäœù' ]*$#",$adresse))
            return true;
        $errmsg=$errmsg."L'adresse ne peut pas contenir de caract&egrave;res sp&eacute;ciaux</br>\n";
        return false;
    }

    function testCodePostal($codepostal)
    {
        global $MINMAX,$errmsg;
        if(!checkSize($codepostal,"code postal"))
            return false;
        if(preg_match("#^[0-9]{5}$#",$codepostal))
            return true;
        $errmsg=$errmsg."Le code postal n'en est pas un.</br>\n";
        return false;
    }

    function testVille($ville)
    {
        global $MINMAX,$errmsg;
        if(!checkSize($ville,"ville"))
            return false;
        if(preg_match("#^[A-Za-z\-éèêàâôöçäœù' ]*$#",$ville))
            return true;
        $errmsg=$errmsg."Le nom de ville ne peut pas contenir de caract&egrave;res sp&eacute;ciaux</br>\n";
        return false;
    }

    // Check tous les champs du formulaire d'inscription,
    // supposés se trouver dans $array.
    // retourne $errmsg, qui vaut "" si tout c'est bien passé.
    function fullCheck($array)
    {
        global $varNames,$errmsg;
        $errmsg="";
        foreach($varNames as $name)
        {
            if(!isset($array[$name]))
            {
                $errmsg=$errmsg."Erreur, champ ".$name." manquant.</br>\n";
            }
        }
        if($errmsg!="")
            return $errmsg;
        testMotDePasse($array["mdp"]);
        testNom($array["nom"]);
        testPrenom($array["prenom"]);
        testMail($array["mail"]);
        testSexe($array["sexe"]);
        testNaissance($array["naissance"]);
        testAdresse($array["adresse"]);
        testCodePostal($array["codepostal"]);
        testVille($array["ville"]);
        return $errmsg;
    }




 ?>






































