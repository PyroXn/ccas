<html>
    <head>
        <title>Infinite Scroll</title>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script type="text/javascript">
 
            $(document).ready(function(){ // Quand le document est compl�tement charg�
 
                var load = false; // aucun chargement de commentaire n'est en cours
 
                /* la fonction offset permet de r�cup�rer la valeur X et Y d'un �l�ment
                dans une page. Ici on r�cup�re la position de la derniere li qui 
                a pour classe : ".foyer" */
                var offset = $('.foyer:last').offset(); 
 
                $(window).scroll(function(){ // On surveille l'�v�nement scroll
 
                    /* Si l'�l�ment offset est en bas de scroll, si aucun chargement 
                        n'est en cours, si le nombre de foyer affich� est sup�rieur 
                        � 10 et si tout les foyer ne sont pas affich�s, alors on 
                        lance la fonction. */
                    if((offset.top-$(window).height() <= $(window).scrollTop()) 
                        && load==false && ($('.foyer').size()>=100) && 
                        ($('.foyer').size()!=$('.nb_foyer').text())){
                        
                        // la valeur passe � vrai, on va charger
                        load = true;
 
                        //On r�cup�re le nombre de foyer affich� global
                        var nb_foyer_total = $('.foyer:last').attr('id');
                        //On affiche un loader
                        $('.loadmore').show();
 
                        //On lance la fonction ajax
                        $.ajax({
                            url: './ajax.php',
                            type: 'get',
                            data: 'last='+nb_foyer_total,
 
                            //Succ�s de la requ�te
                            success: function(data) {
 
                                //On masque le loader
                                $('.loadmore').fadeOut(500);
                                /* On affiche le r�sultat apr�s
                                                le dernier foyer */
                                $('.foyer:last').after(data);
                                /* On actualise la valeur offset
                                                du dernier foyer */
                                offset = $('.foyer:last').offset();
                                //On remet la valeur � faux car c'est fini
                                load = false;
                            }
                        });
                    }
 
 
                });
 
            });
 
        </script>
        <style>
            body{
                background:#ffffff;
            }
            /* Juste pour l'affichage, aucun int�r�t ici ;) */
        </style>
    </head>

    <body>
            <ul id="list_foyer">
                <?php
                include('../config.php');
                $retour = '';
                $foyers = Doctrine_Core::getTable('foyer');
                $retour .= '<div class="nb_foyer">'. $foyers->count() .'</div>';
                
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
            <div class="loadmore">
                Chargement en cours...
            </div>
    </body>

</html>