  $(function() {
    $('#manageuser').click(function() {
       $.ajax({
                url: './index.php?p=manageuser',
                type: 'post',
                //Succès de la requête
                success: function(data) {
                    $('#contenu').html(data);
                }
            });
    });
});
