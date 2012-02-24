/* ATTENTION CE FICHIER EST A UTILISER APRES L'APPEL A UNE FONCTION AJAX
 * ETANT DONNE QUE L'AJAX NE RECHARGE PAS TOUTE LA PAGE LE JQUERY N'EST EFFECTIF
 * QUE SUR LA PAGE INITIAL */
$(function() {
    /* retourne l'element sur lequel on clique */
    $('#list_individu > li').click(function() {
        console.log('ONCLICK');
        /* recherche dans les enfants de l'id list_individu une class current */
        $('#list_individu').children('.current').removeClass('current');
        $(this).addClass('current');
    });  
    
});
