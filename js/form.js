$(function() {
    $('#newfoyer').click(function() {
        creationForm($(this).offset(), $(this).outerHeight(), $('.formulaire[action="creation_foyer"]'))
    });
    
    $('#newUser').live("click", function() {
        creationForm($(this).offset(), $(this).outerHeight(), $('.formulaire[action="creation_utilisateur"]'))
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
                    
                    //CAS NON GENERIQUE
                    if(!$.isEmptyObject(data.listeIndividu)) {
                        $("#list_individu").html(data.listeIndividu);
                        $("#page_header_navigation").html(data.menu);
                    } else if(!$.isEmptyObject(data.tableau)) {
                        $("#contenu").html(data.tableau);
                    }         
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
});