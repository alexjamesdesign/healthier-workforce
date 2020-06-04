jQuery(function ($) {
    $(document).ready(function() {
		// Adtrak Cookies

		$('body').adtrakCookies();

		// MMenu

		$("#mmenu").mmenu({
           "extensions": [
              "theme-dark"
           ],
			"offCanvas": {
			"position": "right"
			}
		});

		// Back to top
		$("#back-top").hide();
		// fade in #back-top
		$(function () {
			$(window).scroll(function () {
				if ($(this).scrollTop() > 300) {
					$('#back-top').fadeIn();
				} else {
					$('#back-top').fadeOut();
				}
			});
		});
		$("#back-top").click(function() {
			$("html, body").animate({
			scrollTop: $("header").offset().top
			}, 750);
		});
        
    });
});

	