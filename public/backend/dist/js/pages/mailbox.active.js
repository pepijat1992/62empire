$(document).ready(function () {
    "use strict"; // Start of use strict

    $('.mailbox-content').on('click', '.inbox_item', function () {
        window.location.href = $(this).data('href');
    });

    $('.i-check input').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green'
    });
});