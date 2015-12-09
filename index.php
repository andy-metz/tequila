<?php  
header('Content-Type: text/html; charset=utf-8');
include 'initialisation.php'; 

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
		<p> 
	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum a nunc et est pellentesque maximus in vel ligula. Nunc rhoncus, orci id placerat lacinia, enim justo vestibulum tellus, ornare finibus est nisi at urna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec bibendum commodo libero, et condimentum dui suscipit sit amet. Nunc pharetra tincidunt mi, in pharetra odio iaculis a. Sed fringilla sed sapien id iaculis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut non interdum tortor. Praesent id malesuada nibh. Proin placerat at lectus sed hendrerit. Vestibulum dignissim, nunc vitae fringilla rutrum, mauris enim ultricies metus, et tempus est ex tincidunt velit.
	</p>
	</div> 
	<div id="accesHierarchique">
toto


	</div>
	<div id="logindisplay">
	</div>
	<div id="partieAutocompletion">  	
		<p>Vous pouvez choisir 6 aliments en tout! Ceux que vous voulez à gauche, et ceux que vous ne voulez pas à droite.</p>
		<div id="wrapper1">
			<div class="search_input_wrapper">
					<button class="add_search_input">Ajouter un aliment</button>
					<div><input type="text" name="SearchInput[]" class="autocomplete_button"></div>
			</div>
		</div>

		<input type="submit" value="Mixer" id="SubmitResult" ></input>

		<div id="wrapper2">
			<div class="search_input_wrapper1">
					<button class="add_search_input1">Ajouter un aliment</button>
					<div><input type="text" name="SearchInput[]" class="autocomplete_button"></div>
			</div>
		</div>
		<div id="result" >
		</div>
	</div>
	<div id="connexion">
		<p> yoyoyoyoyoyoyogigiforjgposdjhsdpofihjsdpofihjqpohijqdfohijqdfhmoij</p>
	</div>
</div>

	<!--<div id="empty-message"> </div> -->

</body>

</html>