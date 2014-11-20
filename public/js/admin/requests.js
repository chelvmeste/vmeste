$(function()
{

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
                    }
                });
            },
            displayKey: 'text'
        }).bind('typeahead:selected', function(obj, selected, name) {
            $('#address_latitude').val(selected.lat);
            $('#address_longitude').val(selected.lon);
        });

    }

    $(document).on('submit', '#edit-request-form', function()
    {
        var sArray = $(this).serializeArray();
        $.ajax({
            "type": "PUT",
            "url": window.location.href.toString(),
            "data": sArray,
            "dataType": "json"
        }).done(function(result)
        {
            if(result.saved === false)
            {
                if(typeof result.message !== 'undefined')
                {
                    showStatusMessage(result.message, result.messageType);
                }
                else if(typeof result.errorMessages !== 'undefined')
                {
                    showRegisterFormAjaxErrors(result.errorMessages);
                }
            }
            else
            {
                window.location = result.redirectUrl;
            }
        });

        return false;
    }).on('click', '#delete-item', function()
    {
        $('#confirm-modal').modal();
    }).on('click', '.delete-request .confirm-action', function()
    {
        $.each($('.table tbody tr td input:checkbox:checked'), function( key, value )
        {
            $.ajax(
                {
                    "url": window.location.href.toString()+"/"+$(this).data('request-id'),
                    "type": "DELETE"
                }).done(function(result)
                {
                    showStatusMessage(result.message, result.messageType);
                    ajaxContent($(this).attr('href'), ".ajax-content", false);
                });
        });

        $('#confirm-modal').modal('hide');
    });

});