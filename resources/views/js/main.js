(function() {
'use strict';

$(document).ready(function() {
	$('.menu-link').click(function() {
		if($('.menu').hasClass('nav-open') === false) {
			$('.menu').addClass('nav-open');
			$(document).on('mousedown', function(e) {
				if(e.target !== $('.menu')[0] && $('.menu')[0].contains(e.target) === false) {
					$('.menu').removeClass('nav-open');
					$(document).unbind('mousedown');
				}
			});
		} else {
			$('.menu').removeClass('nav-open');
		}
	});
});

var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $('header').outerHeight();

$(window).scroll(function() {
	didScroll = true;
});

setInterval(function() {
	if(didScroll) {
		hasScrolled();
		didScroll = false;
	}
}, 250);

function hasScrolled() {
	var st = $(window).scrollTop();

	if(Math.abs(lastScrollTop - st) <= delta)
		return;

	if(st > lastScrollTop && st > navbarHeight) {
		$('header').removeClass('nav-down').addClass('nav-up');
	} else {
		if(st + $(window).height() < $(document).height()) {
			$('header').removeClass('nav-up').addClass('nav-down');
		}
	}

	lastScrollTop = st;
}

})();