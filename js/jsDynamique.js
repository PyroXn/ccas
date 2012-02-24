/* ATTENTION CE FICHIER EST A UTILISER APRES L'APPEL A UNE FONCTION AJAX
 * ETANT DONNE QUE L'AJAX NE RECHARGE PAS TOUTE LA PAGE LE JQUERY N'EST EFFECTIF
 * QUE SUR LA PAGE INITIAL */
$(function() {
    $('#list_individu > li').click(function() {
        console.log("ONCLICK");
        $(this).css({
            "background-color":"black"
        });
        $(this).addClass("current");
    });  
    
});
