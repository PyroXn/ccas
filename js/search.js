$(function() {
        $(".search").keyup(function() 
        {
            var searchbox = $(this).val();
            var dataString = 'searchword='+ searchbox;
            $.ajax({
                type: "POST",
                url: "./search.php",
                data: dataString,
                cache: false,
                success: function(html)
                {
                    $("#list_foyer").html(html).show();	
                }
            });
            return false;
        });
    
});