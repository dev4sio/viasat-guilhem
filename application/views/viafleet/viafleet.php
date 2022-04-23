<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-2.0.3.min.js"></script>
</head>

<body>

    <script defer>
        var settings = {
            "url": "https://cors-anywhere.herokuapp.com/https://pro.viafleet.io/api/geo/devices",
            "method": "GET",
            "timeout": 0,
            datatype: 'application/json',
            crossDomain: true,
            "headers": {
                "Authorization": "Basic YWRtaW4tdGVwaWY6OGdoMzRzWUU=",
            },
            "Cookie": "ci_arc_session=tc3mpjj44v44tpe67oufukt4tbt0ukft"

        };


        $.ajax(settings).done(function(response) {
            geojsonFeatureCollection = {
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
                        "coordinates": [device.last_latitude, device.last_longitude]
                    }
                };
                geojsonFeatureCollection.features.push(geojsonFeature);
            }
            console.log(geojsonFeatureCollection);
        });
    </script>
</body>

</html>