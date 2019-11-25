(function ($) {
    "use strict";
    var bdAdmin = {
        initialize: function () {
            this.navbarClock();
            this.inputSearch();
            this.scrollBar();
            this.iconBarMenu();
            this.sideBar();
            this.materialRipple();
            this.toTop();
            this.pageloader();
        },
        navbarClock: function () {
            //nav clock
            if ($(".nav-clock")[0]) {
                var a = new Date;
                a.setDate(a.getDate()), setInterval(function () {
                    var a = (new Date).getSeconds();
                    $(".time-sec").html((a < 10 ? "0" : "") + a);
                }, 1e3), setInterval(function () {
                    var a = (new Date).getMinutes();
                    $(".time-min").html((a < 10 ? "0" : "") + a);
                }, 1e3), setInterval(function () {
                    var a = (new Date).getHours();
                    $(".time-hours").html((a < 10 ? "0" : "") + a);
                }, 1e3);
            }
        },
        inputSearch: function () {
            //input search focus action
            $("body").on("focus", ".search__text", function () {
                $(this).closest(".search").addClass("search--focus");
            }), $("body").on("blur", ".search__text", function () {
                $(this).val(""), $(this).closest(".search").removeClass("search--focus");
            });
        },
        scrollBar: function () {
            $('.sidebar-body').each(function () {
                const ps = new PerfectScrollbar($(this)[0]);
            });
        },
        iconBarMenu: function () {
            //icon bar menu 
            $('.iconbar .nav-link').on('click', function (e) {
                e.preventDefault();

                $(this).addClass('active');
                $(this).siblings().removeClass('active');

                $('.iconbar-aside').addClass('show');

                var targ = $(this).attr('href');
                $(targ).addClass('show');
                $(targ).siblings().removeClass('show');
            });
            $('.iconbar-toggle-menu').on('click', function (e) {
                e.preventDefault();

                if (window.matchMedia('(min-width: 992px)').matches) {
                    $('.iconbar .nav-link.active').removeClass('active');
                    $('.iconbar-aside').removeClass('show');
                } else {
                    $('body').removeClass('iconbar-show');
                }
            });
            $('#iconbarCollapse').on('click', function (e) {
                e.preventDefault();
                $('body').toggleClass('iconbar-show');

                var targ = $('.iconbar .nav-link.active').attr('href');
                $(targ).addClass('show');
            });
            $(document).bind('click touchstart', function (e) {
                e.stopPropagation();
                var content = $(e.target).closest('.main-content').length;
                var iconBarMenu = $(e.target).closest('.sidebar-toggle-icon').length;

                if (content) {
                    $('.iconbar-aside').removeClass('show');
                    // for mobile
                    if (!iconBarMenu) {
                        $('body').removeClass('iconbar-show');
                    }
                }
            });
        },
        sideBar: function () {
            //navbar toggle icon
            $(".sidebar-toggle-icon").on('click', function () {
                $(this).toggleClass("open");
            });
            $('#sidebarCollapse').on('click', function () {
                $('.sidebar, .navbar').toggleClass('active');
            });
            $('.overlay').on('click', function () {
                $('.sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });
            $('#sidebarCollapse').on('click', function preventDefault(x) {
                if (x.matches) { // If media query matches
                    $('.overlay').addClass('active');
                } else {
                    $('.overlay').removeClass('active');
                }
                var x = window.matchMedia("(max-width: 700px)");
                preventDefault(x); // Call listener function at run time
                x.addListener(preventDefault) // Attach listener function on state changes
            });
            $('.sidebar .with-sub').on('click', function (e) {
                e.preventDefault();
                $(this).parent().toggleClass('show');
                $(this).parent().siblings().removeClass('show');
            });
        },
        materialRipple: function () {
            // Material Ripple effect
            $(".material-ripple").on('click', function (event) {
                var surface = $(this);

                // create .material-ink element if doesn't exist
                if (surface.find(".material-ink").length === 0) {
                    surface.prepend("<div class='material-ink'></div>");
                }

                var ink = surface.find(".material-ink");

                // in case of quick double clicks stop the previous animation
                ink.removeClass("animate");

                // set size of .ink
                if (!ink.height() && !ink.width()) {
                    // use surface's width or height whichever is larger for
                    // the diameter to make a circle which can cover the entire element
                    var diameter = Math.max(surface.outerWidth(), surface.outerHeight());
                    ink.css({height: diameter, width: diameter});
                }

                // get click coordinates
                // Logic:
                // click coordinates relative to page minus
                // surface's position relative to page minus
                // half of self height/width to make it controllable from the center
                var xPos = event.pageX - surface.offset().left - (ink.width() / 2);
                var yPos = event.pageY - surface.offset().top - (ink.height() / 2);

                var rippleColor = surface.data("ripple-color");

                //set the position and add class .animate
                ink.css({
                    top: yPos + 'px',
                    left: xPos + 'px',
                    background: rippleColor
                }).addClass("animate");
            });
        },
        toTop: function () {
            $('body').append('<div id="toTop" class="btn-top"><i class="typcn typcn-arrow-up fs-21"></i></div>');
            $(window).scroll(function () {
                if ($(this).scrollTop() !== 0) {
                    $('#toTop').fadeIn();
                } else {
                    $('#toTop').fadeOut();
                }
            });
            $('#toTop').on('click', function () {
                $("html, body").animate({scrollTop: 0}, 600);
                return false;
            });
        },
        pageloader: function () {
            setTimeout(function () {
                $('.page-loader-wrapper').fadeOut();
            }, 50);
        }
    };
    // Initialize
    $(document).ready(function () {
        "use strict";
        bdAdmin.initialize();
        $('.metismenu').metisMenu();//Metismenu
    });
    $(window).on("load", function () {
        bdAdmin.pageloader();
    });

}(jQuery));