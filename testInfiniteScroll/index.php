<html>
    <head>
        <title>Infinite Scroll</title>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script type="text/javascript">
 
            $(document).ready(function(){ // Quand le document est complètement chargé
 
                var load = false; // aucun chargement de commentaire n'est en cours
 
                /* la fonction offset permet de récupérer la valeur X et Y d'un élément
                dans une page. Ici on récupère la position de la derniere li qui 
                a pour classe : ".foyer" */
                var offset = $('.foyer:last').offset(); 
 
                $(window).scroll(function(){ // On surveille l'évènement scroll
 
                    /* Si l'élément offset est en bas de scroll, si aucun chargement 
                        n'est en cours, si le nombre de foyer affiché est supérieur 
                        à 10 et si tout les foyer ne sont pas affichés, alors on 
                        lance la fonction. */
                    if((offset.top-$(window).height() <= $(window).scrollTop()) 
                        && load==false && ($('.foyer').size()>=100) && 
                        ($('.foyer').size()!=$('.nb_foyer').text())){
                        
                        // la valeur passe à vrai, on va charger
                        load = true;
 
                        //On récupère le nombre de foyer affiché global
                        var nb_foyer_total = $('.foyer:last').attr('id');
                        //On affiche un loader
                        $('.loadmore').show();
 
                        //On lance la fonction ajax
                        $.ajax({
                            url: './ajax.php',
                            type: 'get',
                            data: 'last='+nb_foyer_total,
 
                            //Succès de la requête
                            success: function(data) {
 
                                //On masque le loader
                                $('.loadmore').fadeOut(500);
                                /* On affiche le résultat après
                                                le dernier foyer */
                                $('.foyer:last').after(data);
                                /* On actualise la valeur offset
                                                du dernier foyer */
                                offset = $('.foyer:last').offset();
                                //On remet la valeur à faux car c'est fini
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
            /* Juste pour l'affichage, aucun intérêt ici ;) */
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