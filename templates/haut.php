<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns ="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>ccas</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="./navigationbar.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="./ccas.css" media="screen" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="./js/navigationbar.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){

                $(".search").keyup(function() 
                {
                    var searchbox = $(this).val();
                    var dataString = 'searchword='+ searchbox;
                    $.ajax({
                        type: "POST",
                        url: "../search.php",
                        data: dataString,
                        cache: false,
                        success: function(html)
                        {
                            $("#list_foyer").html(html).show();	
                        }
                    });
                    return false;
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
                    include('../config.php');
                    $retour = '';
                    $foyers = Doctrine_Core::getTable('Foyer')->findAll();
                    $i = 0;
                    foreach ($foyers as $foyer) {
                        if ($i % 2 == 0) {
                            $retour .= '<li class="pair">';
                        } else {
                            $retour .= '<li class="impair">';
                        }
                        $retour .= '
                            <a href="#">
                                <span class="label">' . utf8_encode($foyer->nom) . ' ' . utf8_encode($foyer->prenom) . '</span>
                            </a>
                        </li>';
                        $i++;
                    }
                    echo $retour;
                    ?>
                </ul>
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