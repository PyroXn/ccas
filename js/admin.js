  $(function() {
    $('#manageuser').click(function() {
       $.ajax({
                url: './index.php?p=manageuser',
                type: 'post',
                //Succ�s de la requ�te
                success: function(data) {
                    $('#contenu').html(data);
                }
            });
    });
});
