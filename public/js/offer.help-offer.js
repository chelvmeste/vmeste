$(document).ready(function(){

    $('#timepicker-offer').datetimepicker({
        pickDate: false,
        minuteStepping: 15
    });

    $('#daterimepicker-birthdate').datetimepicker({
        pickTime: false,
        maxDate: moment().format('YYYY-MM-DD')
    });

});