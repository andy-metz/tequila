<!-- FORMULAIRE D INSCRIPTION 

<?php if(isset($_POST['sexe'])){if($_POST['sexe']=='f') echo'checked';}?>
<?php if(isset($_POST['sexe'])){if($_POST['sexe']=='h') echo'checked';}?>

	-->
<?php
    $varNames=array(
        "mdp","mail","nom","prenom","sexe",
        "naissance","adresse","codepostal","ville"
    );
?>
<form method="post" action="#" >
	<fieldset>
	    <legend>Inscription</legend>

	    Adresse mail:
	    <div><input id="idmail" type="text" name="mail" required="required" value=<?php PostToField("mail") ?>></input><br/></div>

	 	Nom:
	 	<div><input id="idnom" type="text" name="nom" required="required" value=<?php PostToField("nom") ?>></input><br/></div>

	 	Pr&eacute;nom:
	 	<div><input id="idprenom" type="text" name="prenom" required="required" value=<?php PostToField("prenom") ?>></input><br/></div>

	 	Sexe:
	 	<div><input type="radio" name="sexe"  value="f"  /> femme</div>
        <div><input type="radio" name="sexe" value="h"  /> homme</div>
        </br>

	 	Date de naissance:
	 	<div><input id="idnaissance" type="text" name="naissance" required="required" value=<?php PostToField("naissance") ?>></input><br/></div>

	 	Adresse:
	 	<div><input id="idadresse" type="text" name="adresse" required="required" value=<?php PostToField("adresse") ?>></input><br/></div>

	 	Code postal:
	 	<div><input id="idcodepostal" type="text" name="codepostal" required="required" value=<?php PostToField("codepostal") ?>></input><br/></div>

	 	ville:
	 	<div><input id="idville" type="text" name="ville" required="required" value=<?php PostToField("ville") ?>></input><br/></div>

	 	Mot de passe:
	 	<div><input id="idmdp" type="password" name="mdp" required="required" value=<?php PostToField("mdp") ?>></input><br/></div>

	 	Entrez &agrave; nouveau votre mot de passe:
	 	<div><input id="idmdp2" type="password" name="mdp2" required="required" value=<?php PostToField("mdp2") ?>></input><br/></div>



	<input type="submit" value="Valider" name="submit_register"/>

	</fieldset>
	<br />

</form>
