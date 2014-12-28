$(document).ready(function(){

    if ($('#daterimepicker-birthdate').length) {
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

    $('.offer-day-switcher-blind').on('change', function(){

        var checkbox = $(this),
            day = $(this).attr('data-day'),
            idStartHours = 'time_start_hours_' + day,
            idStartMinutes = 'time_start_minutes_' + day,
            idEndHours = 'time_end_hours_' + day,
            idEndMinutes = 'time_end_minutes_' + day;

        if (checkbox.is(':checked')) {

            $('#'+idStartHours).attr('disabled',false);
            $('#'+idStartMinutes).attr('disabled',false);
            $('#'+idEndHours).attr('disabled',false);
            $('#'+idEndMinutes).attr('disabled',false);

        } else {

            $('#'+idStartHours).attr('disabled',true);
            $('#'+idStartMinutes).attr('disabled',true);
            $('#'+idEndHours).attr('disabled',true);
            $('#'+idEndMinutes).attr('disabled',true);

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
