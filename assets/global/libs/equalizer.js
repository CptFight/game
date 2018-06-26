
/*********************************
*	@name : Equalizer
*	Exemples : 
	case A: via data-attributes
	add [data_equalizer_max="group_elements"] attribute to set the biggest heigth 
	on all element of this group.
	All elements of this group will take the height of the tallest.

	case B: via javascript
	$('target').equalize('base');
	ex : $('li.small').equalize('li.big');
	base gives its height to target.

	refresher l'equalizer sur un groupe:
	equalizer.setHeightTogroup(nom_du_groupe);
*********************************/


var equalizer = equalizer || {
	data_equalizer_max : 'data-equalizer-max',
	groups : []
};

/*********************************
*	@name : init
*	params : /
*	init first instance	
*********************************/
equalizer.init = function(){
	if(jQuery(window).outerWidth() >= 0){
		equalizer.getgroups();
		equalizer.deleteHeightTogroups();
		equalizer.setHeightTogroups();
	}else{
		equalizer.deleteHeightTogroups();
	}
}

/*********************************
*	@name : refresh
*	params : /
*	refresh instance	
*********************************/
equalizer.refresh = function(){
	equalizer.setHeightTogroups();
}

/*********************************
*	@name : getgroups
*	params : /
*	Get all associated groups	
*********************************/
equalizer.getgroups = function(){
	jQuery("["+equalizer.data_equalizer_max+"]").each(function(){
		var groups = jQuery(this).data('equalizer-max');
		if(equalizer.groups.indexOf(groups) == -1){
			equalizer.groups.push(groups);
		}
	});
}

/*********************************
*	@name : setHeightTogroups
*	params : /
*	Call setHeightTogroup for all groups
*********************************/
equalizer.setHeightTogroups = function(){
	equalizer.groups.forEach(function(value,entry) {
	 	equalizer.setHeightTogroup(value);
	});
}


/*********************************
*	@name : setHeightTogroup
*	params : name_group => the name of the group
*	Set max height of a element to all elements in a group		
*********************************/
equalizer.setHeightTogroup = function(name_group){
	var max_height = 0;
	jQuery("["+equalizer.data_equalizer_max+"='"+name_group+"']").each(function(event){
		if(jQuery(this).outerHeight() > max_height) max_height = jQuery(this).outerHeight();
	});
	
	jQuery("["+equalizer.data_equalizer_max+"='"+name_group+"']").outerHeight(max_height);	
}


/*********************************
*	@name : deleteHeightTogroups
*	params : /
*	Call deleteHeightTogroup for all groups
*********************************/
equalizer.deleteHeightTogroups = function(){
	equalizer.groups.forEach(function(value,entry) {
	 	equalizer.deleteHeightTogroup(value);
	});
}

/*********************************
*	@name : deleteHeightTogroup
*	params : name_group => the name of the group
*	delete height of a element to all elements in a group		
*********************************/
equalizer.deleteHeightTogroup = function(name_group){
	jQuery("["+equalizer.data_equalizer_max+"='"+name_group+"']").height('auto');
}


/*********************************
*	@name : (window).load
*	params : /
*	Call init method on windows load	
*********************************/
jQuery(window).load(function(){			
  	equalizer.init();
});


/*********************************
*	@name : (window).resize
*	params : /
*	Call init method on windows resize juste one time	
*********************************/
function debouncer( func , timeout ) {
   var timeoutID , timeout = timeout || 200;
   return function () {
      var scope = this , args = arguments;
      clearTimeout( timeoutID );
      timeoutID = setTimeout( function () {
          func.apply( scope , Array.prototype.slice.call( args ) );
      } , timeout );
   }
}

jQuery( window ).resize( debouncer( function ( e ) {
	equalizer.init();
} ) );



/*********************************
*	@name : jQuery extends method
*	params : model => the model for the targeting.
*	do equalize job to a container
*********************************/


(function( $ ) {
    $.fn.equalize = function (model){
        var target_object = this.selector;

        $(model+" img").load(function(){            
            doJob(target_object,model);
        });

        function doJob(target_object, model){
            var model_height = $(model).height();
            $(target_object).height(model_height);
        }

        doJob(target_object,model);
        
    }

}( jQuery ));


