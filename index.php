<?php  
header('Content-Type: text/html; charset=utf-8');
include 'initialisation.php'; 
include 'ServeurPrincipal/login.php';

?>
<html>

<head>
	<link rel="php" href="intialisation.php">
	<link rel="stylesheet" href="style.css">  
	<script type="text/javascript" src="jquery/external/jquery.js"></script> 
	<script type="text/javascript" src="jquery/jquery-ui.js"></script>
	<script type="text/javascript" src="ServeurAJAX/interface_script.js"></script>
</head>
<body>

   <nav>
  <ul id="menu">
    <li><a id="linkaccueil"href="#">Accueil</a></li>
    <li><a id="linkHierarchique"href="#accesHierarchique">Recettes</a></li>
    <li><a id="linklogin" href="#logindisplay">Mes favoris</a></li>
    <li><a id="linkcompletion"href="#partieAutocompletion">Trouver ma recette</a></li>
    <li><a id="linkconnexion" href="#connexion">Connexion</a></li>
  </ul>
</nav>

<div class="display-section" >
	<div id="accueil">
		<h1> Bienvenue sur cubalibre</h1>
		<p>	Dans l'onglet Recettes vous pouvez accéder à l'accès hiérarchiques des recettes.	</p>
		<p>	Vous devez être connecté pour accéder à vos favoris dons l'onglet Mes favoris.	</p>
		<p>	Dans trouver ma Recette vous pouvez aller chercher votre recette en fonction d'aliments que vous voulez et vous ne voulez pas.</p>
		<p> Dans l'onglet connexion vous pouvez vous inscrire ou vous connecter. </p>
	</div> 
	<div id="accesHierarchique">
		<?php
			include'ServeurPrincipal/acces_hierarchique.php';
		?>
	</div>
	<div id="logindisplay">
		<?php 
		if($_SESSION["connu"]==false){
			echo "Vous devez être connecté pour profiter de cette fonctionnalité; recharger la page si vous venez de le faire";
		}
		else{
			include'ServeurPrincipal/Favorie.php';
		}
		?>
	</div>
	<div id="partieAutocompletion">  	
		<p>Vous pouvez choisir 6 aliments en tout! Ceux que vous voulez à gauche, et ceux que vous ne voulez pas à droite.</p>
		<br>
		<!--<p>La note corresponds au rapport (NB_ALIMENT_CONTENUE)/(NB_ALIMENT_TOTAL)<p>
		<p>NB_ALIMENT_TOTAL corresponds au nombre d'aliment de la recette courante.</p>
		<p>NB_ALIMENT_CONTENUE corresponds au nombre d'aliment qui sont désirés et contenue dans la recette courante.</p>-->
		<div id="wrapper1">
			<div class="search_input_wrapper">
					<button class="add_search_input">Ajouter un aliment</button>
					<div><input type="text" name="SearchInput[]" class="autocomplete_button"></div>
			</div>
		</div>
		<input type="submit" value="Mixer" id="SubmitResult" ></input>

		<div id="wrapper2">
			<div class="search_input_wrapper1">
					<button class="add_search_input1">Supprimer un aliment</button>
					<div><input type="text" name="SearchInput[]" class="autocomplete_button"></div>
			</div>
		</div>
		<div id="result" >
		</div>
	</div>
	<div id="connexion">
		<?php
			formulaireIdentification();
			if($_SESSION["connu"]===false){
			echo "<br>";
			echo "<p>Pensez à vous inscrire!</p>"	;
			echo "<p>Le mot de passe doit avoir Une majuscule , des minuscules et au moins un chiffre</p>";
			echo"<p>Vous ne pouvez avoir de caractère spéciaux dans aucun champ ce qui veut dire aucun accent ou autre</p>";
			 formulaireEnregistrement();
			}
		?>
	</div>
</div>

	<!--<div id="empty-message"> </div> -->

</body>

</html>