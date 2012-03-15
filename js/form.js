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
    
    $('#createCredit').live("click", function() {        
        var newPosition = new Object();
        newPosition.left = $(window).width()/2 - $('.formulaire[action="creation_credit"]').width()/2;
        newPosition.top = $(window).height()/2 - $('.formulaire[action="creation_credit"]').height();
        creationForm(newPosition, $(this).outerHeight(), $('.formulaire[action="creation_credit"]'));
    });
    
    $('#createAction').live("click", function() {        
        var newPosition = new Object();
        newPosition.left = $(window).width()/2 - $('.formulaire[action="creation_action"]').width()/2;
        newPosition.top = $(window).height()/2 - $('.formulaire[action="creation_action"]').height();
        creationForm(newPosition, $(this).outerHeight(), $('.formulaire[action="creation_action"]'));
    });

    $('#newTableGenerique').live("click", function() {
        $('.formulaire[action="edit_ligne"]').attr('table', $(this).attr('table'));
        $('.formulaire[action="edit_ligne"]').removeAttr('idLigne');
        creationForm($(this).offset(), $(this).outerHeight(), $('.formulaire[action="edit_ligne"]'))
    });
    
    $('.edit_ligne').live("click", function() {
        var form = $('.formulaire[action="edit_ligne"]');
        var newPosition = new Object();
        tmp = $(this).parent();
        newPosition.left = $(window).width()/2 - form.width()/2;
        newPosition.top = $(window).height()/2 - form.height();
        form.attr('table', $(this).attr('table'));
        form.attr('idLigne', $(this).attr('idLigne'));
        //marche pas si jamais checkbox
//        $(form+'[columnName]').each(function(){
//            console.log(tmp);
//            console.log(tmp.find('.input').attr('columnName'));
//            $(this).children().val(tmp.attr('columnName').val());
//        });
        creationForm(newPosition, $(this).outerHeight(), form);
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
    
    $('.checkboxChefFamille').live("click", function(){
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
    
    $('.checkbox').live("click", function(){
        $(this).toggleClass('checkbox_active');
    });
    
    $('.en_execution > li').live("click", function() {
        console.log($(this).children().attr('value'));
        $('.en_execution').toggle();
        $('.en_attente').text($(this).children().text());
        $('.en_attente').attr('value', $(this).children().attr('value'));
        $('.en_attente').toggleClass('en_attente');
        $('.en_execution').toggleClass('en_execution');   
    });
    
    $('.bouton').live("click", function() {
        var value = $(this).attr('value');
        var formActuel = $(this).parent().parent().parent();
        var loc = $(this);
        var idIndividu = $('#list_individu').children('.current').children().attr('id_individu');
        if(value=='cancel') {
            $('.en_execution').toggle();
            $('.en_execution').toggleClass('en_execution');
            $('.en_attente').toggleClass('en_attente');
            $('#ecran_gris').toggle();
            //            $('.formulaire').toggle();
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
            $(form+'[columnName]').each(function(){
                datastring += '&'+$(this).attr('columnName')+'=' + $(this).children().val();
            });
            console.log(datastring);
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=saveTableStatique',
                //Succès de la requête
                success: function(data) {
                    $('#ecran_gris').toggle();
                    formActuel.toggle();
                    effacer();
                    $("#contenu").html(data);
                    
                }
            });
        }  else if(value=='edit_action') {
            var idAction = $(this).attr('idAction');
            datastring = 'idAction='+idAction+'&idIndividu='+idIndividu+'&date='+$('#date_edit').val()+'&motif='+$('#motif_edit').val();
            datastring += '&suiteadonner='+$('#suiteadonner_edit').val()+'&suitedonnee='+$('#suitedonnee_edit').val();
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=updateaction',
                //Succès de la requête
                success: function(data) {
                    $('#ecran_gris').toggle();
                    formActuel.toggle();
                    effacer();
                    $("#contenu").html(data);
                    
                }
            });
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
                    datastring += '&naissance='+$('#form_4').val();
                    datastring += '&idlienfamille='+$('#form_5').attr('value');
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
                        case 'creation_credit':
                            $("#contenu").html(data.budget);
                            break;
                        case 'creation_action':
                            $('#contenu').html(data.action);
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
                url: './index.php?p=updateChefDeFamille',
                //Succès de la requête
                success: function(contenu) {
                    console.log(contenu);
                    $('#contenu').html(contenu);
                }
            });
            
        } else if(value == 'updateRessource') {
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
        } else if(value == 'updateDepense') {
            datastring = 'idIndividu='+idIndividu+'&impotRevenu='+$('#impotRevenu').val();
            datastring += '&impotLocaux='+$('#impotLocaux').val()+'&pensionAlim='+$('#pensionAlim').val();
            datastring += '&mutuelle='+$('#mutuelle').val()+'&electricite='+$('#electricite').val();
            datastring += '&gaz='+$('#gaz').val()+'&eau='+$('#eau').val();
            datastring += '&chauffage='+$('#chauffage').val()+'&telephonie='+$('#telephonie').val();
            datastring += '&internet='+$('#internet').val()+'&television='+$('#television').val();
            datastring += '&autreDepense='+$('#autreDepense').val()+'&natureDepense='+$('#natureDepense').val();
            $.ajax({
                type: 'post',
                dataType:'json',
                data: datastring,
                url: './index.php?p=updatedepense',
                //Succès de la requête
                success: function(data) {
                    loc.parent().find('input').attr("disabled","disabled");
                }
            });
        }
        else if(value == 'updateDepenseHabitation') {
            datastring = 'idIndividu='+idIndividu+'&loyer='+$('#loyer').val();
            datastring += '&apl='+$('#apl').val();
            $.ajax({
                type: 'post',
                dataType:'json',
                data: datastring,
                url: './index.php?p=updatedepensehabitation',
                //Succès de la requête
                success: function(data) {
                    loc.parent().find('input').attr("disabled","disabled");
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
                dataType:'json',
                data: datastring,
                url: './index.php?p=updatedette',
                //Succès de la requête
                success: function(data) {
                    loc.parent().find('input').attr("disabled","disabled");
                }
            });
        }
        else if(value == 'updateContact') {
            datastring = 'idIndividu='+idIndividu+'&telephone='+$('#telephone').val();
            datastring += '&portable='+$('#portable').val()+'&email='+$('#email').val();
            $.ajax({
                type: 'post',
                dataType:'json',
                data: datastring,
                url: './index.php?p=updatecontact',
                //Succès de la requête
                success: function(data) {
                    loc.parent().find('input').attr("disabled","disabled");
                }
            });
        }
        else if(value == 'updateCaf') {
            datastring = 'idIndividu='+idIndividu+'&caf='+$('#caf').attr('value');
            datastring += '&numallocatairecaf='+$('#numallocatairecaf').val();
            $.ajax({
                type: 'post',
                dataType:'json',
                data: datastring,
                url: './index.php?p=updatecaf',
                //Succès de la requête
                success: function(data) {
                    loc.parent().find('input').attr("disabled","disabled");
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
                dataType:'json',
                data: datastring,
                url: './index.php?p=updatemutuelle',
                //Succès de la requête
                success: function(data) {
                    loc.parent().find('input').attr("disabled","disabled");
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
                dataType:'json',
                data: datastring,
                url: './index.php?p=updatecouverture',
                //Succès de la requête
                success: function(data) {
                    loc.parent().find('input').attr("disabled","disabled");
                }
            });
        }
        else if(value == 'updateSituationProfessionnelle') {
            datastring = 'idIndividu='+idIndividu+'&etude='+$('#etude').attr('value');
            datastring += '&profession='+$('#profession').attr('value')+'&employeur='+$('#employeur').val();
            datastring += '&inscriptionpe='+$('#dateinscriptionpe').val()+'&numdossier='+$('#numdossierpe').val();
            datastring += '&debutdroit='+$('#datedebutdroitpe').val()+'&findroit='+$('#datefindroitpe').val();
            $.ajax({
                type: 'post',
                dataType:'json',
                data: datastring,
                url: './index.php?p=updatesituationprofessionnelle',
                //Succès de la requête
                success: function(data) {
                    loc.parent().find('input').attr("disabled","disabled");
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
            datastring += '&instruct='+$('#instruct').attr('value')+'&notes='+$('#note').val();
            console.log(datastring);
            $.ajax({
                type: 'post',
                dataType:'json',
                data: datastring,
                url: './index.php?p=updateFoyer',
                //Succès de la requête
                success: function(data) {
                    loc.parent().find('input').attr("disabled","disabled");
                }
            });
        }
        else if(value == 'updateInfoPerso') {
            datastring = 'idIndividu='+idIndividu+'&nom='+$('#nom').val();
            datastring += '&prenom='+$('#prenom').val()+'&situation='+$('#situation').attr('value');
            datastring += '&nationalite='+$('#nationalite').attr('value')+'&datenaissance='+$('#datenaissance').val();
            datastring += '&lieu='+$('#lieu').attr('valeur')+'&sexe='+$('#sexe').attr('value');
            datastring += '&statut='+$('#statut').attr('value');
            console.log(datastring);
            $.ajax({
                type: 'post',
                dataType:'json',
                data: datastring,
                url: './index.php?p=updateinfoperso',
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
        var update = $(this).parent().parent().children('.update');
        $(update).css({
            "margin-right":"0"
        });
        $(update.after()).slideToggle();
    });
    
    $('.archive').live("click", function() {
        var idIndividu = $('#list_individu').children('.current').children().attr('id_individu');
        if($(this).parent().attr('role') == "ressource") {
            datastring = 'idIndividu='+idIndividu;
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=archiveressource',
                //Succès de la requête
                success: function(data) {
                    $('#contenu').html(data);
                }
            });
        } else if($(this).parent().attr('role') == "depense") {
            datastring = 'idIndividu='+idIndividu;
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=archivedepense',
                //Succès de la requête
                success: function(data) {
                    $('#contenu').html(data);
                }
            });
        } else if($(this).parent().attr('role') == "dette") {
            datastring = 'idIndividu='+idIndividu;
            $.ajax({
                type: 'post',
                data: datastring,
                url: './index.php?p=archivedette',
                //Succès de la requête
                success: function(data) {
                    $('#contenu').html(data);
                }
            });
        }
    });
    
    $('.delete').live("click", function() {
        var idFoyer = $(this).parent().parent().attr('id_foyer');
        var idIndividu = $(this).parent().parent().attr('id_individu');
        datastring = 'idFoyer=' + idFoyer;
        datastring += '&idIndividu=' + idIndividu;
        datastring += '&idIndividuCourant=' + $('#list_individu').children('.current').children().attr('id_individu');
        console.log(datastring);
        $.ajax({
            type: 'post',
            dataType:'json',
            data: datastring,
            url: './index.php?p=deleteIndividu',
            //Succès de la requête
            success: function(data) {
                $("#list_individu").html(data.listeIndividu);
                $('#contenu').html(data.contenu);
            }
        });
    });
    
    $('.delete_credit').live("click", function() {
        var idIndividu = $('#list_individu').children('.current').children().attr('id_individu');
        var id = $(this).parent().attr('name');
        datastring = 'id='+id+'&idIndividu='+idIndividu;
        $.ajax({
            type: 'post',
            data: datastring,
            url: './index.php?p=deletecredit',
            success: function(data) {
                $("#contenu").html(data);
            }
        });
    });
    
    $('.delete_ligne').live("click", function() {
        var datastring = 'table='+$(this).attr('table')+'&idLigne='+$(this).attr('idLigne');
        console.log(datastring);
        $.ajax({
            type: 'post',
            data: datastring,
            url: './index.php?p=deleteTableStatique',
            success: function(data) {
                $("#contenu").html(data);
            }
        });
    });
    
     $('.edit_action').live("click", function() {
        var form = $('.formulaire[action="edit_action"]');
        var idAction = $(this).attr('idAction');
        var newPosition = new Object();
        console.log('id :'+idAction);
        datastring = 'id='+idAction;
                        newPosition.left = $(window).width()/2 - form.width()/2;
                newPosition.top = $(window).height()/2 - form.height();
                creationForm(newPosition, $(this).outerHeight(), form);
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: datastring,
            url: './index.php?p=getaction',
            success: function(data) {
                $('#instruct_edit').parent().next().children(':first').attr('idAction', idAction);
                $('#date_edit').val(data.date);
                $('#typeaction_edit').val(data.action);
                $('#motif_edit').val(data.motif);
                $('#suiteadonner_edit').val(data.suiteadonner);
                $('#suitedonnee_edit').val(data.suitedonnee);
                $('#instruct_edit').val(data.instruct);
            }
        });
        
    });
});