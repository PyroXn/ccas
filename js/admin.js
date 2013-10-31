$(function() {
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
                //Succés de la requête
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
                //Succés de la requête
                success: function() {
                },
                error: function(html) {
                    $("#contenu").html(html.responseText);
                }
            });
        }
    });
    
    $('.radio_stat').live('change', function(){
        if ($("input[type=radio][name=groupe3]:checked").val() != "periode") {
                    $.ajax({
                    type: 'POST',
                    url: './index.php?p=genererPeriode',
                    cache: false,
                    //Succ�s de la requ�te
                    success: function(graph) {
                        $('#periode_exacte').html("");
                    },
                    error: function() {
                        $("#periode_exacte").html();
                    }
                });
        } else if ($("input[type=radio][name=groupe3]:checked").val() == "periode" && ($('#datedebut').val() == null || $('#datedebut').val() == '') && ($('#datefin').val() == null || $('#datefin').val() == '')) {
                $.ajax({
                    type: 'POST',
                    url: './index.php?p=genererPeriode',
                    cache: false,
                    //Succ�s de la requ�te
                    success: function(graph) {
                        $('#periode_exacte').html(graph);
                        $('#graph_stat').html("");
                    },
                    error: function() {
                        $("#periode_exacte").html();
                    }
                });
        }
        if ($("input[type=radio][name=groupe3]:checked").val() != "periode" ||
           (($("input[type=radio][name=groupe3]:checked").val() == "periode" && 
             ($('#datedebut').val() != null && $('#datedebut').val() != '') && ($('#datefin').val() != null) && $('#datefin').val() != ''))) {
            genererGraphstat();
        } 
    });
    
});    


function genererGraphstat() {
    if ($('input[type=radio][name=groupe1]:checked').length != 0 &&
        $('input[type=radio][name=groupe2]:checked').length != 0 &&
        $('input[type=radio][name=groupe3]:checked').length != 0) {
            var datastring = 'groupe1=' + $("input[type=radio][name=groupe1]:checked").val() 
                           + '&groupe2=' + $("input[type=radio][name=groupe2]:checked").val()
                           + '&groupe3=' + $("input[type=radio][name=groupe3]:checked").val()
                           + '&datedebut=' + $('#datedebut').val() + '&datefin=' + $('#datefin').val();
            console.log(datastring);
            $.ajax({
                type: 'POST',
                data: datastring,
                url: './index.php?p=genererStat',
                cache: false,
                //Succ�s de la requ�te
                success: function(graph) {
                    $('#graph_stat').html(graph);
                },
                error: function() {
                    $("#graph_stat").html();
                }
            });
    }
}
