$(document).ready(function(){

    $.ajaxSetup({
        dataType: 'JSON'
    });
    $(document)
        .ajaxStart(function(){
            NProgress.start();
        })
        .ajaxStop(function(){
            NProgress.done();
        });

    if ($('#address').length) {

        $('#address').typeahead(null,{
            source: function (query, process) {

                $.ajax({
                    url: 'http://geocode-maps.yandex.ru/1.x/?format=json&geocode=' + (typeof geoConfig.prepopulate !== 'undefined' && geoConfig.prepopulate.length > 0 ? geoConfig.prepopulate : '') + encodeURIComponent(query),
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(data) {
                        var response = [];
                        if (data.response.GeoObjectCollection.featureMember.length > 0) {
                            for (var i = 0;i < data.response.GeoObjectCollection.featureMember.length; i++) {
                                response.push({
                                    text: data.response.GeoObjectCollection.featureMember[i].GeoObject.metaDataProperty.GeocoderMetaData.text.replace(typeof geoConfig.prepopulate !== 'undefined' && geoConfig.prepopulate.length > 0 ? geoConfig.prepopulate : '',''),
                                    lon: data.response.GeoObjectCollection.featureMember[i].GeoObject.Point.pos.split(' ')[0],
                                    lat: data.response.GeoObjectCollection.featureMember[i].GeoObject.Point.pos.split(' ')[1]
                                });
                            }
                        }
                        process(response);
                        $('#address_latitude').val('');
                        $('#address_longitude').val('');
                    }
                });
            },
            displayKey: 'text'
        }).bind('typeahead:selected', function(obj, selected, name) {
            $('#address_latitude').val(selected.lat);
            $('#address_longitude').val(selected.lon);
        });

    }

});
