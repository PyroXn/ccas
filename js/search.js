$(function() {
    $(".search").keyup(function() 
    {
        var searchbox = $(this).val();
        var dataString = 'searchword='+ searchbox;
        $.ajax({
            type: "POST",
            url: "./search.php",
            data: dataString,
            cache: false,
            success: function(html)
            {
                $("#list_individu").html(html).show();	
            }
        });
        return false;
    });
    
    
    
    
    $("#side_individu").scroll(function(){ // On surveille l'évènement scroll
        /* la fonction offset permet de récupérer la valeur X et Y d'un élément
            dans une page. Ici on récupère la position de la derniere li qui 
            a pour classe : ".individu" */
        var offset = $("#list_individu").height();
        var load = false; // aucun chargement d'individu n'est en cours

                    
        /* Si l'élément offset est en bas de scroll, si aucun chargement 
                n'est en cours, si le nombre d'individu affiché est supérieur 
                à 100 et si tout les individus ne sont pas affichés, alors on 
                lance la fonction. */
        console.log("\n offset.top" + offset + "\n " + "Height" + $("#side_individu").height() + "\n " + "scrollTop" + $(this)[0].scrollTop
            + "\n " + "total = " + (offset-$("#side_individu").height() <= $(this)[0].scrollTop));

        if((offset-$("#side_individu").height() <= $(this)[0].scrollTop) 
            && load==false && ($('.individu').size()>=100) && 
            ($('.individu').size()!=$('.nb_individu').text())){
            // la valeur passe à vrai, on va charger
            load = true;
 
            //On récupère le nombre d'individu affiché global
            var nb_individu_total = $('.individu:last').attr('id');
                        
            //On affiche un loader (trop aps ca fait lag)
            //$('.loadmore').show();
 
            //On lance la fonction ajax
            $.ajax({
                url: './scroll.php',
                type: 'get',
                data: 'last='+nb_individu_total,
 
                //Succès de la requête
                success: function(data) {
 
                    //On masque le loader (fait lag et du coup buger)
                    //$('.loadmore').fadeOut(500);
                    /* On affiche le résultat après le dernier individu */
                    $('.individu:last').after(data);
                    /* On actualise la valeur offset du dernier individu */
                    offset = $("#list_individu").height();
                    //On remet la valeur à faux car c'est fini
                    load = false;
                }
            });
        }
    });
});