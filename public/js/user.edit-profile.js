$(document).ready(function(){

    $('#daterimepicker-birthdate').datetimepicker({
        pickTime: false,
        maxDate: moment().format('YYYY-MM-DD')
    });

});