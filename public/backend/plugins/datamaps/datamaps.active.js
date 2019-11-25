$(document).ready(function () {
    "use strict"; // Start of use strict
    //basic data map
    var map = new Datamap({
        element: document.getElementById('map2'),
        fills: {
            defaultFill: '#6786ac' // Any hex, color name or rgb/rgba value
        }
    });

    //Choropleth with auto-calculated color
    // example data from server
    var series = [
        ["BLR", 75], ["BLZ", 43], ["RUS", 50], ["RWA", 88], ["SRB", 21], ["TLS", 43],
        ["REU", 21], ["TKM", 19], ["TJK", 60], ["ROU", 4], ["TKL", 44], ["GNB", 38],
        ["GUM", 67], ["GTM", 2], ["SGS", 95], ["GRC", 60], ["GNQ", 57], ["GLP", 53],
        ["JPN", 59], ["GUY", 24], ["GGY", 4], ["GUF", 21], ["GEO", 42], ["GRD", 65],
        ["GBR", 14], ["GAB", 47], ["SLV", 15], ["GIN", 19], ["GMB", 63], ["GRL", 56],
        ["ERI", 57], ["MNE", 93], ["MDA", 39], ["MDG", 71], ["MAF", 16], ["MAR", 8],
        ["MCO", 25], ["UZB", 81], ["MMR", 21], ["MLI", 95], ["MAC", 33], ["MNG", 93],
        ["MHL", 15], ["MKD", 52], ["MUS", 19], ["MLT", 69], ["MWI", 37], ["MDV", 44],
        ["MTQ", 13], ["MNP", 21], ["MSR", 89], ["MRT", 20], ["IMN", 72], ["UGA", 59],
        ["TZA", 62], ["MYS", 75], ["MEX", 80], ["ISR", 77], ["FRA", 54], ["IOT", 56],
        ["SHN", 91], ["FIN", 51], ["FJI", 22], ["FLK", 4], ["FSM", 69], ["FRO", 70],
        ["NIC", 66], ["NLD", 53], ["NOR", 7], ["NAM", 63], ["VUT", 15], ["NCL", 66],
        ["NER", 34], ["NFK", 33], ["NGA", 45], ["NZL", 96], ["NPL", 21], ["NRU", 13],
        ["NIU", 6], ["COK", 19], ["XKX", 32], ["CIV", 27], ["CHE", 65], ["COL", 64],
        ["CHN", 16], ["CMR", 70], ["CHL", 15], ["CCK", 85], ["CAN", 76], ["COG", 20],
        ["CAF", 93], ["COD", 36], ["CZE", 77], ["CYP", 65], ["CXR", 14], ["CRI", 31],
        ["CUW", 67], ["CPV", 63], ["CUB", 40], ["SWZ", 58], ["SYR", 96], ["SXM", 31]];
    // Datamaps expect data in format:
    // { "USA": { "fillColor": "#42a844", numberOfWhatever: 75},
    //   "FRA": { "fillColor": "#8dc386", numberOfWhatever: 43 } }
    var dataset = {};
    // We need to colorize every country based on "numberOfWhatever"
    // colors should be uniq for every value.
    // For this purpose we create palette(using min/max series-value)
    var onlyValues = series.map(function (obj) {
        return obj[1];
    });
    var minValue = Math.min.apply(null, onlyValues),
            maxValue = Math.max.apply(null, onlyValues);
    // create color palette function
    // color can be whatever you wish
    var paletteScale = d3.scale.linear()
            .domain([minValue, maxValue])
            .range(["#EFEFFF", "#02386F"]); // blue color
    // fill dataset in appropriate format
    series.forEach(function (item) { //
        // item example value ["USA", 70]
        var iso = item[0],
                value = item[1];
        dataset[iso] = {numberOfThings: value, fillColor: paletteScale(value)};
    });
    // render map
    new Datamap({
        element: document.getElementById('map3'),
        projection: 'mercator', // big world map
        // countries don't listed in dataset will be painted with this color
        fills: {defaultFill: '#F5F5F5'},
        data: dataset,
        geographyConfig: {
            borderColor: '#DEDEDE',
            highlightBorderWidth: 2,
            // don't change color on mouse hover
            highlightFillColor: function (geo) {
                return geo['fillColor'] || '#F5F5F5';
            },
            // only change border
            highlightBorderColor: '#B7B7B7',
            // show desired information in tooltip
            popupTemplate: function (geo, data) {
                // don't show tooltip if country don't present in dataset
                if (!data) {
                    return;
                }
                // tooltip content
                return ['<div class="hoverinfo">',
                    '<strong>', geo.properties.name, '</strong>',
                    '<br>Count: <strong>', data.numberOfThings, '</strong>',
                    '</div>'].join('');
            }
        }
    });

    //Choropleth
    var basic_choropleth = new Datamap({
        element: document.getElementById("map4"),
        projection: 'mercator',
        fills: {
            defaultFill: "#EFEFFF",
            authorHasTraveledTo: "#fa0fa0"
        },
        data: {
            USA: {fillKey: "authorHasTraveledTo"},
            JPN: {fillKey: "authorHasTraveledTo"},
            ITA: {fillKey: "authorHasTraveledTo"},
            CRI: {fillKey: "authorHasTraveledTo"},
            KOR: {fillKey: "authorHasTraveledTo"},
            DEU: {fillKey: "authorHasTraveledTo"}
        }
    });

    var colors = d3.scale.category10();

    window.setInterval(function () {
        basic_choropleth.updateChoropleth({
            USA: colors(Math.random() * 10),
            RUS: colors(Math.random() * 100),
            AUS: {fillKey: 'authorHasTraveledTo'},
            BRA: colors(Math.random() * 50),
            CAN: colors(Math.random() * 50),
            ZAF: colors(Math.random() * 50),
            IND: colors(Math.random() * 50)
        });
    }, 2000);

    //State Labels
    var election = new Datamap({
        scope: 'usa',
        element: document.getElementById('map5'),
        geographyConfig: {
            highlightBorderColor: '#bada55',
            popupTemplate: function (geography, data) {
                return '<div class="hoverinfo">' + geography.properties.name +
                        Electoral;
                Votes:' +  data.electoralVotes + ';
            },
            highlightBorderWidth: 3
        },
        fills: {
            'Republican': '#CC4731',
            'Democrat': '#306596',
            'Heavy Democrat': '#667FAF',
            'Light Democrat': '#A9C0DE',
            'Heavy Republican': '#CA5E5B',
            'Light Republican': '#EAA9A8',
            defaultFill: '#EDDC4E'
        },
        data: {
            "AZ": {
                "fillKey": "Republican",
                "electoralVotes": 5
            },
            "CO": {
                "fillKey": "Light Democrat",
                "electoralVotes": 5
            },
            "DE": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "FL": {
                "fillKey": "UNDECIDED",
                "electoralVotes": 29
            },
            "GA": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "HI": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "ID": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "IL": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "IN": {
                "fillKey": "Republican",
                "electoralVotes": 11
            },
            "IA": {
                "fillKey": "Light Democrat",
                "electoralVotes": 11
            },
            "KS": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "KY": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "LA": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "MD": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "ME": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "MA": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "MN": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "MI": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "MS": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "MO": {
                "fillKey": "Republican",
                "electoralVotes": 13
            },
            "MT": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "NC": {
                "fillKey": "Light Republican",
                "electoralVotes": 32
            },
            "NE": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "NV": {
                "fillKey": "Heavy Democrat",
                "electoralVotes": 32
            },
            "NH": {
                "fillKey": "Light Democrat",
                "electoralVotes": 32
            },
            "NJ": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "NY": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "ND": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "NM": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "OH": {
                "fillKey": "UNDECIDED",
                "electoralVotes": 32
            },
            "OK": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "OR": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "PA": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "RI": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "SC": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "SD": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "TN": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "TX": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "UT": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "WI": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "VA": {
                "fillKey": "Light Democrat",
                "electoralVotes": 32
            },
            "VT": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "WA": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "WV": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "WY": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "CA": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "CT": {
                "fillKey": "Democrat",
                "electoralVotes": 32
            },
            "AK": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "AR": {
                "fillKey": "Republican",
                "electoralVotes": 32
            },
            "AL": {
                "fillKey": "Republican",
                "electoralVotes": 32
            }
        }
    });
    election.labels();

    //Projections & Graticules
    var map = new Datamap({
        scope: 'world',
        element: document.getElementById('map6'),
        projection: 'orthographic',
        fills: {
            defaultFill: "#EFEFFF",
            gt50: colors(Math.random() * 20),
            eq50: colors(Math.random() * 20),
            lt25: colors(Math.random() * 10),
            gt75: colors(Math.random() * 200),
            lt50: colors(Math.random() * 20),
            eq0: colors(Math.random() * 1),
            pink: '#0fa0fa',
            gt500: colors(Math.random() * 1)
        },
        projectionConfig: {
            rotation: [97, -30]
        },
        data: {
            'USA': {fillKey: 'lt50'},
            'MEX': {fillKey: 'lt25'},
            'CAN': {fillKey: 'gt50'},
            'GTM': {fillKey: 'gt500'},
            'HND': {fillKey: 'eq50'},
            'BLZ': {fillKey: 'pink'},
            'GRL': {fillKey: 'eq0'}
        }
    });

    map.graticule();

    map.arc([{
            origin: {
                latitude: 61,
                longitude: -149
            },
            destination: {
                latitude: -22,
                longitude: -43
            }
        }], {
        greatArc: true,
        animationSpeed: 2000
    });
    //Arcs
    var arcs = new Datamap({
        element: document.getElementById("map7"),
        scope: 'usa',
        fills: {
            defaultFill: "#6786ac",
            win: '#02386F'
        },
        data: {
            'TX': {fillKey: 'win'},
            'FL': {fillKey: 'win'},
            'NC': {fillKey: 'win'},
            'CA': {fillKey: 'win'},
            'NY': {fillKey: 'win'},
            'CO': {fillKey: 'win'}
        }
    });

    // Arcs coordinates can be specified explicitly with latitude/longtitude,
    // or just the geographic center of the state/country.
    arcs.arc([
        {
            origin: 'CA',
            destination: 'TX'
        },
        {
            origin: 'OR',
            destination: 'TX'
        },
        {
            origin: 'NY',
            destination: 'TX'
        },
        {
            origin: {
                latitude: 40.639722,
                longitude: -73.778889
            },
            destination: {
                latitude: 37.618889,
                longitude: -122.375
            }
        },
        {
            origin: {
                latitude: 30.194444,
                longitude: -97.67
            },
            destination: {
                latitude: 25.793333,
                longitude: -80.290556
            },
            options: {
                strokeWidth: 2,
                strokeColor: 'rgba(100, 10, 200, 0.4)',
                greatArc: true
            }
        },
        {
            origin: {
                latitude: 39.861667,
                longitude: -104.673056
            },
            destination: {
                latitude: 35.877778,
                longitude: -78.7875
            }
        }
    ], {strokeWidth: 1, arcSharpness: 1.4});
});