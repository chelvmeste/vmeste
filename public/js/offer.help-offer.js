$(document).ready(function(){

    $('#timepicker-offer').datetimepicker({
        pickDate: false,
        minuteStepping: 15
    });

    $('#daterimepicker-birthdate').datetimepicker({
        pickTime: false,
        maxDate: moment().format('YYYY-MM-DD')
    });

    $('#address').typeahead(null,{
        source: function (query, process) {

            $.ajax({
                url: 'http://geocode-maps.yandex.ru/1.x/?format=json&geocode=' + encodeURIComponent(query),
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    var response = [];
                    if (data.response.GeoObjectCollection.featureMember.length > 0) {
                        for (var i = 0;i < data.response.GeoObjectCollection.featureMember.length; i++) {
                            response.push({
                                text: data.response.GeoObjectCollection.featureMember[i].GeoObject.metaDataProperty.GeocoderMetaData.text,
                                lon: data.response.GeoObjectCollection.featureMember[i].GeoObject.Point.pos.split(' ')[0],
                                lat: data.response.GeoObjectCollection.featureMember[i].GeoObject.Point.pos.split(' ')[1]
                            });
                        }
                    }
                    process(response);
                }
            });
        },
        displayKey: 'text'
    }).bind('typeahead:selected', function(obj, selected, name) {
        $('#address_latitude').val(selected.lat);
        $('#address_longitude').val(selected.lon);
    });

});