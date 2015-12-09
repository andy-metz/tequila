<!-- FORMULAIRE D INSCRIPTION -->
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
