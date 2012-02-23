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
        <script type="text/javascript" src="../js/navigationbar.js"></script>
        <script type="text/javascript" src="../js/search.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                /* la fonction offset permet de récupérer la valeur X et Y d'un élément
            dans une page. Ici on récupère la position de la derniere li qui 
            a pour classe : ".foyer" */
                var offset = $("#list_foyer").height();
                $("#side_foyer").scroll(function(){ // On surveille l'évènement scroll
                    //                alert("scrollheight" + $(this)[0].scrollHeight);
                    //                if ($(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
                    //                         // We're at the bottom.
                    //                         alert("yeah !");
                    //                    }
                    var load = false; // aucun chargement de foyer n'est en cours

                    
                    /* Si l'élément offset est en bas de scroll, si aucun chargement 
                n'est en cours, si le nombre de foyer affiché est supérieur 
                à 100 et si tout les foyer ne sont pas affichés, alors on 
                lance la fonction. */
                    console.log("\n offset.top" + offset + "\n " + "Height" + $("#side_foyer").height() + "\n " + "scrollTop" + $(this)[0].scrollTop
                        + "\n " + "total = " + (offset-$("#side_foyer").height() <= $(this)[0].scrollTop));

                    if((offset-$("#side_foyer").height() <= $(this)[0].scrollTop) 
                        && load==false && ($('.foyer').size()>=100) && 
                        ($('.foyer').size()!=$('.nb_foyer').text())){
                        // la valeur passe à vrai, on va charger
                        load = true;
 
                        //On récupère le nombre de foyer affiché global
                        var nb_foyer_total = $('.foyer:last').attr('id');
                        
//                        //On affiche un loader
//                        $('.loadmore').show();
 
                        //On lance la fonction ajax
                        $.ajax({
                            url: '../testInfiniteScroll/ajax.php',
                            type: 'get',
                            data: 'last='+nb_foyer_total,
 
                            //Succès de la requête
                            success: function(data) {
 
//                                //On masque le loader
//                                $('.loadmore').fadeOut(500);
                                /* On affiche le résultat après
                                        le dernier foyer */
                                $('.foyer:last').after(data);
                                /* On actualise la valeur offset
                                        du dernier foyer */
                                offset = $("#list_foyer").height();
                                //On remet la valeur à faux car c'est fini
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


        <div id="menu_gauche">
            <input class="search" type="text" placeholder="Search..."/>
            <div id="side_foyer">
                <ul id="list_foyer">
                    <?php
//                    include('../config.php');
//                    $retour = '';
//                    $foyers = Doctrine_Core::getTable('Foyer')->findAll();
//                    $i = 0;
//                    foreach ($foyers as $foyer) {
//                        if ($i % 2 == 0) {
//                            $retour .= '<li class="pair">';
//                        } else {
//                            $retour .= '<li class="impair">';
//                        }
//                        $retour .= '
//                            <a href="#">
//                                <span class="label">' . $foyer->nom . ' ' . $foyer->prenom . '</span>
//                            </a>
//                        </li>';
//                        $i++;
//                    }
//                    echo $retour;
                    ?>

                    <?php
                    include('../lib/config.php');
                    $retour = '';
                    $foyers = Doctrine_Core::getTable('foyer');
                    $retour .= '<div class="nb_foyer">' . $foyers->count() . '</div>';

                    $i = 1;
                    foreach ($foyers->searchByLimitOffset(100, 0)->execute() as $foyer) {

                        if ($i % 2 == 0) {
                            $retour .= '<li class="pair foyer" id="' . $i . '">';
                        } else {
                            $retour .= '<li class="impair foyer" id="' . $i . '">';
                        }
                        $retour .= '
                            <a href="#">
                                <span class="label">' . $foyer->nom . ' ' . $foyer->prenom . ' ' . $foyer->id . '</span>
                            </a>
                        </li>';
                        $i++;
                    }
                    echo $retour;
                    ?>
                </ul>
<!--                <div class="loadmore">
                    Chargement en cours...
                </div>-->
            </div>
        </div>
        <div id="page_header">
            <div id="page_header_navigation">
                <a href="#" class="page_header_link active">
                    <span class="label">Opif</span>
                </a>
                <a href="#" class="page_header_link">
                    <span class="label">Loulilou</span>
                </a>
            </div>

        </div>
    </body>
</html>