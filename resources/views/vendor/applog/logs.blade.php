<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AppLog</title>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="//cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.css">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">

    <style>
        body {
            padding: 10px;
        }

        h1 {
            font-size: 1.5em;
            margin-top: 0;
        }

        .stack {
            font-size: 0.85em;
        }

        .date {
            min-width: 140px;
        }

        .date, .level, .context {
            text-align: center;
            font-size: 90% !important;
        }

        .text {
            word-break: break-all;
        }

        a.llv-active {
            z-index: 2;
            background-color: #f5f5f5;
            border-color: #777;
        }

        table.dataTable td {
            font-size: 97%;
            vertical-align: middle !important;
        }

        thead tr {
            background-image: radial-gradient(#fff, #eee);
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 table-container">
            @if ($logs === null)
                <div>
                    Log file >50M, please download it.
                </div>
            @else
                <table id="table-log" class="table table-condensed table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Message</th>
                    </tr>
                    </thead>

                    <tfoot>
                    <tr>
                        <th>Type</th>
                        <th>Date</th>
                        <th>&nbsp;</th>
                    </tr>
                    </tfoot>

                    <tbody>

                    @foreach($logs as $key => $log)
                        <tr data-display="stack{{{$key}}}">

                            <td class="text-{{{$log['level_class']}}} level" data-value="{{ucfirst($log['level'])}}">
                                <span class="label label-{{{$log['level_class']}}}">
                                    <span class="glyphicon glyphicon-{{{$log['level_img']}}}-sign"></span>
                                    &nbsp;{{ucfirst($log['level'])}}
                                </span>
                            </td>

                            <td class="date" data-value="{{$log['date']}}">
                                {{{$log['date']}}}
                            </td>

                            <td class="text">
                                @if ($log['stack'])
                                    <a class="pull-right expand btn btn-success btn-xs"
                                       data-display="stack{{{$key}}}">
                                        <span class="glyphicon glyphicon-zoom-in"></span>
                                    </a>
                                @endif

                                {{{$log['text']}}}

                                @if (isset($log['in_file'])) <br/>{{{$log['in_file']}}}@endif

                                @if ($log['stack'])
                                    <div class="stack" id="stack{{{$key}}}"
                                         style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            @endif

            <div>
                @if(isset($exists) && $exists)
                    <a href="?dl={{ base64_encode($current_file) }}"><span
                                class="glyphicon glyphicon-download-alt"></span>
                        Download File</a>
                    -
                    <a id="delete-log" href="?del={{ base64_encode($current_file) }}"><span
                                class="glyphicon glyphicon-trash"></span> Delete File</a>
                @endif
            </div>

        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.js"></script>

<script>
    $(document).ready(function () {
        $('.table-container tr').on('click', function () {
            $('#' + $(this).data('display')).toggle();
        });

        var table = $('#table-log').DataTable({
            "order": [1, 'desc'],
            "stateSave": true,
            "stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("datatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("datatable"));

                if (data) data.start = 0;

                return data;
            }
        });

        ///////////////////////////////////////////////////////////////
        // filter columns
        var dates = [];

        $("#table-log tfoot th:not(:last)").each(function (i) {
            var select = $('<select style="width: 100%;"><option value=""></option></select>')
                .appendTo($(this).empty())
                .on('change', function () {
                    table.column(i)
                        .search($(this).val(), true, false)
                        .draw();
                });

            table.column(i).data().unique().sort().each(function (d, j) {
                var val = d;

                // remove html in case of first/type column
                if (i === 0) {
                    val = $(d).text().replace(/\s/g, '');
                }
                // remove time in case of date column
                else if (i === 1) {
                    val = d.split(' ')[0];

                    if (jQuery.inArray(val, dates) !== -1) {
                        // continue
                        return true;
                    }

                    dates.push(val);

                    // we will populate date column later with dates in descending order
                    return true;
                }

                select.append('<option value="' + val + '">' + val + '</option>')
            });
        });

        // populate dates select box
        $(dates).sort(function (a, b) {
            return a > b ? -1 : a < b ? 1 : 0;
        }).each(function (i, v) {
            $('tfoot select:eq(1)').append('<option value="' + v + '">' + v + '</option>')
        });

        // put filters on header
        $('tfoot').css('display', 'table-header-group');
        ///////////////////////////////////////////////////////////////

        $('#delete-log, #delete-all-log').click(function () {
            return confirm('Are you sure?');
        });

    });
</script>
</body>
</html>
