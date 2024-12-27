$(document).ready(function () {
    $('#status').change(function () {
        if ($(this).val() === 'deceased') {
            $('#death-date-field').show();
        } else {
            $('#death-date-field').hide();
        }
    });
});



