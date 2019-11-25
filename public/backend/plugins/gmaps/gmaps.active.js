$(document).ready(function () {
  
    var map;

    //GMaps.js — Basic
    map = new GMaps({
        el: '#gmaps1',
        lat: -12.043333,
        lng: -77.028333,
        zoomControl: true,
        zoomControlOpt: {
            style: 'SMALL',
            position: 'TOP_LEFT'
        },
        panControl: false,
        streetViewControl: false,
        mapTypeControl: false,
        overviewMapControl: false
    });

    //GMaps.js — Context menu
    map = new GMaps({
        el: '#gmaps2',
        lat: -12.043333,
        lng: -77.028333
    });
    map.setContextMenu({
        control: 'gmaps2',
        options: [{
                title: 'Add marker',
                name: 'add_marker',
                action: function (e) {
                    console.log(e.latLng.lat());
                    console.log(e.latLng.lng());
                    this.addMarker({
                        lat: e.latLng.lat(),
                        lng: e.latLng.lng(),
                        title: 'New marker'
                    });
                    this.hideContextMenu();
                }
            }, {
                title: 'Center here',
                name: 'center_here',
                action: function (e) {
                    this.setCenter(e.latLng.lat(), e.latLng.lng());
                }
            }]
    });
    map.setContextMenu({
        control: 'marker',
        options: [{
                title: 'Center here',
                name: 'center_here',
                action: function (e) {
                    this.setCenter(e.latLng.lat(), e.latLng.lng());
                }
            }]
    });

    //GMaps.js — Geofences
    map = new GMaps({
        el: '#gmaps3',
        lat: -12.043333,
        lng: -77.028333
    });
    var path = [
        [-12.040397656836609, -77.03373871559225],
        [-12.040248585302038, -77.03993927003302],
        [-12.050047116528843, -77.02448169303511],
        [-12.044804866577001, -77.02154422636042]
    ];

    polygon = map.drawPolygon({
        paths: path,
        strokeColor: '#BBD8E9',
        strokeOpacity: 1,
        strokeWeight: 3,
        fillColor: '#BBD8E9',
        fillOpacity: 0.6
    });

    var circle = map.drawCircle({
        lat: -12.040504866577001,
        lng: -77.02024422636042,
        radius: 350,
        strokeColor: '#432070',
        strokeOpacity: 1,
        strokeWeight: 3,
        fillColor: '#432070',
        fillOpacity: 0.6
    });

    map.addMarker({
        lat: -12.043333,
        lng: -77.028333,
        draggable: true,
        fences: [polygon],
        outside: function (m, f) {
            alert('This marker has been moved outside of its fence');
        }
    });

    map.addMarker({
        lat: -12.040504866577001,
        lng: -77.02024422636042,
        draggable: true,
        fences: [circle],
        outside: function (m, f) {
            alert('This marker has been moved outside of its fence');
        }
    });

    //GMaps.js — KML layers
    infoWindow = new google.maps.InfoWindow({});
    map = new GMaps({
        el: '#gmaps4',
        zoom: 12,
        lat: 40.65,
        lng: -73.95
    });
    map.loadFromKML({
        url: 'http://api.flickr.com/services/feeds/geo/?g=322338@N20&lang=en-us&format=feed-georss',
        suppressInfoWindows: true,
        events: {
            click: function (point) {
                infoWindow.setContent(point.featureData.infoWindowHtml);
                infoWindow.setPosition(point.latLng);
                infoWindow.open(map.map);
            }
        }
    });



    // GMaps.js — Overlay Map Types

    var getTile = function (coord, zoom, ownerDocument) {
        var div = ownerDocument.createElement('div');
        div.innerHTML = coord;
        div.style.width = this.tileSize.width + 'px';
        div.style.height = this.tileSize.height + 'px';
        div.style.background = 'rgba(250, 250, 250, 0.55)';
        div.style.fontFamily = 'Monaco, Andale Mono, Courier New, monospace';
        div.style.fontSize = '10';
        div.style.fontWeight = 'bolder';
        div.style.border = 'dotted 1px #aaa';
        div.style.textAlign = 'center';
        div.style.lineHeight = this.tileSize.height + 'px';
        return div;
    };


    map = new GMaps({
        el: '#gmaps5',
        lat: -12.043333,
        lng: -77.028333
    });
    map.addOverlayMapType({
        index: 0,
        tileSize: new google.maps.Size(256, 256),
        getTile: getTile
    });


    //GMaps.js — Fusion Tables layers
    infoWindow = new google.maps.InfoWindow({});
    map = new GMaps({
        el: '#gmaps6',
        zoom: 11,
        lat: 41.850033,
        lng: -87.6500523
    });
    map.loadFromFusionTables({
        query: {
            select: '\'Geocodable address\'',
            from: '1mZ53Z70NsChnBMm-qEYmSDOvLXgrreLTkQUvvg'
        },
        suppressInfoWindows: true,
        events: {
            click: function (point) {
                infoWindow.setContent('You clicked here!');
                infoWindow.setPosition(point.latLng);
                infoWindow.open(map.map);
            }
        }
    });


    //GMaps.js style extension - Styled Maps

    $(function () {
        var map = new GMaps({
            el: "#gmaps7",
            lat: 23.684994,
            lng: 90.356331,
            zoom: 5,
            zoomControl: true,
            zoomControlOpt: {
                style: "SMALL",
                position: "TOP_LEFT"
            },
            panControl: true,
            streetViewControl: false,
            mapTypeControl: false,
            overviewMapControl: false
        });

        var styles = [
            {
                stylers: [
                    {hue: "#00ffe6"},
                    {saturation: -20}
                ]
            }, {
                featureType: "road",
                elementType: "geometry",
                stylers: [
                    {lightness: 100},
                    {visibility: "simplified"}
                ]
            }, {
                featureType: "road",
                elementType: "labels",
                stylers: [
                    {visibility: "off"}
                ]
            }
        ];

        map.addStyle({
            styledMapName: "Styled Map",
            styles: styles,
            mapTypeId: "map_style"
        });

        map.setStyle("map_style");
    });

    //GMaps.js — Map Types
    map = new GMaps({
        el: '#gmaps8',
        lat: -12.043333,
        lng: -77.028333,
        mapTypeControlOptions: {
            mapTypeIds: ["hybrid", "roadmap", "satellite", "terrain", "osm", "cloudmade"]
        }
    });
    map.addMapType("osm", {
        getTileUrl: function (coord, zoom) {
            return "http://tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
        },
        tileSize: new google.maps.Size(256, 256),
        name: "OpenStreetMap",
        maxZoom: 18
    });
    map.addMapType("cloudmade", {
        getTileUrl: function (coord, zoom) {
            return "http://b.tile.cloudmade.com/8ee2a50541944fb9bcedded5165f09d9/1/256/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
        },
        tileSize: new google.maps.Size(256, 256),
        name: "CloudMade",
        maxZoom: 18
    });
    map.setMapTypeId("osm");

});