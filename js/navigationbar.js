/*
 * Pour éviter que le style par défaut n?apparaisse furtivement pendant le chargement de la page, 
 * il faut placer la condition en dehors de la fonction document ready bien qu?il ne 
 * soit généralement pas recommandé de manipuler le DOM avant le chargement complet du document.
 */
if($.cookie("css")) {
    $("link.switchable").attr("href",$.cookie("css"));
}

$(function() {
    $("#cssSwitch li a").click(function() { 
        $("link.switchable").attr("href",$(this).attr('rel'));
        $.cookie("css",$(this).attr('rel'), {expires: 30, path: '/'});
        $('body').hide().fadeIn(1250);
        return false;
    });
    
    $('#lien_option').click(function() {
        if($(this).attr("name") == "passive") {
            $('.menu_option').css({
                "top":"29px"
            });
            $('.menu_option').css({
                "visibility":"visible"
            });
            $('#option').css({
                "background-color":"white"
            });
            $('#option').css({
                "background-position":"5px -21px"
            });
            $('#option').css({
                "border-color":"#BEBEBE"
            });
            $('#option').css({
                "padding-top":"1px"
            });
            $(this).attr("name","active");
        } else {
            $('.menu_option').css({
                "top":"-999px"
            });
            $('.menu_option').css({
                "visibility":"hidden"
            });
            $('#option').css({
                "background-color":""
            });
            $('#option').css({
                "background-position":"5px 7px"
            });
            $('#option').css({
                "border-color":""
            });
            $('#option').css({
                "padding-top":"0"
            });
            
            $(this).attr("name","passive");
        }
    });
});
        
