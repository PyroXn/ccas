$(function() {
    $('#newfoyer').click(function() {
        creationForm($(this).offset(), $(this).outerHeight(), $('.formulaire[action="creation_foyer"]'))
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
    
    $('.bouton').click(function() {
        var value = $(this).attr('value');
        if(value=='cancel') {
            $('.en_execution').toggle();
            $('.en_execution').toggleClass('en_execution');
            $('.en_attente').toggleClass('en_attente');
            $('#ecran_gris').toggle();
            $('.formulaire').toggle();
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
            }
            $.ajax({
                type: 'post',
                dataType:'json',
                data: datastring,
                url: './index.php?p=form',
                //Succès de la requête
                success: function(data) {
                    $('#ecran_gris').toggle();
                    $('.formulaire').toggle();
                    effacer();
                    
                    //CAS NON GENERIQUE
                    $("#list_individu").html(data.listeIndividu);
                    $("#page_header_navigation").html(data.menu);
                }
            });
        }
    });
    
    function effacer() {
        $('.input_text').children().val('');
    }
    
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