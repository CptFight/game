


function translate(value){
  return translate_words[value];
}

function base_url(){
  return translate_words['base_url'];
}


function deg2rad(deg) {
  return deg * (Math.PI/180)
}


/***************
* WEBSERVICE    *
***************/

function printJsonList(zipcode, radius){
    getRemoteContent("http://maps.googleapis.com/maps/api/geocode/json?address="+zipcode+",belgium&sensor=false", function(response){
        var obj = JSON.parse(response);
        if(typeof obj.results[0].geometry != 'undefined'){
            var location = obj.results[0].geometry.location;
            zipcodes.searchCitiesInTheRadius(location.lat,location.lng,radius);
            var json = JSON.stringify(zipcodes.list_city_in_area);

        }else{
            return false;
        }
    });
}


function getRemoteContent(file, callback) {
    var rawFile = new XMLHttpRequest();
   // rawFile.overrideMimeType("application/json");
    rawFile.open("GET", file, true);
    rawFile.onreadystatechange = function() {
        if (rawFile.readyState === 4 && rawFile.status == "200") {
            callback(rawFile.responseText);
        }
    }
    rawFile.send(null);
}

function JsonToArray(json){
    var result = [];
    for(var i in json)
        result.push([i, json [i]]);
    return result;
}


/* ==|====================
   Main/JS
   ======================= */

/* ------ Dropdown ------*/
/* --------------------- */
$(".btn-dropdown").on("click", function(){
	var id = $(this).attr("data-id");
	$("#"+id).toggleClass("hidden");
});

/* ------ Nav Toggle ---------- */
/* ---------------------------- */
function togglemenu(){
	$(".l-nav-aside").toggleClass("hide-menu");
	if($(".wrapper").hasClass("move"))
	{
		$(".wrapper").toggleClass("move remove");
	}
	else 
	{
		$(".wrapper").addClass("move");
		$(".wrapper").removeClass("remove");
	}
}
function clickmenu(){
	$(".l-nav-aside").toggleClass("hide-menu");
	$(".wrapper").toggleClass("move remove");
}

/* ------ Form ---- */
/* ---------------------------- */
$('.inputstyle input, .inputstyle textarea').each(function() {

  $(this).on('focus', function() {
    $(this).parent('fieldset').addClass('active');
  });

  $(this).on('blur', function() {
    if ($(this).val().length == 0) {
      $(this).parent('fieldset').removeClass('active');
    }
  });


  if ($(this).val() != '') $(this).parent('fieldset').addClass('active');

});

/* ------ Smooth Scroll ---- */
/* ---------------------------- */
function linkScroll(){
  	$('a[href*="#"]:not([href="#"])').click(function() {
    	if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      		var target = $(this.hash);
      		target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      		if (target.length) {
        		$('html, body').animate({
        	  		scrollTop: target.offset().top
        		}, 1000);
        		return false;
      		}
    	}
	});
}


$(document).ready(function() {     
    linkScroll();

	//$(".l-nav-big a").click( clickmenu );

	$("#btn-toggle-nav").click( togglemenu);

});
$( window ).resize(function() {
});