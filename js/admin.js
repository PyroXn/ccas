$(function() {
    $('.delete_user').live("click",function() {
        var idUser = $(this).attr('idUser');
        $.ajax({
            url: './index.php?p=deleteUser',
            type:'POST',
            data: "idUser="+idUser,
            cache: false,
            //Succès de la requête
            success: function(user) {
                $('#contenu').html(user);
            },
            error: function(user) {
                $("#contenu").html(user.responseText);
            }
        });
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
                },
                error: function(html) {
                    $("#contenu").html(html.responseText);
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
                },
                error: function(html) {
                    $("#contenu").html(html.responseText);
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
            },
            error: function(role) {
                $("#contenu").html(role.responseText);
            }
        });
    });
    
    $('.radio_stat').live('change', function(){
        var datastring = 'groupe1=' + $("input[name='groupe1']:checked").val() 
                       + '&groupe2=' + $("input[name='groupe2']:checked").val()
                       + '&groupe3=' + $("input[name='groupe3']:checked").val();
        $.ajax({
            type: 'POST',
            data: datastring,
            url: './index.php?p=genererStat',
            cache: false,
            //Succès de la requête
            success: function(graph) {
                alert('succes');
                $('#graph_stat').html(graph);
            },
            error: function() {
                $("#graph_stat").html();
            }
        });
    });
});    
