(function ($) {
    "use strict";
    var amChartsMaps = {
        initialize: function () {
            this.simpleMap();
            this.drillDownMap();
            this.lineGauge();
            this.usHeatMap();
            this.flightRoutesMap();
            this.locationSensitiveMap();
        },
        simpleMap: function () {
            /**
             * This is a demo for MapChart.
             *
             * Refer to the following link(s) for reference:
             * @see {@link https://www.amcharts.com/docs/v4/chart-types/map/}
             */

// Set themes
            am4core.useTheme(am4themes_animated);

// Create the map chart
            var chart = am4core.create("simpleMap", am4maps.MapChart);


// Chech if proper geodata is loaded
            try {
                chart.geodata = am4geodata_worldLow;
            } catch (e) {
                chart.raiseCriticalError(new Error("Map geodata could not be loaded. Please download the latest <a href=\"https://www.amcharts.com/download/download-v4/\">amcharts geodata</a> and extract its contents into the same directory as your amCharts files."));
            }

// Set projection to be used
// @see {@link https://www.amcharts.com/docs/v4/reference/mapchart/#projection_property}
            chart.projection = new am4maps.projections.Miller();

// Create polygon series
            var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
            polygonSeries.useGeodata = true;
            polygonSeries.exclude = ["AQ"]; // Exclude Antractica
            polygonSeries.tooltip.fill = am4core.color("#000000");

            var colorSet = new am4core.ColorSet();

// Configure polygons
            var polygonTemplate = polygonSeries.mapPolygons.template;
            polygonTemplate.tooltipText = "{name}";
            polygonTemplate.togglable = true;

// Set events to apply "active" state to clicked polygons
            var currentActive;
            polygonTemplate.events.on("hit", function (event) {
                // if we have some country selected, set default state to it
                if (currentActive) {
                    currentActive.isActive = false;
                }

                chart.zoomToMapObject(event.target);
                currentActive = event.target;
            })

// Configure states
// @see {@link https://www.amcharts.com/docs/v4/concepts/states/}

// Configure "hover" state
            var hoverState = polygonTemplate.states.create("hover");
            hoverState.properties.fill = colorSet.getIndex(0);

// Configure "active" state
            var activeState = polygonTemplate.states.create("active");
            activeState.properties.fill = colorSet.getIndex(4);

// Create a Small map control
            /*
             var smallMap = new maps.SmallMap();
             chart.smallMap = smallMap;
             
             var smallMapPolygonSeries = smallMap.series.push(new maps.MapPolygonSeries());
             smallMapPolygonSeries.copyFrom(polygonSeries);
             */

// Create a zoom control
            var zoomControl = new am4maps.ZoomControl();
            chart.zoomControl = zoomControl;
            zoomControl.slider.height = 100;
        },
        drillDownMap: function () {
            am4core.ready(function () {

// Themes begin
                am4core.useTheme(am4themes_animated);
// Themes end

// Create map instance
                var chart = am4core.create("drillDownMap", am4maps.MapChart);

// Set projection
                chart.projection = new am4maps.projections.Mercator();

                var restoreContinents = function () {
                    hideCountries();
                    chart.goHome();
                };

// Zoom control
                chart.zoomControl = new am4maps.ZoomControl();

                var homeButton = new am4core.Button();
                homeButton.events.on("hit", restoreContinents);

                homeButton.icon = new am4core.Sprite();
                homeButton.padding(7, 5, 7, 5);
                homeButton.width = 30;
                homeButton.icon.path = "M16,8 L14,8 L14,16 L10,16 L10,10 L6,10 L6,16 L2,16 L2,8 L0,8 L8,0 L16,8 Z M16,8";
                homeButton.marginBottom = 10;
                homeButton.parent = chart.zoomControl;
                homeButton.insertBefore(chart.zoomControl.plusButton);

// Shared
                var hoverColorHex = "#9a7bca";
                var hoverColor = am4core.color(hoverColorHex);
                var hideCountries = function () {
                    countryTemplate.hide();
                    labelContainer.hide();
                };

// Continents 
                var continentsSeries = chart.series.push(new am4maps.MapPolygonSeries());
                continentsSeries.geodata = am4geodata_continentsLow;
                continentsSeries.useGeodata = true;
                continentsSeries.exclude = ["antarctica"];

                var continentTemplate = continentsSeries.mapPolygons.template;
                continentTemplate.tooltipText = "{name}";
                continentTemplate.properties.fillOpacity = 0.8; // Reduce conflict with back to continents map label
                continentTemplate.propertyFields.fill = "color";
                continentTemplate.nonScalingStroke = true;
                continentTemplate.events.on("hit", function (event) {
                    if (!countriesSeries.visible)
                        countriesSeries.visible = true;
                    chart.zoomToMapObject(event.target);
                    countryTemplate.show();
                    labelContainer.show();
                });

                var contintentHover = continentTemplate.states.create("hover");
                contintentHover.properties.fill = hoverColor;
                contintentHover.properties.stroke = hoverColor;

                continentsSeries.dataFields.zoomLevel = "zoomLevel";
                continentsSeries.dataFields.zoomGeoPoint = "zoomGeoPoint";

                continentsSeries.data = [{
                        "id": "africa",
                        "color": chart.colors.getIndex(0)
                    }, {
                        "id": "asia",
                        "color": chart.colors.getIndex(1),
                        "zoomLevel": 2,
                        "zoomGeoPoint": {
                            "latitude": 46,
                            "longitude": 89
                        }
                    }, {
                        "id": "oceania",
                        "color": chart.colors.getIndex(2)
                    }, {
                        "id": "europe",
                        "color": chart.colors.getIndex(3)
                    }, {
                        "id": "northAmerica",
                        "color": chart.colors.getIndex(4)
                    }, {
                        "id": "southAmerica",
                        "color": chart.colors.getIndex(5)
                    }];


// Countries
                var countriesSeries = chart.series.push(new am4maps.MapPolygonSeries());
                var countries = countriesSeries.mapPolygons;
                countriesSeries.visible = false; // start off as hidden
                countriesSeries.exclude = ["AQ"];
                countriesSeries.geodata = am4geodata_worldLow;
                countriesSeries.useGeodata = true;
// Hide each country so we can fade them in
                countriesSeries.events.once("inited", function () {
                    hideCountries();
                });

                var countryTemplate = countries.template;
                countryTemplate.applyOnClones = true;
                countryTemplate.fill = am4core.color("#a791b4");
                countryTemplate.fillOpacity = 0.3; // see continents underneath, however, country shapes are more detailed than continents.
                countryTemplate.strokeOpacity = 0.5;
                countryTemplate.nonScalingStroke = true;
                countryTemplate.tooltipText = "{name}";
                countryTemplate.events.on("hit", function (event) {
                    chart.zoomToMapObject(event.target);
                });

                var countryHover = countryTemplate.states.create("hover");
                countryHover.properties.fill = hoverColor;
                countryHover.properties.fillOpacity = 0.8; // Reduce conflict with back to continents map label
                countryHover.properties.stroke = hoverColor;
                countryHover.properties.strokeOpacity = 1;

                var labelContainer = chart.chartContainer.createChild(am4core.Container);
                labelContainer.hide();
                labelContainer.config = {cursorOverStyle: [
                        {
                            "property": "cursor",
                            "value": "pointer"
                        }
                    ]};
                labelContainer.isMeasured = false;
                labelContainer.layout = "horizontal";
                labelContainer.verticalCenter = "bottom";
                labelContainer.contentValign = "middle";
                labelContainer.y = am4core.percent(100);
                labelContainer.dx = 10;
                labelContainer.dy = -25;
                labelContainer.background.fill = am4core.color("#fff");
                labelContainer.background.fillOpacity = 0; // Hack to ensure entire area of labelContainer, e.g. between icon path, is clickable
                labelContainer.setStateOnChildren = true;
                labelContainer.states.create("hover");
                labelContainer.events.on("hit", restoreContinents);

                var globeIcon = labelContainer.createChild(am4core.Sprite);
                globeIcon.valign = "bottom";
                globeIcon.verticalCenter = "bottom";
                globeIcon.width = 29;
                globeIcon.height = 29;
                globeIcon.marginRight = 7;
                globeIcon.path = "M16,1.466C7.973,1.466,1.466,7.973,1.466,16c0,8.027,6.507,14.534,14.534,14.534c8.027,0,14.534-6.507,14.534-14.534C30.534,7.973,24.027,1.466,16,1.466zM27.436,17.39c0.001,0.002,0.004,0.002,0.005,0.004c-0.022,0.187-0.054,0.37-0.085,0.554c-0.015-0.012-0.034-0.025-0.047-0.036c-0.103-0.09-0.254-0.128-0.318-0.115c-0.157,0.032,0.229,0.305,0.267,0.342c0.009,0.009,0.031,0.03,0.062,0.058c-1.029,5.312-5.709,9.338-11.319,9.338c-4.123,0-7.736-2.18-9.776-5.441c0.123-0.016,0.24-0.016,0.28-0.076c0.051-0.077,0.102-0.241,0.178-0.331c0.077-0.089,0.165-0.229,0.127-0.292c-0.039-0.064,0.101-0.344,0.088-0.419c-0.013-0.076-0.127-0.256,0.064-0.407s0.394-0.382,0.407-0.444c0.012-0.063,0.166-0.331,0.152-0.458c-0.012-0.127-0.152-0.28-0.24-0.318c-0.09-0.037-0.28-0.05-0.356-0.151c-0.077-0.103-0.292-0.203-0.368-0.178c-0.076,0.025-0.204,0.05-0.305-0.015c-0.102-0.062-0.267-0.139-0.33-0.189c-0.065-0.05-0.229-0.088-0.305-0.088c-0.077,0-0.065-0.052-0.178,0.101c-0.114,0.153,0,0.204-0.204,0.177c-0.204-0.023,0.025-0.036,0.141-0.189c0.113-0.152-0.013-0.242-0.141-0.203c-0.126,0.038-0.038,0.115-0.241,0.153c-0.203,0.036-0.203-0.09-0.076-0.115s0.355-0.139,0.355-0.19c0-0.051-0.025-0.191-0.127-0.191s-0.077-0.126-0.229-0.291c-0.092-0.101-0.196-0.164-0.299-0.204c-0.09-0.579-0.15-1.167-0.15-1.771c0-2.844,1.039-5.446,2.751-7.458c0.024-0.02,0.048-0.034,0.069-0.036c0.084-0.009,0.31-0.025,0.51-0.059c0.202-0.034,0.418-0.161,0.489-0.153c0.069,0.008,0.241,0.008,0.186-0.042C8.417,8.2,8.339,8.082,8.223,8.082S8.215,7.896,8.246,7.896c0.03,0,0.186,0.025,0.178,0.11C8.417,8.091,8.471,8.2,8.625,8.167c0.156-0.034,0.132-0.162,0.102-0.195C8.695,7.938,8.672,7.853,8.642,7.794c-0.031-0.06-0.023-0.136,0.14-0.153C8.944,7.625,9.168,7.708,9.16,7.573s0-0.28,0.046-0.356C9.253,7.142,9.354,7.09,9.299,7.065C9.246,7.04,9.176,7.099,9.121,6.972c-0.054-0.127,0.047-0.22,0.108-0.271c0.02-0.015,0.067-0.06,0.124-0.112C11.234,5.257,13.524,4.466,16,4.466c3.213,0,6.122,1.323,8.214,3.45c-0.008,0.022-0.01,0.052-0.031,0.056c-0.077,0.013-0.166,0.063-0.179-0.051c-0.013-0.114-0.013-0.331-0.102-0.203c-0.089,0.127-0.127,0.127-0.127,0.191c0,0.063,0.076,0.127,0.051,0.241C23.8,8.264,23.8,8.341,23.84,8.341c0.036,0,0.126-0.115,0.239-0.141c0.116-0.025,0.319-0.088,0.332,0.026c0.013,0.115,0.139,0.152,0.013,0.203c-0.128,0.051-0.267,0.026-0.293-0.051c-0.025-0.077-0.114-0.077-0.203-0.013c-0.088,0.063-0.279,0.292-0.279,0.292s-0.306,0.139-0.343,0.114c-0.04-0.025,0.101-0.165,0.203-0.228c0.102-0.064,0.178-0.204,0.14-0.242c-0.038-0.038-0.088-0.279-0.063-0.343c0.025-0.063,0.139-0.152,0.013-0.216c-0.127-0.063-0.217-0.14-0.318-0.178s-0.216,0.152-0.305,0.204c-0.089,0.051-0.076,0.114-0.191,0.127c-0.114,0.013-0.189,0.165,0,0.254c0.191,0.089,0.255,0.152,0.204,0.204c-0.051,0.051-0.267-0.025-0.267-0.025s-0.165-0.076-0.268-0.076c-0.101,0-0.229-0.063-0.33-0.076c-0.102-0.013-0.306-0.013-0.355,0.038c-0.051,0.051-0.179,0.203-0.28,0.152c-0.101-0.051-0.101-0.102-0.241-0.051c-0.14,0.051-0.279-0.038-0.355,0.038c-0.077,0.076-0.013,0.076-0.255,0c-0.241-0.076-0.189,0.051-0.419,0.089s-0.368-0.038-0.432,0.038c-0.064,0.077-0.153,0.217-0.19,0.127c-0.038-0.088,0.126-0.241,0.062-0.292c-0.062-0.051-0.33-0.025-0.367,0.013c-0.039,0.038-0.014,0.178,0.011,0.229c0.026,0.05,0.064,0.254-0.011,0.216c-0.077-0.038-0.064-0.166-0.141-0.152c-0.076,0.013-0.165,0.051-0.203,0.077c-0.038,0.025-0.191,0.025-0.229,0.076c-0.037,0.051,0.014,0.191-0.051,0.203c-0.063,0.013-0.114,0.064-0.254-0.025c-0.14-0.089-0.14-0.038-0.178-0.012c-0.038,0.025-0.216,0.127-0.229,0.012c-0.013-0.114,0.025-0.152-0.089-0.229c-0.115-0.076-0.026-0.076,0.127-0.025c0.152,0.05,0.343,0.075,0.622-0.013c0.28-0.089,0.395-0.127,0.28-0.178c-0.115-0.05-0.229-0.101-0.406-0.127c-0.179-0.025-0.42-0.025-0.7-0.127c-0.279-0.102-0.343-0.14-0.457-0.165c-0.115-0.026-0.813-0.14-1.132-0.089c-0.317,0.051-1.193,0.28-1.245,0.318s-0.128,0.19-0.292,0.318c-0.165,0.127-0.47,0.419-0.712,0.47c-0.241,0.051-0.521,0.254-0.521,0.305c0,0.051,0.101,0.242,0.076,0.28c-0.025,0.038,0.05,0.229,0.191,0.28c0.139,0.05,0.381,0.038,0.393-0.039c0.014-0.076,0.204-0.241,0.217-0.127c0.013,0.115,0.14,0.292,0.114,0.368c-0.025,0.077,0,0.153,0.09,0.14c0.088-0.012,0.559-0.114,0.559-0.114s0.153-0.064,0.127-0.166c-0.026-0.101,0.166-0.241,0.203-0.279c0.038-0.038,0.178-0.191,0.014-0.241c-0.167-0.051-0.293-0.064-0.115-0.216s0.292,0,0.521-0.229c0.229-0.229-0.051-0.292,0.191-0.305c0.241-0.013,0.496-0.025,0.444,0.051c-0.05,0.076-0.342,0.242-0.508,0.318c-0.166,0.077-0.14,0.216-0.076,0.292c0.063,0.076,0.09,0.254,0.204,0.229c0.113-0.025,0.254-0.114,0.38-0.101c0.128,0.012,0.383-0.013,0.42-0.013c0.039,0,0.216,0.178,0.114,0.203c-0.101,0.025-0.229,0.013-0.445,0.025c-0.215,0.013-0.456,0.013-0.456,0.051c0,0.039,0.292,0.127,0.19,0.191c-0.102,0.063-0.203-0.013-0.331-0.026c-0.127-0.012-0.203,0.166-0.241,0.267c-0.039,0.102,0.063,0.28-0.127,0.216c-0.191-0.063-0.331-0.063-0.381-0.038c-0.051,0.025-0.203,0.076-0.331,0.114c-0.126,0.038-0.076-0.063-0.242-0.063c-0.164,0-0.164,0-0.164,0l-0.103,0.013c0,0-0.101-0.063-0.114-0.165c-0.013-0.102,0.05-0.216-0.013-0.241c-0.064-0.026-0.292,0.012-0.33,0.088c-0.038,0.076-0.077,0.216-0.026,0.28c0.052,0.063,0.204,0.19,0.064,0.152c-0.14-0.038-0.317-0.051-0.419,0.026c-0.101,0.076-0.279,0.241-0.279,0.241s-0.318,0.025-0.318,0.102c0,0.077,0,0.178-0.114,0.191c-0.115,0.013-0.268,0.05-0.42,0.076c-0.153,0.025-0.139,0.088-0.317,0.102s-0.204,0.089-0.038,0.114c0.165,0.025,0.418,0.127,0.431,0.241c0.014,0.114-0.013,0.242-0.076,0.356c-0.043,0.079-0.305,0.026-0.458,0.026c-0.152,0-0.456-0.051-0.584,0c-0.127,0.051-0.102,0.305-0.064,0.419c0.039,0.114-0.012,0.178-0.063,0.216c-0.051,0.038-0.065,0.152,0,0.204c0.063,0.051,0.114,0.165,0.166,0.178c0.051,0.013,0.215-0.038,0.279,0.025c0.064,0.064,0.127,0.216,0.165,0.178c0.039-0.038,0.089-0.203,0.153-0.166c0.064,0.039,0.216-0.012,0.331-0.025s0.177-0.14,0.292-0.204c0.114-0.063,0.05-0.063,0.013-0.14c-0.038-0.076,0.114-0.165,0.204-0.254c0.088-0.089,0.253-0.013,0.292-0.115c0.038-0.102,0.051-0.279,0.151-0.267c0.103,0.013,0.243,0.076,0.331,0.076c0.089,0,0.279-0.14,0.332-0.165c0.05-0.025,0.241-0.013,0.267,0.102c0.025,0.114,0.241,0.254,0.292,0.279c0.051,0.025,0.381,0.127,0.433,0.165c0.05,0.038,0.126,0.153,0.152,0.254c0.025,0.102,0.114,0.102,0.128,0.013c0.012-0.089-0.065-0.254,0.025-0.242c0.088,0.013,0.191-0.026,0.191-0.026s-0.243-0.165-0.331-0.203c-0.088-0.038-0.255-0.114-0.331-0.241c-0.076-0.127-0.267-0.153-0.254-0.279c0.013-0.127,0.191-0.051,0.292,0.051c0.102,0.102,0.356,0.241,0.445,0.33c0.088,0.089,0.229,0.127,0.267,0.242c0.039,0.114,0.152,0.241,0.19,0.292c0.038,0.051,0.165,0.331,0.204,0.394c0.038,0.063,0.165-0.012,0.229-0.063c0.063-0.051,0.179-0.076,0.191-0.178c0.013-0.102-0.153-0.178-0.203-0.216c-0.051-0.038,0.127-0.076,0.191-0.127c0.063-0.05,0.177-0.14,0.228-0.063c0.051,0.077,0.026,0.381,0.051,0.432c0.025,0.051,0.279,0.127,0.331,0.191c0.05,0.063,0.267,0.089,0.304,0.051c0.039-0.038,0.242,0.026,0.294,0.038c0.049,0.013,0.202-0.025,0.304-0.05c0.103-0.025,0.204-0.102,0.191,0.063c-0.013,0.165-0.051,0.419-0.179,0.546c-0.127,0.127-0.076,0.191-0.202,0.191c-0.06,0-0.113,0-0.156,0.021c-0.041-0.065-0.098-0.117-0.175-0.097c-0.152,0.038-0.344,0.038-0.47,0.19c-0.128,0.153-0.178,0.165-0.204,0.114c-0.025-0.051,0.369-0.267,0.317-0.331c-0.05-0.063-0.355-0.038-0.521-0.038c-0.166,0-0.305-0.102-0.433-0.127c-0.126-0.025-0.292,0.127-0.418,0.254c-0.128,0.127-0.216,0.038-0.331,0.038c-0.115,0-0.331-0.165-0.331-0.165s-0.216-0.089-0.305-0.089c-0.088,0-0.267-0.165-0.318-0.165c-0.05,0-0.19-0.115-0.088-0.166c0.101-0.05,0.202,0.051,0.101-0.229c-0.101-0.279-0.33-0.216-0.419-0.178c-0.088,0.039-0.724,0.025-0.775,0.025c-0.051,0-0.419,0.127-0.533,0.178c-0.116,0.051-0.318,0.115-0.369,0.14c-0.051,0.025-0.318-0.051-0.433,0.013c-0.151,0.084-0.291,0.216-0.33,0.216c-0.038,0-0.153,0.089-0.229,0.28c-0.077,0.19,0.013,0.355-0.128,0.419c-0.139,0.063-0.394,0.204-0.495,0.305c-0.102,0.101-0.229,0.458-0.355,0.623c-0.127,0.165,0,0.317,0.025,0.419c0.025,0.101,0.114,0.292-0.025,0.471c-0.14,0.178-0.127,0.266-0.191,0.279c-0.063,0.013,0.063,0.063,0.088,0.19c0.025,0.128-0.114,0.255,0.128,0.369c0.241,0.113,0.355,0.217,0.418,0.367c0.064,0.153,0.382,0.407,0.382,0.407s0.229,0.205,0.344,0.293c0.114,0.089,0.152,0.038,0.177-0.05c0.025-0.09,0.178-0.104,0.355-0.104c0.178,0,0.305,0.04,0.483,0.014c0.178-0.025,0.356-0.141,0.42-0.166c0.063-0.025,0.279-0.164,0.443-0.063c0.166,0.103,0.141,0.241,0.23,0.332c0.088,0.088,0.24,0.037,0.355-0.051c0.114-0.09,0.064-0.052,0.203,0.025c0.14,0.075,0.204,0.151,0.077,0.267c-0.128,0.113-0.051,0.293-0.128,0.47c-0.076,0.178-0.063,0.203,0.077,0.278c0.14,0.076,0.394,0.548,0.47,0.638c0.077,0.088-0.025,0.342,0.064,0.495c0.089,0.151,0.178,0.254,0.077,0.331c-0.103,0.075-0.28,0.216-0.292,0.47s0.051,0.431,0.102,0.521s0.177,0.331,0.241,0.419c0.064,0.089,0.14,0.305,0.152,0.445c0.013,0.14-0.024,0.306,0.039,0.381c0.064,0.076,0.102,0.191,0.216,0.292c0.115,0.103,0.152,0.318,0.152,0.318s0.039,0.089,0.051,0.229c0.012,0.14,0.025,0.228,0.152,0.292c0.126,0.063,0.215,0.076,0.28,0.013c0.063-0.063,0.381-0.077,0.546-0.063c0.165,0.013,0.355-0.075,0.521-0.19s0.407-0.419,0.496-0.508c0.089-0.09,0.292-0.255,0.268-0.356c-0.025-0.101-0.077-0.203,0.024-0.254c0.102-0.052,0.344-0.152,0.356-0.229c0.013-0.077-0.09-0.395-0.115-0.457c-0.024-0.064,0.064-0.18,0.165-0.306c0.103-0.128,0.421-0.216,0.471-0.267c0.051-0.053,0.191-0.267,0.217-0.433c0.024-0.167-0.051-0.369,0-0.457c0.05-0.09,0.013-0.165-0.103-0.268c-0.114-0.102-0.089-0.407-0.127-0.457c-0.037-0.051-0.013-0.319,0.063-0.345c0.076-0.023,0.242-0.279,0.344-0.393c0.102-0.114,0.394-0.47,0.534-0.496c0.139-0.025,0.355-0.229,0.368-0.343c0.013-0.115,0.38-0.547,0.394-0.635c0.013-0.09,0.166-0.42,0.102-0.497c-0.062-0.076-0.559,0.115-0.622,0.141c-0.064,0.025-0.241,0.127-0.446,0.113c-0.202-0.013-0.114-0.177-0.127-0.254c-0.012-0.076-0.228-0.368-0.279-0.381c-0.051-0.012-0.203-0.166-0.267-0.317c-0.063-0.153-0.152-0.343-0.254-0.458c-0.102-0.114-0.165-0.38-0.268-0.559c-0.101-0.178-0.189-0.407-0.279-0.572c-0.021-0.041-0.045-0.079-0.067-0.117c0.118-0.029,0.289-0.082,0.31-0.009c0.024,0.088,0.165,0.279,0.19,0.419s0.165,0.089,0.178,0.216c0.014,0.128,0.14,0.433,0.19,0.47c0.052,0.038,0.28,0.242,0.318,0.318c0.038,0.076,0.089,0.178,0.127,0.369c0.038,0.19,0.076,0.444,0.179,0.482c0.102,0.038,0.444-0.064,0.508-0.102s0.482-0.242,0.635-0.255c0.153-0.012,0.179-0.115,0.368-0.152c0.191-0.038,0.331-0.177,0.458-0.28c0.127-0.101,0.28-0.355,0.33-0.444c0.052-0.088,0.179-0.152,0.115-0.253c-0.063-0.103-0.331-0.254-0.433-0.268c-0.102-0.012-0.089-0.178-0.152-0.178s-0.051,0.088-0.178,0.153c-0.127,0.063-0.255,0.19-0.344,0.165s0.026-0.089-0.113-0.203s-0.192-0.14-0.192-0.228c0-0.089-0.278-0.255-0.304-0.382c-0.026-0.127,0.19-0.305,0.254-0.19c0.063,0.114,0.115,0.292,0.279,0.368c0.165,0.076,0.318,0.204,0.395,0.229c0.076,0.025,0.267-0.14,0.33-0.114c0.063,0.024,0.191,0.253,0.306,0.292c0.113,0.038,0.495,0.051,0.559,0.051s0.33,0.013,0.381-0.063c0.051-0.076,0.089-0.076,0.153-0.076c0.062,0,0.177,0.229,0.267,0.254c0.089,0.025,0.254,0.013,0.241,0.179c-0.012,0.164,0.076,0.305,0.165,0.317c0.09,0.012,0.293-0.191,0.293-0.191s0,0.318-0.012,0.433c-0.014,0.113,0.139,0.534,0.139,0.534s0.19,0.393,0.241,0.482s0.267,0.355,0.267,0.47c0,0.115,0.025,0.293,0.103,0.293c0.076,0,0.152-0.203,0.24-0.331c0.091-0.126,0.116-0.305,0.153-0.432c0.038-0.127,0.038-0.356,0.038-0.444c0-0.09,0.075-0.166,0.255-0.242c0.178-0.076,0.304-0.292,0.456-0.407c0.153-0.115,0.141-0.305,0.446-0.305c0.305,0,0.278,0,0.355-0.077c0.076-0.076,0.151-0.127,0.19,0.013c0.038,0.14,0.254,0.343,0.292,0.394c0.038,0.052,0.114,0.191,0.103,0.344c-0.013,0.152,0.012,0.33,0.075,0.33s0.191-0.216,0.191-0.216s0.279-0.189,0.267,0.013c-0.014,0.203,0.025,0.419,0.025,0.545c0,0.053,0.042,0.135,0.088,0.21c-0.005,0.059-0.004,0.119-0.009,0.178C27.388,17.153,27.387,17.327,27.436,17.39zM20.382,12.064c0.076,0.05,0.102,0.127,0.152,0.203c0.052,0.076,0.14,0.05,0.203,0.114c0.063,0.064-0.178,0.14-0.075,0.216c0.101,0.077,0.151,0.381,0.165,0.458c0.013,0.076-0.279,0.114-0.369,0.102c-0.089-0.013-0.354-0.102-0.445-0.127c-0.089-0.026-0.139-0.343-0.025-0.331c0.116,0.013,0.141-0.025,0.267-0.139c0.128-0.115-0.189-0.166-0.278-0.191c-0.089-0.025-0.268-0.305-0.331-0.394c-0.062-0.089-0.014-0.228,0.141-0.331c0.076-0.051,0.279,0.063,0.381,0c0.101-0.063,0.203-0.14,0.241-0.165c0.039-0.025,0.293,0.038,0.33,0.114c0.039,0.076,0.191,0.191,0.141,0.229c-0.052,0.038-0.281,0.076-0.356,0c-0.075-0.077-0.255,0.012-0.268,0.152C20.242,12.115,20.307,12.013,20.382,12.064zM16.875,12.28c-0.077-0.025,0.025-0.178,0.102-0.229c0.075-0.051,0.164-0.178,0.241-0.305c0.076-0.127,0.178-0.14,0.241-0.127c0.063,0.013,0.203,0.241,0.241,0.318c0.038,0.076,0.165-0.026,0.217-0.051c0.05-0.025,0.127-0.102,0.14-0.165s0.127-0.102,0.254-0.102s0.013,0.102-0.076,0.127c-0.09,0.025-0.038,0.077,0.113,0.127c0.153,0.051,0.293,0.191,0.459,0.279c0.165,0.089,0.19,0.267,0.088,0.292c-0.101,0.025-0.406,0.051-0.521,0.038c-0.114-0.013-0.254-0.127-0.419-0.153c-0.165-0.025-0.369-0.013-0.433,0.077s-0.292,0.05-0.395,0.05c-0.102,0-0.228,0.127-0.253,0.077C16.875,12.534,16.951,12.306,16.875,12.28zM17.307,9.458c0.063-0.178,0.419,0.038,0.355,0.127C17.599,9.675,17.264,9.579,17.307,9.458zM17.802,18.584c0.063,0.102-0.14,0.431-0.254,0.407c-0.113-0.027-0.076-0.318-0.038-0.382C17.548,18.545,17.769,18.529,17.802,18.584zM13.189,12.674c0.025-0.051-0.039-0.153-0.127-0.013C13.032,12.71,13.164,12.725,13.189,12.674zM20.813,8.035c0.141,0.076,0.339,0.107,0.433,0.013c0.076-0.076,0.013-0.204-0.05-0.216c-0.064-0.013-0.104-0.115,0.062-0.203c0.165-0.089,0.343-0.204,0.534-0.229c0.19-0.025,0.622-0.038,0.774,0c0.152,0.039,0.382-0.166,0.445-0.254s-0.203-0.152-0.279-0.051c-0.077,0.102-0.444,0.076-0.521,0.051c-0.076-0.025-0.686,0.102-0.812,0.102c-0.128,0-0.179,0.152-0.356,0.229c-0.179,0.076-0.42,0.191-0.509,0.229c-0.088,0.038-0.177,0.19-0.101,0.216C20.509,7.947,20.674,7.959,20.813,8.035zM14.142,12.674c0.064-0.089-0.051-0.217-0.114-0.217c-0.12,0-0.178,0.191-0.103,0.254C14.002,12.776,14.078,12.763,14.142,12.674zM14.714,13.017c0.064,0.025,0.114,0.102,0.165,0.114c0.052,0.013,0.217,0,0.167-0.127s-0.167-0.127-0.204-0.127c-0.038,0-0.203-0.038-0.267,0C14.528,12.905,14.65,12.992,14.714,13.017zM11.308,10.958c0.101,0.013,0.217-0.063,0.305-0.101c0.088-0.038,0.216-0.114,0.216-0.229c0-0.114-0.025-0.216-0.077-0.267c-0.051-0.051-0.14-0.064-0.216-0.051c-0.115,0.02-0.127,0.14-0.203,0.14c-0.076,0-0.165,0.025-0.14,0.114s0.077,0.152,0,0.19C11.117,10.793,11.205,10.946,11.308,10.958zM11.931,10.412c0.127,0.051,0.394,0.102,0.292,0.153c-0.102,0.051-0.28,0.19-0.305,0.267s0.216,0.153,0.216,0.153s-0.077,0.089-0.013,0.114c0.063,0.025,0.102-0.089,0.203-0.089c0.101,0,0.304,0.063,0.406,0.063c0.103,0,0.267-0.14,0.254-0.229c-0.013-0.089-0.14-0.229-0.254-0.28c-0.113-0.051-0.241-0.28-0.317-0.331c-0.076-0.051,0.076-0.178-0.013-0.267c-0.09-0.089-0.153-0.076-0.255-0.14c-0.102-0.063-0.191,0.013-0.254,0.089c-0.063,0.076-0.14-0.013-0.217,0.012c-0.102,0.035-0.063,0.166-0.012,0.229C11.714,10.221,11.804,10.361,11.931,10.412zM24.729,17.198c-0.083,0.037-0.153,0.47,0,0.521c0.152,0.052,0.241-0.202,0.191-0.267C24.868,17.39,24.843,17.147,24.729,17.198zM20.114,20.464c-0.159-0.045-0.177,0.166-0.304,0.306c-0.128,0.141-0.267,0.254-0.317,0.241c-0.052-0.013-0.331,0.089-0.242,0.279c0.089,0.191,0.076,0.382-0.013,0.472c-0.089,0.088,0.076,0.342,0.052,0.482c-0.026,0.139,0.037,0.229,0.215,0.229s0.242-0.064,0.318-0.229c0.076-0.166,0.088-0.331,0.164-0.47c0.077-0.141,0.141-0.434,0.179-0.51c0.038-0.075,0.114-0.316,0.102-0.457C20.254,20.669,20.204,20.489,20.114,20.464zM10.391,8.802c-0.069-0.06-0.229-0.102-0.306-0.11c-0.076-0.008-0.152,0.06-0.321,0.06c-0.168,0-0.279,0.067-0.347,0C9.349,8.684,9.068,8.65,9.042,8.692C9.008,8.749,8.941,8.751,9.008,8.87c0.069,0.118,0.12,0.186,0.179,0.178s0.262-0.017,0.288,0.051C9.5,9.167,9.569,9.226,9.712,9.184c0.145-0.042,0.263-0.068,0.296-0.119c0.033-0.051,0.263-0.059,0.263-0.059S10.458,8.861,10.391,8.802z";

                var globeHover = globeIcon.states.create("hover");
                globeHover.properties.fill = hoverColor;

                var label = labelContainer.createChild(am4core.Label);
                label.valign = "bottom";
                label.verticalCenter = "bottom";
                label.dy = -5;
                label.text = "Back to continents map";
                label.states.create("hover").properties.fill = hoverColor;

            }); // end am4core.ready()
        },
        lineGauge: function () {
            am4core.useTheme(am4themes_animated);
            am4core.useTheme(am4themes_dark);

            // times of events
            var startTime = new Date(2018, 0, 13, 6).getTime();
            var endTime = new Date(2018, 0, 13, 11, 59).getTime();
            var launchTime = new Date(2018, 0, 13, 7, 0).getTime();
            var alertTime = new Date(2018, 0, 13, 8, 7).getTime();
            var cancelTime = new Date(2018, 0, 13, 8, 45).getTime();

            var colorSet = new am4core.ColorSet();
            var currentTime;

            var container = am4core.create("lineGauge", am4core.Container);
            container.width = am4core.percent(100);
            container.height = am4core.percent(100);

            // map chart ////////////////////////////////////////////////////////
            var mapChart = container.createChild(am4maps.MapChart);

            try {
                mapChart.geodata = am4geodata_continentsLow;
            } catch (e) {
                mapChart.raiseCriticalError(new Error("Map geodata could not be loaded. Please download the latest <a href=\"https://www.amcharts.com/download/download-v4/\">amcharts geodata</a> and extract its contents into the same directory as your amCharts files."));
            }

            mapChart.projection = new am4maps.projections.Miller();
            mapChart.deltaLongitude = 145;
            mapChart.seriesContainer.draggable = false;

            var polygonSeries = mapChart.series.push(new am4maps.MapPolygonSeries());
            polygonSeries.useGeodata = true;
            polygonSeries.exclude = ["Antarctica"];

            var mapImageSeries = mapChart.series.push(new am4maps.MapImageSeries());
            var pyongyang = mapImageSeries.mapImages.create();
            pyongyang.longitude = 125.739708;
            pyongyang.latitude = 39.034333;
            pyongyang.nonScaling = true;

            var pyongyangCircle = pyongyang.createChild(am4core.Circle);
            pyongyangCircle.fill = colorSet.getIndex(5);
            pyongyangCircle.stroke = pyongyangCircle.fill;
            pyongyangCircle.radius = 4;

            pyongyangCircle.tooltip = new am4core.Tooltip();
            pyongyangCircle.tooltip.filters.clear();
            pyongyangCircle.tooltip.background.cornerRadius = 20;
            pyongyangCircle.tooltip.label.padding(15, 20, 15, 20);
            pyongyangCircle.tooltip.background.strokeOpacity = 0;
            pyongyangCircle.tooltipY = -5;


            var koreaText = pyongyang.createChild(am4core.Label);
            koreaText.text = "North Korea";
            koreaText.fillOpacity = 0.2;
            koreaText.fontSize = 20;
            koreaText.verticalCenter = "middle";
            koreaText.horizontalCenter = "right";
            koreaText.paddingRight = 15;

            var bomb = mapImageSeries.mapImages.create();
            bomb.longitude = 125.739708;
            bomb.latitude = 39.034333;
            bomb.nonScaling = true;
            bomb.opacity = 0;

            var bombImage = bomb.createChild(am4core.Image);
            bombImage.width = 32;
            bombImage.height = 32;
            bombImage.href = "assets/plugins/amcharts4/img/rocket.svg";
            bombImage.verticalCenter = "middle";
            bombImage.horizontalCenter = "middle";


            var honolulu = mapImageSeries.mapImages.create();
            honolulu.longitude = -157.887841;
            honolulu.latitude = 21.368213;
            honolulu.nonScaling = true;


            var bulletAlertCircle = honolulu.createChild(am4core.Circle);
            bulletAlertCircle.fill = am4core.color();
            bulletAlertCircle.stroke = colorSet.getIndex(2);
            bulletAlertCircle.strokeOpacity = 1;
            bulletAlertCircle.radius = 5;
            bulletAlertCircle.strokeWidth = 2;
            bulletAlertCircle.visible = false;
            var bulletAlertAnimation = bulletAlertCircle.animate([{property: "radius", to: 50}, {property: "strokeOpacity", to: 0, from: 1}], 600).loop().pause();

            var honoluluCircle = honolulu.createChild(am4core.Circle);
            honoluluCircle.fill = colorSet.getIndex(2);
            honoluluCircle.stroke = honoluluCircle.fill;
            honoluluCircle.radius = 4;
            honoluluCircle.tooltipY = -5;

            honoluluCircle.tooltip = new am4core.Tooltip();
            honoluluCircle.tooltip.filters.clear();
            honoluluCircle.tooltip.background.cornerRadius = 20;
            honoluluCircle.tooltip.label.padding(15, 20, 15, 20);
            honoluluCircle.tooltip.background.strokeOpacity = 0;


            var hawaiiText = honolulu.createChild(am4core.Label);
            hawaiiText.text = "Hawaii, USA";
            hawaiiText.fillOpacity = 0.1;
            hawaiiText.fontSize = 35;
            hawaiiText.verticalCenter = "middle";
            hawaiiText.paddingLeft = 30;


            var bang = mapImageSeries.mapImages.create();
            bang.longitude = -177;
            bang.latitude = 24;
            bang.nonScaling = true;
            var bangImage = bang.createChild(am4core.Image);
            bangImage.width = 50;
            bangImage.height = 50;
            bangImage.verticalCenter = "middle";
            bangImage.horizontalCenter = "middle";
            bangImage.href = "assets/plugins/amcharts4/img/bang.png";
            bang.opacity = 0;

            var mapLineSeries = mapChart.series.push(new am4maps.MapLineSeries());
            var line = mapLineSeries.mapLines.create();
            line.imagesToConnect = [pyongyang, bang];
            line.line.strokeOpacity = 0; // it's invisible, we use it for a bomb image to follow it

            mapChart.homeGeoPoint = {longitude: -175, latitude: 15};
            mapChart.homeZoomLevel = 2.2;

            // clock chart //////////////////////////////////////////////////////////////////
            var clock = mapChart.chartContainer.createChild(am4charts.GaugeChart);
            clock.align = "right";
            clock.width = 250;
            clock.height = 250;
            clock.align = "right";
            clock.zIndex = 10;

            clock.startAngle = -90;
            clock.endAngle = 270;

            var axis = clock.xAxes.push(new am4charts.ValueAxis());
            axis.min = 0;
            axis.max = 12;
            axis.strictMinMax = true;

            axis.renderer.line.strokeWidth = 1;
            axis.renderer.line.strokeOpacity = 0.2;
            axis.renderer.minLabelPosition = 0.05; // hides 0 label
            axis.renderer.inside = true;
            axis.renderer.labels.template.radius = 23;
            axis.renderer.grid.template.disabled = true;
            axis.renderer.minGridDistance = 20;
            axis.renderer.ticks.template.length = 4;
            axis.renderer.ticks.template.strokeOpacity = 0.2;

            // clock hands
            var hourHand = clock.hands.push(new am4charts.ClockHand());
            hourHand.radius = am4core.percent(60);
            hourHand.startWidth = 5;
            hourHand.endWidth = 5;
            hourHand.rotationDirection = "clockWise";
            hourHand.pin.radius = 5;
            hourHand.zIndex = 0;

            var minutesHand = clock.hands.push(new am4charts.ClockHand());
            minutesHand.rotationDirection = "clockWise";
            minutesHand.startWidth = 2;
            minutesHand.endWidth = 2;
            minutesHand.radius = am4core.percent(78);
            minutesHand.zIndex = 1;


            function updateHands(date) {
                var hours = date.getHours();
                var minutes = date.getMinutes();
                var seconds = date.getSeconds();

                // set hours
                hourHand.showValue(hours + minutes / 60, 0);
                // set minutes
                minutesHand.showValue(12 * (minutes + seconds / 60) / 60, 0);
            }

            /// end of clock

            var exploded = false;

            var honoluluTexts = [
                {time: new Date(2018, 0, 13, 6, 7).getTime(), text: "I wonder what's on youtube..."},
                {time: new Date(2018, 0, 13, 6, 30).getTime(), text: "... oooh a kitty video ..."},
                {time: new Date(2018, 0, 13, 7, 10).getTime(), text: "... LOL funny ..."},
                {time: new Date(2018, 0, 13, 8, 7).getTime(), text: "Huh?!?"},
                {time: new Date(2018, 0, 13, 8, 15).getTime(), text: "OMG!!!"},
                {time: new Date(2018, 0, 13, 8, 49).getTime(), text: "Phew!"},
                {time: new Date(2018, 0, 13, 8, 59).getTime(), text: "OK, where were we?"},
                {time: new Date(2018, 0, 13, 9, 20).getTime(), text: ""}
            ];

            var pyongyangTexts = [
                {time: new Date(2018, 0, 13, 6, 5).getTime(), text: "Great comrade..."},
                {time: new Date(2018, 0, 13, 6, 20).getTime(), text: "WHAT!?"},
                {time: new Date(2018, 0, 13, 6, 40).getTime(), text: "Please, push this button..."},
                {time: new Date(2018, 0, 13, 7, 0).getTime(), text: "O.K."},
                {time: new Date(2018, 0, 13, 7, 30).getTime(), text: ""},
            ];

            // updates all elements
            function setTime() {
                var time = new Date(startTime + (endTime - startTime) * slider.start).getTime();
                ;
                var roundedTime = am4core.time.round(new Date(time), "minute").getTime();

                if (roundedTime != currentTime) {
                    currentTime = roundedTime;
                    var count = lineSeries.dataItems.length;
                    if (slider) {
                        for (var i = 0; i < count; i++) {
                            var dataItem = lineSeries.dataItems.getIndex(i);

                            if (i < slider.start * count) {
                                dataItem.show(500, 0, ["valueY"]);
                            } else {
                                dataItem.hide(500, 0, 0, ["valueY"]);
                            }
                        }
                    }
                }

                // add some drama by zooming the map
                updateHands(new Date(time));

                var bombFlyDuration = cancelTime - launchTime;
                var bombPosition = (time - launchTime) / bombFlyDuration;
                bombPosition = Math.min(1, bombPosition);
                bombPosition = Math.max(0, bombPosition);

                var oPoint = line.positionToPoint(bombPosition);
                var geoPoint = mapChart.seriesPointToGeo(oPoint);
                bomb.latitude = geoPoint.latitude;
                bomb.longitude = geoPoint.longitude;
                bomb.rotation = oPoint.angle + 90;

                if (bombPosition > 0 && bombPosition < 1) {
                    bomb.opacity = 1;
                }

                if ((bombPosition >= 1 && !exploded)) {
                    bomb.opacity = 0;
                    bang.opacity = 1;
                    bang.animate({property: "opacity", to: 0, from: 1}, 1000);
                    exploded = true;
                }

                if (exploded && bombPosition < 1) {
                    exploded = false;
                    bang.opacity = 0;
                    bomb.opacity = 1;
                }

                if (bombPosition <= 0.001) {
                    bomb.opacity = 0;
                }

                if (time > alertTime && time < cancelTime) {
                    if (!bulletAlertCircle.visible) {
                        bulletAlertCircle.visible = true;
                        bulletAlertAnimation.resume();
                    }
                } else {
                    bulletAlertCircle.visible = false;
                }

                for (var i = 0; i < honoluluTexts.length; i++) {
                    var honoluluText = honoluluTexts[i];
                    if (time > honoluluText.time) {
                        honoluluCircle.tooltipText = honoluluText.text;
                    }
                }

                if (honoluluCircle.tooltipText) {
                    honoluluCircle.showTooltip();
                } else {
                    honoluluCircle.hideTooltip();
                }

                for (var i = 0; i < pyongyangTexts.length; i++) {
                    var pyongyangText = pyongyangTexts[i];
                    if (time > pyongyangText.time) {
                        pyongyangCircle.tooltipText = pyongyangText.text;
                    }
                }

                if (pyongyangCircle.tooltipText) {
                    pyongyangCircle.showTooltip();
                } else {
                    pyongyangCircle.hideTooltip();
                }
            }


            var chart = container.createChild(am4charts.XYChart);
            chart.padding(0, 50, 50, 50);
            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.tooltip.background.pointerLength = 4;
            dateAxis.tooltip.background.fillOpacity = 1;
            dateAxis.tooltip.background.fill = am4core.color("#666666");
            dateAxis.tooltip.background.stroke = dateAxis.tooltip.background.fill;


            chart.height = 300;
            chart.valign = "bottom";

            var gradientFill = new am4core.LinearGradient();
            gradientFill.addColor(am4core.color("#000000"), 0, 0);
            gradientFill.addColor(am4core.color("#000000"), 1, 1);
            gradientFill.rotation = 90;

            chart.background.fill = gradientFill;

            //dateAxis.renderer.inside = true;
            dateAxis.renderer.ticks.template.disabled = true;
            dateAxis.renderer.grid.template.strokeDasharray = "3,3";
            dateAxis.renderer.grid.template.strokeOpacity = 0.2;
            dateAxis.renderer.line.disabled = true;
            dateAxis.tooltip.dateFormatter.dateFormat = "YYYY-MM-dd HH:mm";
            dateAxis.renderer.inside = false;
            dateAxis.renderer.labels.template.fillOpacity = 0.4;
            dateAxis.renderer.minLabelPosition = 0.03;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.renderer.ticks.template.disabled = true;
            valueAxis.min = -90;
            valueAxis.max = 90;
            valueAxis.renderer.minGridDistance = 20;
            valueAxis.renderer.grid.template.disabled = true;
            valueAxis.renderer.line.disabled = true;
            valueAxis.tooltip.disabled = true;
            valueAxis.strictMinMax = true;
            valueAxis.renderer.labels.template.fillOpacity = 0.4;
            valueAxis.renderer.inside = true;

            var lineSeries = chart.series.push(new am4charts.LineSeries());
            lineSeries.dataFields.valueY = "value";
            lineSeries.dataFields.dateX = "time";
            lineSeries.tooltipText = "{valueY.workingValue}%";
            lineSeries.stroke = am4core.color("#3f2698");
            lineSeries.tooltip.background.fillOpacity = 0;
            lineSeries.tooltip.autoTextColor = false;
            lineSeries.tooltip.label.fill = am4core.color("#ffffff");
            lineSeries.tooltip.filters.clear();
            lineSeries.tooltip.pointerOrientation = "vertical";
            lineSeries.strokeWidth = 2;
            lineSeries.tensionX = 0.7;

            var negativeRange = valueAxis.createSeriesRange(lineSeries);
            negativeRange.value = 0;
            negativeRange.endValue = -100;
            negativeRange.contents.stroke = am4core.color("#84279a");
            negativeRange.contents.fill = negativeRange.contents.stroke;

            chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm";

            chart.cursor = new am4charts.XYCursor();
            chart.cursor.behavior = "none";
            chart.cursor.xAxis = dateAxis;
            chart.cursor.lineX.strokeOpacity = 0;

            chart.events.on("ready", function () {
                createSlider();
            })

            var slider;

            var alertStart = dateAxis.axisRanges.create();
            alertStart.date = new Date(alertTime);
            alertStart.grid.stroke = am4core.color("#ffffff");
            alertStart.grid.strokeWidth = 1;
            alertStart.grid.strokeOpacity = 0.5;
            alertStart.grid.strokeDasharray = undefined;
            alertStart.label.text = "Citizens alerted";
            alertStart.label.horizontalCenter = "right";
            alertStart.label.fillOpacity = 0.7;
            alertStart.label.dy = -215;

            var alertCanceled = dateAxis.axisRanges.create();
            alertCanceled.date = new Date(cancelTime);
            alertCanceled.grid.stroke = am4core.color("#ffffff");
            alertCanceled.grid.strokeOpacity = 0.5;
            alertCanceled.grid.strokeDasharray = undefined;
            alertCanceled.label.text = "Alert canceled";
            alertCanceled.label.dy = -215;
            alertCanceled.label.fillOpacity = 0.7;
            alertCanceled.label.horizontalCenter = "left";

            var playButton;

            function createSlider() {
                var sliderContainer = container.createChild(am4core.Container);

                sliderContainer.width = am4core.percent(100);
                sliderContainer.valign = "bottom";
                sliderContainer.padding(0, 50, 25, 50);
                sliderContainer.layout = "horizontal";
                sliderContainer.height = 50;


                playButton = sliderContainer.createChild(am4core.PlayButton);
                playButton.valign = "middle";
                playButton.events.on("toggled", function (event) {
                    if (event.target.isActive) {
                        play();
                    } else {
                        stop();
                    }
                })

                slider = sliderContainer.createChild(am4core.Slider);
                slider.valign = "middle";
                slider.margin(0, 0, 0, 0);
                slider.marginLeft = 30;
                slider.height = 15;
                slider.events.on("rangechanged", function () {
                    setTime();
                });

                slider.startGrip.events.on("drag", function () {
                    stop();
                    sliderAnimation.setProgress(slider.start);
                });

                sliderAnimation = slider.animate({property: "start", to: 1}, 50000, am4core.ease.linear).pause();
                sliderAnimation.events.on("animationended", function () {
                    playButton.isActive = false;
                })
            }


            var sliderAnimation;

            function play() {
                if (slider) {
                    if (slider.start >= 1) {
                        slider.start = 0;
                        sliderAnimation.start();
                    }
                    sliderAnimation.resume();
                    playButton.isActive = true;
                }
            }

            function stop() {
                sliderAnimation.pause();
                playButton.isActive = false;
            }

            setTimeout(function () {
                play()
            }, 2000);

            var label = container.createChild(am4core.Label);
            label.text = "Website traffic in Hawaii during January 13, 2018 false ballistic missile alert";
            label.valign = "bottom";
            label.padding(0, 50, 10, 0);
            label.align = "right";

            chart.data = [{"time": "2018-01-13 06:00", "value": 0},
                {"time": "2018-01-13 06:01", "value": -4},
                {"time": "2018-01-13 06:02", "value": -16},
                {"time": "2018-01-13 06:03", "value": -5},
                {"time": "2018-01-13 06:04", "value": 12},
                {"time": "2018-01-13 06:05", "value": -4},
                {"time": "2018-01-13 06:06", "value": -5},
                {"time": "2018-01-13 06:07", "value": -8},
                {"time": "2018-01-13 06:08", "value": -2},
                {"time": "2018-01-13 06:09", "value": -14},
                {"time": "2018-01-13 06:10", "value": 15},
                {"time": "2018-01-13 06:11", "value": 0},
                {"time": "2018-01-13 06:12", "value": -14},
                {"time": "2018-01-13 06:13", "value": -13},
                {"time": "2018-01-13 06:14", "value": 2},
                {"time": "2018-01-13 06:15", "value": 10},
                {"time": "2018-01-13 06:16", "value": 11},
                {"time": "2018-01-13 06:17", "value": 13},
                {"time": "2018-01-13 06:18", "value": -11},
                {"time": "2018-01-13 06:19", "value": 0},
                {"time": "2018-01-13 06:20", "value": -10},
                {"time": "2018-01-13 06:21", "value": 0},
                {"time": "2018-01-13 06:22", "value": -21},
                {"time": "2018-01-13 06:23", "value": -9},
                {"time": "2018-01-13 06:24", "value": -11},
                {"time": "2018-01-13 06:25", "value": -7},
                {"time": "2018-01-13 06:26", "value": -14},
                {"time": "2018-01-13 06:27", "value": 0},
                {"time": "2018-01-13 06:28", "value": -9},
                {"time": "2018-01-13 06:29", "value": 12},
                {"time": "2018-01-13 06:30", "value": 7},
                {"time": "2018-01-13 06:31", "value": 10},
                {"time": "2018-01-13 06:32", "value": 5},
                {"time": "2018-01-13 06:33", "value": 12},
                {"time": "2018-01-13 06:34", "value": 13},
                {"time": "2018-01-13 06:35", "value": 10},
                {"time": "2018-01-13 06:36", "value": -14},
                {"time": "2018-01-13 06:37", "value": -12},
                {"time": "2018-01-13 06:38", "value": -8},
                {"time": "2018-01-13 06:39", "value": -13},
                {"time": "2018-01-13 06:40", "value": -13},
                {"time": "2018-01-13 06:41", "value": -12},
                {"time": "2018-01-13 06:42", "value": -11},
                {"time": "2018-01-13 06:43", "value": 9},
                {"time": "2018-01-13 06:44", "value": 0},
                {"time": "2018-01-13 06:45", "value": -4},
                {"time": "2018-01-13 06:46", "value": -6},
                {"time": "2018-01-13 06:47", "value": -7},
                {"time": "2018-01-13 06:48", "value": -12},
                {"time": "2018-01-13 06:49", "value": -8},
                {"time": "2018-01-13 06:50", "value": -7},
                {"time": "2018-01-13 06:51", "value": 9},
                {"time": "2018-01-13 06:52", "value": 10},
                {"time": "2018-01-13 06:53", "value": 12},
                {"time": "2018-01-13 06:54", "value": -4},
                {"time": "2018-01-13 06:55", "value": 3},
                {"time": "2018-01-13 06:56", "value": 9},
                {"time": "2018-01-13 06:57", "value": -2},
                {"time": "2018-01-13 06:58", "value": 7},
                {"time": "2018-01-13 06:59", "value": 5},
                {"time": "2018-01-13 07:00", "value": 8},
                {"time": "2018-01-13 07:01", "value": -1},
                {"time": "2018-01-13 07:02", "value": 1},
                {"time": "2018-01-13 07:03", "value": -6},
                {"time": "2018-01-13 07:04", "value": 0},
                {"time": "2018-01-13 07:05", "value": -7},
                {"time": "2018-01-13 07:06", "value": 3},
                {"time": "2018-01-13 07:07", "value": 7},
                {"time": "2018-01-13 07:08", "value": 2},
                {"time": "2018-01-13 07:09", "value": -6},
                {"time": "2018-01-13 07:10", "value": 2},
                {"time": "2018-01-13 07:11", "value": -3},
                {"time": "2018-01-13 07:12", "value": -8},
                {"time": "2018-01-13 07:13", "value": -15},
                {"time": "2018-01-13 07:14", "value": -3},
                {"time": "2018-01-13 07:15", "value": -17},
                {"time": "2018-01-13 07:16", "value": -8},
                {"time": "2018-01-13 07:17", "value": -4},
                {"time": "2018-01-13 07:18", "value": 0},
                {"time": "2018-01-13 07:19", "value": -6},
                {"time": "2018-01-13 07:20", "value": -5},
                {"time": "2018-01-13 07:21", "value": -16},
                {"time": "2018-01-13 07:22", "value": -8},
                {"time": "2018-01-13 07:23", "value": -23},
                {"time": "2018-01-13 07:24", "value": -9},
                {"time": "2018-01-13 07:25", "value": -9},
                {"time": "2018-01-13 07:26", "value": -11},
                {"time": "2018-01-13 07:27", "value": -12},
                {"time": "2018-01-13 07:28", "value": -13},
                {"time": "2018-01-13 07:29", "value": -11},
                {"time": "2018-01-13 07:30", "value": -14},
                {"time": "2018-01-13 07:31", "value": -10},
                {"time": "2018-01-13 07:32", "value": -4},
                {"time": "2018-01-13 07:33", "value": -17},
                {"time": "2018-01-13 07:34", "value": 0},
                {"time": "2018-01-13 07:35", "value": 12},
                {"time": "2018-01-13 07:36", "value": -11},
                {"time": "2018-01-13 07:37", "value": 5},
                {"time": "2018-01-13 07:38", "value": -4},
                {"time": "2018-01-13 07:39", "value": 4},
                {"time": "2018-01-13 07:40", "value": 1},
                {"time": "2018-01-13 07:41", "value": -3},
                {"time": "2018-01-13 07:42", "value": 4},
                {"time": "2018-01-13 07:43", "value": -1},
                {"time": "2018-01-13 07:44", "value": 0},
                {"time": "2018-01-13 07:45", "value": 1},
                {"time": "2018-01-13 07:46", "value": 1},
                {"time": "2018-01-13 07:47", "value": 0},
                {"time": "2018-01-13 07:48", "value": -5},
                {"time": "2018-01-13 07:49", "value": 8},
                {"time": "2018-01-13 07:50", "value": 7},
                {"time": "2018-01-13 07:51", "value": -1},
                {"time": "2018-01-13 07:52", "value": 10},
                {"time": "2018-01-13 07:53", "value": 10},
                {"time": "2018-01-13 07:54", "value": -10},
                {"time": "2018-01-13 07:55", "value": -6},
                {"time": "2018-01-13 07:56", "value": 0},
                {"time": "2018-01-13 07:57", "value": 2},
                {"time": "2018-01-13 07:58", "value": -10},
                {"time": "2018-01-13 07:59", "value": 0},
                {"time": "2018-01-13 08:00", "value": -12},
                {"time": "2018-01-13 08:01", "value": -1},
                {"time": "2018-01-13 08:02", "value": 0},
                {"time": "2018-01-13 08:03", "value": 0},
                {"time": "2018-01-13 08:04", "value": 0},
                {"time": "2018-01-13 08:05", "value": 0},
                {"time": "2018-01-13 08:06", "value": 0},
                {"time": "2018-01-13 08:07", "value": 0},
                {"time": "2018-01-13 08:08", "value": -47},
                {"time": "2018-01-13 08:09", "value": -48},
                {"time": "2018-01-13 08:10", "value": -54},
                {"time": "2018-01-13 08:11", "value": -60},
                {"time": "2018-01-13 08:12", "value": -44},
                {"time": "2018-01-13 08:13", "value": -55},
                {"time": "2018-01-13 08:14", "value": -56},
                {"time": "2018-01-13 08:15", "value": -62},
                {"time": "2018-01-13 08:16", "value": -62},
                {"time": "2018-01-13 08:17", "value": -58},
                {"time": "2018-01-13 08:18", "value": -56},
                {"time": "2018-01-13 08:19", "value": -63},
                {"time": "2018-01-13 08:20", "value": -58},
                {"time": "2018-01-13 08:21", "value": -63},
                {"time": "2018-01-13 08:22", "value": -62},
                {"time": "2018-01-13 08:23", "value": -77},
                {"time": "2018-01-13 08:24", "value": -69},
                {"time": "2018-01-13 08:25", "value": -62},
                {"time": "2018-01-13 08:26", "value": -68},
                {"time": "2018-01-13 08:27", "value": -68},
                {"time": "2018-01-13 08:28", "value": -63},
                {"time": "2018-01-13 08:29", "value": -55},
                {"time": "2018-01-13 08:30", "value": -54},
                {"time": "2018-01-13 08:31", "value": -58},
                {"time": "2018-01-13 08:32", "value": -61},
                {"time": "2018-01-13 08:33", "value": -64},
                {"time": "2018-01-13 08:34", "value": -53},
                {"time": "2018-01-13 08:35", "value": -52},
                {"time": "2018-01-13 08:36", "value": -47},
                {"time": "2018-01-13 08:37", "value": -55},
                {"time": "2018-01-13 08:38", "value": -48},
                {"time": "2018-01-13 08:39", "value": -47},
                {"time": "2018-01-13 08:40", "value": -32},
                {"time": "2018-01-13 08:41", "value": -42},
                {"time": "2018-01-13 08:42", "value": -41},
                {"time": "2018-01-13 08:43", "value": -34},
                {"time": "2018-01-13 08:44", "value": -40},
                {"time": "2018-01-13 08:45", "value": -49},
                {"time": "2018-01-13 08:46", "value": -38},
                {"time": "2018-01-13 08:47", "value": -33},
                {"time": "2018-01-13 08:48", "value": -39},
                {"time": "2018-01-13 08:49", "value": -28},
                {"time": "2018-01-13 08:50", "value": -38},
                {"time": "2018-01-13 08:51", "value": -39},
                {"time": "2018-01-13 08:52", "value": -35},
                {"time": "2018-01-13 08:53", "value": -30},
                {"time": "2018-01-13 08:54", "value": -13},
                {"time": "2018-01-13 08:55", "value": -15},
                {"time": "2018-01-13 08:56", "value": -17},
                {"time": "2018-01-13 08:57", "value": -17},
                {"time": "2018-01-13 08:58", "value": -14},
                {"time": "2018-01-13 08:59", "value": -5},
                {"time": "2018-01-13 09:00", "value": 13},
                {"time": "2018-01-13 09:01", "value": 48},
                {"time": "2018-01-13 09:02", "value": 33},
                {"time": "2018-01-13 09:03", "value": 32},
                {"time": "2018-01-13 09:04", "value": 22},
                {"time": "2018-01-13 09:05", "value": 38},
                {"time": "2018-01-13 09:06", "value": 9},
                {"time": "2018-01-13 09:07", "value": 28},
                {"time": "2018-01-13 09:08", "value": 21},
                {"time": "2018-01-13 09:09", "value": 32},
                {"time": "2018-01-13 09:10", "value": 16},
                {"time": "2018-01-13 09:11", "value": 22},
                {"time": "2018-01-13 09:12", "value": 17},
                {"time": "2018-01-13 09:13", "value": 32},
                {"time": "2018-01-13 09:14", "value": 12},
                {"time": "2018-01-13 09:15", "value": 11},
                {"time": "2018-01-13 09:16", "value": 18},
                {"time": "2018-01-13 09:17", "value": 19},
                {"time": "2018-01-13 09:18", "value": 15},
                {"time": "2018-01-13 09:19", "value": -7},
                {"time": "2018-01-13 09:20", "value": 6},
                {"time": "2018-01-13 09:21", "value": 7},
                {"time": "2018-01-13 09:22", "value": 13},
                {"time": "2018-01-13 09:23", "value": 14},
                {"time": "2018-01-13 09:24", "value": 11},
                {"time": "2018-01-13 09:25", "value": 15},
                {"time": "2018-01-13 09:26", "value": -5},
                {"time": "2018-01-13 09:27", "value": 6},
                {"time": "2018-01-13 09:28", "value": 10},
                {"time": "2018-01-13 09:29", "value": 24},
                {"time": "2018-01-13 09:30", "value": -11},
                {"time": "2018-01-13 09:31", "value": -8},
                {"time": "2018-01-13 09:32", "value": -13},
                {"time": "2018-01-13 09:33", "value": 3},
                {"time": "2018-01-13 09:34", "value": -1},
                {"time": "2018-01-13 09:35", "value": 6},
                {"time": "2018-01-13 09:36", "value": 7},
                {"time": "2018-01-13 09:37", "value": 7},
                {"time": "2018-01-13 09:38", "value": 8},
                {"time": "2018-01-13 09:39", "value": 10},
                {"time": "2018-01-13 09:40", "value": -12},
                {"time": "2018-01-13 09:41", "value": -6},
                {"time": "2018-01-13 09:42", "value": -10},
                {"time": "2018-01-13 09:43", "value": 2},
                {"time": "2018-01-13 09:44", "value": -6},
                {"time": "2018-01-13 09:45", "value": -5},
                {"time": "2018-01-13 09:46", "value": -9},
                {"time": "2018-01-13 09:47", "value": -12},
                {"time": "2018-01-13 09:48", "value": -6},
                {"time": "2018-01-13 09:49", "value": -10},
                {"time": "2018-01-13 09:50", "value": 2},
                {"time": "2018-01-13 09:51", "value": -6},
                {"time": "2018-01-13 09:52", "value": -5},
                {"time": "2018-01-13 09:53", "value": -9},
                {"time": "2018-01-13 09:54", "value": -12},
                {"time": "2018-01-13 09:55", "value": -6},
                {"time": "2018-01-13 09:56", "value": -16},
                {"time": "2018-01-13 09:57", "value": 2},
                {"time": "2018-01-13 09:58", "value": -6},
                {"time": "2018-01-13 09:59", "value": -5},
                {"time": "2018-01-13 10:00", "value": -20},
                {"time": "2018-01-13 10:01", "value": -12},
                {"time": "2018-01-13 10:02", "value": 8},
                {"time": "2018-01-13 10:03", "value": -10},
                {"time": "2018-01-13 10:04", "value": -20},
                {"time": "2018-01-13 10:05", "value": -6},
                {"time": "2018-01-13 10:06", "value": -5},
                {"time": "2018-01-13 10:07", "value": -9},
                {"time": "2018-01-13 10:08", "value": -5},
                {"time": "2018-01-13 10:09", "value": 9},
                {"time": "2018-01-13 10:10", "value": 2},
                {"time": "2018-01-13 10:11", "value": -8},
                {"time": "2018-01-13 10:12", "value": 10},
                {"time": "2018-01-13 10:13", "value": 4},
                {"time": "2018-01-13 10:14", "value": -1},
                {"time": "2018-01-13 10:15", "value": 3},
                {"time": "2018-01-13 10:16", "value": -5},
                {"time": "2018-01-13 10:17", "value": -1},
                {"time": "2018-01-13 10:18", "value": -4},
                {"time": "2018-01-13 10:19", "value": 0},
                {"time": "2018-01-13 10:20", "value": 4},
                {"time": "2018-01-13 10:21", "value": 5},
                {"time": "2018-01-13 10:22", "value": 6},
                {"time": "2018-01-13 10:23", "value": 20},
                {"time": "2018-01-13 10:24", "value": 12},
                {"time": "2018-01-13 10:25", "value": 8},
                {"time": "2018-01-13 10:26", "value": 3},
                {"time": "2018-01-13 10:27", "value": 2},
                {"time": "2018-01-13 10:28", "value": 0},
                {"time": "2018-01-13 10:29", "value": -3},
                {"time": "2018-01-13 10:30", "value": 0},
                {"time": "2018-01-13 10:31", "value": 4},
                {"time": "2018-01-13 10:32", "value": 5},
                {"time": "2018-01-13 10:33", "value": 3},
                {"time": "2018-01-13 10:34", "value": 13},
                {"time": "2018-01-13 10:35", "value": 16},
                {"time": "2018-01-13 10:36", "value": 12},
                {"time": "2018-01-13 10:37", "value": 11},
                {"time": "2018-01-13 10:38", "value": 3},
                {"time": "2018-01-13 10:39", "value": 13},
                {"time": "2018-01-13 10:40", "value": 16},
                {"time": "2018-01-13 10:41", "value": 12},
                {"time": "2018-01-13 10:42", "value": 11},
                {"time": "2018-01-13 10:43", "value": 3},
                {"time": "2018-01-13 10:44", "value": 13},
                {"time": "2018-01-13 10:45", "value": 22},
                {"time": "2018-01-13 10:46", "value": 18},
                {"time": "2018-01-13 10:47", "value": 22},
                {"time": "2018-01-13 10:48", "value": 3},
                {"time": "2018-01-13 10:49", "value": 13},
                {"time": "2018-01-13 10:50", "value": 6},
                {"time": "2018-01-13 10:51", "value": 12},
                {"time": "2018-01-13 10:52", "value": 11},
                {"time": "2018-01-13 10:53", "value": 3},
                {"time": "2018-01-13 10:54", "value": 24},
                {"time": "2018-01-13 10:55", "value": 2},
                {"time": "2018-01-13 10:56", "value": -1},
                {"time": "2018-01-13 10:57", "value": 2},
                {"time": "2018-01-13 10:58", "value": -10},
                {"time": "2018-01-13 10:59", "value": -5},
                {"time": "2018-01-13 11:00", "value": -11},
                {"time": "2018-01-13 11:01", "value": 4},
                {"time": "2018-01-13 11:02", "value": 0},
                {"time": "2018-01-13 11:03", "value": 5},
                {"time": "2018-01-13 11:04", "value": -4},
                {"time": "2018-01-13 11:05", "value": -19},
                {"time": "2018-01-13 11:06", "value": 4},
                {"time": "2018-01-13 11:07", "value": -1},
                {"time": "2018-01-13 11:08", "value": 3},
                {"time": "2018-01-13 11:09", "value": -5},
                {"time": "2018-01-13 11:10", "value": -3},
                {"time": "2018-01-13 11:11", "value": -10},
                {"time": "2018-01-13 11:12", "value": -8},
                {"time": "2018-01-13 11:13", "value": -10},
                {"time": "2018-01-13 11:14", "value": 2},
                {"time": "2018-01-13 11:15", "value": -10},
                {"time": "2018-01-13 11:16", "value": 14},
                {"time": "2018-01-13 11:17", "value": 16},
                {"time": "2018-01-13 11:18", "value": 8},
                {"time": "2018-01-13 11:19", "value": 12},
                {"time": "2018-01-13 11:20", "value": 6},
                {"time": "2018-01-13 11:21", "value": 17},
                {"time": "2018-01-13 11:22", "value": 14},
                {"time": "2018-01-13 11:23", "value": -15},
                {"time": "2018-01-13 11:24", "value": -14},
                {"time": "2018-01-13 11:25", "value": -8},
                {"time": "2018-01-13 11:26", "value": -6},
                {"time": "2018-01-13 11:27", "value": -3},
                {"time": "2018-01-13 11:28", "value": -16},
                {"time": "2018-01-13 11:29", "value": -8},
                {"time": "2018-01-13 11:30", "value": 10},
                {"time": "2018-01-13 11:31", "value": -8},
                {"time": "2018-01-13 11:32", "value": -6},
                {"time": "2018-01-13 11:33", "value": -3},
                {"time": "2018-01-13 11:34", "value": 0},
                {"time": "2018-01-13 11:35", "value": 4},
                {"time": "2018-01-13 11:36", "value": -11},
                {"time": "2018-01-13 11:37", "value": -8},
                {"time": "2018-01-13 11:38", "value": -3},
                {"time": "2018-01-13 11:39", "value": -2},
                {"time": "2018-01-13 11:40", "value": -15},
                {"time": "2018-01-13 11:41", "value": 9},
                {"time": "2018-01-13 11:42", "value": 0},
                {"time": "2018-01-13 11:43", "value": -1},
                {"time": "2018-01-13 11:44", "value": -5},
                {"time": "2018-01-13 11:45", "value": -1},
                {"time": "2018-01-13 11:46", "value": -7},
                {"time": "2018-01-13 11:47", "value": -4},
                {"time": "2018-01-13 11:48", "value": -7},
                {"time": "2018-01-13 11:49", "value": -8},
                {"time": "2018-01-13 11:50", "value": -7},
                {"time": "2018-01-13 11:51", "value": -6},
                {"time": "2018-01-13 11:52", "value": -5},
                {"time": "2018-01-13 11:53", "value": -6},
                {"time": "2018-01-13 11:54", "value": 1},
                {"time": "2018-01-13 11:55", "value": -3},
                {"time": "2018-01-13 11:56", "value": 10},
                {"time": "2018-01-13 11:57", "value": 15},
                {"time": "2018-01-13 11:58", "value": 0},
                {"time": "2018-01-13 11:59", "value": 0}];
        },
        usHeatMap: function () {
            am4core.ready(function () {

// Themes begin
                am4core.useTheme(am4themes_animated);
// Themes end

                // Create map instance
                var chart = am4core.create("usHeatMap", am4maps.MapChart);

// Set map definition
                chart.geodata = am4geodata_usaLow;

// Set projection
                chart.projection = new am4maps.projections.AlbersUsa();

// Create map polygon series
                var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());

//Set min/max fill color for each area
                polygonSeries.heatRules.push({
                    property: "fill",
                    target: polygonSeries.mapPolygons.template,
                    min: chart.colors.getIndex(1).brighten(1),
                    max: chart.colors.getIndex(1).brighten(-0.3)
                });

// Make map load polygon data (state shapes and names) from GeoJSON
                polygonSeries.useGeodata = true;

// Set heatmap values for each state
                polygonSeries.data = [
                    {
                        id: "US-AL",
                        value: 4447100
                    },
                    {
                        id: "US-AK",
                        value: 626932
                    },
                    {
                        id: "US-AZ",
                        value: 5130632
                    },
                    {
                        id: "US-AR",
                        value: 2673400
                    },
                    {
                        id: "US-CA",
                        value: 33871648
                    },
                    {
                        id: "US-CO",
                        value: 4301261
                    },
                    {
                        id: "US-CT",
                        value: 3405565
                    },
                    {
                        id: "US-DE",
                        value: 783600
                    },
                    {
                        id: "US-FL",
                        value: 15982378
                    },
                    {
                        id: "US-GA",
                        value: 8186453
                    },
                    {
                        id: "US-HI",
                        value: 1211537
                    },
                    {
                        id: "US-ID",
                        value: 1293953
                    },
                    {
                        id: "US-IL",
                        value: 12419293
                    },
                    {
                        id: "US-IN",
                        value: 6080485
                    },
                    {
                        id: "US-IA",
                        value: 2926324
                    },
                    {
                        id: "US-KS",
                        value: 2688418
                    },
                    {
                        id: "US-KY",
                        value: 4041769
                    },
                    {
                        id: "US-LA",
                        value: 4468976
                    },
                    {
                        id: "US-ME",
                        value: 1274923
                    },
                    {
                        id: "US-MD",
                        value: 5296486
                    },
                    {
                        id: "US-MA",
                        value: 6349097
                    },
                    {
                        id: "US-MI",
                        value: 9938444
                    },
                    {
                        id: "US-MN",
                        value: 4919479
                    },
                    {
                        id: "US-MS",
                        value: 2844658
                    },
                    {
                        id: "US-MO",
                        value: 5595211
                    },
                    {
                        id: "US-MT",
                        value: 902195
                    },
                    {
                        id: "US-NE",
                        value: 1711263
                    },
                    {
                        id: "US-NV",
                        value: 1998257
                    },
                    {
                        id: "US-NH",
                        value: 1235786
                    },
                    {
                        id: "US-NJ",
                        value: 8414350
                    },
                    {
                        id: "US-NM",
                        value: 1819046
                    },
                    {
                        id: "US-NY",
                        value: 18976457
                    },
                    {
                        id: "US-NC",
                        value: 8049313
                    },
                    {
                        id: "US-ND",
                        value: 642200
                    },
                    {
                        id: "US-OH",
                        value: 11353140
                    },
                    {
                        id: "US-OK",
                        value: 3450654
                    },
                    {
                        id: "US-OR",
                        value: 3421399
                    },
                    {
                        id: "US-PA",
                        value: 12281054
                    },
                    {
                        id: "US-RI",
                        value: 1048319
                    },
                    {
                        id: "US-SC",
                        value: 4012012
                    },
                    {
                        id: "US-SD",
                        value: 754844
                    },
                    {
                        id: "US-TN",
                        value: 5689283
                    },
                    {
                        id: "US-TX",
                        value: 20851820
                    },
                    {
                        id: "US-UT",
                        value: 2233169
                    },
                    {
                        id: "US-VT",
                        value: 608827
                    },
                    {
                        id: "US-VA",
                        value: 7078515
                    },
                    {
                        id: "US-WA",
                        value: 5894121
                    },
                    {
                        id: "US-WV",
                        value: 1808344
                    },
                    {
                        id: "US-WI",
                        value: 5363675
                    },
                    {
                        id: "US-WY",
                        value: 493782
                    }
                ];

// Set up heat legend
                let heatLegend = chart.createChild(am4maps.HeatLegend);
                heatLegend.series = polygonSeries;
                heatLegend.align = "right";
                heatLegend.valign = "bottom";
                heatLegend.width = am4core.percent(20);
                heatLegend.marginRight = am4core.percent(4);
                heatLegend.minValue = 0;
                heatLegend.maxValue = 40000000;

// Set up custom heat map legend labels using axis ranges
                var minRange = heatLegend.valueAxis.axisRanges.create();
                minRange.value = heatLegend.minValue;
                minRange.label.text = "Little";
                var maxRange = heatLegend.valueAxis.axisRanges.create();
                maxRange.value = heatLegend.maxValue;
                maxRange.label.text = "A lot!";

// Blank out internal heat legend value axis labels
                heatLegend.valueAxis.renderer.labels.template.adapter.add("text", function (labelText) {
                    return "";
                });

// Configure series tooltip
                var polygonTemplate = polygonSeries.mapPolygons.template;
                polygonTemplate.tooltipText = "{name}: {value}";
                polygonTemplate.nonScalingStroke = true;
                polygonTemplate.strokeWidth = 0.5;

// Create hover state and set alternative fill color
                var hs = polygonTemplate.states.create("hover");
                hs.properties.fill = am4core.color("#3c5bdc");

            }); // end am4core.ready()
        },
        flightRoutesMap: function () {
            am4core.ready(function () {

// Themes begin
                am4core.useTheme(am4themes_animated);
// Themes end

// Create map instance
                var chart = am4core.create("flightRoutesMap", am4maps.MapChart);

                var interfaceColors = new am4core.InterfaceColorSet();

// Set map definition
                chart.geodata = am4geodata_worldLow;

// Set projection
                chart.projection = new am4maps.projections.Mercator();

// Export
                chart.exporting.menu = new am4core.ExportMenu();

// Zoom control
                chart.zoomControl = new am4maps.ZoomControl();

// Data for general and map use
                var originCities = [
                    {
                        "id": "london",
                        "title": "London",
                        "destinations": ["vilnius", "reykjavik", "lisbon", "moscow", "belgrade", "ljublana", "madrid", "stockholm", "bern", "kiev", "new york"],
                        "latitude": 51.5002,
                        "longitude": -0.1262,
                        "scale": 1.5,
                        "zoomLevel": 2.74,
                        "zoomLongitude": -20.1341,
                        "zoomLatitude": 49.1712
                    },
                    {
                        "id": "vilnius",
                        "title": "Vilnius",
                        "destinations": ["london", "brussels", "prague", "athens", "dublin", "oslo", "moscow", "bratislava", "belgrade", "madrid"],
                        "latitude": 54.6896,
                        "longitude": 25.2799,
                        "scale": 1.5,
                        "zoomLevel": 4.92,
                        "zoomLongitude": 15.4492,
                        "zoomLatitude": 50.2631
                    }
                ];

                var destinationCities = [{
                        "id": "brussels",
                        "title": "Brussels",
                        "latitude": 50.8371,
                        "longitude": 4.3676
                    }, {
                        "id": "prague",
                        "title": "Prague",
                        "latitude": 50.0878,
                        "longitude": 14.4205
                    }, {
                        "id": "athens",
                        "title": "Athens",
                        "latitude": 37.9792,
                        "longitude": 23.7166
                    }, {
                        "id": "reykjavik",
                        "title": "Reykjavik",
                        "latitude": 64.1353,
                        "longitude": -21.8952
                    }, {
                        "id": "dublin",
                        "title": "Dublin",
                        "latitude": 53.3441,
                        "longitude": -6.2675
                    }, {
                        "id": "oslo",
                        "title": "Oslo",
                        "latitude": 59.9138,
                        "longitude": 10.7387
                    }, {
                        "id": "lisbon",
                        "title": "Lisbon",
                        "latitude": 38.7072,
                        "longitude": -9.1355
                    }, {
                        "id": "moscow",
                        "title": "Moscow",
                        "latitude": 55.7558,
                        "longitude": 37.6176
                    }, {
                        "id": "belgrade",
                        "title": "Belgrade",
                        "latitude": 44.8048,
                        "longitude": 20.4781
                    }, {
                        "id": "bratislava",
                        "title": "Bratislava",
                        "latitude": 48.2116,
                        "longitude": 17.1547
                    }, {
                        "id": "ljublana",
                        "title": "Ljubljana",
                        "latitude": 46.0514,
                        "longitude": 14.5060
                    }, {
                        "id": "madrid",
                        "title": "Madrid",
                        "latitude": 40.4167,
                        "longitude": -3.7033
                    }, {
                        "id": "stockholm",
                        "title": "Stockholm",
                        "latitude": 59.3328,
                        "longitude": 18.0645
                    }, {
                        "id": "bern",
                        "title": "Bern",
                        "latitude": 46.9480,
                        "longitude": 7.4481
                    }, {
                        "id": "kiev",
                        "title": "Kiev",
                        "latitude": 50.4422,
                        "longitude": 30.5367
                    }, {
                        "id": "paris",
                        "title": "Paris",
                        "latitude": 48.8567,
                        "longitude": 2.3510
                    }, {
                        "id": "new york",
                        "title": "New York",
                        "latitude": 40.43,
                        "longitude": -74
                    }];

// Default to London view
//chart.homeGeoPoint = { "longitude": originCities[0].zoomLongitude, "latitude": originCities[0].zoomLatitude };
//chart.homeZoomLevel = originCities[0].zoomLevel;

                var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";
                var planeSVG = "m2,106h28l24,30h72l-44,-133h35l80,132h98c21,0 21,34 0,34l-98,0 -80,134h-35l43,-133h-71l-24,30h-28l15,-47";

// Texts
                var labelsContainer = chart.createChild(am4core.Container);
                labelsContainer.isMeasured = false;
                labelsContainer.x = 80;
                labelsContainer.y = 27;
                labelsContainer.layout = "horizontal";
                labelsContainer.zIndex = 10;

                var plane = labelsContainer.createChild(am4core.Sprite);
                plane.scale = 0.15;
                plane.path = planeSVG;
                plane.fill = am4core.color("#cc0000");

                var title = labelsContainer.createChild(am4core.Label);
                title.text = "Flights from London";
                title.fill = am4core.color("#cc0000");
                title.fontSize = 20;
                title.valign = "middle";
                title.dy = 2;
                title.marginLeft = 15;

                var changeLink = chart.createChild(am4core.TextLink);
                changeLink.text = "Click to change origin city";
                changeLink.isMeasured = false;

                changeLink.events.on("hit", function () {
                    if (currentOrigin == originImageSeries.dataItems.getIndex(0)) {
                        showLines(originImageSeries.dataItems.getIndex(1));
                    } else {
                        showLines(originImageSeries.dataItems.getIndex(0));
                    }
                })

                changeLink.x = 142;
                changeLink.y = 72;
                changeLink.fontSize = 13;


// The world
                var worldPolygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
                worldPolygonSeries.useGeodata = true;
                worldPolygonSeries.fillOpacity = 0.6;
                worldPolygonSeries.exclude = ["AQ"];

// Origin series (big targets, London and Vilnius)
                var originImageSeries = chart.series.push(new am4maps.MapImageSeries());

                var originImageTemplate = originImageSeries.mapImages.template;

                originImageTemplate.propertyFields.latitude = "latitude";
                originImageTemplate.propertyFields.longitude = "longitude";
                originImageTemplate.propertyFields.id = "id";

                originImageTemplate.cursorOverStyle = am4core.MouseCursorStyle.pointer;
                originImageTemplate.nonScaling = true;
                originImageTemplate.tooltipText = "{title}";

                originImageTemplate.setStateOnChildren = true;
                originImageTemplate.states.create("hover");

                originImageTemplate.horizontalCenter = "middle";
                originImageTemplate.verticalCenter = "middle";

                var originHitCircle = originImageTemplate.createChild(am4core.Circle);
                originHitCircle.radius = 11;
                originHitCircle.fill = interfaceColors.getFor("background");

                var originTargetIcon = originImageTemplate.createChild(am4core.Sprite);
                originTargetIcon.fill = interfaceColors.getFor("alternativeBackground");
                originTargetIcon.strokeWidth = 0;
                originTargetIcon.scale = 1.3;
                originTargetIcon.horizontalCenter = "middle";
                originTargetIcon.verticalCenter = "middle";
                originTargetIcon.path = targetSVG;

                var originHoverState = originTargetIcon.states.create("hover");
                originHoverState.properties.fill = chart.colors.getIndex(1);

// when hit on city, change lines
                originImageTemplate.events.on("hit", function (event) {
                    showLines(event.target.dataItem);
                })

// destination series (small targets)
                var destinationImageSeries = chart.series.push(new am4maps.MapImageSeries());
                var destinationImageTemplate = destinationImageSeries.mapImages.template;

                destinationImageTemplate.nonScaling = true;
                destinationImageTemplate.tooltipText = "{title}";
                destinationImageTemplate.fill = interfaceColors.getFor("alternativeBackground");
                destinationImageTemplate.setStateOnChildren = true;
                destinationImageTemplate.states.create("hover");

                destinationImageTemplate.propertyFields.latitude = "latitude";
                destinationImageTemplate.propertyFields.longitude = "longitude";
                destinationImageTemplate.propertyFields.id = "id";

                var destinationHitCircle = destinationImageTemplate.createChild(am4core.Circle);
                destinationHitCircle.radius = 7;
                destinationHitCircle.fillOpacity = 1;
                destinationHitCircle.fill = interfaceColors.getFor("background");

                var destinationTargetIcon = destinationImageTemplate.createChild(am4core.Sprite);
                destinationTargetIcon.scale = 0.7;
                destinationTargetIcon.path = targetSVG;
                destinationTargetIcon.horizontalCenter = "middle";
                destinationTargetIcon.verticalCenter = "middle";

                originImageSeries.data = originCities;
                destinationImageSeries.data = destinationCities;

// Line series
                var lineSeries = chart.series.push(new am4maps.MapLineSeries());
                lineSeries.mapLines.template.line.strokeOpacity = 0.5;

                chart.events.on("ready", function () {
                    showLines(originImageSeries.dataItems.getIndex(0));
                })


                var currentOrigin;

                function showLines(origin) {

                    var dataContext = origin.dataContext;
                    var destinations = dataContext.destinations;
                    // clear old
                    lineSeries.mapLines.clear();
                    lineSeries.toBack();
                    worldPolygonSeries.toBack();

                    currentOrigin = origin;

                    if (destinations) {
                        for (var i = 0; i < destinations.length; i++) {
                            var line = lineSeries.mapLines.create();
                            line.imagesToConnect = [origin.mapImage.id, destinations[i]];
                        }
                    }

                    title.text = "Flights from " + dataContext.title;

                    chart.zoomToGeoPoint({latitude: dataContext.zoomLatitude, longitude: dataContext.zoomLongitude}, dataContext.zoomLevel, true);
                }

                var graticuleSeries = chart.series.push(new am4maps.GraticuleSeries());
                graticuleSeries.mapLines.template.line.strokeOpacity = 0.05;


            }); // end am4core.ready()
        },
        locationSensitiveMap: function () {
            am4core.ready(function () {

// Themes begin
                am4core.useTheme(am4themes_animated);
// Themes end


                var countryCodes = ["AF", "AO", "AR", "AM", "AU", "AT", "AZ", "BD", "BY", "BE", "BO", "BA", "BW", "BR", "BG", "KH", "CM", "CA", "CF", "TD", "CL", "CN", "CO", "CG", "CD", "CR", "CI", "HR", "CU", "CY", "CZ", "DK", "EC", "EG", "ER", "EE", "ET", "FI", "FR", "GE", "DE", "GR", "GL", "GP", "GT", "GN", "GW", "GY", "HT", "HN", "HU", "IS", "IN", "ID", "IR", "IQ", "IE", "IL", "IT", "JM", "JP", "JO", "KZ", "KE", "KP", "KR", "KG", "LA", "LV", "LB", "LS", "LR", "LY", "LT", "LU", "MK", "MG", "MY", "ML", "MT", "MR", "MX", "MD", "MN", "ME", "MA", "MZ", "MM", "NA", "NP", "NL", "NZ", "NI", "NE", "NG", "NO", "OM", "PK", "PA", "PG", "PY", "PE", "PH", "PL", "PT", "RO", "RU", "SA", "SN", "RS", "SK", "SI", "SO", "ZA", "SS", "ES", "SD", "SE", "CH", "SY", "TW", "TJ", "TZ", "TH", "TN", "TR", "TM", "UA", "AE", "GB", "US", "UY", "UZ", "VE", "VN", "YE", "ZM", "ZW"];

                var chart = am4core.create("countryMorphing", am4maps.MapChart);


                try {
                    chart.geodata = am4geodata_worldHigh;
                } catch (e) {
                    chart.raiseCriticalError(new Error("Map geodata could not be loaded. Please download the latest <a href=\"https://www.amcharts.com/download/download-v4/\">amcharts geodata</a> and extract its contents into the same directory as your amCharts files."));
                }

                chart.projection = new am4maps.projections.Mercator();
                chart.padding(10, 20, 10, 20);
                chart.minZoomLevel = 0.9;
                chart.zoomLevel = 0.9;
                chart.maxZoomLevel = 1;

                var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
                polygonSeries.useGeodata = true;
                polygonSeries.include = ["AF"];


                var chart1 = am4core.create("hiddenchartdiv", am4maps.MapChart);
                chart1.padding(10, 20, 10, 20);
                chart1.geodata = am4geodata_worldHigh;
                chart1.projection = new am4maps.projections.Mercator();

                var polygonSeries1 = chart1.series.push(new am4maps.MapPolygonSeries());
                polygonSeries1.useGeodata = true;
                polygonSeries1.include = ["AF"];


                var label = chart.chartContainer.createChild(am4core.Label);
                label.x = 100;
                label.y = 100;
                label.fill = am4core.color("#000000");
                label.fontSize = 35;
                label.fontWeight = "bold";
                label.text = "Afghanistan";
                label.fillOpacity = 0.2;

                var slider = chart.createChild(am4core.Slider);
                slider.padding(0, 15, 0, 60);
                slider.background.padding(0, 15, 0, 60);
                slider.marginBottom = 15;
                slider.valign = "bottom";

                var currentIndex = -1;
                var colorset = new am4core.ColorSet();

                setInterval(function () {
                    var next = slider.start + 1 / countryCodes.length;
                    if (next >= 1) {
                        next = 0;
                    }
                    slider.animate({property: "start", to: next}, 300);
                }, 2000)

                slider.events.on("rangechanged", function () {
                    changeCountry();
                })

                function changeCountry() {
                    var totalCountries = countryCodes.length - 1;
                    var countryIndex = Math.round(totalCountries * slider.start);

                    var morphToPolygon;

                    if (currentIndex != countryIndex) {
                        polygonSeries1.data = [];
                        polygonSeries1.include = [countryCodes[countryIndex]];

                        currentIndex = countryIndex;

                        polygonSeries1.events.once("validated", function () {

                            morphToPolygon = polygonSeries1.mapPolygons.getIndex(0);
                            if (morphToPolygon) {
                                var countryPolygon = polygonSeries.mapPolygons.getIndex(0);

                                var morpher = countryPolygon.polygon.morpher;
                                var morphAnimation = morpher.morphToPolygon(morphToPolygon.polygon.points);

                                var colorAnimation = countryPolygon.animate({"property": "fill", "to": colorset.getIndex(Math.round(Math.random() * 20))}, 1000);

                                var animation = label.animate({property: "y", to: 1000}, 300);

                                animation.events.once("animationended", function () {
                                    label.text = morphToPolygon.dataItem.dataContext["name"];
                                    label.y = -50;
                                    label.animate({property: "y", to: 200}, 300, am4core.ease.quadOut);
                                })
                            }
                        })
                    }
                }


            }); // end am4core.ready()
        },
    };
    // Initialize
    $(document).ready(function () {
        "use strict"; // Start of use strict
        amChartsMaps.initialize();
    });
}(jQuery));