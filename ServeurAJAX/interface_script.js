$(document).ready(function() {
    var max_fields      = 4; //maximum input boxes allowed
    var wrapper         = $('*.search_input_wrapper'); //Fields wrapper// changer selecteur
    var add_button      = $('.add_search_input'); //Add button ID

    var wrapper1    =$('*.search_input_wrapper1');
    var add_button1 =$(".add_search_input1");
    
    var x = 0; //initlal text box count
   
    $(add_button).click(function(e){ //on_click de add_bouton
        e.preventDefault();
        if(x < max_fields){ //max input box autorisé
            x++; //+1 input de présent
            $(wrapper).append('<div><input type="text" name="SearchInput" class="autocomplete_button" /><a href="#" class="remove_field">Supprimer</a></div>'); 
            
            $(wrapper).find('input[type=text]:last').autocomplete({
                source: "./ServeurAJAX/Completion.php",
                minLength:3
            }); 
            //add input box avec autocomplete
        }
    });
    
    //Action du bouton bouton suppression
    $(wrapper).on("click",".remove_field", function(e){ 
        e.preventDefault(); 
        $(this).parent('div').remove(); x--;
    })

    $(add_button1).click(function(e){
        e.preventDefault();
        if(x<max_fields){
            x++;
            $(wrapper1).append('<div><input type="text" name="SearchInput" class="autocomplete_button" /><a href="#" class="remove_field">Supprimer</a></div>');
            
            $(wrapper1).find('input[type=text]:last').autocomplete({
                source: "./ServeurAJAX/Completion.php",
                minLength:3
            })
        }

    });
    $(wrapper1).on("click",".remove_field", function(e){ 
        e.preventDefault(); 
        $(this).parent('div').remove(); x--;
    })
    
    $("input[name^='SearchInput']").autocomplete({
        source: "./ServeurAJAX/Completion.php",
        minLength :3
    }); 

    $("input[name^='SearchInputFavori'").autocomplete({
        source:"./ServeurPrincipal/CompletionFavorie.php",
        minLength:2
    });

    $("input[id^=SubmitFavori]").click(function(e){
        e.preventDefault();
        var recette_to_insert;
        var user_to_insert;


        $("div input[name^='SearchInputFavori'").each(function(e){
            recette_to_insert=$(this).val();
        });

        $("div.iduserfavori p").each(function(e)
        {
            user_to_insert=$(this).text();

        });

        console.log(recette_to_insert);
        console.log(user_to_insert);
         $.post("./ServeurAJAX/ajoutfavori.php",{insertrecette:recette_to_insert,userinsert:user_to_insert});            
    });
    $("input[name^='SearchInputDeleteFavori']").autocomplete({
        source:"./ServeurAJAX/deletefavoricompletion.php",
        minLength:1
    });
    $("input[id^='DeleteFavori']").click(function(e){
        e.preventDefault();
        var favori_to_delete;
        var user_deletion;
        $("input[name^='SearchInputDeleteFavori']").each(function(e){
            favori_to_delete=$(this).val();
        });

          $("div.iduserfavori p").each(function(e)
        {
            user_deletion=$(this).text();

        });
        console.log(favori_to_delete);
        console.log(user_deletion);

        $.post("./ServeurAJAX/deletefavori.php",{recette_to_delete:favori_to_delete,user_id:user_deletion });
    });

    $("#menu").menu();

    $("#idnaissance").datepicker({
      changeMonth: true,
      changeYear: true
    });
    /*"Slide"  "swing"  effect "puff"
    .fadeOut("slow");
    .show
    $("#partieAutocompletion").hide("puff","swing");
    */
    $("a#linkconnexion").click(function(e){
        $("#connexion").fadeIn("slow");
        $("#partieAutocompletion").fadeOut("slow");
        $("#logindisplay").fadeOut("slow");
        $("#accesHierarchique").fadeOut("slow");
        $("#accueil").fadeOut("slow");
        e.preventDefault();
    });

    $("a#linkaccueil").click(function(e){
        $("#accueil").fadeIn( "slow" );
        $("#partieAutocompletion").fadeOut("slow");
        $("#logindisplay").fadeOut("slow");
        $("#accesHierarchique").fadeOut("slow");
        $("#connexion").fadeOut("slow");
        e.preventDefault();
    });
    $("a#linkcompletion").click(function(e){      
        $("#partieAutocompletion").fadeIn( "slow" );
        $("#accueil").fadeOut("slow");
        $("#logindisplay").fadeOut("slow");
        $("#accesHierarchique").fadeOut("slow");
        $("#connexion").fadeOut("slow");
         e.preventDefault();
    });
    $("a#linkHierarchique").click(function(e){
        $("#accesHierarchique").fadeIn( "slow" );
        $("#accueil").fadeOut("slow");
        $("#logindisplay").fadeOut("slow");
        $("#partieAutocompletion").fadeOut("slow");
        $("#connexion").fadeOut("slow");
         e.preventDefault();
    });
    $("a#linklogin").click(function(e){
        $("#logindisplay").fadeIn( "slow" );
        $("#partieAutocompletion").fadeOut("slow");
        $("#accueil").fadeOut("slow");
        $("#accesHierarchique").fadeOut("slow");
        $("#connexion").fadeOut("slow");
          e.preventDefault();
     });

     $("#SubmitResult").click(function(e){
        e.preventDefault();
        var wanted_element=[];
        var forbid_element=[];

        $('*.search_input_wrapper input[name^=SearchInput]').each(function(){
            wanted_element.push($(this).val());
        });

        console.log(wanted_element);

        $('*.search_input_wrapper1 input[name^=SearchInput]').each(function(){
            forbid_element.push($(this).val());
        });

        console.log(forbid_element);
        /* 
        récupérer les recettes
        */
       $.post("./ServeurAJAX/averagesearch.php",{wanted_element,forbid_element},
            function(data){
                $('div#result').html(data);
            });
    });

});
/*===============================


    EVENT HANDLER 
        ACCES
    HIERARCHIQUE

================================*/
$(document).on("click","button[class^=sous_categorie]", function(e){
        e.preventDefault();        
        var libaliment_voulu;
        var myClass = (this).className;
        console.log(myClass);

        $("a").filter('.'+myClass).each(function(){
            libaliment_voulu=$(this).text();

            console.log(libaliment_voulu);
        });

       $.post("./ServeurPrincipal/hierarchie_liste_aliment.php",{libaliment:libaliment_voulu},
            function(data){
                $('div#liste_fils_aliment').html(data);
            });    
        

     });


$(document).on("click","button[class^=id_super_categorie]", function(e){
        e.preventDefault();        
        var libaliment_voulu;
          libaliment_voulu=$(this).text();
            console.log(libaliment_voulu);

    $.post("./ServeurPrincipal/hierarchie_liste_aliment_pop.php",{libaliment:libaliment_voulu},
            function(data){
                $('div#liste_fils_aliment').html(data);
            });    
        

     });



$(document).on("click","a[class^=sous_categorie]", function(e){
        e.preventDefault();        
        var libaliment_voulu;
        var myClass = (this).className;        
          libaliment_voulu=$(this).text();
            console.log(libaliment_voulu);

        $("a").filter('.'+myClass).each(function(){
            libaliment_voulu=$(this).text();
        });

       $.post("./ServeurPrincipal/hierarchie_liste_recette.php",{libaliment:libaliment_voulu},
            function(data){
                $('div#ah_liste_recettes').html(data);
            });    
        

     });

$(document).on("click","a[class^=affichage_recette]", function(e){
        e.preventDefault();        
        var recette_voulu;
        var myClass = (this).className;        
          recette_voulu=$(this).text();
            console.log(recette_voulu);

       $.post("./ServeurPrincipal/hierarchie_affichage_recette.php",{librecette:recette_voulu},
            function(data){
                $('div#ah_affichage_recette').html(data);
            });    
        

     });