<!-- FORMULAIRE D INSCRIPTION -->
<?
    $varNames=array(
        "mdp","mail","nom","prenom","sexe",
        "naissance","adresse","codepostal","ville"
    );
?>
<form method="post" action="#" >
	<fieldset>
	    <legend>Inscription</legend>

	    Adresse mail:
	    <input id="idmail" type="text" name="mail" required="required" value=<?php PostToField("mail") ?>></input><br/>

	 	Nom:
	 	<input id="idnom" type="text" name="nom" required="required" value=<?php PostToField("nom") ?>></input><br/>

	 	Pr&eacute;nom:
	 	<input id="idprenom" type="text" name="prenom" required="required" value=<?php PostToField("prenom") ?>></input><br/>

	 	Sexe:
	 	<input type="radio" name="sexe" value="f" <?php if(isset($_POST['sexe']))if($_POST['sexe']=='f') echo'checked="checked"';?> /> femme
        <input type="radio" name="sexe" value="h" <?php if(isset($_POST['sexe']))if($_POST['sexe']=='h') echo'checked="checked"';?> /> homme
        </br>

	 	Date de naissance:
	 	<input id="idnaissance" type="date" name="naissance" required="required" value=<?php PostToField("naissance") ?>></input><br/>

	 	Adresse:
	 	<input id="idadresse" type="text" name="adresse" required="required" value=<?php PostToField("adresse") ?>></input><br/>

	 	Code postal:
	 	<input id="idcodepostal" type="text" name="codepostal" required="required" value=<?php PostToField("codepostal") ?>></input><br/>

	 	ville:
	 	<input id="idville" type="text" name="ville" required="required" value=<?php PostToField("ville") ?>></input><br/>

	 	Mot de passe:
	 	<input id="idmdp" type="password" name="mdp" required="required" value=<?php PostToField("mdp") ?>></input><br/>

	 	Entrez &agrave; nouveau votre mot de passe:
	 	<input id="idmdp2" type="password" name="mdp2" required="required" value=<?php PostToField("mdp2") ?>></input><br/>



	<input type="submit" value="Valider" name="submit_register"/>

	</fieldset>
	<br />

</form>
