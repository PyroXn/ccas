$(function() {
    $('#newfoyer').click(function() {
        creationForm($(this).offset(), $(this).outerHeight(), $('.formulaire[action="creation_foyer"]'))
    });
    $('#newRole').live("click", function() {
        console.log('LA');
        creationForm($(this).offset(), $(this).outerHeight(), $('.formulaire[action="creation_role"]'))
    });
    
    $('#newUser').live("click", function() {
        creationForm($(this).offset(), $(this).outerHeight(), $('.formulaire[action="creation_utilisateur"]'))
    });
    
    $('#newIndividu').live("click", function() {
        console.log('Creation Form');
        creationForm($(this).offset(), $(this).outerHeight(), $('.formulaire[action="creation_individu"]'))
    });
    
    $('.delete_doc').live("click", function() {
        var file = $(this).attr('name');
        datastring = 'file='+file;
        $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=deletedoc',
                cache: false,
                //Succés de la requête
                success: function(data) {
                    $("#contenu").html(data);
                }
            });
    })
    $('.addElem').live("click", function() {
        console.log("addElem");
        var action = $(this).attr('role');
        var form = $('.formulaire[action="'+action+'"]');
        var newPosition = new Object();
        newPosition.left = $(window).width()/2 - form.width()/2;
        newPosition.top = $(window).height()/2 - form.height();
        creationForm(newPosition, $(this).outerHeight(), form);
    });
    
    $('.edit_user').live("click",function() {
        var form = $('.formulaire[action="creation_utilisateur"]');
        var newPosition = new Object();
        newPosition.left = $(window).width()/2 - $(form).width()/2;
        newPosition.top = $(window).height()/2 - $(form).height();
        creationForm(newPosition, $(this).outerHeight(), $(form));
        var ligne = $(this).parent().parent();
        form.find('#newlogin').val(ligne.find('[login]').text());
        form.find('#newnomcomplet').val(ligne.find('[nomcomplet]').text());
        form.find('#newrole').text(ligne.find('[role]').text());
        form.attr('iduser', $(this).attr('idUser'));
    });
    
    $('#createAction').live("click", function() {
        creationForm($(this).offset(), $(this).outerHeight(), $('.formulaire[action="creation_action"]'));
    });

    $('#newTableGenerique').live("click", function() {
        $('.formulaire[action="edit_ligne"]').attr('table', $(this).attr('table'));
        $('.formulaire[action="edit_ligne"]').removeAttr('idLigne');
        creationForm($(this).offset(), $(this).outerHeight(), $('.formulaire[action="edit_ligne"]'))
    });
    
    $('#newDocument').live("click", function() {        
        var newPosition = new Object();
        newPosition.left = $(window).width()/2 - $('.formulaire[action="new_document"]').width()/2;
        newPosition.top = $(window).height()/2 - $('.formulaire[action="new_document"]').height();
        creationForm(newPosition, $(this).outerHeight(), $('.formulaire[action="new_document"]'));
    });
    
    $('#createAideInterne').live("click", function() {
        creationForm($(this).offset(), $(this).outerHeight(), $('.formulaire[action="creation_aide_interne"]'));
    });
    
    $('#createAideExterne').live("click", function() {
        creationForm($(this).offset(), $(this).outerHeight(), $('.formulaire[action="creation_aide_externe"]'));
    });
    
    $('.edit_ligne').live("click", function() {
        var form = $('.formulaire[action="edit_ligne"]');
        var newPosition = new Object();
        var tmp = $(this).parent();
        var tab = false;
        if ($(tmp).hasClass('icon')) {
            tmp = $(tmp).parent();
            tab = true;
        }
        console.log($(window).height());
        console.log(form.height());
        newPosition.left = $(window).width()/2 - form.width()/2;
        newPosition.top = $(window).height()/2 - form.height()/2;
        form.attr('table', $(this).attr('table'));
        form.attr('idLigne', $(this).attr('idLigne'));
        $(form).find('[columnName]').each(function(){
            //            console.log($(this).attr('columnName')); // balance la valeur de l'attribut
            //            var test = tmp.find('[columnName="'+$(this).attr('columnName')+'"]'); //le input

            // pour chaque columnname du formulaire on cherche si il existe une columnname avec une valeur similaire dans notre edit_ligne
            // si c'est le cas on lui met la valeur'
            if ($(this).children().hasClass('checkbox')) {   //gestion checkbox
                var value = $(tmp.find('[columnName="'+$(this).attr('columnName')+'"]')).attr('value');
                $(this).children().each(function(){
                    if ($(this).hasClass('checkbox')) {
                        $(this).attr('value', value);
                        value == '1' ? $(this).addClass('checkbox_active') : $(this).removeClass('checkbox_active');
                    }
                });
            } else if($(this).children().hasClass('option')) {
                var valuecle = $(tmp.find('[columnName="'+$(this).attr('columnName')+'"]')).text();
                var idcle = $(tmp.find('[columnName="'+$(this).attr('columnName')+'"]')).attr('idcleetrangere');
                $(this).children().each(function(){
                    if ($(this).hasClass('option')) {
                        $(this).text(valuecle);
                        $(this).attr('value', idcle);
                    }
                });                
            } else if (tab) {
                $(this).children().val($(tmp.find('[columnName="'+$(this).attr('columnName')+'"]')).text());
            } else {
                $(this).children().val($(tmp.find('[columnName="'+$(this).attr('columnName')+'"]')).val());
            }
        });
        creationForm(newPosition, $(this).outerHeight(), form);
    });
    
    $('.select').live("click", function() {
        if (!$(this).attr('disabled')) {
            //permet de generaliser sur tous les select
            var attr = '.'+$(this).attr('role');
            
            $(attr).toggle();
            var x = $(this).offset();
            var h = $(this).outerHeight();
            var l = $(this).outerWidth();
            //les -2 correspondent à la bordure de 1px de chacun des 2 cotés
            $(attr).css("min-width", l-2);
            var lAttr = $(attr).outerWidth();
            console.log(attr);
            $(attr).offset({
                top:x.top+h,
                left:x.left+l-lAttr
            });
            
            $(this).children('.option').toggleClass('en_attente');
            $(attr).toggleClass('en_execution');
        }
    });
    
    $('.checkboxChefFamille').live("click", function(){
        if (!$(this).attr('disabled')) {
            if(!$(this).hasClass('checkbox_active')) {
                $('.checkbox_active').toggleClass('checkbox_active');
                $(this).toggleClass('checkbox_active');
                $('.update[value="updateMembreFoyer"]').css({
                    "display":"block"
                });
                $('.update[value="updateMembreFoyer"]').css({
                    "margin-right":"0"
                });
            }
        }
    });
    
    $('#checkboxScolarise').live("click", function(){
        if (!$(this).attr('disabled')) {
            $('#ligneScolaire').toggleClass('nonscolarise');
        }
    });
    
    $('.checkbox').live("click", function(){
        if (!$(this).attr('disabled')) {
            $(this).toggleClass('checkbox_active');
            console.log($(this).parent().parent());
            if ($(this).parent().parent().is('#ligneRechercheTableStatique')) {
                searchTableStatique();
            }
        }
    });
    
    $('.en_execution > li').live("click", function() {
        console.log($(this).children().attr('value'));
        $('.en_execution').toggle();
        $('.en_attente').text($(this).children().text());
        $('.en_attente').attr('value', $(this).children().attr('value'));
        $('.en_attente').toggleClass('en_attente');
        $('.en_execution').toggleClass('en_execution');
        if ($(this).parent().hasClass("select_table_statique")) {
            var datastring = 'table=' + $('#choixTableStatique').text();
            console.log(datastring);
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=generateEcranStatique',
                cache: false,
                //Succés de la requête
                success: function(data) {
                    $("#tableStatique").html(data);
                }
            });
        }
        if ($(this).parent().hasClass("select_instruct")) {
            if ($(this).children().attr('interne') == 1) {
                $('#checkbox_instruct').addClass('checkbox_active');
            } else {
                $('#checkbox_instruct').removeClass('checkbox_active');
            }
        }
        if ($(this).parent().hasClass("select_historique_type_action")) {
            searchTableHistorique();
        }
        if($(this).parent().hasClass("select_graph_instruct")) {
            var stringdata = 'id='+$(this).children().attr('value');
            console.log(stringdata);
            $.ajax({
                type: 'post',
                data: stringdata,
                url: './index.php?p=graphinstruct',
                cache: false,
                success: function(graphInstruct) {
                    console.log('Success : '+graphInstruct);
                    $("#graphTypeAction").html(graphInstruct);
                }
            })
        }  
    });
    
    $('.bouton').live("click", function() {
        var value = $(this).attr('value');
        var formActuel = $(this).parent().parent().parent();
        var loc = $(this);
        var idIndividu = $('#list_individu').children('.current').children().attr('id_individu');
        console.log("FONCTION DE PORC");
        if(value=='cancel') {
            $('.en_execution').toggle();
            $('.en_execution').toggleClass('en_execution');
            $('.en_attente').toggleClass('en_attente');
            $('#ecran_gris').toggle();
            formActuel.find('.requis').each(function(){
                if ($(this).is('input')) {
                    if ($(this).val() == '') {
                        traitement = false;
                        $(this).removeClass('a_completer');
                    }
                } else if ($(this).hasClass('option')) {
                    if ($(this).attr('value') == undefined || $(this).attr('value') == '') {
                        traitement = false;
                        $(this).parent().removeClass('a_completer');
                    }
                }
            });
            formActuel.toggle();
            effacer();
        } else if(value=='saveTableStatique') {
            var form = $('.formulaire[action="edit_ligne"]');
            var table = form.attr('table');
            var idLigne = form.attr('idLigne');
            
            var datastring = 'table=' + table;
            if (idLigne != undefined) {
                datastring += '&idLigne='+idLigne;
            }
            $(form).find('[columnName]').each(function(){
                console.log($(this));
                console.log($(this).children());
                if ($(this).children().hasClass('checkbox')) {
                    if ($(this).children().hasClass('checkbox_active')) {
                        datastring += '&'+$(this).attr('columnName')+'=1';
                    } else {
                        datastring += '&'+$(this).attr('columnName')+'=0';
                    }
                } else if($(this).children().hasClass('option')) {
                    datastring += '&'+$(this).attr('columnName')+'=' + $(this).children().val();
                } else {
                    datastring += '&'+$(this).attr('columnName')+'=' + $(this).children().val();
                }
            });
            if(findRequis(form)) {
                console.log(datastring);
                $.ajax({
                    type: 'post',
                    data: datastring,
                    url: './index.php?p=saveTableStatique',
                    cache: false,
                    //Succés de la requête
                    success: function() {
                        $('#ecran_gris').toggle();
                        formActuel.toggle();
                        effacer();
                        searchTableStatique();
                    },
                    error: function(data) {
                        $("#contenu").html(data.responseText);
                    }
                });
            }
        } else if(value=='edit_action') {
            var idAction = $(this).attr('idAction');
            datastring = 'idAction='+idAction+'&idIndividu='+idIndividu+'&date='+$('#date_edit').val()+'&motif='+$('#motif_edit').val();
            datastring += '&suiteadonner='+$('#suiteadonner_edit').val()+'&suitedonnee='+$('#suitedonnee_edit').val();
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=updateaction',
                cache: false,
                //Succés de la requête
                success: function(data) {
                    $('#ecran_gris').toggle();
                    formActuel.toggle();
                    effacer();
                    $("#contenu").html(data);
                    
                },
                error: function(data) {
                    $("#contenu").html(data.responseText);
                }
            });
        } else if(value == 'updateDecisionInterne') {
            var traitement = true;
            console.log($('#decisionRequis'));
//            $('#decisionRequis').find('.requis').each(function(){
//                if ($(this).is('input')) {
//                    if ($(this).val() == '') {
//                        traitement = false;
//                        $(this).addClass('a_completer');
//                    } else {
//                        $(this).removeClass('a_completer');
//                    }
//                } else if ($(this).hasClass('option')) {
//                    if ($(this).attr('value') == undefined || $(this).attr('value') == '') {
//                        traitement = false;
//                        $(this).parent().addClass('a_completer');
//                    } else {
//                        $(this).parent().removeClass('a_completer');
//                    }
//                }
//                
//            });
            if(findRequis($('#decisionRequis'))) {
                var vigilance = 0;
                if($('#vigilance').hasClass('checkbox_active')) {
                    vigilance = 1;
                }
                datastring = 'idIndividu='+idIndividu+'&idAide='+$('#idAide').attr('value')+'&aide='+$('#aideaccorde').attr('value');
                datastring += '&date='+$('#dateDecision').val()+'&avis='+$('#avis').attr('value');
                datastring += '&vigilance='+vigilance+'&commentaire='+$('#commentaire').val();
                datastring += '&rapport='+$('#rapport').val()+'&decideur='+$('#decideur').attr('value');
                console.log(datastring);
                $.ajax({
                    type: 'post',
                    dataType:'json',
                    data: datastring,
                    url: './index.php?p=updatedecisioninterne',
                    cache: false,
                    success: function(aideinterne) {
                        console.log(aideinterne);
                        $('#contenu').html(aideinterne.aide);
                    },
                    error: function(aideinterne) {
                        $("#contenu").html(aideinterne.responseText);
                    }
                });
            }
        } else if(value == 'cancelDecisionInterne') {
            var idMenu = 'aides';
            var idFoyer = $('#list_individu').children('.current').children().attr('id_foyer');
            console.log(idIndividu);
            $.ajax({
                type: "POST",
                url: "./index.php?p=contenu",
                data: 'idMenu=' + idMenu + '&idIndividu='+ idIndividu + '&idFoyer='+idFoyer,
                cache: false,
                success: function(html)
                {
                    $("#contenu").html(html);
                },
                error: function(html) {
                    $("#contenu").html(html.responseText);
                }
            });
        } else if(value == 'cancelRapport') {
            datastring = 'idIndividu='+idIndividu;
            $.ajax({
                type: "POST",
                url: "./index.php?p=cancelrapport",
                data: datastring,
                cache: false,
                success: function(html) {
                    $('#contenu').html(html);
                },
                error: function(html) {
                    $('#contenu').html(html.responseText);
                }
            });
        } else if(value == 'updateDecisionExterne') {
            if(findRequis($('#decisionRequis'))) {
                datastring = 'idIndividu='+idIndividu+'&idAide='+$('#idAide').attr('value')+'&montantPercu='+$('#montantPercu').val();
                datastring += '&dateDecision='+$('#dateDecision').val()+'&avis='+$('#avis').attr('value');
                datastring += '&commentaire='+$('#commentaire').val();
                console.log(datastring);
                $.ajax({
                    type: 'post',
                    dataType:'json',
                    data: datastring,
                    url: './index.php?p=updatedecisionexterne',
                    cache: false,
                    success: function(aideexterne) {
                        console.log(aideexterne);
                        $('#contenu').html(aideexterne.aide);
                    },
                    error: function(aideexterne) {
                        $("#contenu").html(aideexterne.responseText);
                    }
                });
            }
        } else if(value == 'cancelDecisionExterne') {
            var idMenu = 'aides';
            var idFoyer = $('#list_individu').children('.current').children().attr('id_foyer');
            console.log(idIndividu);
            $.ajax({
                type: "POST",
                url: "./index.php?p=contenu",
                data: 'idMenu=' + idMenu + '&idIndividu='+ idIndividu + '&idFoyer='+idFoyer,
                cache: false,
                success: function(html)
                {
                    $("#contenu").html(html);
                },
                error: function(html) {
                    $("#contenu").html(html.responseText);
                }
            });
        } else if(value == 'ajout_doc_type') {
            $("#upload").upload('upload.php', function(retour) {
                console.log(retour);
                    if(retour != '') {
                         $('#ecran_gris').toggle();
                         formActuel.toggle();
                         effacer();
                        $('#contenu').html(retour);
                    }
                    else{
                        alert("non");
                        $('#result').html("L'upload a échoué");
                    }
            }, 'html');
        }
        else if(value=='save') {
//            var traitement = true;
//            formActuel.find('.requis').each(function(){
//                if ($(this).is('input')) {
//                    if ($(this).val() == '') {
//                        traitement = false;
//                        $(this).addClass('a_completer');
//                    } else {
//                        $(this).removeClass('a_completer');
//                    }
//                } else if ($(this).hasClass('option')) {
//                    if ($(this).attr('value') == undefined || $(this).attr('value') == '') {
//                        traitement = false;
//                        $(this).parent().addClass('a_completer');
//                    } else {
//                        $(this).parent().removeClass('a_completer');
//                    }
//                }
//                
//            });
            if (findRequis(formActuel)) {
                //commun a tous les form
                var table = formActuel.attr('action');
                var datastring = 'table=' + table;

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
                        datastring += '&role='+$('#newrole').text();
                        var iduser = formActuel.attr('iduser');
                        if (typeof iduser !== 'undefined' && iduser !== false) {
                            datastring += '&iduser='+iduser;
                        }
                        break;
                    case 'creation_individu':
                        datastring += '&idFoyer=' + $('#list_individu').children('.current').children().attr('id_foyer');
                        datastring += '&idIndividuCourant=' + $('#list_individu').children('.current').children().attr('id_individu');
                        datastring += '&civilite=' + $('#form_1').text();
                        datastring += '&nom=' + $('#form_2').val();
                        datastring += '&prenom=' + $('#form_3').val();
                        datastring += '&naissance='+$('#form_4').val();
                        datastring += '&idlienfamille='+$('#form_5').attr('value');
                        console.log('DATSTRING : ' + datastring);
                        break;
                    case 'creation_credit':
                        datastring += '&idIndividu='+idIndividu+'&organisme='+$('#organisme').val();
                        datastring += '&mensualite='+$('#mensualite').val()+'&duree='+$('#duree').val();
                        datastring += '&total='+$('#total').val();
                        break;
                    case 'creation_action':
                        datastring += '&idIndividu='+idIndividu+'&date='+$('#date').val();
                        datastring += '&typeaction='+$('#typeaction').attr('value')+'&motif='+$('#motif').val();
                        datastring += '&suiteadonner='+$('#suiteadonner').val()+'&suitedonnee='+$('#suitedonnee').val();
                        datastring += '&instruct='+$('#instruct').attr('value');
                        console.log(datastring);
                        break;
                    case 'creation_aide_interne':
                        var urgence = 0;
                        if($('#urgence').hasClass('checkbox_active')) {
                            urgence = 1;
                        }
                        datastring += '&idIndividu='+idIndividu+'&typeaide='+$('#typeaideinterne').attr('value');
                        datastring += '&date='+$('#date').val()+'&instruct='+$('#instruct').attr('value');
                        datastring += '&nature='+$('#nature').attr('value')+'&proposition='+$('#proposition').val();
                        datastring += '&etat='+$('#etat').attr('value')+'&orga='+$('#orga').attr('value')+'&urgence='+urgence;
                        console.log("DATE :" + $('#date').val());
                        break;
                    case 'creation_aide_externe':
                        var urgence = 0;
                        if($('#urgenceexterne').hasClass('checkbox_active')) {
                            urgence = 1;
                        }
                        datastring += '&idIndividu='+idIndividu+'&typeaideexterne='+$('#typeaideexterne').attr('value');
                        datastring += '&date='+$('#dateaideexterne').val()+'&instruct='+$('#instructexterne').attr('value');
                        datastring += '&natureexterne='+$('#natureaideexterne').attr('value')+'&distrib='+$('#distrib').attr('value');
                        datastring += '&etat='+$('#etatexterne').attr('value')+'&orgaext='+$('#orgaext').attr('value')+'&urgence='+urgence;
                        datastring += '&montantDemande='+$('#montantdemande').attr('value');
                        console.log(datastring);
                        break;
                    case 'addBonInterne':
                        var idAide = $('.formulaire').attr('idAide');
                        datastring += '&idAide='+idAide+'&dateprevue='+$('#dateprevue').val();
                        datastring += '&dateeffective='+$('#dateeffective').val()+'&montant='+$('#montant').val();
                        datastring += '&commentaire='+$('#commentaireBon').val()+'&instruct='+$('#idinstruct').attr('value');
                        datastring += '&typebon='+$('#typebon').attr('value');
                        console.log(datastring);
                        break;
                    case 'creation_role':
                        datastring += '&designationRole='+$('#designationRole').val();
                        break;
                }
                $.ajax({
                    type: 'post',
                    dataType:'json',
                    data: datastring,
                    url: './index.php?p=form',
                    cache: false,
                    //Succés de la requête
                    success: function(data) {
                        console.log("SUCCESS FONCTION PORC");
                        $('#ecran_gris').toggle();
                        formActuel.toggle();
                        findRequis(formActuel);
//                        formActuel.find('.requis').each(function(){
//                            if ($(this).is('input')) {
//                                if ($(this).val() == '') {
//                                    traitement = false;
//                                    $(this).removeClass('a_completer');
//                                }
//                            } else if ($(this).hasClass('option')) {
//                                if ($(this).attr('value') == undefined || $(this).attr('value') == '') {
//                                    traitement = false;
//                                    $(this).parent().toggleClass('a_completer');
//                                }
//                            }
//                        });
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
                            case 'creation_credit':
                                $("#contenu").html(data.budget);
                                break;
                            case 'creation_action':
                                console.log(data);
                                $('#contenu').html(data.actions);
                                break;
                            case 'creation_aide_interne':
                                $('#contenu').html(data.aide);
                                break;
                            case 'creation_aide_externe':
                                $('#contenu').html(data.aide);
                                break;
                            case 'addBonInterne':
                                $('#contenu').html(data.detail);
                                break;
                            case 'creation_role':
                                $('#contenu').html(data.role);
                                break;
                        }
                    },
                    error: function(data) {
                        $("#contenu").html(data.responseText);
                    }
                });
            }
        } else if(value == 'create_rapport') {
            var aide = $('#numAide').attr('idAide');
            datastring = 'motif='+$('#motif').val()+'&evaluation='+$('#evaluation').val()+'&idIndividu='+idIndividu+'&idAide='+aide;
            console.log(datastring);
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=createrapport',
                cache: false,
                success: function(pageaide) {
                    $('#contenu').html(pageaide);
                },
                error: function(pageaide) {
                    $('#contenu').html(pageaide.responseText);
                }
            });
            
        } else if(value == 'create_tab_demande_commission') {
               if(findRequis($('#demande_commission'))) {    
                var datastring = 'datedebut=' + $('#datedebut').val() + '&datefin=' + $('#datefin').val()
                      +'&withDecission=' + "0";
                console.log(datastring);
                $.ajax({
                    type: 'post',
                    data: datastring,
                    url: './index.php?p=genererTabCommission',
                    cache: false,
                    success: function(retour) {
                        $('#dialogTab').html(retour);
                        $('#iPDF').dialog({position: ['center',100], width: 500, height: 500});
                    },
                    error: function(data) {
                        $("#contenu").html(data.responseText);
                    }
                });
            }
            
            

        
        } else if(value == 'create_tab_decision_commission') {
             if(findRequis($('#demande_commission'))) {    
                var datastring =  'datecommission=' + $('#datecommission').val() +'&withDecission=' + "1";
                console.log(datastring);
                $.ajax({
                    type: 'post',
                    data: datastring,
                    url: './index.php?p=genererTabCommission',
                    cache: false,
                    success: function(retour) {
                        $('#dialogTab').html(retour);
                        $('#iPDF').dialog({position: ['center',100], width: 500, height: 500});
                    },
                    error: function(data) {
                        $("#contenu").html(data.responseText);
                    }
                });
            }

        } else if (value == 'updateMembreFoyer') {
            var membreFoyer = $('.checkbox_active').parent().parent().parent();
            console.log(membreFoyer);
            var idFoyer = membreFoyer.attr('id_foyer');
            var idIndividu = membreFoyer.attr('id_individu');
            datastring = 'idFoyer=' + idFoyer;
            datastring += '&idIndividu=' + idIndividu;
            console.log('datastring' + datastring);
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=updateChefDeFamille',
                cache: false,
                //Succés de la requête
                success: function(contenu) {
                    console.log(contenu);
                    $('#contenu').html(contenu);
                },
                error: function(contenu) {
                    $("#contenu").html(contenu.responseText);
                }
            });
            
        } else if(value == 'updateRessource') {
            datastring = 'idIndividu='+idIndividu+'&salaire='+$('#salaire').val();
            datastring += '&chomage='+$('#chomage').val()+'&revenuAlloc='+$('#revenuAlloc').val();
            datastring += '&ass='+$('#ass').val()+'&aah='+$('#aah').val();
            datastring += '&rsaSocle='+$('#rsaSocle').val()+'&rsaActivite='+$('#rsaActivite').val();
            datastring += '&retraitComp='+$('#retraitComp').val()+'&pensionAlim='+$('#pensionAlimRessource').val();
            datastring += '&pensionRetraite='+$('#pensionRetraite').val()+'&autreRevenu='+$('#autreRevenu').val();
            datastring += '&natureAutre='+$('#natureRevenu').val();
            datastring += '&pensionInvalide='+$('#invalide').val()+'&ijss='+$('#ijss').val();
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=updateressource',
                cache: false,
                //Succés de la requête
                success: function() {
                    relockAll(loc);
                    slideBouton(loc);
                },
                error: function(contenu) {
                    $("#contenu").html(contenu.responseText);
                }
            });
        } else if(value == 'updateDepense') {
            console.log($('#pensionAlimDepense').val());
            datastring = 'idIndividu='+idIndividu+'&impotRevenu='+$('#impotRevenu').val();
            datastring += '&impotLocaux='+$('#impotLocaux').val()+'&pensionAlim='+$('#pensionAlimDepense').val();
            datastring += '&mutuelle='+$('#mutuelle').val()+'&electricite='+$('#electricite').val();
            datastring += '&gaz='+$('#gaz').val()+'&eau='+$('#eau').val();
            datastring += '&chauffage='+$('#chauffage').val()+'&telephonie='+$('#telephonie').val();
            datastring += '&internet='+$('#internet').val()+'&television='+$('#television').val();
            datastring += '&autreDepense='+$('#autreDepense').val()+'&natureDepense='+$('#natureDepense').val();
            datastring += '&assuranceVoiture='+$('#assuranceVoiture').val()+'&assuranceHabitation='+$('#assuranceHabitation').val();
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=updatedepense',
                cache: false,
                //Succés de la requête
                success: function() {
                    relockAll(loc);
                    slideBouton(loc);
                },
                error: function(contenu) {
                    $("#contenu").html(contenu.responseText);
                }
            });
        }
        else if(value == 'updateDepenseHabitation') {
            datastring = 'idIndividu='+idIndividu+'&loyer='+$('#loyer').val();
            datastring += '&apl='+$('#apl').val();
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=updatedepensehabitation',
                cache: false,
                //Succés de la requête
                success: function() {
                    relockAll(loc);
                    slideBouton(loc);
                },
                error: function(contenu) {
                    $("#contenu").html(contenu.responseText);
                }
            });
        }
        else if(value == 'updateDette') {
            datastring = 'idIndividu='+idIndividu+'&arriereLocatif='+$('#arriereLocatif').val();
            datastring += '&fraisHuissier='+$('#fraisHuissier').val()+'&autreDette='+$('#autreDette').val();
            datastring += '&natureDette='+$('#natureDette').val()+'&arriereElec='+$('#arriereElec').val();
            datastring += '&prestaElec='+$('#prestaElec').val()+'&arriereGaz='+$('#arriereGaz').val();
            datastring += '&prestaGaz='+$('#prestaGaz').val();
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=updatedette',
                cache: false,
                //Succés de la requête
                success: function() {
                    relockAll(loc);
                    slideBouton(loc);
                },
                error: function(contenu) {
                    $("#contenu").html(contenu.responseText);
                }
            });
        }
        else if(value == 'updateContact') {
            datastring = 'idIndividu='+idIndividu+'&telephone='+$('#telephone').val();
            datastring += '&portable='+$('#portable').val()+'&email='+$('#email').val();
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=updatecontact',
                cache: false,
                //Succés de la requête
                success: function() {
                    relockAll(loc);
                    slideBouton(loc);
                },
                error: function(contenu) {
                    $("#contenu").html(contenu.responseText);
                }
            });
        }
        else if(value == 'updateCaf') {
            datastring = 'idIndividu='+idIndividu+'&caf='+$('#caf').attr('value');
            datastring += '&numallocatairecaf='+$('#numallocatairecaf').val();
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=updatecaf',
                cache: false,
                //Succés de la requête
                success: function() {
                    relockAll(loc);
                    slideBouton(loc);
                },
                error: function(contenu) {
                    $("#contenu").html(contenu.responseText);
                }
            });
        }
        else if(value == 'updateMutuelle') {
            var cmuc = 0;
            if($('#cmuc').hasClass('checkbox_active')) {
                cmuc = 1;
            }
            datastring = 'idIndividu='+idIndividu+'&mut='+$('#mutuelle').attr('value');
            datastring += '&cmuc='+cmuc+'&numadherentmut='+$('#numadherentmut').val();
            datastring += '&datedebutcouvmut='+$('#datedebutcouvmut').val()+'&datefincouvmut='+$('#datefincouvmut').val();
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=updatemutuelle',
                cache: false,
                //Succés de la requête
                success: function() {
                    relockAll(loc);
                    slideBouton(loc);
                },
                error: function(contenu) {
                    $("#contenu").html(contenu.responseText);
                }
            });
        }
        else if(value == 'updateCouvertureSocial') {
            var assure = 0;
            var cmu = 0;
            if($('#assure').hasClass('checkbox_active')) {
                assure = 1;
            }
            if($('#cmu').hasClass('checkbox_active')) {
                cmu = 1;
            }
            datastring = 'idIndividu='+idIndividu+'&assure='+assure;
            datastring += '&caisseCouv='+$('#caisseCouv').attr('value')+'&cmu='+cmu;
            datastring += '&numsecu='+$('#numsecu').val()+'&clefsecu='+$('#clefsecu').val();
            datastring += '&regime='+$('#regime').attr('value')+'&datedebutcouvsecu='+$('#datedebutcouvsecu').val();
            datastring += '&datefincouvsecu='+$('#datefincouvsecu').val();
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=updatecouverture',
                cache: false,
                //Succés de la requête
                success: function() {
                    relockAll(loc);
                    slideBouton(loc);
                },
                error: function(contenu) {
                    $("#contenu").html(contenu.responseText);
                }
            });
        }
        else if(value == 'updateSituationProfessionnelle') {
            datastring = 'idIndividu='+idIndividu;
            datastring += '&profession='+$('#profession').attr('value')+'&employeur='+$('#employeur').val();
            datastring += '&inscriptionpe='+$('#dateinscriptionpe').val()+'&numdossier='+$('#numdossierpe').val();
            datastring += '&debutdroit='+$('#datedebutdroitpe').val()+'&findroit='+$('#datefindroitpe').val();
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=updatesituationprofessionnelle',
                cache: false,
                //Succés de la requête
                success: function() {
                    relockAll(loc);
                    slideBouton(loc);
                },
                error: function(contenu) {
                    $("#contenu").html(contenu.responseText);
                }
            });
        }
        else if(value == 'updateSituationScolaire') {
            var scolarise = 0;
            if($('#checkboxScolarise').hasClass('checkbox_active')) {
                scolarise = 1;
            }
            datastring = 'idIndividu='+idIndividu+'&scolarise='+scolarise;
            datastring += '&etablissementscolaire='+$('#etablissementscolaire').val()+'&etude='+$('#etude').val();
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=updateSituationScolaire',
                cache: false,
                //Succés de la requête
                success: function() {
                    relockAll(loc);
                    slideBouton(loc);
                },
                error: function(contenu) {
                    $("#contenu").html(contenu.responseText);
                }
            });
        }
        else if(value == 'updateFoyer') {
            var idFoyer = $('#list_individu').children('.current').children().attr('id_foyer');
            datastring = 'idFoyer='+idFoyer+'&numrue='+$('#numrue').val();
            datastring += '&rue='+$('#rue').attr('valeur')+'&secteur='+$('#secteur').attr('value');
            datastring += '&ville='+$('#ville').attr('valeur')+'&type='+$('#typelogement').attr('value');
            datastring += '&statut='+$('#statutlogement').attr('value')+'&surface='+$('#surface').val();
            datastring += '&dateentree='+$('#dateentree').val()+'&bailleur='+$('#bailleur').attr('value');
            datastring += '&instruct='+$('#instruct').attr('value')+'&sitfam='+$('#sitfam').attr('value');
            datastring += '&notes='+$('#note').val();
            console.log(datastring);
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=updateFoyer',
                cache: false,
                //Succés de la requête
                success: function() {
                    relockAll(loc);
                    slideBouton(loc);
                },
                error: function(contenu) {
                    $("#contenu").html(contenu.responseText);
                }
            });
        }
        else if(value == 'updateInfoPerso') {
            datastring = 'idIndividu='+idIndividu+'&nom='+$('#nom').val();
            datastring += '&prenom='+$('#prenom').val()+'&situation='+$('#situation').attr('value');
            datastring += '&nationalite='+$('#nationalite').attr('value')+'&datenaissance='+$('#datenaissance').val();
            datastring += '&lieu='+$('#lieu').attr('valeur')+'&sexe='+$('#sexe').attr('value');
            datastring += '&statut='+$('#statut').attr('value');
            console.log("UPDATE INFO PERSO : " + datastring);
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=updateinfoperso',
                cache: false,
                //Succés de la requête
                success: function() {
                    console.log('SUCCESS INFO PERSO');
                    relockAll(loc);
                    slideBouton(loc);
                },
                error: function(contenu) {
                    $("#contenu").html(contenu.responseText);
                }
            });
        }
        else if (value == 'delete_credit') {
            var id = formActuel.attr('idCredit');
            datastring = 'id='+id+'&idIndividu='+idIndividu;
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=deletecredit',
                cache: false,
                success: function(data) {
                    $('#ecran_gris').toggle();
                    formActuel.toggle();
                    $("#contenu").html(data);
                },
                error: function(data) {
                    $("#contenu").html(data.responseText);
                }
            });
        }
        else if (value == 'delete_individu') {
            var idIndividuADelete = formActuel.attr('idIndividuADelete');
            datastring = 'idFoyer=' + formActuel.attr('idFoyer');
            datastring += '&idIndividu=' + idIndividuADelete;
            datastring += '&idIndividuCourant=' + $('#list_individu').children('.current').children().attr('id_individu');
            console.log(datastring);
            $.ajax({
                type: 'post',
                dataType:'json',
                data: datastring,
                url: './index.php?p=deleteIndividu',
                cache: false,
                //Succés de la requête
                success: function(data) {
                    $(".tipsy").remove();
                    $('#ecran_gris').toggle();
                    formActuel.toggle();
                    $("#list_individu").html(data.listeIndividu);
                    $('#contenu').html(data.contenu);
                },
                error: function(data) {
                    $("#contenu").html(data.responseText);
                }
            });
        }
        else if (value == 'archive_ressource') {
            datastring = 'idIndividu='+idIndividu;
            console.log('ARCHIVE ressource ' + datastring);
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=archiveressource',
                cache: false,
                //Succés de la requête
                success: function(data) {
                    $('#ecran_gris').toggle();
                    formActuel.toggle();
                    $('#contenu').html(data);
                },
                error: function(data) {
                    $("#contenu").html(data.responseText);
                }
            });
        }
        else if (value == 'archive_depense') {
            datastring = 'idIndividu='+idIndividu;
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=archivedepense',
                cache: false,
                //Succés de la requête
                success: function(data) {
                    $('#ecran_gris').toggle();
                    formActuel.toggle();
                    $('#contenu').html(data);
                },
                error: function(data) {
                    $("#contenu").html(data.responseText);
                }
            });
        }
        else if (value == 'archive_dette') {
            datastring = 'idIndividu='+idIndividu;
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=archivedette',
                cache: false,
                //Succés de la requête
                success: function(data) {
                    $('#ecran_gris').toggle();
                    formActuel.toggle();
                    $('#contenu').html(data);
                },
                error: function(data) {
                    $("#contenu").html(data.responseText);
                }
            });
        }
    });
    
    
    
    
    function effacer() {
        $('.input_text').children().val('');
    }
    
    //permet l'affichage des formulaires flottant entouré de gris
    function creationForm(x, h, form) {
        console.log("creationForm");
        console.log(form);
        $('#ecran_gris').toggle();
        $(form).css({
            "display":"block",
            "position":"fixed"
        });
        $(form).offset({
            top:x.top+h,
            left:x.left
        });
    }
    
    $('.edit').live("click", function() {
        var attr = $(this).parent().next().children().find('input').attr('disabled');
        if (typeof attr !== 'undefined' && attr !== false) {
            $(this).parent().next().children().find('input').removeAttr('disabled');
            $(this).parent().next().children().find('[class^=select]').removeAttr('disabled');
            $(this).parent().next().children().find('textarea').removeAttr('disabled');
            if (!$(this).parent().next().children().find('[class^=checkbox]').hasClass('lock')) {
                $(this).parent().next().children().find('[class^=checkbox]').removeAttr('disabled');
            }
        } else {
            $(this).parent().next().children().find('input').attr('disabled','');
            $(this).parent().next().children().find('[class^=select]').attr('disabled','');
            $(this).parent().next().children().find('textarea').attr('disabled','');
            $(this).parent().next().children().find('[class^=checkbox]').attr('disabled','');
        }
        var update = $(this).parent().parent().children('.update');
        slideBouton(update);
    });
    
    $('.archive').live("click", function() {
        console.log('ARCHIVE');
        if($(this).parent().attr('role') == "ressource") {
            var form = $('.formulaire[action="archive_ressource"]');
            var newPosition = new Object();
            newPosition.left = $(window).width()/2 - form.width()/2;
            newPosition.top = $(window).height()/2 - form.height();
            creationForm(newPosition, $(this).outerHeight(), form);
        } else if($(this).parent().attr('role') == "depense") {
            var form = $('.formulaire[action="archive_depense"]');
            var newPosition = new Object();
            newPosition.left = $(window).width()/2 - form.width()/2;
            newPosition.top = $(window).height()/2 - form.height();
            creationForm(newPosition, $(this).outerHeight(), form);
        } else if($(this).parent().attr('role') == "dette") {
            var form = $('.formulaire[action="archive_dette"]');
            var newPosition = new Object();
            newPosition.left = $(window).width()/2 - form.width()/2;
            newPosition.top = $(window).height()/2 - form.height();
            creationForm(newPosition, $(this).outerHeight(), form);
        }
    });
    
    $('.delete_credit').live("click", function() {
        var form = $('.formulaire[action="suppression_credit"]');
        var newPosition = new Object();
        newPosition.left = $(window).width()/2 - form.width()/2;
        newPosition.top = $(window).height()/2 - form.height();
        creationForm(newPosition, $(this).outerHeight(), form);
        var id = $(this).parent().parent().attr('name');
        form.attr('idCredit', id);
    });
    
    $('.delete_individu').live("click", function() {
        var form = $('.formulaire[action="suppression_individu"]');
        var newPosition = new Object();
        newPosition.left = $(window).width()/2 - form.width()/2;
        newPosition.top = $(window).height()/2 - form.height();
        creationForm(newPosition, $(this).outerHeight(), form);
        console.log($(this).parent().parent());
        var idIndividuADelete = $(this).parent().parent().attr('id_individu');
        var idFoyer = $(this).parent().parent().attr('id_foyer');
        form.attr('idIndividuADelete', idIndividuADelete);
        form.attr('idFoyer', idFoyer);
    });
    
    $('.delete_ligne').live("click", function() {
        var datastring = 'table='+$(this).attr('table')+'&idLigne='+$(this).attr('idLigne');
        console.log(datastring);
        $.ajax({
            type: 'post',
            data: datastring,
            url: './index.php?p=deleteTableStatique',
            cache: false,
            success: function() {
                searchTableStatique();
            },
            error: function(data) {
                $("#contenu").html(data.responseText);
            }
        });
    });
    
    $('.edit_action').live("click", function() {
        var form = $('.formulaire[action="edit_action"]');
        var idAction = $(this).attr('idAction');
        var newPosition = new Object();
        console.log('id :'+idAction);
        var datastring = 'id='+idAction;
        newPosition.left = $(window).width()/2 - form.width()/2;
        newPosition.top = $(window).height()/2 - form.height();
        creationForm(newPosition, $(this).outerHeight(), form);
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: datastring,
            url: './index.php?p=getaction',
            cache: false,
            success: function(data) {
                $('#instruct_edit').parent().next().children(':first').attr('idAction', idAction);
                $('#date_edit').val(data.date);
                $('#typeaction_edit').val(data.action);
                $('#motif_edit').val(data.motif);
                $('#suiteadonner_edit').val(data.suiteadonner);
                $('#suitedonnee_edit').val(data.suitedonnee);
                $('#instruct_edit').val(data.instruct);
            },
            error: function(data) {
                $("#contenu").html(data.responseText);
            }
        });
        
    });
    
    $('.rechercheTableStatique').live("keyup", function() {
        searchTableStatique();
    });
    
    $('#updateDecision').live("click", function() {
        $('#decision').toggle();
        $(this).toggle();
    });
    
    $('.create_bon_interne').live("click", function() {
        var loc = $(this);
        var name = $(this).attr('name');
        var datastring = "idBon=" + $(this).attr('idBon');
        console.log(datastring);
        $.ajax({
            type: 'post',
            data: datastring,
            url: './index.php?p=createPDF',
            cache: false,
            success: function() {
                console.log("succes");
                $(".tipsy").remove();
                loc.attr('href', name);
                loc.attr('target','_blank');
                loc.attr('class', 'open_doc')
            },
            error: function(data) {
                $("#contenu").html(data.responseText);
            }
        });
           
    });
    
    $('.create_rapport_social').live("click", function() {
        var loc = $(this);
        var name = $(this).attr('name');
        var datastring = "idAide=" + $(this).attr('idAide');
        console.log(datastring);
        $.ajax({
            type: 'post',
            data: datastring,
            url: './index.php?p=rapportsocial',
            cache: false,
            success: function(retour) {
                $(".tipsy").remove();
                $('#contenu').html(retour);
            },
            error: function(data) {
                $("#contenu").html(data.responseText);
            }
        });
           
    });
    
    $('.doc_remis').live("click", function() {
        var idBon = $(this).attr('idBon');
        var idAide = $(this).attr('idAide');
        var datastring = 'idBon='+idBon+'&idAide='+idAide;
        $.ajax ({
            type: 'post',
            data: datastring,
            url: './index.php?p=docremis',
            cache: false,
            success: function(aide) {
                $(".tipsy").remove();
                $('#contenu').html(aide);
            },
            error: function(data) {
                $('#contenu').html(data);
            }
        });
    });
    
    $('.delete_aide').live("click", function() {
        var idAide = $(this).parent().parent().attr('name');
        var idIndividu = $('#list_individu').children('.current').children().attr('id_individu');
        datastring = 'idAide='+idAide+'&idIndividu='+idIndividu;
         $.ajax ({
            type: 'post',
            data: datastring,
            url: './index.php?p=deleteaide',
            cache: false,
            success: function(aide) {
                $(".tipsy").remove();
                $('#contenu').html(aide);
            },
            error: function(data) {
                $('#contenu').html(data);
            }
        });
    });
});

function relockAll(loc) {
    loc.parent().find('input').attr('disabled','');
    loc.parent().find('[class^=select]').attr('disabled','');
    loc.parent().find('textarea').attr('disabled','');
    loc.parent().find('[class^=checkbox]').attr('disabled','');
}

function searchTableStatique() {
    var datastring = 'table=' + $('#ligneRechercheTableStatique').attr('table');
    $('#ligneRechercheTableStatique').find('[columnName]').each(function(){
        if ($(this).hasClass('checkbox_active')) {
            console.log($(this));
            datastring += '&' + $(this).attr('columnName') + '=1';
        } else {
            console.log($(this).attr('columnName') + ' : ' + $(this).val());
            datastring += '&' + $(this).attr('columnName') + '=' + $(this).val();
        }
    });
        
    console.log(datastring);
    $.ajax({
        type: 'post',
        data: datastring,
        url: './index.php?p=searchTableStatique',
        cache: false,
        //Succés de la requête
        success: function(tableStatique) {
            //                console.log(tableStatique);
            $("#contenu_table_statique").html(tableStatique);
        },
        error: function(tableStatique) {
            $("#contenu_table_statique").html(tableStatique.responseText);
        }
    });
}

function slideBouton(update) {
    $(update).css({
        "margin-right":"0"
    });
    $(update.after()).slideToggle();
}

function findRequis(select) {
    var traitement = true;
    select.find('.requis').each(function(){
        if ($(this).is('input')) {
       if ($(this).val() == '') {
                        traitement = false;
                        $(this).addClass('a_completer');
                    } else {
                        $(this).removeClass('a_completer');
                    }
                } else if ($(this).hasClass('option')) {
                    if ($(this).attr('value') == undefined || $(this).attr('value') == '') {
                        traitement = false;
                        $(this).parent().addClass('a_completer');
                    } else {
                        $(this).parent().removeClass('a_completer');
                    }
                }
    });
    return traitement;
}
