<!DOCTYPE html>
<html>
	<head>
		<title>Login.php</title>
		<meta charset="ISO-8859-1"/>
	</head>
	<body>
        <!-- TODO: supprimer le code html de cette page -->

		<?php
            $servname="localhost";
            $dbname="phpproject"; // "cocktail"
            $user="root";
            $mdp="";
            $utilisateurtablename="utilisateur";
            $PSEUDO_MAX_CHAR=20;
            $PSEUDO_MIN_CHAR=3;
            $MDP_MAX_CHAR=48;
            $MDP_MIN_CHAR=8;

            // Créee une session si il n'y en a pas
            // Démarre la session si elle est inactive
            function startSession()
            {
                $ss=session_status();
                if($ss===PHP_SESSION_DISABLED)
                { // Cas de la 1ere connection
                    //echo"Session DISABLED</br>\n";
                    session_start();
                    $_SESSION["pseudo"]="inconnu(e)";
                    $_SESSION["mail"]="";
                    // connu indique si l'utilisateur est enregistré dans la bdd ou non.
                    $_SESSION["connu"]=false;
                }
                // Si il y a une session non active, on la démarre
                else if($ss===PHP_SESSION_NONE)
                { // Cas des autres connections
                    //echo"Session NONE</br>\n";
                    session_start();
                    if($_SESSION["connu"]===false)
                    {
                        $_SESSION["pseudo"]="inconnu(e)";
                        $_SESSION["mail"]="";
                    }
                }
                // Sinon
                else if($ss===PHP_SESSION_ACTIVE);
                //echo"Session ACTIVE</br>\n";
                // rien à faire
                // cas où cette fonction est appellée 2 fois dans le même fichier.
            }
            // Première chose à faire:
            // Démarrer la session.
            // L'utilisateur pourras utiliser les services sans avoir besoin de compte'
            startSession();


            function custom_hash($value)
            {

            }

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
                include 'form login.php';
			}

            // Affiche le formulaire d'inscription'
			function print_register_form(){
                include 'form register.php';
			}

			// Affiche un petit truc pour indiquer à l'utilisateur son statut de connexion.
			function printSession()
			{
                echo '<div id ="idsession">'."</br>\n";
                echo "Bienvenue ".$_SESSION["pseudo"]."</br>\n";
                if($_SESSION["connu"]===true)
                    echo "connect&eacute;</br>\n";
                else echo "d&eacute;connect&eacute;</br>\n";
			}

            // affiche la session si elle est active
            // sinon récupère et traite les infos du formulaire d'enregistrement
            // sinon affiche le formulaire pour s'enregistrer
            function checkRegistration()
            {
                global $PSEUDO_MAX_CHAR, $PSEUDO_MIN_CHAR, $MDP_MAX_CHAR, $MDP_MIN_CHAR,
                        $servname,$dbname,$user,$mdp;
                //startSession();
                if($_SESSION["connu"]===true)
                    printSession();
                else
                {
                    // Afficher le formulaire
                    $isformvalid=true;
                    $errmsg=array("Mail"=>"","Pseudonyme"=>"","Mot de passe"=>"","2eme mot de passe"=>"");
                    if(!isset($_POST["submit_register"]))
                    {
                        // TODO afficher le formulaire d'enregistrement
                        echo '<div id="form">'."\n";
                                print_register_form();
                        echo "</div>";
                    }
                    else
                    {
                        // TODO vérifier le formulaire
                        $ok=array("mail"=>false,"pseudo"=>false,"mdp"=>false,"mdp2"=>false);
                        $isFormValid=true;

                        if(isset($_POST["mail"]))
                        {
                            if(!(filter_var($_POST["mail"],FILTER_VALIDATE_EMAIL,null)===false))
                                $ok["mail"]=true;
                            else
                            {
                                $errmsg["Mail"]=$errmsg["Mail"]."Adresse mail non valide.</br>\n";
                                $isFormValid=false;
                            }
                        }
                        else
                            $isformvalid=false;
                        if(isset($_POST["pseudo"]))
                        {
                            $pseudo_regexp="#^[0-9A-Za-zéôöçäœ ]{".strval($PSEUDO_MIN_CHAR).",".strval($PSEUDO_MAX_CHAR)."}$#";
                            if(preg_match($pseudo_regexp,$_POST["pseudo"])){
                                $ok["pseudo"]=true;
                            }
                            else{
                                $errmsg["Pseudonyme"]=$errmsg["Pseudonyme"]."Doit contenir entre ".
                                $PSEUDO_MIN_CHAR." et ".$PSEUDO_MAX_CHAR.
                                " Charact&egraveres.</br>\n Ne doit pas contenir de caract&egrave;res sp&eacute;ciaux.</br>\n";
                                $isFormValid=false;
                            }
                        }
                        else
                            $isformvalid=false;
                        if(isset($_POST["mdp"]))
                        {
                            $mdp=$_POST["mdp"];
                            $isPwdValid=true;
                            $mdp_regexp="#^.{".$MDP_MIN_CHAR.",".$MDP_MAX_CHAR."}$#";
                            if(!preg_match($mdp_regexp,$mdp)) $isPwdValid=false;
                            if(!preg_match("#[a-z]#",$mdp)) $isPwdValid=false;
                            if(!preg_match("#[A-Z]#",$mdp)) $isPwdValid=false;
                            if(!preg_match("#[0-9]#",$mdp)) $isPwdValid=false;
                            if(preg_match("#[^a-zA-Z0-9]#",$mdp)) $isPwdValid=false;
                            if($isPwdValid)
                            {
                                $ok["mdp"]=true;
                            }
                            else
                            {
                                $errmsg["Mot de passe"]=$errmsg["Mot de passe"].
                                "Le mot de passe doit contenir entre ".
                                $MDP_MIN_CHAR." et ".$MDP_MAX_CHAR." caract&egrave;res.</br>\n".
                                "Seuls les chiffres, lettres et majuscules sont autoris&eacute;s et requis.</br>\n";
                                $isFormValid=false;
                            }
                        }
                        else
                            $isformvalid=false;
                        if(isset($_POST["mdp2"]))
                        {
                            $isMdp2Valid=true;
                            if(!isset($_POST["mdp"])) $isMdp2Valid=false;
                            if($_POST["mdp"]!=$_POST["mdp2"]) $isMdp2Valid=false;
                            if($isMdp2Valid)
                                $ok["mdp2"]=true;
                            else
                            {
                                $errmsg["2eme mot de passe"]=$errmsg["2eme mot de passe"]."Ne correspond pas au 1er.</br>\n";
                                $isformvalid=false;
                            }
                        }
                        else
                            $isformvalid=false;

                        // TODO tester $isFormValid
                        if($isFormValid)
                        {
                            // Hasher mdp
                            $mdp_key=hash("sha256",$_POST["mdp"]);
                            //! TODO Sauvegarder les données
                            //!
                            $mysqli = new mysqli($servname, $user, $mdp, $dbname);
                            if($mysqli->connect_errno > 0){
                                die('Unable to connect to database [' . $mysqli->connect_error . ']');
                            }
                            $query="INSERT INTO utilisateur (mail,pseudo,mdp)".
                            "VALUES ('".htmlentities($_POST["mail"]).
                            "','".htmlentities($_POST["pseudo"].
                            "','".$mdp_key."')";
                            $mysqli->query($query);
                            //! TOD0 TERMINER CECI
                            //!
                            //!
                            //!
                            //!
                            //!
                            //!
                            //!
                            // Activer la session
                            echo "Votre inscription a bien été prise en compte.</br>\n";
                            $_SESSION["pseudo"]=$_POST["pseudo"];
                            $_SESSION["mail"]=$_POST["mail"];
                            $_SESSION["connu"]=true;
                            printSession();
                        }
                        else //$isFormValid
                        {
                            // TODO afficher le formulaire et les messages d'erreur
                            echo '<div id="form">'."\n";
                                print_register_form();
                                echo '<div id="errmsg">'."\n";
                                    foreach($errmsg as $fieldname=>$msg){
                                        echo "Erreur champ ".$fieldname.": ".$msg."\n";
                                    }
                                echo "</div>";
                            echo "</div>";
                        } // else $isFormValid
                    } // if(!isset($_POST["submit_register"]))
                } // if ($_SESSION["connu"]===false)
            } // function checkRegistration()

            // Affiche la session si elle est active
            // Sinon récupère et traite les infos du formulaire de login
            // sinon affiche le formulaire pour s'identifier
            function checkLogin()
            {
                global $MDP_MAX_CHAR, $MDP_MIN_CHAR;
                // TODO validation du formulaire
                printSession();
                if ($_SESSION["connu"]===false)
                {
                    $isformvalid=true;
                    if(isset($_POST["submit_login"]))
                    {
                        // TODO vérifier si les infos sont dans la base,
                        // sinon réafficher le formulaire et les messages d'erreur correspondants
                    }
                    else
                    {
                        // TODO afficher le formulaire
                        print_login_form();
                    }
                }

            }



            // permet d'afficher les inputs de manière sécurisée.
            // trim déjà réalisé.
			foreach($_POST as $input){
                $input=htmlentities($input,ENT_QUOTES|ENT_HTML401);
			}


		?>

        <?php
            // Utilisation: inclure login.php et à l'emplacement du formulaire appeler
            checkRegistration();
            // ou
            checkLogin();
            // TODO supprimer le code html de cette page.
         ?>

		<!-- FORMULAIRE POUR LOGIN -->
		<!--
            <form method="post" action="#" >
                <fieldset>
                    <legend>Login</legend>
                    Adresse mail:
                    <input id="idmail" type="text" name="mail" required="required" value=<?php PostToField("mail") ?>/></input><br/>
                    Mot de passe:
                    <input id="idmdp" type="text" name="mdp" required="required" value=<?php PostToField("mdp") ?>></input><br/>
                </fieldset>
                <input type="submit" value="Valider" name="submit_login"></input>
                </br>
            </form>
		-->

		<!-- FORMULAIRE D INSCRIPTION -->
		<!--
            <form method="post" action="#" >
                <fieldset>
                    <legend>Inscription</legend>
                    Adresse mail:
                    <input id="idmail" type="text" name="mail" required="required" value=<?php PostToField("mail") ?>></input><br/>
                    Pseudonyme:
                    <input id="idpseudo" type="text" name="pseudo" required="required" value=<?php PostToField("pseudo") ?>></input><br/>
                    Mot de passe:
                    <input id="idmdp" type="text" name="mdp" required="required" value=<?php PostToField("mdp") ?>></input><br/>
                    Entrez &agrave; nouveau votre mot de passe:
                    <input id="idmdp2" type="text" name="mdp2" required="required" value=<?php PostToField("mdp2") ?>></input><br/>
                <input type="submit" value="Valider" name="submit_register"/>

                </fieldset>
                <br />

            </form>
        -->

    <!-- TODO: Utiliser l'inclusion du pied de page -->

	</body>
</html>
