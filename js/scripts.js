/* Document ready */

$( function() {

	/************************************
	 *
	 * INDEX 
	 *
	 *************************************/

    var navtimer;

	$("ul#main-nav li.dept").hover(
		function() {
			clearTimeout(navtimer);
			$(".preview-window").hide(); // hide all other preview windows...
			$(this).children(".preview-window").first().show();
		},
		function()
        {
            navtimer = setTimeout(function(){$(".preview-window").hide();}, 300);
        }
	);

	$("ul#main-nav li .preview-window").hover(
        function ()
        {
            clearTimeout(navtimer);
        },
        function()
        {
            navtimer = setTimeout(function(){$(this).children(".preview-window").first().hide();}, 300);
        }
    );

    /* Slider top */

    $('#featured-carousel').skdslider({delay:7000, animationSpeed: 2000,showNextPrev:true,showPlayButton:false,autoSlide:true,showNav:false,animationType:'fading'});

    /* Slider Sections */
    $('#sections-carousel').skdslider({delay:7000, animationSpeed: 1000,showNextPrev:true,showPlayButton:false,autoSlide:true,showNav:false,animationType:'fading'});

	/* Back to top */

	var offset = 220;
	var duration = 500;
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > offset) {
			jQuery('.back-to-top').fadeIn(duration);
		} else {
			jQuery('.back-to-top').fadeOut(duration);
		}
	});

	$("#back-to-top a").bind("click", function(event) {
		event.preventDefault();
		jQuery('html, body').animate({scrollTop: 0}, duration);
		return false;
	});



});
