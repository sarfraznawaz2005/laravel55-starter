/**
 * Created by Sarfraz on 10/18/2016.
 *
 * Custom Javascript for the app.
 *
 */

$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#flash-overlay-modal').modal();

    // BTS Popover
    $('[rel="popover"]').addClass('text-primary').popover({"trigger": "hover", "html": true});

    // to close popover when clicking outside
    $('body').on('click', function (e) {
        $('[rel="popover"]').each(function () {
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

    $('[data-tooltip]').tooltip();
});

// confirm delete
$('body').on('click', '.confirm-delete', function (e) {
    var $form = $(this).closest('form');

    if (confirm('Are you sure?')) {
        $form.submit();
    }

    return false;
});

function showAlert(message, title, type, closeOnEscapeKey, callback) {
    type = type || '';
    title = title || '';

    if (typeof closeOnEscapeKey === 'undefined') {
        closeOnEscapeKey = true;
    }

    swal({
        title: title,
        text: message,
        icon: type,
        content: message,
        closeOnEsc: closeOnEscapeKey
    });

    if (typeof callback !== 'undefined' && typeof callback === 'function') {
        callback();
    }
}