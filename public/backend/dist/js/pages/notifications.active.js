"use strict"; // Start of use strict

(function () {
    function1();
    function2();
    function3();
    function4();
    function5();
    function6();
    function7();
    function8();
    function9();
    function10();
    function11();
    function12();
    function13();
    function14();
    function15();
    function16();
    function17();
})();

function function1() {
    var bttn = document.getElementById('scale');

    // make sure..
    bttn.disabled = false;

    bttn.addEventListener('click', function () {
        // simulate loading (for demo purposes only)
        classie.add(bttn, 'active');
        setTimeout(function () {

            classie.remove(bttn, 'active');

            // create the notification
            var notification = new NotificationFx({
                message: '<p>This is just a simple notice. Everything is in order and this is a <a href="#">simple link</a>.</p>',
                layout: 'growl',
                effect: 'scale',
                type: 'notice', // notice, warning, error or success
                onClose: function () {
                    bttn.disabled = false;
                }
            });

            // show the notification
            notification.show();

        }, 1200);

        // disable the button (for demo purposes only)
        this.disabled = true;
    });
}
function function2() {
    var bttn = document.getElementById('jelly');

    // make sure..
    bttn.disabled = false;

    bttn.addEventListener('click', function () {
        // simulate loading (for demo purposes only)
        classie.add(bttn, 'active');
        setTimeout(function () {

            classie.remove(bttn, 'active');

            // create the notification
            var notification = new NotificationFx({
                message: '<p>Hello there! I\'m a classic notification but I have some elastic jelliness thanks to <a href="http://bouncejs.com/">bounce.js</a>. </p>',
                layout: 'growl',
                effect: 'jelly',
                type: 'notice', // notice, warning, error or success
                onClose: function () {
                    bttn.disabled = false;
                }
            });

            // show the notification
            notification.show();

        }, 1200);

        // disable the button (for demo purposes only)
        this.disabled = true;
    });
}
function function3() {
    var bttn = document.getElementById('slideIn');

    // make sure..
    bttn.disabled = false;

    bttn.addEventListener('click', function () {
        // simulate loading (for demo purposes only)
        classie.add(bttn, 'active');
        setTimeout(function () {

            classie.remove(bttn, 'active');

            // create the notification
            var notification = new NotificationFx({
                message: '<p>This notification has slight elasticity to it thanks to <a href="http://bouncejs.com/">bounce.js</a>.</p>',
                layout: 'growl',
                effect: 'slide',
                type: 'notice', // notice, warning or error
                onClose: function () {
                    bttn.disabled = false;
                }
            });

            // show the notification
            notification.show();

        }, 1200);

        // disable the button (for demo purposes only)
        this.disabled = true;
    });
}
function function4() {
    var bttn = document.getElementById('genie');

    // make sure..
    bttn.disabled = false;

    bttn.addEventListener('click', function () {
        // simulate loading (for demo purposes only)
        classie.add(bttn, 'active');
        setTimeout(function () {

            classie.remove(bttn, 'active');

            // create the notification
            var notification = new NotificationFx({
                message: '<p>Your preferences have been saved successfully. See all your settings in your <a href="#">profile overview</a>.</p>',
                layout: 'growl',
                effect: 'genie',
                type: 'notice', // notice, warning or error
                onClose: function () {
                    bttn.disabled = false;
                }
            });

            // show the notification
            notification.show();

        }, 1200);

        // disable the button (for demo purposes only)
        this.disabled = true;
    });
}
function function5() {
    var bttn = document.getElementById('flip');

    // make sure..
    bttn.disabled = false;

    bttn.addEventListener('click', function () {
        // simulate loading (for demo purposes only)
        classie.add(bttn, 'active');
        setTimeout(function () {

            classie.remove(bttn, 'active');

            // create the notification
            var notification = new NotificationFx({
                message: '<p>Your preferences have been saved successfully. See all your settings in your <a href="#">profile overview</a>.</p>',
                layout: 'attached',
                effect: 'flip',
                type: 'notice', // notice, warning or error
                onClose: function () {
                    bttn.disabled = false;
                }
            });

            // show the notification
            notification.show();

        }, 1200);

        // disable the button (for demo purposes only)
        this.disabled = true;
    });
}
function function6() {

    var bttn = document.getElementById('bouncyFlip');

    // make sure..
    bttn.disabled = false;

    bttn.addEventListener('click', function () {
        // simulate loading (for demo purposes only)
        classie.add(bttn, 'active');
        setTimeout(function () {

            classie.remove(bttn, 'active');

            // create the notification
            var notification = new NotificationFx({
                message: '<span class="icon icon-calendar"></span><p>The event was added to your calendar. Check out all your events in your <a href="#">event overview</a>.</p>',
                layout: 'attached',
                effect: 'bouncyflip',
                type: 'notice', // notice, warning or error
                onClose: function () {
                    bttn.disabled = false;
                }
            });

            // show the notification
            notification.show();

        }, 1200);

        // disable the button (for demo purposes only)
        this.disabled = true;
    });
}
function function7() {
    var bttn = document.getElementById('slidetop');

    // make sure..
    bttn.disabled = false;

    bttn.addEventListener('click', function () {
        // simulate loading (for demo purposes only)
        classie.add(bttn, 'active');
        setTimeout(function () {

            classie.remove(bttn, 'active');

            // create the notification
            var notification = new NotificationFx({
                message: '<span class="icon icon-megaphone"></span><p>You have some interesting news in your inbox. Go <a href="#">check it out</a> now.</p>',
                layout: 'bar',
                effect: 'slidetop',
                type: 'notice', // notice, warning or error
                onClose: function () {
                    bttn.disabled = false;
                }
            });

            // show the notification
            notification.show();

        }, 1200);

        // disable the button (for demo purposes only)
        this.disabled = true;
    });

}


function function8() {

    var bttn = document.getElementById('exploader');

    // make sure..
    bttn.disabled = false;

    bttn.addEventListener('click', function () {

        // create the notification
        var notification = new NotificationFx({
            message: '<span class="icon icon-settings"></span><p>Your preferences have been saved successfully. See all your settings in your <a href="#">profile overview</a>.</p>',
            layout: 'bar',
            effect: 'exploader',
            type: 'notice', // notice, warning or error
            onClose: function () {
                bttn.disabled = false;
            }
        });

        // show the notification
        notification.show();

        // disable the button (for demo purposes only)
        this.disabled = true;
    });
}

function function9() {
    var svgshape = document.getElementById('notification-shape'),
            s = Snap(svgshape.querySelector('svg')),
            path = s.select('path'),
            pathConfig = {
                from: path.attr('d'),
                to: svgshape.getAttribute('data-path-to')
            },
            bttn = document.getElementById('cornerExpand');

    // make sure..
    bttn.disabled = false;

    bttn.addEventListener('click', function () {
        // simulate loading (for demo purposes only)
        classie.add(bttn, 'active');
        setTimeout(function () {

            path.animate({'path': pathConfig.to}, 300, mina.easeinout);

            classie.remove(bttn, 'active');

            // create the notification
            var notification = new NotificationFx({
                wrapper: svgshape,
                message: '<p><span class="icon icon-bulb"></span> I\'m appaering in a morphed shape thanks to <a href="http://snapsvg.io/">Snap.svg</a></p>',
                layout: 'other',
                effect: 'cornerexpand',
                type: 'notice', // notice, warning or error
                onClose: function () {
                    bttn.disabled = false;
                    setTimeout(function () {
                        path.animate({'path': pathConfig.from}, 300, mina.easeinout);
                    }, 200);
                }
            });

            // show the notification
            notification.show();

        }, 1200);

        // disable the button (for demo purposes only)
        this.disabled = true;
    });

}
function function10() {
    var svgshape = document.getElementById('notification-shape2'),
            bttn = document.getElementById('loadingcircle');

    // make sure..
    bttn.disabled = false;

    bttn.addEventListener('click', function () {
        // create the notification
        var notification = new NotificationFx({
            wrapper: svgshape,
            message: '<p>Whatever you did, it was successful!</p>',
            layout: 'other',
            effect: 'loadingcircle',
            ttl: 9000,
            type: 'notice', // notice, warning or error
            onClose: function () {
                bttn.disabled = false;
            }
        });

        // show the notification
        notification.show();

        // disable the button (for demo purposes only)
        this.disabled = true;
    });
}
function function11() {
    var bttn = document.getElementById('boxspinner');

    // make sure..
    bttn.disabled = false;

    bttn.addEventListener('click', function () {
        // create the notification
        var notification = new NotificationFx({
            message: '<p>I am using a beautiful spinner from <a href="http://tobiasahlin.com/spinkit/">SpinKit</a></p>',
            layout: 'other',
            effect: 'boxspinner',
            ttl: 9000,
            type: 'notice', // notice, warning or error
            onClose: function () {
                bttn.disabled = false;
            }
        });

        // show the notification
        notification.show();

        // disable the button (for demo purposes only)
        this.disabled = true;
    });

}
function function12() {
    var bttn = document.getElementById('thumbslider');
    // make sure..
    bttn.disabled = false;

    bttn.addEventListener('click', function () {
        // simulate loading (for demo purposes only)
        classie.add(bttn, 'active');
        setTimeout(function () {

            classie.remove(bttn, 'active');

            // create the notification
            var notification = new NotificationFx({
                message: '<div class="ns-thumb"><img src="assets/dist/img/user1.jpg"/></div><div class="ns-content"><p><a href="#">Zoe Moulder</a> accepted your invitation.</p></div>',
                layout: 'other',
                ttl: 6000,
                effect: 'thumbslider',
                type: 'notice', // notice, warning, error or success
                onClose: function () {
                    bttn.disabled = false;
                }
            });

            // show the notification
            notification.show();

        }, 1200);

        // disable the button (for demo purposes only)
        this.disabled = true;
    });

}

function function13() {
    $('.demo1').on("click", function () {
        swal({
            title: "Here's a message!",
            text: "It's pretty, isn't it?"
        });
    });
}

function function14() {
    $('.demo2').on("click", function () {
        swal({
            title: "Good job!",
            text: "You clicked the button!",
            type: "success"
        });
    });
}

function function15() {
    $('.demo3').on("click", function () {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
                function () {
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                });
    });
}

function function16() {
    $('.demo4').on("click", function () {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel plx!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
                function (isConfirm) {
                    if (isConfirm) {
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    } else {
                        swal("Cancelled", "Your imaginary file is safe :)", "error");
                    }
                });
    });
}

function function17() {
    $('.demo5').on("click", function () {
        swal({
            title: "Sweet!",
            text: "Here's a custom image.",
            imageUrl: "assets/plugins/sweetalert/thumbs-up.jpg"
        });
    });
}

// Toastr options
toastr.options = {
    "debug": false,
    "newestOnTop": false,
    "positionClass": "toast-top-center",
    "closeButton": true,
    "toastClass": "animated fadeInDown"
};

$('.toastr1').on("click", function () {
    toastr.info('Info - This is a custom Burger - UI info notification');
});

$('.toastr2').on("click", function () {
    toastr.success('Success - This is a Burger - UI success notification');
});

$('.toastr3').on("click", function () {
    toastr.warning('Warning - This is a Burger - UI warning notification');
});

$('.toastr4').on("click", function () {
    toastr.error('Error - This is a Burger - UI error notification');
});