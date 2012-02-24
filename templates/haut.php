<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns ="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>ccas</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="./navigationbar.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="./ccas.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="./templates/navigationbar.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="./templates/ccas.css" media="screen" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="./js/navigationbar.js"></script>
        <script type="text/javascript" src="./js/search.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                /* la fonction offset permet de r�cup�rer la valeur X et Y d'un �l�ment
            dans une page. Ici on r�cup�re la position de la derniere li qui 
            a pour classe : ".individu" */
                var offset = $("#list_individu").height();
                $("#side_individu").scroll(function(){ // On surveille l'�v�nement scroll
                    //                alert("scrollheight" + $(this)[0].scrollHeight);
                    //                if ($(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
                    //                         // We're at the bottom.
                    //                         alert("yeah !");
                    //                    }
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
                        
//                        //On affiche un loader
//                        $('.loadmore').show();
 
                        //On lance la fonction ajax
                        $.ajax({
                            url: './scroll.php',
                            type: 'get',
                            data: 'last='+nb_individu_total,
 
                            //Succ�s de la requ�te
                            success: function(data) {
 
//                                //On masque le loader
//                                $('.loadmore').fadeOut(500);
                                /* On affiche le r�sultat apr�s
                                        le dernier individu */
                                $('.individu:last').after(data);
                                /* On actualise la valeur offset
                                        du dernier individu */
                                offset = $("#list_individu").height();
                                //On remet la valeur � faux car c'est fini
                                load = false;
                            }
                        });
                    }
                });
                
            });
        </script>

    </head>
    <body>
        <div id="navigationbar">
            <ul id="navigationlist">
                <li class="navigationligne">
                    <a id="" class="lien_navigation" href="#" title="Ccas">
                        <span class="border_top"></span>
                        <span class="categorie">Ccas</span>
                    </a>
                </li>
                <li class="navigationligne">
                    <a id="" class="lien_navigation current" href="#" title="Expulsion">
                        <span class="border_top"></span>
                        <span class="categorie">Expulsion</span>
                    </a>
                </li>
                <li class="navigationligne">
                    <a id="" class="lien_navigation" href="#" title="Opif">
                        <span class="border_top"></span>
                        <span class="categorie">Opif</span>
                    </a>
                </li>
            </ul>
            <div id="navigationright">
                <ul id="connexionlist">
                    <li class="navigationligne">
                        <a class="lien_navigation" href="#" title="Connexion">
                            <span class="border_top"></span>
                            <span class="categorie">Pierre Charrasse</span>
                        </a>
                    </li>
                    <li class="navigationligne">
                        <a id="lien_option" name="passive" class="lien_navigation actif" href="#" title="Options">
                            <span class="border_top"></span>
                            <span id="option" class="categorie"></span>
                        </a>
                        <div class="menu_option">
                            <ul class="liste_menu_option">
                                <li>
                                    <a class="" href="#" >Coucou c'est moi</a>
                                </li>
                                <li>
                                    <a class="" href="#" >Coucou c'est moi2</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>


