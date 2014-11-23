$(function()
{

    $(document).on('submit', '#edit-response-form', function()
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
    }).on('click', '.delete-response .confirm-action', function()
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