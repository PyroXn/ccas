$(function() {
    $('#newfoyer').click(function() {
        $.ajax({
                url: './index.php?p=formFoyer',
                //Succ�s de la requ�te
                success: function(data) {
                    $('#contenu').html(data).show();
                }
        });
    });
});