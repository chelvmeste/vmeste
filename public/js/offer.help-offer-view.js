$(document).ready(function(){

    var map = new Map(geoConfig);
    map.createMap();

    map.addMapObject(offerData.lat, offerData.lon, offerData.description);

});