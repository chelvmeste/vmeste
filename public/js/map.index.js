$(document).ready(function(){

    ymaps.ready(init);

    function init () {
        var map = new ymaps.Map('map', {
                center: [55.76, 37.64],
                zoom: 10,
                controls: ['zoomControl','typeSelector']
            });

        $.ajax({
            url: '/getOffers',
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
                        map.setCenter([data.offers[i].user.address_latitude, data.offers[i].user.address_longitude]);

                    }

                }
            }
        });

    }

});