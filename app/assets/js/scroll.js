function scrollMenu(){
	var raz = $("#menu").offset().top;

	$(window).scroll(function() {
	    if ( $(this).scrollTop() > raz ) {
	        $("#menu").addClass("fix");
	        //$("#phone-nav").addClass("fix");
	    } else {
	        $("#menu").removeClass("fix");
	        //$("#phone-nav").removeClass("fix");
	    }
	});
}