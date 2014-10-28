$(document).ready(function(){

    var geoConfig, map;

    ymaps.ready(initMap);

    function loadMapConfig(callback) {
        $.ajax({
            url: 'ajax/map/settings',
            type: 'GET',
            success: function(data) {
                geoConfig = data;
                if (typeof callback === 'function') {
                    callback();
                }
            }
        });
    }

    function initMap() {

        if (!geoConfig) {
            loadMapConfig(initMap);
            return;
        }

        if (!$('#map').length) {
            console.log('No map container detected');
            return;
        }

        map = new ymaps.Map('map', {
            center: [geoConfig.center.lon, geoConfig.center.lat],
            zoom: geoConfig.zoom,
            controls: ['zoomControl','typeSelector']
        });

        loadObjects();

    }

    // @todo refactor all this
    function loadObjects () {

        $.ajax({
            url: 'ajax/offers',
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
                if (data.offers.length > 0) {

                    for (var i = 0; i < data.offers.length; i++) {

                        map.geoObjects
                            .add(new ymaps.Placemark([data.offers[i].user.address_latitude, data.offers[i].user.address_longitude], {
                                balloonContent: data.offers[i].description
                            }, {
                                preset: 'islands#icon',
                                iconColor: '#0095b6'
                            }));
                        //map.setCenter([data.offers[i].user.address_latitude, data.offers[i].user.address_longitude]);

                    }

                }
            }
        });

    }

});