$(document).ready(function() {
    $(".persian-datetimepicker").pDatepicker({
        format: 'YYYY/MM/DD-HH:mm',
        initialValueType: 'persian',
        initialValue: false,
        autoClose: true,
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: true
            },
            second: {
                enabled: false
            }
        }
    });

    $(".persian-datepicker").pDatepicker({
        format: 'YYYY/MM/DD',
        initialValueType: 'persian',
        initialValue: false,
        autoClose: true,
        timePicker: {
            enabled: false,
            meridiem: {
                enabled: true
            },
            second: {
                enabled: false
            }
        }
    });

    $(".persian-timepicker").persianDatepicker({
        format: 'HH:mm',
        initialValueType: 'persian',
        onlyTimePicker: true,
        initialValue: false,
        autoClose: true,
        timePicker: {
            enabled: false,
            meridiem: {
                enabled: true
            },
            second: {
                enabled: false
            }
        }
    });



});
