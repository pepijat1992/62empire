$(document).ready(function () {
    "use strict"; // Start of use strict

    //  World Map
    $('.world-map-markers').vectorMap({
        map: 'world_mill_en',
        scaleColors: ['#4bd396', '#4bd396'],
        normalizeFunction: 'polynomial',
        hoverOpacity: 0.7,
        hoverColor: false,
        regionStyle: {
            initial: {
                fill: '#5b69bc'
            }
        },
        markerStyle: {
            initial: {
                r: 9,
                'fill': '#E5343D',
                'fill-opacity': 0.9,
                'stroke': '#fff',
                'stroke-width': 7,
                'stroke-opacity': 0.4
            },
            hover: {
                'stroke': '#fff',
                'fill-opacity': 1,
                'stroke-width': 1.5
            }
        },
        backgroundColor: 'transparent',
        markers: [{
                latLng: [48.019573, 66.923684],
                name: 'kazakistan'
            }, {
                latLng: [56.130366, -106.346771],
                name: 'Canada'
            }, {
                latLng: [-0.52, 166.93],
                name: 'Nauru'
            }, {
                latLng: [43.93, 12.46],
                name: 'San Marino'
            }, {
                latLng: [47.14, 9.52],
                name: 'Liechtenstein'
            }, {
                latLng: [7.11, 171.06],
                name: 'Marshall Islands'
            }, {
                latLng: [20.593684, 78.962880],
                name: 'India'
            }, {
                latLng: [3.2, 73.22],
                name: 'Maldives'
            }, {
                latLng: [35.88, 14.5],
                name: 'Malta'
            }, {
                latLng: [12.05, -61.75],
                name: 'Grenada'
            }, {
                latLng: [13.16, -61.23],
                name: 'Saint Vincent and the Grenadines'
            }, {
                latLng: [13.16, -59.55],
                name: 'Barbados'
            }, {
                latLng: [17.11, -61.85],
                name: 'Antigua and Barbuda'
            }, {
                latLng: [-4.61, 55.45],
                name: 'Seychelles'
            }, {
                latLng: [7.35, 134.46],
                name: 'Palau'
            }, {
                latLng: [42.5, 1.51],
                name: 'Andorra'
            }, {
                latLng: [14.01, -60.98],
                name: 'Saint Lucia'
            }, {
                latLng: [6.91, 158.18],
                name: 'Federated States of Micronesia'
            }, {
                latLng: [1.3, 103.8],
                name: 'Singapore'
            }, {
                latLng: [35.861660, 104.195397],
                name: 'Chin'
            }, {
                latLng: [23.810332, 90.412518],
                name: 'Dhaka'
            }, {
                latLng: [15.3, -61.38],
                name: 'Dominica'
            }, {
                latLng: [-20.2, 57.5],
                name: 'Mauritius'
            }, {
                latLng: [26.02, 50.55],
                name: 'Bahrain'
            }, {
                latLng: [0.33, 6.73],
                name: 'SÃ£o TomÃ© and PrÃ­ncipe'
            }]
    });

    // Asia Map
    $('.asia').vectorMap({
        map: 'asia_mill',
        backgroundColor: 'transparent',
        regionStyle: {
            initial: {
                fill: '#558B2F'
            }
        }
    });

    // India Map
    $('.india').vectorMap({
        map: 'in_mill',
        backgroundColor: 'transparent',
        regionStyle: {
            initial: {
                fill: '#EF6C00'
            }
        }
    });
    // UK Map
    $('.uk').vectorMap({
        map: 'uk_countries_mill',
        backgroundColor: 'transparent',
        regionStyle: {
            initial: {
                fill: '#FFB61E'
            }
        }
    });
    // USA Map
    $('.usa').vectorMap({
        map: 'us_aea',
        backgroundColor: 'transparent',
        regionStyle: {
            initial: {
                fill: '#E5343D'
            }
        }
    });
    // Australia Map
    $('.australia').vectorMap({
        map: 'au_mill',
        backgroundColor: 'transparent',
        regionStyle: {
            initial: {
                fill: '#5b69bc'
            }
        }
    });
    // Europe Map
    $('.europe').vectorMap({
        map: 'europe_mill',
        backgroundColor: 'transparent',
        regionStyle: {
            initial: {
                fill: '#EF6C00'
            }
        }
    });

});