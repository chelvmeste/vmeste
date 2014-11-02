$(document).ready(function(){

    var map = new Map(geoConfig);
    map.createMap();

    $.ajax({
        url: 'ajax/offers',
        type: 'GET',
        success: function(data){
            if (data.offers.length > 0) {

                for (var i = 0; i < data.offers.length; i++) {

                    map.addMapObject(data.offers[i].user.address_latitude, data.offers[i].user.address_longitude, data.offers[i].description);

                }

            }
        }
    });

});