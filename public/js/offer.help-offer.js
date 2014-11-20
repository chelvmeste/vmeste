$(document).ready(function(){

    $('#daterimepicker-birthdate').datetimepicker({
        pickTime: false,
        maxDate: moment().format('YYYY-MM-DD')
    });

    for (var i = 1; i <= 7; i++) {

        var timeStartPicker = $('#time_start_' + i),
            timeEndPicker = $('#time_end_' + i);
        timeStartPicker.datetimepicker({
            pickDate: false,
            minuteStepping: 15
        });
        timeEndPicker.datetimepicker({
            pickDate: false,
            minuteStepping: 15
        });

        if (timeStartPicker.val() === '' && !timeStartPicker.closest('.day-container').find('.offer-day-switcher').is(':checked')) {
            timeStartPicker.data('DateTimePicker').disable();
        }
        if (timeEndPicker.val() === '' && !timeStartPicker.closest('.day-container').find('.offer-day-switcher').is(':checked')) {
            timeEndPicker.data('DateTimePicker').disable();
        }

    }

    $('.offer-day-switcher').on('change', function(){

        var checkbox = $(this),
            offerTimeStartId = checkbox.closest('.day-container').find('.offer-time-start').attr('id'),
            offerTimeEndId = checkbox.closest('.day-container').find('.offer-time-end').attr('id');

        //$('.days-type-switcher').attr('checked', false);

        if (checkbox.is(':checked')) {

            // enable datetimepickers
            $('#'+offerTimeStartId).data('DateTimePicker').enable();
            $('#'+offerTimeEndId).data('DateTimePicker').enable();

        } else {

            // disable datetimepickers
            $('#'+offerTimeStartId).data('DateTimePicker').disable();
            $('#'+offerTimeEndId).data('DateTimePicker').disable();

        }

    });

    $('.days-type-switcher').on('change', function(){

        var offerType = $(this).attr('data-day-type');
        $('input[type=checkbox].offer-day-switcher').prop('checked', false).trigger('change');

        switch (offerType) {
            case 'work':
                $('input[type=checkbox].offer-day-work').prop('checked', true).trigger('change');
                break;
            case 'weekends':
                $('input[type=checkbox].offer-day-weekends').prop('checked', true).trigger('change');
                break;
            case 'anytime':
                $('input[type=checkbox].offer-day-switcher').prop('checked', true).trigger('change');
                break;
        }

    });

});