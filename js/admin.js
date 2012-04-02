$(function() {
    $('#test').live("click",function() {
        var name = $(this).attr('name');
        if(confirm("Confirmer la d\351sactivation du compte utilisateur "+name+" ?")) {
            alert("ok");
        }
    });
    
    $('#permissions_configurator_tabs > li').live("click",function() {
        var pane = "#"+$('.selected').attr('id') + "_pane";
        var currentPane = "#"+$(this).attr('id') + "_pane";
        $('.selected').toggleClass('selected');
        $(this).toggleClass('selected');
        $(currentPane).toggle();
        $(pane).toggle();
    });
});
        
