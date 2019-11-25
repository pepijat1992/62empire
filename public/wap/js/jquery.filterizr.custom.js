$(function(){
	'use strict';

    // filterizr
    $('.filtr-container').imagesLoaded( function() {
        var filterizr = $('.filtr-container').filterizr();
    });

    // work filter
    $('.portfolio-menu li').on('click', function() {
        $('.portfolio-menu li').removeClass('active');
        $(this).addClass('active');
    });

});