var map;
var infowindow;

function initMap() {

    var mapProp = {
        center: new google.maps.LatLng(51.2182404, 22.4236861),
        zoom: 4,
        mapTypeControl: false,
    };
    map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

    infowindow = new google.maps.InfoWindow();


    function placeMarker(map, location) {
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });


        //get place name from coordinates
        var geocoder = new google.maps.Geocoder;

        geocoder.geocode({'location': location}, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {

                    marker.setTitle(results[results.length - 2].formatted_address);

                    $.ajax({
                        type: 'POST',
                        url: '/app_dev.php/map',
                        data: {'name': marker.getTitle(), 'lat': marker.getPosition().lat(), 'lng': marker.getPosition().lng()},
                        success: function (data) {
                            $('#results').html(data);
                        }
                    });

                    infowindow.setContent(results[results.length - 2].formatted_address);
                    infowindow.open(map, marker);

                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });

        infowindow.open(map, marker);

        addMarkerListener(marker);
    }


    google.maps.event.addListener(map, 'click', function (event) {
        placeMarker(map, event.latLng);
    }
    );

    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    searchBox.addListener('places_changed', function () {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        // For each place, get the icon, name and location.
        places.forEach(function (place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }

            // Create a marker for each place.
            var newMarker = new google.maps.Marker({
                map: map,
                title: place.name,
                position: place.geometry.location
            });


            $.ajax({
                type: 'POST',
                url: '/app_dev.php/map',
                data: {'name': newMarker.getTitle(), 'lat': newMarker.getPosition().lat(), 'lng': newMarker.getPosition().lng()},
                success: function (data) {
                    $('#results').html(data);
                }
            });
        });
    });
}


function loadData(locations) {

    var i;
    for (i = 0; i < locations.length; i++) {
        var marker = new google.maps.Marker({
            title: locations[i].name,
            position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
            map: map
        });

        addMarkerListener(marker);
    }
}

function addMarkerListener(marker) {
    google.maps.event.addListener(marker, 'click', function (event) {
        infowindow.setContent(this.getTitle());
        infowindow.open(map, this);
    });
}

