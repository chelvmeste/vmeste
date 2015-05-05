$(document).ready(function(){

    ymaps.ready(function() {

        var map = new Map(geoConfig);
        map.createMap();

        map.addPlacemarkToCollection('offer', 0, offerData.lat, offerData.lon);
        map.renderCollection('offer', true);

    });

});