

var header = header || {
  
};


/*********************************
*   @name : bind
*   params : /
*   bind  instance  
*********************************/
header.bind = function(){
    /* Au lancement */

    $('#langue-big .change_lang').click(function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: base_url()+"index.php/users/changeLang",
            dataType: 'json',
            data: {
                lang : $(this).data('lang')
            },
            success: function(response){
               location.reload();
             
            }
        });
    });
    
}

/*********************************
*   @name : init
*   params : /
*   init  instance  
*********************************/
header.init = function(){
   header.bind();
}

/*********************************
*   @name : (window).load
*   params : /
*   Call init method on windows load    
*********************************/
$(document).ready(function() {     
    header.init();

});


