$(function() {
    $('#test').live("click",function() {
        var name = $(this).attr('name');
        if(confirm("Confirmer la d\351sactivation du compte utilisateur "+name+" ?")) {
            alert("ok");
        }
    });
});
        
