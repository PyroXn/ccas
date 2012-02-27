$(function() {
    $('#newfoyer').click(function() {
        $.ajax({
                url: './index.php?p=formFoyer',
                //Succès de la requête
                success: function(data) {
                    $('#contenu').html(data).show();
                }
        });
    });
});