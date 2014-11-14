$(document).ready(function(){

    ymaps.ready(function() {

        var map = new Map(geoConfig);
        map.createMap();

        var search = new Search(map);
        search.bindEvents();
        search.loadItems().then(function(){
            search.buildSideList();
        });

    });



















    $('.response-success').on('click', function(e) {

        e.preventDefault();
        var responseId = $(this).attr('data-response-id');
        var modal = $('#response-success-modal');

        modal.find('.send-response-success').attr('data-response-id', responseId);
        modal.modal();

    });

    $('.response-cancel').on('click', function(e) {

        e.preventDefault();
        var responseId = $(this).attr('data-response-id');
        var modal = $('#response-cancel-modal');

        modal.find('.send-response-cancel').attr('data-response-id', responseId);
        modal.modal();

    });

    $('.send-response-success').on('click', function(e) {

        e.preventDefault();
        var btn = $(this);
        var responseId = btn.attr('data-response-id');
        var modal = btn.closest('div.modal');
        var responseText = modal.find('textarea[name=response_text]').val();
        var errorsDiv = modal.find('.errors');
        errorsDiv.empty();

        $.ajax({
            url: '/ajax/response',
            type: 'POST',
            data: {
                response_id: responseId,
                response_text: responseText,
                response_type: 'success'
            },
            success: function() {
                errorsDiv.empty();
                modal.modal('hide');
                $('.response-alert-'+responseId).remove();
            },
            error: function(error) {
                errorsDiv.append('<div class="alert alert-danger">'+error.responseJSON.message+'</div>');
            }
        });

    });

    $('.send-response-cancel').on('click', function(e) {

        e.preventDefault();
        var btn = $(this);
        var responseId = btn.attr('data-response-id');
        var modal = btn.closest('div.modal');
        var responseText = modal.find('textarea[name=response_text]').val();
        var errorsDiv = modal.find('.errors');
        errorsDiv.empty();

        $.ajax({
            url: '/ajax/response',
            type: 'POST',
            data: {
                response_id: responseId,
                response_text: responseText,
                response_type: 'canceled'
            },
            success: function() {
                errorsDiv.empty();
                modal.modal('hide');
                $('.response-alert-'+responseId).remove();
            },
            error: function(error) {
                errorsDiv.append('<div class="alert alert-danger">'+error.responseJSON.message+'</div>');
            }
        });

    });

});