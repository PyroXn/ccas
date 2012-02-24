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
});
