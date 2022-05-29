/////////////////FONCTIONS///////////////////
function directionApiTest(firstPoint,secondPoint){
    if(intineraire != null){
        map.removeLayer(intineraire);
    }

    if(firstPoint != null && secondPoint == null){
        console.log('Départ uniquement initialisé');
        return;
    }else if(firstPoint == null && secondPoint != null){
        console.log('Arrivée uniquement initialisé');
        return;
    }else{
        var geometries = 'geojson';

        var apiToken = 'pk.eyJ1IjoiMHJlc3RlIiwiYSI6ImNreWN2NmpyNzBxbXcycXA1Y3BjbWZ0YmEifQ.vpTj7B1jfveJ23QpnrX4Mw';
    
        var apiUrl = `https://api.mapbox.com/directions/v5/mapbox/driving/${firstPoint.lng},${firstPoint.lat};${secondPoint.lng},${secondPoint.lat}?geometries=${geometries}&access_token=${apiToken}`;
    
        var settings = {
            "url": apiUrl,
            "method": "GET",
            "timeout": 0,
            async: true,
            datatype: 'application/json',
            crossDomain: true,
        };
        
        // $.ajax(settings).done(function (response){
        //     var direction = response.routes[0].geometry.coordinates;

        //     //formatage des données par permutation
        //     direction.forEach(function(element){
        //         var permute = element[0];
        //         element[0] = element[1];
        //         element[1] = permute;
        //     });

        //     console.log(direction);
            
        //     var line = turf.lineString(direction);
        //     var options = {units: 'kilometers'};
        //     var along = turf.along(line, 200, options);
        //     var bbox = turf.bbox(line);
        //     bbox.addTo(map);
        // });

        intineraire = L.Routing.control({
            waypoints: [
              L.latLng(firstPoint.lat, firstPoint.lng),
              L.latLng(secondPoint.lat, secondPoint.lng)
            ]
          }).addTo(map);
    }
}
function loadDevices() {
    var settings = {
        "url": "http://viasat.app.lan/index.php/api/getDevices",
        "method": "GET",
        "timeout": 0,
        async: true,
        datatype: 'application/json',
        crossDomain: true,
    }

    var chargingStationCollection = null;
    var vehicules = null;
    $.ajax(settings).done(function (response) {
        chargingStationCollection = {
            "type": "FeatureCollection",
            "features": []
        };

        for (const device of response.response.devices) {
            var geojsonFeature = {
                "type": "Feature",
                "properties": {
                    device
                },
                "geometry": {
                    "type": "Point",
                    "coordinates": [device.last_longitude, device.last_latitude]
                }
            };
            chargingStationCollection.features.push(geojsonFeature);
        }
        // vehiclesLayer.addLayer(devicePointToLayer(chargingStationCollection, carIcon));
        devicePointToLayer(chargingStationCollection, carIcon).eachLayer(function (vehicule){
            vehiclesLayer.addLayer(vehicule);
        });

        fillSideNav(vehiclesLayer.getLayers());
        assignEventSideNavBar(vehiclesLayer);

        vehiclesLayer.eachLayer(function (vehicule) {
            popupOnCar(vehicule);
            addZoomEventOnCar(vehicule, vehiclesLayer);
            ColorVehiculeGroup(vehiclesLayer, vehicule);
        });

        vehiclesLayer.addTo(map);

    });

}
function loadChargingStations() {

    var settings = {
        "url": "http://viasat.app.lan/index.php/api/getChargingStations",
        "method": "GET",
        "timeout": 0,
        async: false,
        datatype: 'application/json',
        crossDomain: true
    }

    var chargingStationCollection = null;
    var vehicules = null;


    $.ajax(settings).done(function (response) {
        var bornesElectriques = response;

        geojsonFeatureCollection = {
            "type": "FeatureCollection",
            "features": []
        };

        for (borne of bornesElectriques) {

            //formatage des données
            var formattedData = formatCharginStation(borne);

            var geojsonFeature = {
                "type": "Feature",
                "properties": {
                    "name": formattedData.name
                },
                "geometry": {
                    "type": "Point",
                    "coordinates": formattedData.coordinates
                }
            };

            geojsonFeatureCollection.features.push(geojsonFeature);
        }

        //Création d'une copie du json avec moins de features pour tester
        var geojsonFeatureCollectionTest = geojsonFeatureCollection;
        // geojsonFeatureCollectionTest.features = geojsonFeatureCollectionTest.features.slice(0, 100);

        stationPointToLayer(geojsonFeatureCollectionTest, chargingStationIcon).eachLayer(function (station){
            popupOnChargingStation(station);
            chargingStationLayer.addLayer(station);

        });


        var csCluster = L.markerClusterGroup.layerSupport();
        csCluster.addLayer(chargingStationLayer);

        map.addLayer(csCluster);
    });

}

function fillSideNav(vehicules) {
    //on instencie l'element sur lequel on ajoutera le html
    let elem = document.getElementById("sidenav");
    //string qu'on envoyra à l'element 
    let stringListeVehicules = "";
    //cette boucle 

    for (const vehicule of vehicules) {
        stringListeVehicules +=
            "<a id=\"" + vehiclesLayer.getLayerId(vehicule) + "\" class=\"layer\" href=\"#\">" + vehicule["feature"]["properties"]["device"]["alias"] + "</a>";
    }
    elem.innerHTML = stringListeVehicules;
}

function removeItinerary(){
  
    map.removeLayer(intineraire);
}


function popupOnCar(vehicule) {
  vehicule.setZIndexOffset(1000);
    vehicule.bindPopup(
        "Alias : " + vehicule["feature"]["properties"]["device"]["alias"] + "<br>"
        + "Coordonées : " + vehicule.getLatLng().toString() + "<br>"
        + "Marque : " + vehicule["feature"]["properties"]["device"]["brand"] + "<br>"
        + "Dernière vitesse enregistrée : " + vehicule["feature"]["properties"]["device"]["last_gps_speed"] + "<br>"
        + "Nom de Groupe : " + vehicule["feature"]["properties"]["device"]["group"]["name"] + "<br>"
        + "ID de Groupe : " + vehicule["feature"]["properties"]["device"]["group"]["id_group"] + "<br>"
    );
}

function popupOnChargingStation(station) {
    station.setZIndexOffset(1000);
    station.bindPopup(
        station["feature"]["properties"][""]+ 'sgsdfgsdfgdsfg'
    );
}

function addZoomEventOnCar(vehicule, vehiclesLayer) {
    vehicule.addEventListener("click", function () {
        map.setView(vehicule.getLatLng(), 20)

        vehiclesLayer.eachLayer(function (vehicule) {
            vehicule.setZIndexOffset(1000);
        });
        vehicule.setZIndexOffset(2000);
    });
}

function assignEventSideNavBar(vehiclesLayer) {
    //Cette partie permet le zoom et l'ouverture de la popup sur un point quand on clique sur son nom correspondant dans la sidenav
    var anchorItem = document.getElementsByClassName("layer");
    for (var i = 0; i < anchorItem.length; i++) {
        anchorItem[i].addEventListener("click", function () {
            var markerId = this.id;
            var currentMarker = vehiclesLayer.getLayer(markerId);
            currentMarker.setZIndexOffset(1000);
            map.setView(currentMarker.getLatLng(), 20);
            currentMarker.openPopup();
        });
    }
}

function formatCharginStation(data) {

    data['coordonneesXY'] = data['coordonneesXY'].substring(1, data['coordonneesXY'].length - 2);
    data['coordonneesXY'] = data['coordonneesXY'].split(',');
    data['coordonneesXY'][1] = data['coordonneesXY'][1].substring(1, data['coordonneesXY'][1].length);
    //Permutation de l'index de la latitude longitude
    var temp = data['coordonneesXY'][0];
    data['coordonneesXY'][0] = data['coordonneesXY'][1];
    data['coordonneesXY'][1] = temp;

    var formattedData = {
        coordinates: data['coordonneesXY'],
        name: data['nom_station']
    }
    return formattedData;
}

//Va dessiner tous les points à partir d'un geoJson
function stationPointToLayer(geojson, customIcon) {

    return L.geoJSON(geojson, {

        pointToLayer: function (feature, latlng) {

            return L.marker(latlng, { 
                icon: customIcon,
                contextmenu: true,
                contextmenuInheritItems: false,
                contextmenuItems: [{
                    text: 'Arrivée',
                    index: 3,
                    callback: arrivee
                }]
            });
        }
    })
}

function devicePointToLayer(geojson, customIcon) {

    return L.geoJSON(geojson, {

        pointToLayer: function (feature, latlng) {

            return L.marker(latlng, { 
                icon: customIcon,
                contextmenu: true,
                contextmenuInheritItems: false,
                contextmenuItems: [{
                    text: 'Départ',
                    index: 0,
                    callback: depart
                }]
            });
        }
    })
}
function depart(e){
    firstPoint = e.latlng;
    directionApiTest(firstPoint,secondPoint);
}

function arrivee(e){
    secondPoint = e.latlng;
    directionApiTest(firstPoint,secondPoint);
}

function ColorVehiculeGroup(vehiclesLayer, vehicule) {
    vehicule.addEventListener("click", function () {
        vehicule.setIcon(redCarIcon);
        vehiclesLayer.eachLayer(function (vehiculeJ) {
            if (vehicule.feature.properties.device.group.id_group == vehiculeJ.feature.properties.device.group.id_group) {
                vehiculeJ.setIcon(redCarIcon);
            } else {
                vehiculeJ.setIcon(carIcon);
            }
        });

    });
}

/////////////////DECLARATION DES VARIABLES///////////////////




//Sert à ajouter les layers en overlay
var tilesSelector = L.control.layers();
var layerOverlay = L.control.layers();

//on intencie un layer affin de pourvoir y ajouter des markers, repères, forme géo par la suite
var vehiclesLayer = L.layerGroup();
var chargingStationLayer = L.layerGroup();

//Variables tuiles openstreetmap
const tiles = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    maxZoom: 18,
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox/streets-v11', //mapbox/streets-v11
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoiMHJlc3RlIiwiYSI6ImNreWN2NmpyNzBxbXcycXA1Y3BjbWZ0YmEifQ.vpTj7B1jfveJ23QpnrX4Mw'
});
//Variables tuiles heremap
const here = {
    apiKey: 'fxbTiuKpHkfZ9ZnrkreEb0nHMwb_u0kB47wuhYKd0kM'
}
const style = 'reduced.night';

const hereTileUrl = `https://2.base.maps.ls.hereapi.com/maptile/2.1/maptile/newest/${style}/{z}/{x}/{y}/512/png8?apiKey=${here.apiKey}&ppi=320`;
const heraLayer = L.tileLayer(hereTileUrl);

//Initialisation de la map
const map = L.map('map',{
    //mettra cette tuile par défaut
    layers:[tiles]
});
map.attributionControl.addAttribution('&copy; HERE 2019');
map.fitWorld();


L.control.layers({
    "Landscape": tiles,
    "Here": heraLayer
}).addTo(map);

L.control.layers({},{
    "Véhicule": vehiclesLayer,
    "Station de recharge": chargingStationLayer
}).addTo(map);


//Points intinéraire
var firstPoint = null;
var secondPoint = null;
var intineraire = null;

//Création de l'icone qu'on ajoutera à toutes les features du layer
var carIcon = L.icon({
    iconUrl: 'http://viasat.app.lan/assets/img/car_icon.png',

    iconSize: [25, 25], // size of the icon
    iconAnchor: [20, 27], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -28], // point from which the popup should open relative to the iconAnchor
    className: "voitureIcon"
});

var redCarIcon = L.icon({
    iconUrl: 'http://viasat.app.lan/assets/img/car_icon.png',

    iconSize: [25, 25], // size of the icon
    iconAnchor: [20, 27], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -28], // point from which the popup should open relative to the iconAnchor
    className: "voitureIconSelected"
})

var chargingStationIcon = L.icon({
    iconUrl: 'http://viasat.app.lan/assets/img/charginStation.png',
    iconSize: [25, 25], // size of the icon
    iconAnchor: [20, 27], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -28], // point from which the popup should open relative to the iconAnchor
    className: "voitureIcon"
});


loadDevices();

loadChargingStations();

var line = turf.lineString([[-83, 30], [-84, 36], [-78, 41]]);
var options = {units: 'miles'};

var along = turf.along(line, 200, options);















