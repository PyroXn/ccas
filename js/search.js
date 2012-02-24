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
    
    
    
    
    $("#side_individu").scroll(function(){ // On surveille l'�v�nement scroll
        /* la fonction offset permet de r�cup�rer la valeur X et Y d'un �l�ment
            dans une page. Ici on r�cup�re la position de la derniere li qui 
            a pour classe : ".individu" */
        var offset = $("#list_individu").height();
        var load = false; // aucun chargement d'individu n'est en cours

                    
        /* Si l'�l�ment offset est en bas de scroll, si aucun chargement 
                n'est en cours, si le nombre d'individu affich� est sup�rieur 
                � 100 et si tout les individus ne sont pas affich�s, alors on 
                lance la fonction. */
        console.log("\n offset.top" + offset + "\n " + "Height" + $("#side_individu").height() + "\n " + "scrollTop" + $(this)[0].scrollTop
            + "\n " + "total = " + (offset-$("#side_individu").height() <= $(this)[0].scrollTop));

        if((offset-$("#side_individu").height() <= $(this)[0].scrollTop) 
            && load==false && ($('.individu').size()>=100) && 
            ($('.individu').size()!=$('.nb_individu').text())){
            // la valeur passe � vrai, on va charger
            load = true;
 
            //On r�cup�re le nombre d'individu affich� global
            var nb_individu_total = $('.individu:last').attr('id');
                        
            //On affiche un loader (trop aps ca fait lag)
            //$('.loadmore').show();
 
            //On lance la fonction ajax
            $.ajax({
                url: './scroll.php',
                type: 'get',
                data: 'last='+nb_individu_total,
 
                //Succ�s de la requ�te
                success: function(data) {
 
                    //On masque le loader (fait lag et du coup buger)
                    //$('.loadmore').fadeOut(500);
                    /* On affiche le r�sultat apr�s le dernier individu */
                    $('.individu:last').after(data);
                    /* On actualise la valeur offset du dernier individu */
                    offset = $("#list_individu").height();
                    //On remet la valeur � faux car c'est fini
                    load = false;
                }
            });
        }
    });
});