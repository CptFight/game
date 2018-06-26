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

/* ------ Dropdown ------*/
/* --------------------- */
$(".btn-dropdown").on("click", function(){
  var id = $(this).attr("data-id");
  $("#"+id).toggleClass("hidden");
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