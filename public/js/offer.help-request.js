$(document).ready(function(){

    $('#datepicker-offer').datetimepicker({
        pickTime: false,
        minDate: moment().format('YYYY-MM-DD')
    });

    $('#timepicker-offer').datetimepicker({
        pickDate: false,
        minuteStepping: 15
    });

    $('#daterimepicker-birthdate').datetimepicker({
        pickTime: false,
        maxDate: moment().format('YYYY-MM-DD')
    });

});