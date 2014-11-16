$(function()
{

    $('#dateStart-datepicker').datetimepicker({
        pickTime: false,
        maxDate: moment().format('YYYY-MM-DD')
    });
    $('#dateEnd-datepicker').datetimepicker({
        pickTime: false,
        maxDate: moment().format('YYYY-MM-DD')
    });

});