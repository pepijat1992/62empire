$.fn.raty.defaults.path = 'assets/plugins/raty/lib/images';

$(function () {
    $('#default').raty();

    $('#score').raty({score: 3});

    $('#score-callback').raty({
        score: function () {
            return $(this).attr('data-score');
        }
    });

    $('#scoreName').raty({scoreName: 'entity[score]'});

    $('#number').raty({number: 10});

    $('#number-callback').raty({
        number: function () {
            return $(this).attr('data-number');
        }
    });

    $('#numberMax').raty({
        numberMax: 5,
        number: 100
    });

    $('#readOnly').raty({readOnly: true, score: 3});

    $('#readOnly-callback').raty({
        readOnly: function () {
            return 'true becomes readOnly' === 'true becomes readOnly';
        }
    });

    $('#noRatedMsg').raty({
        readOnly: true,
        noRatedMsg: "I'm readOnly and I haven't rated yet!"
    });

    $('#halfShow-true').raty({score: 4.570});

    $('#halfShow-false').raty({
        halfShow: false,
        score: 3.26
    });

    $('#round').raty({
        round: {down: .26, full: .6, up: .76},
        score: 3.26
    });

    $('#half').raty({
        half: true,
        score: 3.5,
        hints: [['bad 1/2', 'bad'], ['poor 1/2', 'poor'], ['regular 1/2', 'regular'], ['good 1/2', 'good'], ['gorgeous 1/2', 'gorgeous']]
    });

    $('#starHalf').raty({
        half: true,
        path: null,
        starHalf: 'assets/plugins/raty/lib/images/star-half-mono.png',
        starOff: 'assets/plugins/raty/lib/images/star-off.png',
        starOn: 'assets/plugins/raty/lib/images/star-on.png'
    });

    $('#click').raty({
        click: function (score, evt) {
            alert('ID: ' + this.id + "\nscore: " + score + "\nevent: " + evt.type);
        }
    });

    $('#click-prevent').raty({
        click: function (score, evt) {
            alert('Score will not change.');
            return false;
        }
    });

    $('#hints').raty({hints: ['a', null, '', undefined, '*_*']});

    $('#star-off-and-star-on').raty({
        path: 'assets/plugins/raty/lib/images',
        starOff: 'off.png',
        starOn: 'on.png'
    });

    $('#cancel').raty({cancel: true});

    $('#cancelHint').raty({
        cancel: true,
        cancelHint: 'My cancel hint!'
    });

    $('#cancelPlace').raty({
        cancel: true,
        cancelPlace: 'right'
    });

    $('#cancel-off-and-cancel-on').raty({
        cancel: true,
        cancelOff: 'cancel-custom-off.png',
        cancelOn: 'cancel-custom-on.png',
        starOff: 'star-off.png',
        starOn: 'star-on.png'
    });

    $('#iconRange').raty({
        starOff: 'star-off.png',
        iconRange: [
            {range: 1, on: '1.png', off: '0.png'},
            {range: 2, on: '2.png', off: '0.png'},
            {range: 3, on: '3.png', off: '0.png'},
            {range: 4, on: '4.png', off: '0.png'},
            {range: 5, on: '5.png', off: '0.png'}
        ]
    });

});