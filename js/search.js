$(function() {
    calculTailleInputSearch();
    
    $(window).resize(function(){
        calculTailleInputSearch();
    })

    $("#search").keyup(function() 
    {
        var searchbox = $(this).val();
        search(searchbox);
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
 
 
            var searchbox = $("#search").val();
 

            //On lance la fonction ajax
            $.ajax({
                url: './index.php?p=scroll',
                type: 'post',
                //                data: 'last='+nb_individu_total,
                data: "last=" + nb_individu_total+ "&searchword=" + searchbox,
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
    
    /* retourne l'element sur lequel on clique */
    $('#list_individu > li').live("click", function() {
        
        /* recherche dans les enfants de l'id list_individu une class current */
        var test = $('#list_individu').children('.current');
        test.removeClass('current');
        
        if (!test.is(this)) {
            $(this).addClass('current');
            var idFoyer = $(this).children().attr('id_foyer');
            var idIndividu = $(this).children().attr('id_individu');
            console.log(idIndividu);
            console.log(idFoyer);
            $.ajax({
                type: "POST",
                dataType:'json',
                url: "./index.php?p=foyer",
                data: 'idFoyer='+ idFoyer + '&idIndividu=' + idIndividu,
                success: function(html)
                {
                    console.log(html);
                    $("#list_individu").html(html.listeIndividu);
                    $("#page_header_navigation").html(html.menu);
                    $('#contenu').html(html.contenu);
                }
            });
        } else {
            $.ajax({
                type: "POST",
                dataType:'json',
                url: "./index.php?p=accueil",
                success: function(html)
                {
                    $("#page_header_navigation").html(html.menu);
                    $("#contenu").html(html.contenu);
                }
            });
            var searchbox = $("#search").val();
            search(searchbox);
        }
    });  
    
    $('#page_header_navigation > div').live("click", function() {
        console.log($(this));
        $('.active').toggleClass('active');
        $(this).toggleClass('active');
        var idMenu = $(this).attr("id");
        var idIndividu = $('#list_individu').children('.current').children().attr('id_individu');
        var idFoyer = $('#list_individu').children('.current').children().attr('id_foyer');
        console.log(idIndividu);
        $.ajax({
            type: "POST",
            url: "./index.php?p=contenu",
            data: 'idMenu=' + idMenu + '&idIndividu='+ idIndividu + '&idFoyer='+idFoyer,
            success: function(html)
            {
                $("#contenu").html(html);
            }
        });
    });  
    
    $('.autoComplete').live("keyup", function()  {
        var searchbox = $(this).val();
        var table = $(this).attr('table');
        var champ = $(this).attr('champ');
        autoComplete(searchbox, table, champ, $(this));
    });
    
});

function autoComplete(searchbox, table, champ, elmt) {
    var dataString = 'searchword='+ searchbox;
    dataString += '&table=' + table
    dataString += '&champ=' + champ
    $.ajax({
        type: "POST",
        url: "./index.php?p=autoComplete",
        data: dataString,
        cache: false,
        success: function(html)
        {
            $('.liste_sugestion').html(html);
        }
    });
}

function search(searchbox) {
    var dataString = 'searchword='+ searchbox;
    $.ajax({
        type: "POST",
        url: "./index.php?p=search",
        //        url: "./search.php",
        data: dataString,
        cache: false,
        success: function(html)
        {
            $("#list_individu").html(html);	
        }
    });
}

function calculTailleInputSearch() {
    $('#search').css({
        "width" : $('#menu_gauche').outerWidth() - $('.add').outerWidth(true) 
        - parseInt($('#search').css("margin-left"))
    });
}