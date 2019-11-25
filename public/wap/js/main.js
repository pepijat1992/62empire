$(function(){
	'use strict';

    // preloader
    $(".wrap-preloader").fadeOut();
    
    // link back
    $('.link-back').on('click', function() {
        window.history.back();
        return false;
    });

    // carousel
    $(".carousel-slide").owlCarousel({
        items: 1,
        navigation: true,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        singleItem: true,
        loop: true
    });

    // product-d-slide
    $(".product-d-slide").owlCarousel({
        items: 1,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        loop: false,
        margin: 10
    });

    // walkthrough
    $('.walkthrough-slider').owlCarousel({
        items: true,
        loop: false,
        marign: 10
    });

    // all slider
    $(".slide-show").owlCarousel({
        items: 1,
        navigation: true,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        singleItem: true,
        loop: true,
        autoplay: true
    });

    $('.menu-link').bigSlide({
        menu: '#menu',
        side: 'left',
        easyClose: true,
        menuWidth: '260px',
        afterOpen: function(){
        $('body').addClass('menu-open');
        },
        afterClose: function(){
        $('body').removeClass('menu-open');
        }
    });

    $('.menu-link-2').bigSlide({
        menu: '#menu2',
        side: 'right',
        easyClose: true,
        menuWidth: '260px',
        afterOpen: function(){
        $('body').addClass('menu-open');
        },
        afterClose: function(){
        $('body').removeClass('menu-open');
        }
    });

    // slider home
    $(".slide-show-home").owlCarousel({
        items: 1,
        navigation: true,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        singleItem: true,
        loop: true
    });    

    // testimonial
    $(".testimonial-slide").owlCarousel({
        items: 1,
        navigation: true,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        singleItem: true,
        autoplay: true,
        loop: true
    });

    // product-d-slide
    $(".b-seller-slide").owlCarousel({
        items: 3,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        loop: false,
        margin: 10
    });

    // slide walkthrough
    $(".wt-slide").owlCarousel({
        items: 1,
        navigation: true,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        singleItem: true,
        loop: false
    });

    // link to chat detail
    $('.wrap-chat-l .content-text').on('click', function() {
        window.location='chat-detail.html'
    });

    $("button").addClass("waves-effect waves-light");

    $("#bonus_splash").click(function(){
        $.get( "/m/read_bonus", function( data ) {
            $("#bonus_splash").fadeOut();
          });
    });


});