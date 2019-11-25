$(document).ready(function () {
    "use strict"; // Start of use strict

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
        var chart_labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var temp_dataset = [0, 15, 5, 30, 10, 20, 10, 15, 10, 30, 25, 10];
        var rain_dataset = [20, 25, 30, 35, 27, 23, 18, 26, 28, 26, 20, 32];
        var data = forecast_chart.config.data;
        data.datasets[0].data = temp_dataset;
        data.datasets[1].data = rain_dataset;
        data.labels = chart_labels;
        forecast_chart.update();
    });
    $("#2").on("click", function () {
        var chart_labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
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
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: '#37a000',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(231,233,237)'
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
        }
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
                    data: [25, 20, 30, 22, 17, 10, 18, 26, 28, 26, 20, 32]
                }, {
                    label: 'Teachers',
                    backgroundColor: chartColors.gray,
                    data: [15, 10, 20, 12, 6, 7, 10, 15, 15, 20, 15, 20]
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
                            padding: 10
                        },
                        gridLines: {
                            borderDash: [2],
                            borderDashOffset: [2],
                            drawBorder: false,
                            drawTicks: false
                        }
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
                        }
                    }]
            }
        }
    });

    //radar chart
    var ctx = document.getElementById("radarChart");
    var myChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: [["Eating", "Dinner"], ["Drinking", "Water"], "Sleeping", ["Designing", "Graphics"], "Coding", "Cycling", "Running"],
            datasets: [
                {
                    label: "My First dataset",
                    data: [65, 59, 66, 45, 56, 55, 40],
                    borderColor: "rgba(55, 160, 0, 0.7)",
                    borderWidth: "1",
                    backgroundColor: "rgba(55, 160, 0, 0.4)"
                },
                {
                    label: "My Second dataset",
                    data: [28, 12, 40, 19, 63, 27, 87],
                    borderColor: "rgba(55, 160, 0, 0.7)",
                    borderWidth: "1",
                    backgroundColor: "rgba(85, 139, 47, 0.5)"
                }
            ]
        },
        options: {
            legend: false,
            scale: {
                ticks: {
                    beginAtZero: true
                }
            }
        }
    });

    //line chart
    var ctx = document.getElementById("lineChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
                {
                    label: "My First dataset",
                    borderColor: "rgba(0,0,0,.2)",
                    borderWidth: "2",
                    backgroundColor: "rgba(0,0,0,.07)",
                    data: [22, 44, 67, 43, 76, 45, 12]
                },
                {
                    label: "My Second dataset",
                    borderColor: "#37a000",
                    borderWidth: "2",
                    backgroundColor: "rgba(55, 160, 0, 0.1)",
                    pointHighlightStroke: "rgba(26,179,148,1)",
                    data: [16, 32, 18, 26, 42, 33, 44]
                }
            ]
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
    });

    //pie chart
    var ctx = document.getElementById("pieChart");
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
                    data: [45, 25, 20, 10],
                    backgroundColor: [
                        "#37a000",
                        "#43bb04",
                        "#49cc05",
                        "rgba(0, 0, 0, 0.07)"
                    ],
                    hoverBackgroundColor: [
                        "#37a000",
                        "#43bb04",
                        "#49cc05",
                        "rgba(0, 0, 0, 0.07)"
                    ]

                }],
            labels: [
                "green",
                "green",
                "green"
            ]
        },
        options: {
            legend: false,
            responsive: true
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
                        "#e4e4e4"
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
            cutoutPercentage: 80
        }
    });

    //polar chart
    var ctx = document.getElementById("polarChart");
    var myChart = new Chart(ctx, {
        type: 'polarArea',
        data: {
            datasets: [{
                    data: [15, 18, 9, 6, 19],
                    backgroundColor: [
                        "#37a000",
                        "#43bb04",
                        "#49cc05",
                        "rgba(0,0,0,0.2)",
                        "#2e8203"
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
            responsive: true
        }
    });

    // single bar chart
    var ctx = document.getElementById("singelBarChart");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Sun", "Mon", "Tu", "Wed", "Th", "Fri", "Sat"],
            datasets: [
                {
                    label: "My First dataset",
                    data: [40, 55, 75, 81, 56, 55, 40],
                    backgroundColor: "#37a000"
                }
            ]
        },
        options: {
            legend: false,
            responsive: true,
            barRoundness: 1,
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            padding: 10
                        },
                        gridLines: {
                            borderDash: [2],
                            borderDashOffset: [2],
                            drawBorder: false,
                            drawTicks: false
                        }
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
                        }
                    }]
            }
        }
    });
});