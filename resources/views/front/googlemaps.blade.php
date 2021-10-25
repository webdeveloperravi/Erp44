<!DOCTYPE html>
<html>

<head>
    <title>Simple Map</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>



    <style>
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        #map {
            height: 100%;
        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

    </style>



</head>

<body>
    <div id="map"></div>


</body>


<script>
    // The location to show on map
    const amritsar = {
        lat: 31.64079,
        lng: 74.88798
    };

    const dubai = {
        lat: 25.2048,
        lng: 55.2708
    };




    // Initialize and add the map
    function loadMap() {


        // The map, centered at defined location above
        const map = new google.maps.Map(
            document.getElementById("map"), {
                zoom: 4,
                center: dubai,
            }
        );




        let markers = [];
        
        var infoWind = new google.maps.InfoWindow;

        var content = document.createElement('div');
        var strong = document.createElement('strong');

        strong.innerText = 'marker location';
        content.appendChild(strong);


        // The marker, positioned at above location
        var marker1 = new google.maps.Marker({
            position: dubai,
            map: map,
        });

        markers.push(marker1);

        // The marker, positioned at above location
        var marker2 = new google.maps.Marker({
            position: amritsar,
            map: map,
        });

        markers.push(marker2);



        markers.forEach(marker => {

            marker.addListener('click', (val) => {
                infoWind.setContent(content);
                infoWind.open(map, marker);
            });
        });



    }
</script>
<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBr4n-ESZ8D06z0UNdLA1_3Fg0EEmNRrdI&callback=loadMap"
async>
</script>

</html>
