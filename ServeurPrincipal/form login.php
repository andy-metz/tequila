<!-- FORMULAIRE POUR LOGIN -->
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