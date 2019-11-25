$(document).ready(function () {
    "use strict"; // Start of use strict

    //Sparklines Charts
    $(".sparkline5").sparkline([32, 15, 22, 46, 33, 86, 54, 73, 53, 12, 53, 23, 65, 23, 63, 53, 42, 34, 56, 76, 15], {
        type: 'line',
        lineColor: '#37a000',
        fillColor: '#37a000',
        width: '100',
        height: '20'
    });
    $(".sparkline6").sparkline([4, 6, 7, 7, 4, 3, 2, 1, 4, 4, 5, 6, 3, 4, 5, 8, 7, 6, 9, 3, 2, 4, 1, 5, 6, 4, 3, 7], {
        type: 'discrete',
        lineColor: '#37a000',
        width: '100',
        height: '20'
    });
    $(".sparkline7").sparkline([5, 6, 7, 2, 0, -4, -2, 4, 5, 6, 3, 2, 4, -6, -5, -4, 6, 5, 4, 3], {
        type: 'bar',
        barColor: '#37a000',
        negBarColor: '#c6c6c6',
        width: '100',
        height: '20'
    });

    //emojionearea
    $(".emojionearea").emojioneArea({
        pickerPosition: "top",
        tonesStyle: "radio"
    });

    //Chat UI
    $('.chat_list').each(function () {
        const ps = new PerfectScrollbar($(this)[0]);
    });

    //Card table
    $('.card-table').DataTable({
        "bPaginate": false,
        "bFilter": false,
        "bInfo": false
    });
    
    //Tooltip
    $('[data-toggle="tooltip"]').tooltip();

    //Performance Chart
    var chart_labels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var temp_dataset = [25, 30, 20, 30, 20, 20, 15, 25, 20, 30, 25, 30];
    var rain_dataset = [25, 20, 30, 22, 17, 20, 18, 26, 28, 26, 20, 32];
    var ctx = document.getElementById("forecast").getContext('2d');
    var config = {
        type: 'bar',
        data: {
            labels: chart_labels,
            datasets: [{
                    type: 'line',
                    label: "Salles",
                    borderColor: "rgb(55, 160, 0)",
                    fill: false,
                    data: temp_dataset
                }, {
                    type: 'bar',
                    label: "Affiliate",
                    backgroundColor: "rgba(55, 160, 0, .1)",
                    borderColor: "rgba(55, 160, 0, .4)",
                    data: rain_dataset
                }]
        },
        options: {
            legend: false,
            scales: {
                yAxes: [{
                        gridLines: {
                            color: "#e6e6e6",
                            zeroLineColor: "#e6e6e6",
                            borderDash: [2],
                            borderDashOffset: [2],
                            drawBorder: false,
                            drawTicks: false
                        },
                        ticks: {
                            padding: 20
                        }
                    }],

                xAxes: [{
                        maxBarThickness: 50,
                        gridLines: {
                            lineWidth: [0]
                        },
                        ticks: {
                            padding: 20,
                            fontSize: 14,
                            fontFamily: "'Nunito Sans', sans-serif"
                        }
                    }]
            }
        }
    };
    var forecast_chart = new Chart(ctx, config);
    $("#0").on("click", function () {
        var data = forecast_chart.config.data;
        data.datasets[0].data = temp_dataset;
        data.datasets[1].data = rain_dataset;
        data.labels = chart_labels;
        forecast_chart.update();
    });
    $("#1").on("click", function () {
        var chart_labels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var temp_dataset = [0, 15, 5, 30, 10, 20, 10, 15, 10, 30, 25, 10];
        var rain_dataset = [20, 25, 30, 35, 27, 23, 18, 26, 28, 26, 20, 32];
        var data = forecast_chart.config.data;
        data.datasets[0].data = temp_dataset;
        data.datasets[1].data = rain_dataset;
        data.labels = chart_labels;
        forecast_chart.update();
    });
    $("#2").on("click", function () {
        var chart_labels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var temp_dataset = [0, 10, 5, 15, 10, 20, 15, 25, 20, 30, 25, 40];
        var rain_dataset = [25, 20, 30, 22, 17, 10, 18, 26, 28, 26, 20, 32];
        var data = forecast_chart.config.data;
        data.datasets[0].data = temp_dataset;
        data.datasets[1].data = rain_dataset;
        data.labels = chart_labels;
        forecast_chart.update();
    });

    //bar chart
    var chartColors = {
        gray: '#e4e4e4',
        green: '#37a000'
    };

    var randomScalingFactor = function () {
        return (Math.random() > 0.5 ? 1.0 : 1.0) * Math.round(Math.random() * 100);
    };

    // draws a rectangle with a rounded top
    Chart.helpers.drawRoundedTopRectangle = function (ctx, x, y, width, height, radius) {
        ctx.beginPath();
        ctx.moveTo(x + radius, y);
        // top right corner
        ctx.lineTo(x + width - radius, y);
        ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
        // bottom right	corner
        ctx.lineTo(x + width, y + height);
        // bottom left corner
        ctx.lineTo(x, y + height);
        // top left	
        ctx.lineTo(x, y + radius);
        ctx.quadraticCurveTo(x, y, x + radius, y);
        ctx.closePath();
    };

    Chart.elements.RoundedTopRectangle = Chart.elements.Rectangle.extend({
        draw: function () {
            var ctx = this._chart.ctx;
            var vm = this._view;
            var left, right, top, bottom, signX, signY, borderSkipped;
            var borderWidth = vm.borderWidth;

            if (!vm.horizontal) {
                // bar
                left = vm.x - vm.width / 2;
                right = vm.x + vm.width / 2;
                top = vm.y;
                bottom = vm.base;
                signX = 1;
                signY = bottom > top ? 1 : -1;
                borderSkipped = vm.borderSkipped || 'bottom';
            } else {
                // horizontal bar
                left = vm.base;
                right = vm.x;
                top = vm.y - vm.height / 2;
                bottom = vm.y + vm.height / 2;
                signX = right > left ? 1 : -1;
                signY = 1;
                borderSkipped = vm.borderSkipped || 'left';
            }

            // Canvas doesn't allow us to stroke inside the width so we can
            // adjust the sizes to fit if we're setting a stroke on the line
            if (borderWidth) {
                // borderWidth shold be less than bar width and bar height.
                var barSize = Math.min(Math.abs(left - right), Math.abs(top - bottom));
                borderWidth = borderWidth > barSize ? barSize : borderWidth;
                var halfStroke = borderWidth / 2;
                // Adjust borderWidth when bar top position is near vm.base(zero).
                var borderLeft = left + (borderSkipped !== 'left' ? halfStroke * signX : 0);
                var borderRight = right + (borderSkipped !== 'right' ? -halfStroke * signX : 0);
                var borderTop = top + (borderSkipped !== 'top' ? halfStroke * signY : 0);
                var borderBottom = bottom + (borderSkipped !== 'bottom' ? -halfStroke * signY : 0);
                // not become a vertical line?
                if (borderLeft !== borderRight) {
                    top = borderTop;
                    bottom = borderBottom;
                }
                // not become a horizontal line?
                if (borderTop !== borderBottom) {
                    left = borderLeft;
                    right = borderRight;
                }
            }

            // calculate the bar width and roundess
            var barWidth = Math.abs(left - right);
            var roundness = this._chart.config.options.barRoundness || 0.5;
            var radius = barWidth * roundness * 0.5;

            // keep track of the original top of the bar
            var prevTop = top;

            // move the top down so there is room to draw the rounded top
            top = prevTop + radius;
            var barRadius = top - prevTop;

            ctx.beginPath();
            ctx.fillStyle = vm.backgroundColor;
            ctx.strokeStyle = vm.borderColor;
            ctx.lineWidth = borderWidth;

            // draw the rounded top rectangle
            Chart.helpers.drawRoundedTopRectangle(ctx, left, (top - barRadius + 1), barWidth, bottom - prevTop, barRadius);

            ctx.fill();
            if (borderWidth) {
                ctx.stroke();
            }

            // restore the original top value so tooltips and scales still work
            top = prevTop;
        },
    });

    Chart.defaults.roundedBar = Chart.helpers.clone(Chart.defaults.bar);

    Chart.controllers.roundedBar = Chart.controllers.bar.extend({
        dataElementType: Chart.elements.RoundedTopRectangle
    });

    var ctx = document.getElementById("barChart").getContext("2d");
    var myBar = new Chart(ctx, {
        type: 'roundedBar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                    label: 'Students',
                    backgroundColor: chartColors.green,
                    data: [25, 20, 30, 22, 17, 10, 18, 26, 28, 26, 20, 32],
                }, {
                    label: 'Teachers',
                    backgroundColor: chartColors.gray,
                    data: [15, 10, 20, 12, 6, 7, 10, 15, 15, 20, 15, 20],
                }]
        },
        options: {
            legend: false,
            responsive: true,
            barRoundness: 1,
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            padding: 10,
//                            fontFamily: "'Nunito Sans', sans-serif",
                        },
                        gridLines: {
                            borderDash: [2],
                            borderDashOffset: [2],
//                            color: 'E3EBF6',
                            drawBorder: false,
                            drawTicks: false,
//                            zeroLineColor: 'E3EBF6',
//                            zeroLineBorderDash: [2],
//                            zeroLineBorderDashOffset: [2],

                        },

                    }],

                xAxes: [{
                        maxBarThickness: 10,
                        gridLines: {
                            lineWidth: [0],
                            drawBorder: false,
                            drawOnChartArea: false,
                            drawTicks: false
                        },
                        ticks: {
                            padding: 20
                        },

                    }],
            }
        }
    });

    //doughut chart
    var ctx = document.getElementById("doughutChart");
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            datasets: [{
                    data: [40, 25, 20],
                    backgroundColor: [
                        "#37a000",
                        "#42b704",
                        "#e4e4e4",
                    ],
                    hoverBackgroundColor: [
                        "#4cd604",
                        "#4cd604",
                        "#4cd604"
                    ]
                }],
            labels: [
                "green",
                "green",
                "green",
                "green"
            ]
        },
        options: {
            legend: false,
            responsive: true,
            cutoutPercentage: 80,
        }
    });
});