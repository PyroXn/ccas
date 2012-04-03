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
    
    $('.permission').live("click",function() {
        $(this).next().toggle();
    });
    
    $('.checkboxPermission').live("click", function(){
        $(this).toggleClass('checkbox_active');
        var datastring = 'droit=' + $(this).attr('droit') + '&idRole=' + $(this).attr('idRole');
        if ($(this).hasClass('checkbox_active')) {
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=addPermission',
                cache: false,
                //Succès de la requête
                success: function() {
                }
            });
        } else {
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=removePermission',
                cache: false,
                //Succès de la requête
                success: function() {
                }
            });
        }
    });
    
    $('.delete_role').live("click", function(){
        var datastring = 'idRole=' + $(this).attr('idRole');
        $.ajax({
            type: 'post',
            data: datastring,
            url: './index.php?p=removeRole',
            cache: false,
            //Succès de la requête
            success: function(role) {
                $('#contenu').html(role);
            }
        });
    });
});    
