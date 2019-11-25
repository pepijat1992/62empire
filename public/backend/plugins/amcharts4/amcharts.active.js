(function ($) {
    "use strict";
    var amCharts = {
        initialize: function () {
            this.combinedBullet();
            this.columnChart();
            this.radiusPieChart();
            this.tagCloud();
            this.zoomableValueAxis();
            this.solidGauge();
            this.liveData();
            this.animationsChart();
        },
        combinedBullet: function () {
            am4core.ready(function () {
                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart = am4core.create("multipleValue", am4charts.XYChart);

                // Add data
                chart.data = [{
                        "date": "2013-01-16",
                        "market1": 71,
                        "market2": 75,
                        "sales1": 5,
                        "sales2": 8
                    }, {
                        "date": "2013-01-17",
                        "market1": 74,
                        "market2": 78,
                        "sales1": 4,
                        "sales2": 6
                    }, {
                        "date": "2013-01-18",
                        "market1": 78,
                        "market2": 88,
                        "sales1": 5,
                        "sales2": 2
                    }, {
                        "date": "2013-01-19",
                        "market1": 85,
                        "market2": 89,
                        "sales1": 8,
                        "sales2": 9
                    }, {
                        "date": "2013-01-20",
                        "market1": 82,
                        "market2": 89,
                        "sales1": 9,
                        "sales2": 6
                    }, {
                        "date": "2013-01-21",
                        "market1": 83,
                        "market2": 85,
                        "sales1": 3,
                        "sales2": 5
                    }, {
                        "date": "2013-01-22",
                        "market1": 88,
                        "market2": 92,
                        "sales1": 5,
                        "sales2": 7
                    }, {
                        "date": "2013-01-23",
                        "market1": 85,
                        "market2": 90,
                        "sales1": 7,
                        "sales2": 6
                    }, {
                        "date": "2013-01-24",
                        "market1": 85,
                        "market2": 91,
                        "sales1": 9,
                        "sales2": 5
                    }, {
                        "date": "2013-01-25",
                        "market1": 80,
                        "market2": 84,
                        "sales1": 5,
                        "sales2": 8
                    }, {
                        "date": "2013-01-26",
                        "market1": 87,
                        "market2": 92,
                        "sales1": 4,
                        "sales2": 8
                    }, {
                        "date": "2013-01-27",
                        "market1": 84,
                        "market2": 87,
                        "sales1": 3,
                        "sales2": 4
                    }, {
                        "date": "2013-01-28",
                        "market1": 83,
                        "market2": 88,
                        "sales1": 5,
                        "sales2": 7
                    }, {
                        "date": "2013-01-29",
                        "market1": 84,
                        "market2": 87,
                        "sales1": 5,
                        "sales2": 8
                    }, {
                        "date": "2013-01-30",
                        "market1": 81,
                        "market2": 85,
                        "sales1": 4,
                        "sales2": 7
                    }];

                // Create axes
                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                //dateAxis.renderer.grid.template.location = 0;
                //dateAxis.renderer.minGridDistance = 30;

                var valueAxis1 = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis1.title.text = "Sales";

                var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis2.title.text = "Market Days";
                valueAxis2.renderer.opposite = true;
                valueAxis2.renderer.grid.template.disabled = true;

                // Create series
                var series1 = chart.series.push(new am4charts.ColumnSeries());
                series1.dataFields.valueY = "sales1";
                series1.dataFields.dateX = "date";
                series1.yAxis = valueAxis1;
                series1.name = "Target Sales";
                series1.tooltipText = "{name}\n[bold font-size: 20]${valueY}M[/]";
                series1.fill = chart.colors.getIndex(0);
                series1.strokeWidth = 0;
                series1.clustered = false;
                series1.columns.template.width = am4core.percent(40);

                var series2 = chart.series.push(new am4charts.ColumnSeries());
                series2.dataFields.valueY = "sales2";
                series2.dataFields.dateX = "date";
                series2.yAxis = valueAxis1;
                series2.name = "Actual Sales";
                series2.tooltipText = "{name}\n[bold font-size: 20]${valueY}M[/]";
                series2.fill = chart.colors.getIndex(0).lighten(0.5);
                series2.strokeWidth = 0;
                series2.clustered = false;
                series2.toBack();

                var series3 = chart.series.push(new am4charts.LineSeries());
                series3.dataFields.valueY = "market1";
                series3.dataFields.dateX = "date";
                series3.name = "Market Days";
                series3.strokeWidth = 2;
                series3.tensionX = 0.7;
                series3.yAxis = valueAxis2;
                series3.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";

                var bullet3 = series3.bullets.push(new am4charts.CircleBullet());
                bullet3.circle.radius = 3;
                bullet3.circle.strokeWidth = 2;
                bullet3.circle.fill = am4core.color("#fff");

                var series4 = chart.series.push(new am4charts.LineSeries());
                series4.dataFields.valueY = "market2";
                series4.dataFields.dateX = "date";
                series4.name = "Market Days ALL";
                series4.strokeWidth = 2;
                series4.tensionX = 0.7;
                series4.yAxis = valueAxis2;
                series4.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series4.stroke = chart.colors.getIndex(0).lighten(0.5);
                series4.strokeDasharray = "3,3";

                var bullet4 = series4.bullets.push(new am4charts.CircleBullet());
                bullet4.circle.radius = 3;
                bullet4.circle.strokeWidth = 2;
                bullet4.circle.fill = am4core.color("#fff");

                // Add cursor
                chart.cursor = new am4charts.XYCursor();

                // Add legend
                chart.legend = new am4charts.Legend();
                chart.legend.position = "top";

                // Add scrollbar
                chart.scrollbarX = new am4charts.XYChartScrollbar();
                chart.scrollbarX.series.push(series1);
                chart.scrollbarX.series.push(series3);
                chart.scrollbarX.parent = chart.bottomAxesContainer;

            }); // end am4core.ready()

        },
        columnChart: function () {
            am4core.ready(function () {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart = am4core.create("columnChart", am4charts.XYChart);

                // Add data
                chart.data = [{
                        "name": "John",
                        "points": 35654,
                        "color": chart.colors.next(),
                        "bullet": "https://www.amcharts.com/lib/images/faces/A04.png"
                    }, {
                        "name": "Damon",
                        "points": 65456,
                        "color": chart.colors.next(),
                        "bullet": "https://www.amcharts.com/lib/images/faces/C02.png"
                    }, {
                        "name": "Patrick",
                        "points": 45724,
                        "color": chart.colors.next(),
                        "bullet": "https://www.amcharts.com/lib/images/faces/D02.png"
                    }, {
                        "name": "Mark",
                        "points": 13654,
                        "color": chart.colors.next(),
                        "bullet": "https://www.amcharts.com/lib/images/faces/E01.png"
                    }];

                // Create axes
                var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "name";
                categoryAxis.renderer.grid.template.disabled = true;
                categoryAxis.renderer.minGridDistance = 30;
                categoryAxis.renderer.inside = true;
                categoryAxis.renderer.labels.template.fill = am4core.color("#fff");
                categoryAxis.renderer.labels.template.fontSize = 20;

                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis.renderer.grid.template.strokeDasharray = "4,4";
                valueAxis.renderer.labels.template.disabled = true;
                valueAxis.min = 0;

                // Do not crop bullets
                chart.maskBullets = false;

                // Remove padding
                chart.paddingBottom = 0;

                // Create series
                var series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueY = "points";
                series.dataFields.categoryX = "name";
                series.columns.template.propertyFields.fill = "color";
                series.columns.template.propertyFields.stroke = "color";
                series.columns.template.column.cornerRadiusTopLeft = 15;
                series.columns.template.column.cornerRadiusTopRight = 15;
                series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/b]";

                // Add bullets
                var bullet = series.bullets.push(new am4charts.Bullet());
                var image = bullet.createChild(am4core.Image);
                image.horizontalCenter = "middle";
                image.verticalCenter = "bottom";
                image.dy = 20;
                image.y = am4core.percent(100);
                image.propertyFields.href = "bullet";
                image.tooltipText = series.columns.template.tooltipText;
                image.propertyFields.fill = "color";
                image.filters.push(new am4core.DropShadowFilter());

            }); // end am4core.ready()
        },
        radiusPieChart: function () {
            am4core.ready(function () {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart
                var chart = am4core.create("radiusPieChart", am4charts.PieChart);
                chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

                chart.data = [
                    {
                        country: "Lithuania",
                        value: 260
                    },
                    {
                        country: "Czech Republic",
                        value: 230
                    },
                    {
                        country: "Ireland",
                        value: 200
                    },
                    {
                        country: "Germany",
                        value: 165
                    },
                    {
                        country: "Australia",
                        value: 139
                    },
                    {
                        country: "Austria",
                        value: 128
                    }
                ];

                var series = chart.series.push(new am4charts.PieSeries());
                series.dataFields.value = "value";
                series.dataFields.radiusValue = "value";
                series.dataFields.category = "country";
                series.slices.template.cornerRadius = 6;
                series.colors.step = 3;

                series.hiddenState.properties.endAngle = -90;

                chart.legend = new am4charts.Legend();

            }); // end am4core.ready()
        },
        tagCloud: function () {
            am4core.ready(function () {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                var chart = am4core.create("tagCloud", am4plugins_wordCloud.WordCloud);
                chart.fontFamily = "Courier New";
                var series = chart.series.push(new am4plugins_wordCloud.WordCloudSeries());
                series.randomness = 0.1;
                series.rotationThreshold = 0.5;

                series.data = [{
                        "tag": "javascript",
                        "count": "1765836"
                    }, {
                        "tag": "java",
                        "count": "1517355"
                    }, {
                        "tag": "c#",
                        "count": "1287629"
                    }, {
                        "tag": "php",
                        "count": "1263946"
                    }, {
                        "tag": "android",
                        "count": "1174721"
                    }, {
                        "tag": "python",
                        "count": "1116769"
                    }, {
                        "tag": "jquery",
                        "count": "944983"
                    }, {
                        "tag": "html",
                        "count": "805679"
                    }, {
                        "tag": "c++",
                        "count": "606051"
                    }, {
                        "tag": "ios",
                        "count": "591410"
                    }, {
                        "tag": "css",
                        "count": "574684"
                    }, {
                        "tag": "mysql",
                        "count": "550916"
                    }, {
                        "tag": "sql",
                        "count": "479892"
                    }, {
                        "tag": "asp.net",
                        "count": "343092"
                    }, {
                        "tag": "ruby-on-rails",
                        "count": "303311"
                    }, {
                        "tag": "c",
                        "count": "296963"
                    }, {
                        "tag": "arrays",
                        "count": "288445"
                    }, {
                        "tag": "objective-c",
                        "count": "286823"
                    }, {
                        "tag": ".net",
                        "count": "280079"
                    }, {
                        "tag": "r",
                        "count": "277144"
                    }, {
                        "tag": "node.js",
                        "count": "263451"
                    }, {
                        "tag": "angularjs",
                        "count": "257159"
                    }, {
                        "tag": "json",
                        "count": "255661"
                    }, {
                        "tag": "sql-server",
                        "count": "253824"
                    }, {
                        "tag": "swift",
                        "count": "222387"
                    }, {
                        "tag": "iphone",
                        "count": "219827"
                    }, {
                        "tag": "regex",
                        "count": "203121"
                    }, {
                        "tag": "ruby",
                        "count": "202547"
                    }, {
                        "tag": "ajax",
                        "count": "196727"
                    }, {
                        "tag": "django",
                        "count": "191174"
                    }, {
                        "tag": "excel",
                        "count": "188787"
                    }, {
                        "tag": "xml",
                        "count": "180742"
                    }, {
                        "tag": "asp.net-mvc",
                        "count": "178291"
                    }, {
                        "tag": "linux",
                        "count": "173278"
                    }, {
                        "tag": "angular",
                        "count": "154447"
                    }, {
                        "tag": "database",
                        "count": "153581"
                    }, {
                        "tag": "wpf",
                        "count": "147538"
                    }, {
                        "tag": "spring",
                        "count": "147456"
                    }, {
                        "tag": "wordpress",
                        "count": "145801"
                    }, {
                        "tag": "python-3.x",
                        "count": "145685"
                    }, {
                        "tag": "vba",
                        "count": "139940"
                    }, {
                        "tag": "string",
                        "count": "136649"
                    }, {
                        "tag": "xcode",
                        "count": "130591"
                    }, {
                        "tag": "windows",
                        "count": "127680"
                    }, {
                        "tag": "reactjs",
                        "count": "125021"
                    }, {
                        "tag": "vb.net",
                        "count": "122559"
                    }, {
                        "tag": "html5",
                        "count": "118810"
                    }, {
                        "tag": "eclipse",
                        "count": "115802"
                    }, {
                        "tag": "multithreading",
                        "count": "113719"
                    }, {
                        "tag": "mongodb",
                        "count": "110348"
                    }, {
                        "tag": "laravel",
                        "count": "109340"
                    }, {
                        "tag": "bash",
                        "count": "108797"
                    }, {
                        "tag": "git",
                        "count": "108075"
                    }, {
                        "tag": "oracle",
                        "count": "106936"
                    }, {
                        "tag": "pandas",
                        "count": "96225"
                    }, {
                        "tag": "postgresql",
                        "count": "96027"
                    }, {
                        "tag": "twitter-bootstrap",
                        "count": "94348"
                    }, {
                        "tag": "forms",
                        "count": "92995"
                    }, {
                        "tag": "image",
                        "count": "92131"
                    }, {
                        "tag": "macos",
                        "count": "90327"
                    }, {
                        "tag": "algorithm",
                        "count": "89670"
                    }, {
                        "tag": "python-2.7",
                        "count": "88762"
                    }, {
                        "tag": "scala",
                        "count": "86971"
                    }, {
                        "tag": "visual-studio",
                        "count": "85825"
                    }, {
                        "tag": "list",
                        "count": "84392"
                    }, {
                        "tag": "excel-vba",
                        "count": "83948"
                    }, {
                        "tag": "winforms",
                        "count": "83600"
                    }, {
                        "tag": "apache",
                        "count": "83367"
                    }, {
                        "tag": "facebook",
                        "count": "83212"
                    }, {
                        "tag": "matlab",
                        "count": "82452"
                    }, {
                        "tag": "performance",
                        "count": "81443"
                    }, {
                        "tag": "css3",
                        "count": "78250"
                    }, {
                        "tag": "entity-framework",
                        "count": "78243"
                    }, {
                        "tag": "hibernate",
                        "count": "76123"
                    }, {
                        "tag": "typescript",
                        "count": "74867"
                    }, {
                        "tag": "linq",
                        "count": "73128"
                    }, {
                        "tag": "swing",
                        "count": "72333"
                    }, {
                        "tag": "function",
                        "count": "72043"
                    }, {
                        "tag": "amazon-web-services",
                        "count": "71155"
                    }, {
                        "tag": "qt",
                        "count": "69552"
                    }, {
                        "tag": "rest",
                        "count": "69138"
                    }, {
                        "tag": "shell",
                        "count": "68854"
                    }, {
                        "tag": "azure",
                        "count": "67431"
                    }, {
                        "tag": "firebase",
                        "count": "66411"
                    }, {
                        "tag": "api",
                        "count": "66158"
                    }, {
                        "tag": "maven",
                        "count": "66113"
                    }, {
                        "tag": "powershell",
                        "count": "65467"
                    }, {
                        "tag": ".htaccess",
                        "count": "65014"
                    }, {
                        "tag": "sqlite",
                        "count": "64888"
                    }, {
                        "tag": "file",
                        "count": "62783"
                    }, {
                        "tag": "codeigniter",
                        "count": "62393"
                    }, {
                        "tag": "unit-testing",
                        "count": "61909"
                    }, {
                        "tag": "perl",
                        "count": "61752"
                    }, {
                        "tag": "loops",
                        "count": "61015"
                    }, {
                        "tag": "symfony",
                        "count": "60820"
                    }, {
                        "tag": "selenium",
                        "count": "59855"
                    }, {
                        "tag": "google-maps",
                        "count": "59616"
                    }, {
                        "tag": "csv",
                        "count": "59600"
                    }, {
                        "tag": "uitableview",
                        "count": "59011"
                    }, {
                        "tag": "web-services",
                        "count": "58916"
                    }, {
                        "tag": "cordova",
                        "count": "58195"
                    }, {
                        "tag": "class",
                        "count": "58055"
                    }, {
                        "tag": "numpy",
                        "count": "57132"
                    }, {
                        "tag": "google-chrome",
                        "count": "56836"
                    }, {
                        "tag": "ruby-on-rails-3",
                        "count": "55962"
                    }, {
                        "tag": "android-studio",
                        "count": "55801"
                    }, {
                        "tag": "tsql",
                        "count": "55736"
                    }, {
                        "tag": "validation",
                        "count": "55531"
                    }];

                series.dataFields.word = "tag";
                series.dataFields.value = "count";

                series.heatRules.push({
                    "target": series.labels.template,
                    "property": "fill",
                    "min": am4core.color("#0000CC"),
                    "max": am4core.color("#CC00CC"),
                    "dataField": "value"
                });

                series.labels.template.url = "https://stackoverflow.com/questions/tagged/{word}";
                series.labels.template.urlTarget = "_blank";
                series.labels.template.tooltipText = "{word}: {value}";

                var hoverState = series.labels.template.states.create("hover");
                hoverState.properties.fill = am4core.color("#FF0000");

                var subtitle = chart.titles.create();
                subtitle.text = "(click to open)";

                var title = chart.titles.create();
                title.text = "Most Popular Tags @ StackOverflow";
                title.fontSize = 20;
                title.fontWeight = "800";

            }); // end am4core.ready()
        },
        zoomableValueAxis: function () {
            am4core.ready(function () {

// Themes begin
                am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
                var chart = am4core.create("zoomableValueAxis", am4charts.XYChart);

// Add data
                chart.data = [{
                        "date": "2012-07-27",
                        "value": 13
                    }, {
                        "date": "2012-07-28",
                        "value": 11
                    }, {
                        "date": "2012-07-29",
                        "value": 15
                    }, {
                        "date": "2012-07-30",
                        "value": 16
                    }, {
                        "date": "2012-07-31",
                        "value": 18
                    }, {
                        "date": "2012-08-01",
                        "value": 13
                    }, {
                        "date": "2012-08-02",
                        "value": 22
                    }, {
                        "date": "2012-08-03",
                        "value": 23
                    }, {
                        "date": "2012-08-04",
                        "value": 20
                    }, {
                        "date": "2012-08-05",
                        "value": 17
                    }, {
                        "date": "2012-08-06",
                        "value": 16
                    }, {
                        "date": "2012-08-07",
                        "value": 18
                    }, {
                        "date": "2012-08-08",
                        "value": 21
                    }, {
                        "date": "2012-08-09",
                        "value": 26
                    }, {
                        "date": "2012-08-10",
                        "value": 24
                    }, {
                        "date": "2012-08-11",
                        "value": 29
                    }, {
                        "date": "2012-08-12",
                        "value": 32
                    }, {
                        "date": "2012-08-13",
                        "value": 18
                    }, {
                        "date": "2012-08-14",
                        "value": 24
                    }, {
                        "date": "2012-08-15",
                        "value": 22
                    }, {
                        "date": "2012-08-16",
                        "value": 18
                    }, {
                        "date": "2012-08-17",
                        "value": 19
                    }, {
                        "date": "2012-08-18",
                        "value": 14
                    }, {
                        "date": "2012-08-19",
                        "value": 15
                    }, {
                        "date": "2012-08-20",
                        "value": 12
                    }, {
                        "date": "2012-08-21",
                        "value": 8
                    }, {
                        "date": "2012-08-22",
                        "value": 9
                    }, {
                        "date": "2012-08-23",
                        "value": 8
                    }, {
                        "date": "2012-08-24",
                        "value": 7
                    }, {
                        "date": "2012-08-25",
                        "value": 5
                    }, {
                        "date": "2012-08-26",
                        "value": 11
                    }, {
                        "date": "2012-08-27",
                        "value": 13
                    }, {
                        "date": "2012-08-28",
                        "value": 18
                    }, {
                        "date": "2012-08-29",
                        "value": 20
                    }, {
                        "date": "2012-08-30",
                        "value": 29
                    }, {
                        "date": "2012-08-31",
                        "value": 33
                    }, {
                        "date": "2012-09-01",
                        "value": 42
                    }, {
                        "date": "2012-09-02",
                        "value": 35
                    }, {
                        "date": "2012-09-03",
                        "value": 31
                    }, {
                        "date": "2012-09-04",
                        "value": 47
                    }, {
                        "date": "2012-09-05",
                        "value": 52
                    }, {
                        "date": "2012-09-06",
                        "value": 46
                    }, {
                        "date": "2012-09-07",
                        "value": 41
                    }, {
                        "date": "2012-09-08",
                        "value": 43
                    }, {
                        "date": "2012-09-09",
                        "value": 40
                    }, {
                        "date": "2012-09-10",
                        "value": 39
                    }, {
                        "date": "2012-09-11",
                        "value": 34
                    }, {
                        "date": "2012-09-12",
                        "value": 29
                    }, {
                        "date": "2012-09-13",
                        "value": 34
                    }, {
                        "date": "2012-09-14",
                        "value": 37
                    }, {
                        "date": "2012-09-15",
                        "value": 42
                    }, {
                        "date": "2012-09-16",
                        "value": 49
                    }, {
                        "date": "2012-09-17",
                        "value": 46
                    }, {
                        "date": "2012-09-18",
                        "value": 47
                    }, {
                        "date": "2012-09-19",
                        "value": 55
                    }, {
                        "date": "2012-09-20",
                        "value": 59
                    }, {
                        "date": "2012-09-21",
                        "value": 58
                    }, {
                        "date": "2012-09-22",
                        "value": 57
                    }, {
                        "date": "2012-09-23",
                        "value": 61
                    }, {
                        "date": "2012-09-24",
                        "value": 59
                    }, {
                        "date": "2012-09-25",
                        "value": 67
                    }, {
                        "date": "2012-09-26",
                        "value": 65
                    }, {
                        "date": "2012-09-27",
                        "value": 61
                    }, {
                        "date": "2012-09-28",
                        "value": 66
                    }, {
                        "date": "2012-09-29",
                        "value": 69
                    }, {
                        "date": "2012-09-30",
                        "value": 71
                    }, {
                        "date": "2012-10-01",
                        "value": 67
                    }, {
                        "date": "2012-10-02",
                        "value": 63
                    }, {
                        "date": "2012-10-03",
                        "value": 46
                    }, {
                        "date": "2012-10-04",
                        "value": 32
                    }, {
                        "date": "2012-10-05",
                        "value": 21
                    }, {
                        "date": "2012-10-06",
                        "value": 18
                    }, {
                        "date": "2012-10-07",
                        "value": 21
                    }, {
                        "date": "2012-10-08",
                        "value": 28
                    }, {
                        "date": "2012-10-09",
                        "value": 27
                    }, {
                        "date": "2012-10-10",
                        "value": 36
                    }, {
                        "date": "2012-10-11",
                        "value": 33
                    }, {
                        "date": "2012-10-12",
                        "value": 31
                    }, {
                        "date": "2012-10-13",
                        "value": 30
                    }, {
                        "date": "2012-10-14",
                        "value": 34
                    }, {
                        "date": "2012-10-15",
                        "value": 38
                    }, {
                        "date": "2012-10-16",
                        "value": 37
                    }, {
                        "date": "2012-10-17",
                        "value": 44
                    }, {
                        "date": "2012-10-18",
                        "value": 49
                    }, {
                        "date": "2012-10-19",
                        "value": 53
                    }, {
                        "date": "2012-10-20",
                        "value": 57
                    }, {
                        "date": "2012-10-21",
                        "value": 60
                    }, {
                        "date": "2012-10-22",
                        "value": 61
                    }, {
                        "date": "2012-10-23",
                        "value": 69
                    }, {
                        "date": "2012-10-24",
                        "value": 67
                    }, {
                        "date": "2012-10-25",
                        "value": 72
                    }, {
                        "date": "2012-10-26",
                        "value": 77
                    }, {
                        "date": "2012-10-27",
                        "value": 75
                    }, {
                        "date": "2012-10-28",
                        "value": 70
                    }, {
                        "date": "2012-10-29",
                        "value": 72
                    }, {
                        "date": "2012-10-30",
                        "value": 70
                    }, {
                        "date": "2012-10-31",
                        "value": 72
                    }, {
                        "date": "2012-11-01",
                        "value": 73
                    }, {
                        "date": "2012-11-02",
                        "value": 67
                    }, {
                        "date": "2012-11-03",
                        "value": 68
                    }, {
                        "date": "2012-11-04",
                        "value": 65
                    }, {
                        "date": "2012-11-05",
                        "value": 71
                    }, {
                        "date": "2012-11-06",
                        "value": 75
                    }, {
                        "date": "2012-11-07",
                        "value": 74
                    }, {
                        "date": "2012-11-08",
                        "value": 71
                    }, {
                        "date": "2012-11-09",
                        "value": 76
                    }, {
                        "date": "2012-11-10",
                        "value": 77
                    }, {
                        "date": "2012-11-11",
                        "value": 81
                    }, {
                        "date": "2012-11-12",
                        "value": 83
                    }, {
                        "date": "2012-11-13",
                        "value": 80
                    }, {
                        "date": "2012-11-14",
                        "value": 81
                    }, {
                        "date": "2012-11-15",
                        "value": 87
                    }, {
                        "date": "2012-11-16",
                        "value": 82
                    }, {
                        "date": "2012-11-17",
                        "value": 86
                    }, {
                        "date": "2012-11-18",
                        "value": 80
                    }, {
                        "date": "2012-11-19",
                        "value": 87
                    }, {
                        "date": "2012-11-20",
                        "value": 83
                    }, {
                        "date": "2012-11-21",
                        "value": 85
                    }, {
                        "date": "2012-11-22",
                        "value": 84
                    }, {
                        "date": "2012-11-23",
                        "value": 82
                    }, {
                        "date": "2012-11-24",
                        "value": 73
                    }, {
                        "date": "2012-11-25",
                        "value": 71
                    }, {
                        "date": "2012-11-26",
                        "value": 75
                    }, {
                        "date": "2012-11-27",
                        "value": 79
                    }, {
                        "date": "2012-11-28",
                        "value": 70
                    }, {
                        "date": "2012-11-29",
                        "value": 73
                    }, {
                        "date": "2012-11-30",
                        "value": 61
                    }, {
                        "date": "2012-12-01",
                        "value": 62
                    }, {
                        "date": "2012-12-02",
                        "value": 66
                    }, {
                        "date": "2012-12-03",
                        "value": 65
                    }, {
                        "date": "2012-12-04",
                        "value": 73
                    }, {
                        "date": "2012-12-05",
                        "value": 79
                    }, {
                        "date": "2012-12-06",
                        "value": 78
                    }, {
                        "date": "2012-12-07",
                        "value": 78
                    }, {
                        "date": "2012-12-08",
                        "value": 78
                    }, {
                        "date": "2012-12-09",
                        "value": 74
                    }, {
                        "date": "2012-12-10",
                        "value": 73
                    }, {
                        "date": "2012-12-11",
                        "value": 75
                    }, {
                        "date": "2012-12-12",
                        "value": 70
                    }, {
                        "date": "2012-12-13",
                        "value": 77
                    }, {
                        "date": "2012-12-14",
                        "value": 67
                    }, {
                        "date": "2012-12-15",
                        "value": 62
                    }, {
                        "date": "2012-12-16",
                        "value": 64
                    }, {
                        "date": "2012-12-17",
                        "value": 61
                    }, {
                        "date": "2012-12-18",
                        "value": 59
                    }, {
                        "date": "2012-12-19",
                        "value": 53
                    }, {
                        "date": "2012-12-20",
                        "value": 54
                    }, {
                        "date": "2012-12-21",
                        "value": 56
                    }, {
                        "date": "2012-12-22",
                        "value": 59
                    }, {
                        "date": "2012-12-23",
                        "value": 58
                    }, {
                        "date": "2012-12-24",
                        "value": 55
                    }, {
                        "date": "2012-12-25",
                        "value": 52
                    }, {
                        "date": "2012-12-26",
                        "value": 54
                    }, {
                        "date": "2012-12-27",
                        "value": 50
                    }, {
                        "date": "2012-12-28",
                        "value": 50
                    }, {
                        "date": "2012-12-29",
                        "value": 51
                    }, {
                        "date": "2012-12-30",
                        "value": 52
                    }, {
                        "date": "2012-12-31",
                        "value": 58
                    }, {
                        "date": "2013-01-01",
                        "value": 60
                    }, {
                        "date": "2013-01-02",
                        "value": 67
                    }, {
                        "date": "2013-01-03",
                        "value": 64
                    }, {
                        "date": "2013-01-04",
                        "value": 66
                    }, {
                        "date": "2013-01-05",
                        "value": 60
                    }, {
                        "date": "2013-01-06",
                        "value": 63
                    }, {
                        "date": "2013-01-07",
                        "value": 61
                    }, {
                        "date": "2013-01-08",
                        "value": 60
                    }, {
                        "date": "2013-01-09",
                        "value": 65
                    }, {
                        "date": "2013-01-10",
                        "value": 75
                    }, {
                        "date": "2013-01-11",
                        "value": 77
                    }, {
                        "date": "2013-01-12",
                        "value": 78
                    }, {
                        "date": "2013-01-13",
                        "value": 70
                    }, {
                        "date": "2013-01-14",
                        "value": 70
                    }, {
                        "date": "2013-01-15",
                        "value": 73
                    }, {
                        "date": "2013-01-16",
                        "value": 71
                    }, {
                        "date": "2013-01-17",
                        "value": 74
                    }, {
                        "date": "2013-01-18",
                        "value": 78
                    }, {
                        "date": "2013-01-19",
                        "value": 85
                    }, {
                        "date": "2013-01-20",
                        "value": 82
                    }, {
                        "date": "2013-01-21",
                        "value": 83
                    }, {
                        "date": "2013-01-22",
                        "value": 88
                    }, {
                        "date": "2013-01-23",
                        "value": 85
                    }, {
                        "date": "2013-01-24",
                        "value": 85
                    }, {
                        "date": "2013-01-25",
                        "value": 80
                    }, {
                        "date": "2013-01-26",
                        "value": 87
                    }, {
                        "date": "2013-01-27",
                        "value": 84
                    }, {
                        "date": "2013-01-28",
                        "value": 83
                    }, {
                        "date": "2013-01-29",
                        "value": 84
                    }, {
                        "date": "2013-01-30",
                        "value": 81
                    }];

// Create axes
                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                dateAxis.renderer.grid.template.location = 0;
                dateAxis.renderer.minGridDistance = 50;

                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
                var series = chart.series.push(new am4charts.LineSeries());
                series.dataFields.valueY = "value";
                series.dataFields.dateX = "date";
                series.strokeWidth = 3;
                series.fillOpacity = 0.5;

// Add vertical scrollbar
                chart.scrollbarY = new am4core.Scrollbar();
                chart.scrollbarY.marginLeft = 0;

// Add cursor
                chart.cursor = new am4charts.XYCursor();
                chart.cursor.behavior = "zoomY";
                chart.cursor.lineX.disabled = true;

            }); // end am4core.ready()
        },
        solidGauge: function () {
            am4core.ready(function () {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end



                // Create chart instance
                var chart = am4core.create("solidGauge", am4charts.RadarChart);

                // Add data
                chart.data = [{
                        "category": "Research",
                        "value": 80,
                        "full": 100
                    }, {
                        "category": "Marketing",
                        "value": 35,
                        "full": 100
                    }, {
                        "category": "Distribution",
                        "value": 92,
                        "full": 100
                    }, {
                        "category": "Human Resources",
                        "value": 68,
                        "full": 100
                    }];

                // Make chart not full circle
                chart.startAngle = -90;
                chart.endAngle = 180;
                chart.innerRadius = am4core.percent(20);

                // Set number format
                chart.numberFormatter.numberFormat = "#.#'%'";

                // Create axes
                var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "category";
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.renderer.grid.template.strokeOpacity = 0;
                categoryAxis.renderer.labels.template.horizontalCenter = "right";
                categoryAxis.renderer.labels.template.fontWeight = 500;
                categoryAxis.renderer.labels.template.adapter.add("fill", function (fill, target) {
                    return (target.dataItem.index >= 0) ? chart.colors.getIndex(target.dataItem.index) : fill;
                });
                categoryAxis.renderer.minGridDistance = 10;

                var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
                valueAxis.renderer.grid.template.strokeOpacity = 0;
                valueAxis.min = 0;
                valueAxis.max = 100;
                valueAxis.strictMinMax = true;

                // Create series
                var series1 = chart.series.push(new am4charts.RadarColumnSeries());
                series1.dataFields.valueX = "full";
                series1.dataFields.categoryY = "category";
                series1.clustered = false;
                series1.columns.template.fill = new am4core.InterfaceColorSet().getFor("alternativeBackground");
                series1.columns.template.fillOpacity = 0.08;
                series1.columns.template.cornerRadiusTopLeft = 20;
                series1.columns.template.strokeWidth = 0;
                series1.columns.template.radarColumn.cornerRadius = 20;

                var series2 = chart.series.push(new am4charts.RadarColumnSeries());
                series2.dataFields.valueX = "value";
                series2.dataFields.categoryY = "category";
                series2.clustered = false;
                series2.columns.template.strokeWidth = 0;
                series2.columns.template.tooltipText = "{category}: [bold]{value}[/]";
                series2.columns.template.radarColumn.cornerRadius = 20;

                series2.columns.template.adapter.add("fill", function (fill, target) {
                    return chart.colors.getIndex(target.dataItem.index);
                });

                // Add cursor
                chart.cursor = new am4charts.RadarCursor();

            }); // end am4core.ready()
        },
        liveData: function () {

// Themes begin
            am4core.useTheme(am4themes_animated);
// Themes end

            var chart = am4core.create("liveData", am4charts.XYChart);
            chart.hiddenState.properties.opacity = 0;

            chart.padding(0, 0, 0, 0);

            chart.zoomOutButton.disabled = true;

            var data = [];
            var visits = 10;
            var i = 0;

            for (i = 0; i <= 30; i++) {
                visits -= Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);
                data.push({date: new Date().setSeconds(i - 30), value: visits});
            }

            chart.data = data;

            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.grid.template.location = 0;
            dateAxis.renderer.minGridDistance = 30;
            dateAxis.dateFormats.setKey("second", "ss");
            dateAxis.periodChangeDateFormats.setKey("second", "[bold]h:mm a");
            dateAxis.periodChangeDateFormats.setKey("minute", "[bold]h:mm a");
            dateAxis.periodChangeDateFormats.setKey("hour", "[bold]h:mm a");
            dateAxis.renderer.inside = true;
            dateAxis.renderer.axisFills.template.disabled = true;
            dateAxis.renderer.ticks.template.disabled = true;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.interpolationDuration = 500;
            valueAxis.rangeChangeDuration = 500;
            valueAxis.renderer.inside = true;
            valueAxis.renderer.minLabelPosition = 0.05;
            valueAxis.renderer.maxLabelPosition = 0.95;
            valueAxis.renderer.axisFills.template.disabled = true;
            valueAxis.renderer.ticks.template.disabled = true;

            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.dateX = "date";
            series.dataFields.valueY = "value";
            series.interpolationDuration = 500;
            series.defaultState.transitionDuration = 0;
            series.tensionX = 0.8;

            chart.events.on("datavalidated", function () {
                dateAxis.zoom({start: 1 / 15, end: 1.2}, false, true);
            });

            dateAxis.interpolationDuration = 500;
            dateAxis.rangeChangeDuration = 500;

            document.addEventListener("visibilitychange", function () {
                if (document.hidden) {
                    if (interval) {
                        clearInterval(interval);
                    }
                } else {
                    startInterval();
                }
            }, false);

// add data
            var interval;
            function startInterval() {
                interval = setInterval(function () {
                    visits =
                            visits + Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 5);
                    var lastdataItem = series.dataItems.getIndex(series.dataItems.length - 1);
                    chart.addData(
                            {date: new Date(lastdataItem.dateX.getTime() + 1000), value: visits},
                            1
                            );
                }, 1000);
            }

            startInterval();

// all the below is optional, makes some fancy effects
// gradient fill of the series
            series.fillOpacity = 1;
            var gradient = new am4core.LinearGradient();
            gradient.addColor(chart.colors.getIndex(0), 0.2);
            gradient.addColor(chart.colors.getIndex(0), 0);
            series.fill = gradient;

// this makes date axis labels to fade out
            dateAxis.renderer.labels.template.adapter.add("fillOpacity", function (fillOpacity, target) {
                var dataItem = target.dataItem;
                return dataItem.position;
            })

// need to set this, otherwise fillOpacity is not changed and not set
            dateAxis.events.on("validated", function () {
                am4core.iter.each(dateAxis.renderer.labels.iterator(), function (label) {
                    label.fillOpacity = label.fillOpacity;
                })
            })

// this makes date axis labels which are at equal minutes to be rotated
            dateAxis.renderer.labels.template.adapter.add("rotation", function (rotation, target) {
                var dataItem = target.dataItem;
                if (dataItem.date && dataItem.date.getTime() == am4core.time.round(new Date(dataItem.date.getTime()), "minute").getTime()) {
                    target.verticalCenter = "middle";
                    target.horizontalCenter = "left";
                    return -90;
                } else {
                    target.verticalCenter = "bottom";
                    target.horizontalCenter = "middle";
                    return 0;
                }
            })

// bullet at the front of the line
            var bullet = series.createChild(am4charts.CircleBullet);
            bullet.circle.radius = 5;
            bullet.fillOpacity = 1;
            bullet.fill = chart.colors.getIndex(0);
            bullet.isMeasured = false;

            series.events.on("validated", function () {
                bullet.moveTo(series.dataItems.last.point);
                bullet.validatePosition();
            });
        },
        animationsChart: function () {
            am4core.ready(function () {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                am4core.options.autoSetClassName = true;

                // Create chart instance
                var chart = am4core.create("animationsChart", am4charts.XYChart);

                chart.colors.step = 2;
                chart.maskBullets = false;

                // Add data
                chart.data = [{
                        "date": "2012-01-01",
                        "distance": 227,
                        "townName": "New York",
                        "townName2": "New York",
                        "townSize": 12,
                        "latitude": 40.71,
                        "duration": 408
                    }, {
                        "date": "2012-01-02",
                        "distance": 371,
                        "townName": "Washington",
                        "townSize": 7,
                        "latitude": 38.89,
                        "duration": 482
                    }, {
                        "date": "2012-01-03",
                        "distance": 433,
                        "townName": "Wilmington",
                        "townSize": 3,
                        "latitude": 34.22,
                        "duration": 562
                    }, {
                        "date": "2012-01-04",
                        "distance": 345,
                        "townName": "Jacksonville",
                        "townSize": 3.5,
                        "latitude": 30.35,
                        "duration": 379
                    }, {
                        "date": "2012-01-05",
                        "distance": 480,
                        "townName": "Miami",
                        "townName2": "Miami",
                        "townSize": 5,
                        "latitude": 25.83,
                        "duration": 501
                    }, {
                        "date": "2012-01-06",
                        "distance": 386,
                        "townName": "Tallahassee",
                        "townSize": 3.5,
                        "latitude": 30.46,
                        "duration": 443
                    }, {
                        "date": "2012-01-07",
                        "distance": 348,
                        "townName": "New Orleans",
                        "townSize": 5,
                        "latitude": 29.94,
                        "duration": 405
                    }, {
                        "date": "2012-01-08",
                        "distance": 238,
                        "townName": "Houston",
                        "townName2": "Houston",
                        "townSize": 8,
                        "latitude": 29.76,
                        "duration": 309
                    }, {
                        "date": "2012-01-09",
                        "distance": 218,
                        "townName": "Dalas",
                        "townSize": 8,
                        "latitude": 32.8,
                        "duration": 287
                    }, {
                        "date": "2012-01-10",
                        "distance": 349,
                        "townName": "Oklahoma City",
                        "townSize": 5,
                        "latitude": 35.49,
                        "duration": 485
                    }, {
                        "date": "2012-01-11",
                        "distance": 603,
                        "townName": "Kansas City",
                        "townSize": 5,
                        "latitude": 39.1,
                        "duration": 890
                    }, {
                        "date": "2012-01-12",
                        "distance": 534,
                        "townName": "Denver",
                        "townName2": "Denver",
                        "townSize": 9,
                        "latitude": 39.74,
                        "duration": 810
                    }, {
                        "date": "2012-01-13",
                        "townName": "Salt Lake City",
                        "townSize": 6,
                        "distance": 425,
                        "duration": 670,
                        "latitude": 40.75,
                        "dashLength": 8,
                        "alpha": 0.4
                    }, {
                        "date": "2012-01-14",
                        "latitude": 36.1,
                        "duration": 470,
                        "townName": "Las Vegas",
                        "townName2": "Las Vegas"
                    }, {
                        "date": "2012-01-15"
                    }, {
                        "date": "2012-01-16"
                    }, {
                        "date": "2012-01-17"
                    }];

                // Create axes
                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                dateAxis.dataFields.category = "category";
                dateAxis.renderer.grid.template.location = 0;
                dateAxis.renderer.minGridDistance = 50;
                dateAxis.renderer.grid.template.disabled = true;
                dateAxis.renderer.fullWidthTooltip = true;

                var distanceAxis = chart.yAxes.push(new am4charts.ValueAxis());
                distanceAxis.title.text = "Distance";
                distanceAxis.renderer.grid.template.disabled = true;

                var durationAxis = chart.yAxes.push(new am4charts.DurationAxis());
                durationAxis.title.text = "Duration";
                durationAxis.baseUnit = "minute";
                durationAxis.renderer.grid.template.disabled = true;
                durationAxis.renderer.opposite = true;

                durationAxis.durationFormatter.durationFormat = "hh'h' mm'min'";

                var latitudeAxis = chart.yAxes.push(new am4charts.ValueAxis());
                latitudeAxis.renderer.grid.template.disabled = true;
                latitudeAxis.renderer.labels.template.disabled = true;

                // Create series
                var distanceSeries = chart.series.push(new am4charts.ColumnSeries());
                distanceSeries.id = "g1";
                distanceSeries.dataFields.valueY = "distance";
                distanceSeries.dataFields.dateX = "date";
                distanceSeries.yAxis = distanceAxis;
                distanceSeries.tooltipText = "{valueY} miles";
                distanceSeries.name = "Distance";
                distanceSeries.columns.template.fillOpacity = 0.7;

                var disatnceState = distanceSeries.columns.template.states.create("hover");
                disatnceState.properties.fillOpacity = 0.9;

                var durationSeries = chart.series.push(new am4charts.LineSeries());
                durationSeries.id = "g3";
                durationSeries.dataFields.valueY = "duration";
                durationSeries.dataFields.dateX = "date";
                durationSeries.yAxis = durationAxis;
                durationSeries.name = "Duration";
                durationSeries.strokeWidth = 2;
                durationSeries.tooltipText = "{valueY.formatDuration()}";

                var durationBullet = durationSeries.bullets.push(new am4charts.Bullet());
                var durationRectangle = durationBullet.createChild(am4core.Rectangle);
                durationBullet.horizontalCenter = "middle";
                durationBullet.verticalCenter = "middle";
                durationBullet.width = 7;
                durationBullet.height = 7;
                durationRectangle.width = 7;
                durationRectangle.height = 7;

                var durationState = durationBullet.states.create("hover");
                durationState.properties.scale = 1.2;

                var latitudeSeries = chart.series.push(new am4charts.LineSeries());
                latitudeSeries.id = "g2";
                latitudeSeries.dataFields.valueY = "latitude";
                latitudeSeries.dataFields.dateX = "date";
                latitudeSeries.yAxis = latitudeAxis;
                latitudeSeries.name = "Duration";
                latitudeSeries.strokeWidth = 2;
                latitudeSeries.tooltipText = "Latitude: {valueY} ({townName})";

                var latitudeBullet = latitudeSeries.bullets.push(new am4charts.CircleBullet());
                latitudeBullet.circle.fill = am4core.color("#fff");
                latitudeBullet.circle.strokeWidth = 2;
                latitudeBullet.circle.propertyFields.radius = "townSize";

                var latitudeState = latitudeBullet.states.create("hover");
                latitudeState.properties.scale = 1.2;

                var latitudeLabel = latitudeSeries.bullets.push(new am4charts.LabelBullet());
                latitudeLabel.label.text = "{townName2}";
                latitudeLabel.label.horizontalCenter = "left";
                latitudeLabel.label.dx = 14;

                // Add legend
                chart.legend = new am4charts.Legend();

                // Add cursor
                chart.cursor = new am4charts.XYCursor();
                chart.cursor.fullWidthLineX = true;
                chart.cursor.xAxis = dateAxis;
                chart.cursor.lineX.strokeOpacity = 0;
                chart.cursor.lineX.fill = am4core.color("#000");
                chart.cursor.lineX.fillOpacity = 0.1;

            }); // end am4core.ready()
        }
    };
    // Initialize
    $(document).ready(function () {
        "use strict"; // Start of use strict
        amCharts.initialize();
    });

}(jQuery));