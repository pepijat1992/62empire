$(document).ready(function () {
    "use strict"; // Start of use strict

    $("#range_01").ionRangeSlider();

    $("#range_02").ionRangeSlider({
        min: 100,
        max: 1000,
        from: 550
    });

    $("#range_03").ionRangeSlider({
        type: "double",
        grid: true,
        min: 0,
        max: 1000,
        from: 200,
        to: 800,
        prefix: "$"
    });

    $("#range_04").ionRangeSlider({
        type: "double",
        grid: true,
        min: -1000,
        max: 1000,
        from: -500,
        to: 500
    });

    $("#range_05").ionRangeSlider({
        type: "double",
        grid: true,
        min: -1000,
        max: 1000,
        from: -500,
        to: 500,
        step: 250
    });

    $("#range_06").ionRangeSlider({
        type: "double",
        grid: true,
        min: -12.8,
        max: 12.8,
        from: -3.2,
        to: 3.2,
        step: 0.1
    });

    $("#range_07").ionRangeSlider({
        type: "double",
        min: 0,
        max: 100,
        from: 30,
        to: 70,
        from_fixed: true
    });

    $("#range_08").ionRangeSlider({
        type: "double",
        min: 0,
        max: 100,
        from: 30,
        to: 70,
        from_fixed: true,
        to_fixed: true
    });

    $("#range_09").ionRangeSlider({
        min: 0,
        max: 100,
        from: 30,
        from_min: 10,
        from_max: 50
    });

    $("#range_10").ionRangeSlider({
        min: 0,
        max: 100,
        from: 30,
        from_min: 10,
        from_max: 50,
        from_shadow: true
    });

    $("#range_11").ionRangeSlider({
        type: "double",
        min: 0,
        max: 100,
        from: 20,
        from_min: 10,
        from_max: 30,
        from_shadow: true,
        to: 80,
        to_min: 70,
        to_max: 90,
        to_shadow: true,
        grid: true,
        grid_num: 10
    });

    $("#range_12").ionRangeSlider({
        min: 0,
        max: 100,
        from: 30,
        disable: true
    });

    $("#range_13").ionRangeSlider({
        type: "double",
        min: 0,
        max: 100,
        from: 30,
        to: 70,
        keyboard: true
    });

    $("#range_14").ionRangeSlider({
        type: "double",
        min: 0,
        max: 100,
        from: 30,
        to: 70,
        keyboard: true,
        keyboard_step: 20
    });

    $("#range_15").ionRangeSlider({
        min: +moment().subtract(1, "years").format("X"),
        max: +moment().format("X"),
        from: +moment().subtract(6, "months").format("X"),
        prettify: function (num) {
            return moment(num, "X").format("LL");
        }
    });

    $("#range_16").ionRangeSlider({
        min: +moment().subtract(12, "hours").format("X"),
        max: +moment().format("X"),
        from: +moment().subtract(6, "hours").format("X"),
        prettify: function (num) {
            return moment(num, "X").format("MMM Do, hh:mm A");
        }
    });

    $("#range_17").ionRangeSlider({
        min: +moment().subtract(12, "hours").format("X"),
        max: +moment().format("X"),
        from: +moment().subtract(6, "hours").format("X"),
        grid: true,
        force_edges: true,
        prettify: function (num) {
            var m = moment(num, "X").locale("ru");
            return m.format("Do MMMM, HH:mm");
        }
    });

});