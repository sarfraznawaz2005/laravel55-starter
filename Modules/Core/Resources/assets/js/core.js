/**
 * Created by Sarfraz on 1/10/2018.
 *
 * Custom Javascript for the app.
 *
 */

$(function () {

    var $dataTable = $('.dataTable');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#flash-overlay-modal').modal();

    // avoid onkeyup search in datatables filter, use Enter button instead
    $dataTable.dataTable().fnFilterOnReturn();

    // throw datatables errors to console instead of alert box
    $.fn.dataTable.ext.errMode = 'throw';

    // select 2 for dropdowns
    $('select').not('.no_select2').select2();

    // file upload style
    $(':file').filestyle({
        badge: true,
        input: false,
        size: 'sm',
        buttonText: '&nbsp;Choose File',
        buttonName: 'btn-primary'
    });

    $('.pulsate').pulsate();

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

    // BTS Tooltips
    if (!isMobile.any) {
        $('[data-tooltip]').tooltip();
    }

    // this event is called when datatable is drawn
    $dataTable.on('draw.dt', function () {
        // BTS Popover
        $('[rel="popover"]').addClass('text-primary').popover({"trigger": "click", "html": true});

        // BTS Tooltips
        $('[data-tooltip]').tooltip();

        // center elements with classs "center" inside tables
        $('.tdcenter').each(function () {
            $(this).parent().css('text-align', 'center');
        });

        // move any bt models outside of tables if they are in them otherwise they don't show up
        $('.move_modal').each(function () {
            $(this).appendTo(document.body);
        });
    });

    // activate last active tab
    try {
        if (typeof selected_tab !== 'undefined') {
            var activeTab = $('a[href="' + selected_tab + '"]');
            activeTab && activeTab.tab('show');
        }
    }
    catch (e) {
    }

    // summernote
    $('textarea.editor').summernote({
        height: 250,
        focus: false,
        toolbar: [
            ['undo', ['undo']],
            ['redo', ['redo']],
            ['style',
                [
                    'clear', 'bold', 'italic', 'underline', 'fontsize',
                    'strikethrough', /*'superscript', 'subscript',*/ 'color'
                ]
            ],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['hr', 'link', 'picture', 'table']],
            ['fullscreen', ['fullscreen']]
            //['codeview', ['codeview']],
            //['help', ['help']]
        ]
    });

    // disable submit button after clicked once to avoid duplicatation
    $('button[type="submit"], input[type="submit"]').disabler({
        timeout: 5000,
        html: 'Wait...'
    });

    // validate forms
    $('form.validate').validator({
        html: true,
        disable: false,
        focus: true
    });

    // disable scroll change value on input type number
    $(':input[type=number]').on('mousewheel', function (e) {
        $(this).blur();
    });

});

// confirm delete
$('body').on('click', '.confirm-delete', function (e) {
    var label = $(this).data('label');
    var $form = $(this).closest('form');

    swal({
        title: "Are you sure?",
        text: label + " will be deleted!",
        icon: "warning",
        buttons: ["Cancel", "Yes, delete it!"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                document.querySelector('.swal-button').disabled = true;
                $form.submit();
            }
        });

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

function showConfirm(message, callback) {
    swal({
        title: "Are you sure?",
        text: message,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                document.querySelector('.swal-button').disabled = true;
                callback();
            }
        });
}