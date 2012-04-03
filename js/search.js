$(function() {

    calculTailleInputSearch();
    
    $(window).resize(function(){
        calculTailleInputSearch();
    });

    $("#search").keyup(function() 
    {
        var searchbox = $(this).val();
        search(searchbox);
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
 
 
            var searchbox = $("#search").val();
 

            //On lance la fonction ajax
            $.ajax({
                url: './index.php?p=scroll',
                type: 'post',
                //                data: 'last='+nb_individu_total,
                data: "last=" + nb_individu_total+ "&searchword=" + searchbox,
                cache: false,
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
                },
                error: function(data) {
                    $('.individu:last').after(data.responseText);
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
                cache: false,
                success: function(html)
                {
                    console.log(html);
                    $("#list_individu").html(html.listeIndividu);
                    $("#page_header_navigation").html(html.menu);
                    $('#contenu').html(html.contenu);
                },
                error: function(html) {
                    $("#contenu").html(html.responseText);
                }
            });
        } else {
            $.ajax({
                type: "POST",
                dataType:'json',
                url: "./index.php?p=accueil",
                cache: false,
                success: function(html)
                {
                    $("#page_header_navigation").html(html.menu);
                    $("#contenu").html(html.contenu);
                },
                error: function(html) {
                    $("#contenu").html(html.responseText);
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
            cache: false,
            success: function(html)
            {
                $("#contenu").html(html);
            },
            error: function(html) {
                $("#contenu").html(html.responseText);
            }
        });
    });
    
    $('.edit_aide_interne').live("click", function() {
        var idAide = $(this).parent().parent().attr('name');
        console.log(idAide);
        $.ajax({
            type: "POST",
            url: "./index.php?p=detailaideinterne",
            data: 'idAide='+ idAide,
            cache: false,
            success: function(html)
            {
                $("#contenu").html(html);
            },
            error: function(html) {
                $("#contenu").html(html.responseText);
            }
        });
    });
    $('.edit_aide_externe').live("click", function() {
        var idAide = $(this).parent().parent().attr('name');
        console.log(idAide);
        $.ajax({
            type: "POST",
            url: "./index.php?p=detailaideexterne",
            data: 'idAide='+ idAide,
            cache: false,
            success: function(html)
            {
                $("#contenu").html(html);
            },
            error: function(html) {
                $("#contenu").html(html.responseText);
            }
        });
    });
     
    $('.input_date').live('click', function() {
        $(this).datepicker({
            showOn:'focus',
            showAnim: 'slideDown'
        }).focus();
    });
    
    $('.autoComplete').live("keyup", function(evenement)  {
        var codeTouche = evenement.which || evenement.keyCode;
        var searchbox = $(this).val();
        if (searchbox.length > 2) {
            switch(codeTouche) {
                case 13:
                    var selection = $('.selection');
                    
                    console.log(selection);
                    if(selection.length != 0) {
                        var parent = selection.parent();
                        var table = parent.attr('table');
                        var champ = parent.attr('champ');
                        selectionList(selection, table, champ);
                    }
                    //Touche entrée
                    console.log("Touche entrée");
                    break;
                case 40:
                    var selection = $('.selection');
                    console.log(selection);
                    if(selection.length != 0) {
                        console.log('after ' + $(selection).next());
                        $(selection).toggleClass('selection');
                        $(selection).next().toggleClass('selection');
                    } else {
                        $('.liste_suggestion > li:first').toggleClass('selection');
                    }
                    //fleche bas
                    console.log("Fleche bas");
                    break;
                case 38:
                    var selection = $('.selection');
                    console.log(selection);
                    if(selection.length != 0) {
                        console.log('before ' + $(selection).prev());
                        $(selection).toggleClass('selection');
                        $(selection).prev().toggleClass('selection');
                    } else {
                        $('.liste_suggestion > li:last').toggleClass('selection');
                    }
                    //fleche haut
                    console.log("Fleche haut");
                    break;
                default:
                    var table = $(this).attr('table');
                    var champ = $(this).attr('champ');

                    //positionnement de la liste de suggestion
                    var x = $(this).offset();
                    var h = $(this).outerHeight();            
                    $('#suggestion').css("top", x.top+h);
                    $('#suggestion').css("left", x.left);
                    $('#suggestion').css("display", "block");
                    autoComplete(searchbox, table, champ, $(this));
            }
        } else {
            $('#suggestion').css("display", "none");
        }
    });
        
    $('.autoComplete').live("click", function() {
        $(this).attr('autocomplete', 'off');
    });
        
    $('.autoComplete').live("blur", function()  {
        $('#suggestion').css("display", "none");
    });
    
    $('.liste_suggestion > li').live("click", function() {
        var focus = $(this);
        var parent = $(this).parent();
        var table = parent.attr('table');
        var champ = parent.attr('champ');
        console.log('parent ' + parent);
        console.log('table ' + table);
        console.log('champ ' + champ);
        selectionList(focus, table, champ);
    });
    
    //le hover permet de chopper l'evenment à l'entrer et à la sortie, le toggleClass prend donc tous son sens!
    $('.liste_suggestion > li').live('hover', function() {
        $(this).toggleClass('selection');
    });
    
    $('.afficherArchivage').live("click", function() {
        var ligne = $(this);
        if (!$(this).hasClass('archiveVisible')) {
        
            var datastring;
            datastring = 'table=' + $(this).attr('table') + '&idObjet=' + $(this).attr('idObjet');
            if ($(this).hasClass('isGlobal')) {
                datastring += '&global=true';
            } else {
                datastring += '&global=false';
            }
            console.log(datastring);
            $.ajax({
                type: "POST",
                url: "./index.php?p=afficherArchive",
                data: datastring,
                cache: false,
                success: function(html)
                {
                    ligne.after(html);
                },
                error: function(html) {
                    ligne.after(html.responseText);
                }
            });
        } else {
            ligne.next().remove();
        }
        $(this).toggleClass('archiveVisible');
    });
    
    $('.rechercheHistorique').live("keyup", function() {
        searchTableHistorique();
    });
});

function searchTableHistorique() {
    var datastring = 'table=historique';
    if ($('#ligneRechercheTableHistorique').hasClass('isGlobal')) {
        datastring += '&global=true';
    } else {
        datastring += '&idIndividu='+$('#list_individu').children('.current').children().attr('id_individu');
    }
    $('#ligneRechercheTableHistorique').find('[columnName]').each(function(){
        if($(this).is('div')) {
            if($(this).text() != '--------') {
                datastring += '&' + $(this).attr('columnName') + '=' + $(this).text();
            }
        } else {
            if($(this).val() != '') {
                datastring += '&' + $(this).attr('columnName') + '=' + $(this).val();
            }
        }
    });
        
    console.log(datastring);
    $.ajax({
        type: 'post',
        data: datastring,
        url: './index.php?p=searchTableHistorique',
        cache: false,
        //Succès de la requête
        success: function(tableHistorique) {
            //                console.log(tableStatique);
            $("#contenu_table_historique").html(tableHistorique);
        },
        error: function(tableHistorique) {
            $("#contenu_table_historique").html(tableHistorique.responseText);
        }
    });
}

function autoComplete(searchbox, table, champ) {
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
            $('#suggestion').html(html);
            $('.liste_suggestion > li:first').focus();
        },
        error: function(html) {
            $('#suggestion').html(html.responseText);
        }
    });
}

/*
 * fonction qui fait les operations lors de la selection dans un autocomplete
 */
function selectionList(focus, table, champ) {
    console.log('focus ' + focus);
    console.log('table ' + table);
    console.log('champ ' + champ);
    $('.autoComplete[table="' + table + '"][champ="' + champ + '"]').val(focus.text());
    $('.autoComplete[table="' + table + '"][champ="' + champ + '"]').attr("valeur", focus.attr("valeur"));
    $('#suggestion').css("display", "none"); 
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
        },
        error: function(html) {
            $("#list_individu").html(html.responseText);
        }
    });
}

function calculTailleInputSearch() {
    $('#search').css({
        "width" : $('#menu_gauche').outerWidth() - $('.add').outerWidth(true) 
        - parseInt($('#search').css("margin-left")) - 1
    });
    
    function createPickers(context) {
        $(".datefield", context || document).datepicker({
            showAnim:'fadeIn',
            dateFormat:'dd/mm/yy',
            changeMonth:true,
            changeYear:true
        });
    }
}