$(function() {
  $('#lien_option').click(function() {
     if($(this).attr("name") == "passive") {
         $('.menu_option').css({"top":"29px"});
         $('.menu_option').css({"visibility":"visible"});
         $('#option').css({"background-color":"white"});
         $('#option').css({"background-position":"5px -21px"});
         $('#option').css({"border-color":"#BEBEBE"});
         $('#option').css({"padding-top":"1px"});
         $(this).attr("name","active");
      } else {
         $('.menu_option').css({"top":"-999px"});
         $('.menu_option').css({"visibility":"hidden"});
         $('#option').css({"background-color":""});
         $('#option').css({"background-position":"5px 7px"});
         $('#option').css({"border-color":""});
         $('#option').css({"padding-top":"0"});
            
         $(this).attr("name","passive");
      }
  });    
  $('.edituser').click(function() {
      var user = $(this).attr('name');
      $.ajax({
                url: './index.php?p=edituser',
                type:'POST',
                data: "user="+user,
                //Succès de la requête
                success: function(data) {
                    $('#useredit').html(data);
                }
  });
  });
  $('#submitedit').live("click", function() {
      var id = $('#idedit').val();
      var login = $('#loginedit').val();
      var pwd = $('#pwdedit').val();
      var nomcomplet = $('#nomcompletedit').val();
      $.ajax({
          url: './index.php?p=edituser',
          type:'POST',
          data: "idedit="+id+"&loginedit="+login+"&pwdedit="+pwd+"&nomcompletedit="+nomcomplet,
          success: function(data) {
              $(location).attr('href','index.php?p=manageuser');
          }
      });
  });
});

