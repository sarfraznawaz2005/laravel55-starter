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

    // select 2 for dropdowns
    var $select2 = $('select').not('.no_select2').select2();
    $select2.length && $select2.data('select2').$container.addClass('wrap');

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
    var label = $(this).data('label');
    var $form = $(this).closest('form');

    swal({
        title: "Are you sure?",
        text: label + " will be deleted!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function () {
        swal.disableButtons();
        $form.submit();
    });

    return false;
});

function showAlert(message, type, closeOnEscapeKey, callback) {
    type = type || '';

    if (typeof closeOnEscapeKey === 'undefined') {
        closeOnEscapeKey = true;
    }

    swal({
        title: "Important",
        text: message,
        type: type,
        html: true,
        allowEscapeKey: closeOnEscapeKey
    });

    if (typeof callback !== 'undefined' && typeof callback === 'function') {
        callback();
    }
}