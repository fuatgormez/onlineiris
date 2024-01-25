<section class="content">
    <div class="row">
        <div class="col-md-12" style="height: 600px">

            <div id="map"></div>
            <ul id="buttons">
                <li id="button-fr" class="button">French</li>
                <li id="button-ru" class="button">Russian</li>
                <li id="button-de" class="button">German</li>
                <li id="button-es" class="button">Spanish</li>
            </ul>
            <script>
                mapboxgl.accessToken = 'pk.eyJ1IjoibGFmY2FuYmF6aSIsImEiOiJja3BnemRoY2YyZzIzMnBsbHJodzBjbGR3In0.vkFF6P2wnDleyD5n7JvP7w';
                var map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    center: [52.48, 13.436],
                    zoom: 11.15
                });

                map.on('load', function() {
                    map.addSource('places', {
                        'type': 'geojson',
                        'data': {
                            'type': 'FeatureCollection',
                            'features': [{
                                    'type': 'Feature',
                                    'properties': {
                                        'description': '<strong> Fuat Berlin Fotoflash</strong><p>Make it Mount Pleasant is a handmade and vintage market and afternoon of live entertainment and kids activities. 12:00-6:00 p.m.</p>',
                                    },
                                    'geometry': {
                                        'type': 'Point',
                                        'coordinates': [52.4765292, 13.436337]
                                    }
                                },

                                {
                                    'type': 'Feature',
                                    'properties': {
                                        'description': '<strong>Big Backyard Beach Bash and Wine Fest</strong><p>EatBar (2761 Washington Boulevard Arlington VA) is throwing a Big Backyard Beach Bash and Wine Fest on Saturday, serving up conch fritters, fish tacos and crab sliders, and Red Apron hot dogs. 12:00-3:00 p.m. $25.</p>'
                                    },
                                    'geometry': {
                                        'type': 'Point',
                                        'coordinates': [-77.090372, 38.881189]
                                    }
                                },

                            ]
                        }
                    });
                    // Add a layer showing the places.
                    map.addLayer({
                        'id': 'places',
                        // 'type': 'symbol',
                        'type': 'circle',
                        'source': 'places',
                        // 'layout': {
                        //     'icon-image': '{icon}',
                        //     'icon-allow-overlap': true
                        // }

                        'paint': {
                            'circle-color': '#4264fb',
                            'circle-radius': 12,
                            'circle-stroke-width': 4,
                            'circle-stroke-color': '#ffffff'
                        }
                    });

                    // Create a popup, but don't add it to the map yet.
                    var popup = new mapboxgl.Popup({
                        closeButton: false,
                        closeOnClick: false
                    });

                    map.on('mouseenter', 'places', function(e) {
                        // Change the cursor style as a UI indicator.
                        map.getCanvas().style.cursor = 'pointer';

                        var coordinates = e.features[0].geometry.coordinates.slice();
                        var description = e.features[0].properties.description;

                        // Ensure that if the map is zoomed out such that multiple
                        // copies of the feature are visible, the popup appears
                        // over the copy being pointed to.
                        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                        }

                        // Populate the popup and set its coordinates
                        // based on the feature found.
                        popup.setLngLat(coordinates).setHTML(description).addTo(map);
                    });

                    map.on('mouseleave', 'places', function() {
                        map.getCanvas().style.cursor = '';
                        popup.remove();
                    });

                    
                });
            </script>








        </div>
    </div>
</section>