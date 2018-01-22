@push('scripts')
    <script>
        var ajaxRequest;
        var $overlay = $('#__cover__');
        var table = window.LaravelDataTables["dataTableBuilder"];

        $('.table').on('click', 'td:first-child', function () {
            // doesn't trigger
            return false;
        });

        table.on('row-reorder', function (e, diff, edit) {
            var myArray = [];
            var sendRequest = false;

            for (var i = 0, ien = diff.length; i < ien; i++) {
                var rowData = table.row(diff[i].node).data();

                if (diff[i].newData !== diff[i].oldData) {
                    sendRequest = true;

                    myArray.push({
                        id: rowData.id,			// record id from datatable
                        position: diff[i].newData		// new position
                    });
                }
            }

            if (!sendRequest) {
                return false;
            }

            if (ajaxRequest) {
                ajaxRequest.abort();
            }

            $overlay.css('display', 'table');

            setTimeout(function () {
                ajaxRequest = $.ajax({
                    url: '{{$route}}',
                    type: 'POST',
                    data: JSON.stringify(myArray),
                    dataType: 'json',
                    success: function (json) {
                        // now refresh datatable
                        $('#dataTableBuilder').DataTable().ajax.reload();
                        $overlay.hide();

                        /*
                        $.each(json, function (key, msg) {
                            // handle json response
                        });
                        */
                    }
                });
            }, 5000);

        });

    </script>
@endpush