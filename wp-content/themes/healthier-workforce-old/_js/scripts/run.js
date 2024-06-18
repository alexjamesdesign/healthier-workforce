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
		
		
		// Toggle Callback
		$(".callback-form-show-hide").click(function(){
			$(".callback-hidden").slideToggle();
			$(".quick-quote .container > p").toggleClass("selected");
		});

		$( ".page-template-page-management-form .rm-user-row h2" ).replaceWith( "<h2>Your Management Referrals</h2>" );
		$( ".page-template-page-management-form .rmtab-registration" ).text( 'Management Referrals' );

		// Accordion V3
		$('.form-content').slideUp();
		$('.form-title').click(function(e) {
			e.preventDefault();

			var open = $(this).parent().find('.form-content');
			var rotated = $(this).parent().find('.fa-caret-right');

			$('.form-content').not(open).slideUp();
			$(this).parent().find('.form-content').slideToggle({duration: 400, start: function() {

				if($(this).parent().find('i.fa-caret-right').hasClass('fa-rotate-90')) {
					$(this).parent().find('i.fa-caret-right').removeClass('fa-rotate-90');
				} else {
					$(this).parent().find('i.fa-caret-right').addClass('fa-rotate-90');
				}
				$('.fa-caret-right').not(rotated).removeClass('fa-rotate-90');
			}});
		});

    });
});

	