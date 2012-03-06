$(function() {
    $('#newfoyer').click(function() {
        creationForm($(this).offset(), $(this).outerHeight(), $('.formulaire[action="creation_foyer"]'))
    });
    
    $('#newUser').live("click", function() {
        creationForm($(this).offset(), $(this).outerHeight(), $('.formulaire[action="creation_utilisateur"]'))
    });
    
    $('#newIndividu').live("click", function() {
        creationForm($(this).offset(), $(this).outerHeight(), $('.formulaire[action="creation_individu"]'))
    });
    
    
    $('.select').live("click", function() {
        //permet de generaliser sur tous les select
        var attr = '.'+$(this).attr('role');
        console.log(attr);
        var x = $(this).offset();
        var h = $(this).outerHeight();
        $(attr).toggle();
        $(attr).offset({
            top:x.top+h,
            left:x.left
        });
        $(this).children('.option').toggleClass('en_attente');
        $(attr).toggleClass('en_execution');
    });
    
    $('.checkbox').live("click", function(){
        if(!$(this).hasClass('checkbox_active')) {
            $('.checkbox_active').toggleClass('checkbox_active');
            $(this).toggleClass('checkbox_active');
            $('.update').css({
                "display":"block"
            });
            $('.update').css({
                "margin-right":"0"
            });
        }
    });
    
    $('.en_execution > li').live("click", function() {
        console.log($(this).children().text());
        $('.en_execution').toggle();
        $('.en_attente').text($(this).children().text());
        $('.en_attente').toggleClass('en_attente');
        $('.en_execution').toggleClass('en_execution');   
    });
    
    $('.bouton').live("click", function() {
        var value = $(this).attr('value');
        var formActuel = $(this).parent().parent().parent();
        if(value=='cancel') {
            $('.en_execution').toggle();
            $('.en_execution').toggleClass('en_execution');
            $('.en_attente').toggleClass('en_attente');
            $('#ecran_gris').toggle();
            //            $('.formulaire').toggle();
            formActuel.toggle();
            effacer();
        } else if(value=='save') {
            //commun a tous les form
            var table = $('.formulaire').attr('action');
            var datastring = 'table=' + table
            
            
            switch(table){
                //unique pour la creation de foyer
                case 'creation_foyer':
                    datastring += '&civilite=' + $('#form_1').text();
                    datastring += '&nom=' + $('#form_2').val();
                    datastring += '&prenom=' + $('#form_3').val();
                    break;
                case 'creation_utilisateur':
                    datastring += '&login='+$('#newlogin').val();
                    datastring += '&pwd='+$('#newpwd').val();
                    datastring += '&nomcomplet='+$('#newnomcomplet').val();
                    break;
                case 'creation_individu':
                    datastring += '&idFoyer=' + $('#list_individu').children('.current').children().attr('id_foyer');
                    datastring += '&idIndividuCourant=' + $('#list_individu').children('.current').children().attr('id_individu');
                    datastring += '&civilite=' + $('#form_1').text();
                    datastring += '&nom=' + $('#form_2').val();
                    datastring += '&prenom=' + $('#form_3').val();
                    break;
                        
            }
            $.ajax({
                type: 'post',
                dataType:'json',
                data: datastring,
                url: './index.php?p=form',
                //Succès de la requête
                success: function(data) {
                    $('#ecran_gris').toggle();
                    formActuel.toggle();
                    effacer();
                    
                    switch(table){
                        //unique pour la creation de foyer
                        case 'creation_foyer':
                            $("#list_individu").html(data.listeIndividu);
                            $("#page_header_navigation").html(data.menu);
                            $('#contenu').html(data.contenu);
                            break;
                        case 'creation_utilisateur':
                            $("#contenu").html(data.tableau);
                            break;
                        case 'creation_individu':
                            $("#list_individu").html(data.listeIndividu);
                            /*Si lenteur possibilité de ne regénéré que la liste et pas tous le contenu*/
                            $('#contenu').html(data.newIndividu);
                            break;
                    }
                //FONCTIONNE PAS 
                //                    if(!($.isEmptyObject(data.listeIndividu) && $.isEmptyObject(data.menu))) {
                //                        $("#list_individu").html(data.listeIndividu);
                //                        $("#page_header_navigation").html(data.menu);
                //                    } else if(!$.isEmptyObject(data.tableau)) {
                //                        $("#contenu").html(data.tableau);
                //                    } else if(!$.isEmptyObject(data.newIndividu)) {
                //                        $("#list_individu").html(data.listeIndividu);
                //                        /*Si lenteur possibilité de ne regénéré que la liste et pas tous le contenu*/
                //                        $('#contenu').html(data.newIndividu);
                //                    }     
                }
            });
        } else if (value == 'updateMembreFoyer') {
            $membreFoyer = $('.checkbox_active').parent().parent().parent();
            console.log($membreFoyer);
            $idFoyer = $membreFoyer.attr('id_foyer');
            $idIndividu = $membreFoyer.attr('id_individu');
            datastring = 'idFoyer=' + $idFoyer;
            datastring += '&idIndividu=' + $idIndividu;
            console.log('datastring' + datastring);
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=individu',
                //Succès de la requête
                success: function(contenu) {
                    console.log(contenu);
                    $('#contenu').html(contenu);
                }
            });
            
        } else if(value == 'updateRessource') {
            var loc = $(this);
            var idIndividu = $('#list_individu').children('.current').children().attr('id_individu');
            datastring = 'idIndividu='+idIndividu+'&salaire='+$('#salaire').val();
            datastring += '&chomage='+$('#chomage').val()+'&revenuAlloc='+$('#revenuAlloc').val();
            datastring += '&ass='+$('#ass').val()+'&aah='+$('#aah').val();
            datastring += '&rsaSocle='+$('#rsaSocle').val()+'&rsaActivite='+$('#rsaActivite').val();
            datastring += '&retraitComp='+$('#retraitComp').val()+'&pensionAlim='+$('#pensionAlim').val();
            datastring += '&pensionRetraite='+$('#pensionRetraite').val()+'&autreRevenu='+$('#autreRevenu').val();
            datastring += '&natureAutre='+$('#natureRevenu').val();
            $.ajax({
                type: 'post',
                dataType:'json',
                data: datastring,
                url: './index.php?p=updateressource',
                //Succès de la requête
                success: function(data) {
                    loc.parent().find('input').attr("disabled","disabled");
        }
    });
        }
    });
    
    
    function effacer() {
        $('.input_text').children().val('');
    }
    
    //permet l'affichage des formulaires flottant entouré de gris
    function creationForm(x, h, form) {
        $('#ecran_gris').toggle();
        $(form).css({
            "display":"block"
        });
        $(form).offset({
            top:x.top+h,
            left:x.left
        });
    }
    
    $('.edit').live("click", function() {
        $(this).parent().next().children().find('input').removeAttr("disabled");
        $('.update').css({
                 "margin-right":"0"
            });
            $('.update').slideToggle();
    });
});