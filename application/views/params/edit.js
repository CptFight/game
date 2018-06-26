



var edit_param = edit_param || {
    colorpicker : null
};

/*********************************
*   @name : bind
*   params : /
*   bind  instance  
*********************************/
edit_param.bind = function(){
    edit_param.bindColorPicker();

    /*$('.btn-add').click(function(e){ 
      e.preventDefault();
      var new_elem = $(this).closest('li').clone();
      $(new_elem).find('.btn-add').remove();
      console.log('passe',new_elem);
      $(new_elem.html()).insertBefore($(this).closest('ul').find('.add-element-template'));
      edit_param.bindColorPicker();
    });*/
}

edit_param.bindColorPicker = function(){
  edit_param.colorpicker.on('changeColor', function(e,color){
  
      if(color==null) {
        //when select transparent color
        $('.color-fill-icon', $(this)).addClass('colorpicker-color');
      } else {
        $('.color-fill-icon', $(this)).removeClass('colorpicker-color');
        $('.color-fill-icon', $(this)).css('background-color', color);
      }
      $(this).closest('li').find('.status_color').val(color);
  }); 
}

/*********************************
*   @name : init
*   params : /
*   init  instance  
*********************************/
edit_param.init = function(){
    edit_param.colorpicker = $('.colorpickerjs');
    edit_param.colorpicker.colorpickerplus();
    edit_param.bind();
    edit_param.tabScript();
}


edit_param.tabScript = function(){
  $('.tab').hide();
  $('.active').show();
    $('.tabs div').on('click',function(){
      $('.tabs div').removeClass('active');
      $(this).addClass('active');
        var thisselect = $(this).attr("data-select");

        $('#current_tab').val(thisselect);

        $('#tabsselect').removeAttr('selected');
        $('#tabsselect').find('option[value="'+thisselect+'"]').attr("selected",true);

      $('.tab').hide();
      var activeTab = $(this).attr('id');
      $("."+activeTab).show();
      return false;
  });
    $("#tabsselect").on("change", function(){
        $('.tabs div').removeClass('active');
        $('#tabsselect').removeAttr('selected');
        var thisvalue = $(this).val();

        $("#"+thisvalue).addClass('active');
        
        $('.tab').hide();
        $("."+thisvalue).show();
        return false;
    });
}

/*********************************
*   @name : (window).load
*   params : /
*   Call init method on windows load    
*********************************/
$(document).ready(function() {     
    edit_param.init();
});





$(document).ready(function() {     
    
    
});

