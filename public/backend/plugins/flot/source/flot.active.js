$(document).ready(function () {

    "use strict"; // Start of use strict

    //Flot charts data and options

    var data = [[1, 4], [2, 6], [3, 8], [4, 10], [5, 12], [6, 8], [7, 6], [8, 4], [9, 8], [10, 5], [11, 12], [12, 3]];

    $.plot("#flotChart1", [data], {
        series: {
            bars: {
                show: true,
                lineWidth: 2,
                align: "center",
                fill: false
            }
        },
        legend: {
            show: false
        },
        grid: {
            tickColor: "#e4e5e7",
            borderWidth: 1,
            borderColor: '#ddd',
            color: '#37a000'
        },
        colors: ["#37a000"]
    });

    var data1 = [[0, 2], [1, 3], [2, 8], [3, 9], [4, 12], [5, 14], [6, 15], [7, 12],
        [8, 14], [9, 12], [10, 13], [11, 10], [12, 14], [13, 16], [14, 15], [15, 15],
        [16, 16], [17, 10], [18, 15], [19, 15], [20, 15], [21, 18], [22, 20], [23, 23],
        [24, 22], [25, 21], [26, 20], [27, 17], [28, 15], [29, 14], [30, 13], [31, 10]];

    var chartUsersOptions2 = {
//        points: {
//            show: true,
//            fill: true,
//            lineWidth: 1,
//            fillColor: "#37a000"
//        },
        series: {
            lines: {
                show: true
            },
            points: {
                show: true,
//                fill: true,
                lineWidth: 1,
//                fillColor: "#37a000"
            }
        },
        grid: {
            tickColor: "#e4e5e7",
            borderWidth: 1,
            borderColor: '#ddd',
            color: '#37a000'
        },
        colors: ["#37a000"]
    };



    $.plot($("#flotChart2"), [data1], chartUsersOptions2);

    var chartUsersOptions3 = {
        lines: {
            show: true,
            fill: false,
            lineWidth: 2,
            fillColor: "#37a000"
        },
        grid: {
            tickColor: "#e4e5e7",
            borderWidth: 1,
            borderColor: '#ddd',
            color: '#37a000'
        },
        colors: ["#37a000"]
    };

    $.plot($("#flotChart3"), [data1], chartUsersOptions3);

    var data = [],
            totalPoints = 300;

    function getRandomData() {

        if (data.length > 0)
            data = data.slice(1);

        // Do a random walk

        while (data.length < totalPoints) {

            var prev = data.length > 0 ? data[data.length - 1] : 50,
                    y = prev + Math.random() * 10 - 5;

            if (y < 0) {
                y = 0;
            } else if (y > 100) {
                y = 100;
            }

            data.push(y);
        }

        // Zip the generated y values with the x values

        var res = [];
        for (var i = 0; i < data.length; ++i) {
            res.push([i, data[i]]);
        }

        return res;
    }

    // Set up the control widget

    var updateInterval = 30;

    var plot = $.plot("#flotChart4", [getRandomData()], {
        series: {
            shadowSize: 0	// Drawing is faster without shadows
        },
        yaxis: {
            min: 0,
            max: 100
        },
        xaxis: {
            show: false
        },
        grid: {
            tickColor: "#e4e5e7",
            borderWidth: 1,
            borderColor: '#ddd',
            color: '#37a000'
        },
        colors: ["#37a000"]
    });

    function update() {

        plot.setData([getRandomData()]);

        // Since the axes don't change, we don't need to call plot.setupGrid()

        plot.draw();
        setTimeout(update, updateInterval);
    }

    update();

    var data5 = [
        {
            data: [[1, 3], [2, 6], [3, 7], [4, 9], [5, 5], [6, 9], [7, 7], [8, 10], [9, 5], [10, 6], [11, 7], [12, 3], [13, 4]]
        }
    ];

    var chartUsersOptions5 = {
        series: {
            lines: {
                show: true,
                fill: 0.1
            }
        },
        grid: {
            tickColor: "#e4e5e7",
            borderWidth: 1,
            borderColor: '#ddd',
            color: '#37a000'
        },
        colors: ["#37a000"]
    };

    $.plot($("#flotChart5"), data5, chartUsersOptions5);

    var data6 = [
        {
            label: "bar",
            data: [[1, 10], [2, 14], [3, 18], [4, 24], [5, 28], [6, 26], [7, 24], [8, 18], [9, 17], [10, 13], [11, 15], [12, 17]]
        }
    ];

    var chartUsersOptions6 = {
        series: {
            lines: {
                show: true,
                steps: true
            }
        },
        grid: {
            tickColor: "#e4e5e7",
            borderWidth: 1,
            borderColor: '#ddd',
            color: '#37a000'
        },
        colors: ["#37a000"]
    };

    $.plot($("#flotChart6"), data6, chartUsersOptions6);

    var sin = [],
            cos = [];
    for (var i = 0; i < 14; i += 0.5) {
        sin.push([i, Math.sin(i)]);
        cos.push([i, Math.cos(i)]);
    }

    var data7 = [
        {data: sin, label: "sin(x)"},
        {data: cos, label: "cos(x)"}
    ];

    var chartUsersOptions7 = {
        series: {
            lines: {
                show: true
            },
            points: {
                show: true
            }
        },
        grid: {
            tickColor: "#e4e5e7",
            borderWidth: 1,
            borderColor: '#ddd',
            color: '#37a000'
        },
        yaxis: {
            min: -1.2,
            max: 1.2
        },
        colors: ["#37a000", "#efefef"]
    }
    ;

    $.plot($("#flotChart7"), data7, chartUsersOptions7);

    var data8 = [
        {label: "Data 1", data: 16, color: "#37a000"},
        {label: "Data 2", data: 6, color: "#4b8523"},
        {label: "Data 3", data: 22, color: "#40761a"},
        {label: "Data 4", data: 32, color: "#3a6d16"}
    ];

    var chartUsersOptions8 = {
        series: {
            pie: {
                show: true
            }
        },
        grid: {
            hoverable: true
        },
        tooltip: true,
        tooltipOpts: {
            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
            shifts: {
                x: 20,
                y: 0
            },
            defaultTheme: false
        }
    };

    $.plot($("#flotChart8"), data8, chartUsersOptions8);

});