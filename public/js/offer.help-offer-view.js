$(document).ready(function(){

    var map = new Map(geoConfig);
    map.createMap();

    map.addMapObject(offerData.lat, offerData.lon, offerData.description);

    $(document).on('click', '.show-requests-select', function(e){
        e.preventDefault();
        var btn = $(this);
        btn.addClass('hidden');
        btn.parent().find('.requests-list').removeClass('hidden');
    });

    $('.requests-list select').on('change', function(){

        var btn = $('.requests-list').find('.submit-link');

        btn.attr('href', btn.attr('data-submit-link').replace('XXX',$(this).val()));
        console.log(btn.attr('href'));

    }).trigger('change');

});