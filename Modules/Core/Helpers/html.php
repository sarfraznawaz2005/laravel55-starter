<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/15/2017
 * Time: 3:35 PM
 */

/**
 * make listing edit button
 *
 * @param $link
 * @param string $title
 * @return string
 */
function listingEditButton($link, $title = 'Edit')
{
    $html = <<< HTML
    <a data-placement="top" data-tooltip data-original-title="$title" style="text-decoration: none;" href="$link">
        <b class="btn btn-primary fa fa-pencil"></b>
    </a>
HTML;

    return $html;
}


/**
 * make listing delete button
 *
 * @param $link
 * @param string $title
 * @param bool $showTip
 * @param bool $icon
 * @return string
 */
function listingDeleteButton($link, $title = 'this', $showTip = true, $icon = true)
{
    $tooltipClass = $showTip ? 'data-tooltip' : '';
    $csrf_field = csrf_field();
    $method_field = method_field('DELETE');
    $text = $icon ? '<b class="btn btn-danger fa fa-trash"></b>' : 'Delete';

    $html = <<< HTML
    <form action="$link" method="POST" style="display: inline;">
        $csrf_field
        $method_field

        <a data-placement="top" $tooltipClass data-original-title="Delete" 
        class="confirm-delete"
        style="text-decoration: none;"
        data-label="$title"
        href="javascript:void(0);">
            $text
        </a>
    </form>
HTML;

    return $html;
}

function listingDeleteButtonOld($link, $title = 'this', $showTip = true, $icon = true)
{
    $tooltipClass = $showTip ? 'data-tooltip' : '';
    $csrf_field = csrf_field();
    $method_field = method_field('DELETE');
    $text = $icon ? '<b class="btn btn-danger btn-sm glyphicon glyphicon-trash"></b>' : 'Delete';
    $btnClass = $icon ? '' : 'btn btn-danger btn-sm';

    $html = <<< HTML
    <form action="$link" method="POST" style="display: inline;">
        $csrf_field
        $method_field

        <a data-placement="top" $tooltipClass data-original-title="Delete" 
        class="delete_btn confirm-delete $btnClass"
        data-label="$title"
        href="javascript:void(0);">
            $text
        </a>
    </form>
HTML;

    return $html;
}

/**
 * make listing view button
 *
 * @param $link
 * @param string $title
 * @return string
 */
function listingViewButton($link, $title = 'View')
{
    $html = <<< HTML
    <a data-placement="top" data-tooltip data-original-title="$title" style="text-decoration: none;" href="$link">
        <b class="btn btn-success fa fa-eye"></b>
    </a>
HTML;

    return $html;
}

/**
 * Adds Search column to each column of datatable
 *
 * @param bool $lastColumn
 * @return string
 */
function searchColumns($lastColumn = false)
{
    $filterLastColumn = $lastColumn ? '' : ':not(:last)';

    return "
            function () {
                this.api().columns('$filterLastColumn').every(function (index) {
                    var column = this;
                    var header = $(column.header(index));
                    var title = header.text();
                    var input = document.createElement('input');
                    $(input).attr('placeholder', 'type to filter');
                    $(input).attr('class', 'form-control');
                    $(input).appendTo($(column.footer()).empty())
                    .on('change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
                });
            }";
}

/**
 * Adds filter dropdown to specified columns of datatable
 *
 * NOTE: jQuery is needed for this to work.
 *
 * @param $data
 * @param $columns
 * @return string
 * @author Sarfraz
 */
function filterColumns($data, $columns)
{
    $select = '';

    $data = collect($data->getData()->data);

    if (!$data || !$columns) {
        return false;
    }

    foreach ($columns as $index => $column) {
        $columnData = $data->pluck($column)->unique()->sort();

        $select .= <<< SELECT
        \n\nvar column_$column = this.api().columns('$column:name');
        \n\nvar columnField = column_$column.dataSrc()[0];
        \n\nvar tableField = '$column';
        
        \n\nvar select_$column = $('<select class=\"select2\"><option value=\"\">No Filter</option></select>')
SELECT;

        foreach ($columnData as $row) {
            $value = htmlentities(strip_tags($row), ENT_QUOTES, "UTF-8");

            if (trim($row)) {
                $select .= ".append('<option value=\'$value\'>$value</option>')";
            }
        }

        $select .= <<< SELECT
                .appendTo($(column_$column.footer()).empty())                
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                    
                    column_$column.search(val ? '^'+val+'$' : '', true, false).draw();
                });
                
                \n\n
                
                if(jQuery().select2) {
                    var \$select2 = select_$column.select2();
                }
                
                \n\n
                
                // put filters on header
                $('tfoot').css('display', 'table-header-group');

SELECT;

    }

    return "function () { $select }";
}

/**
 * Converts model data into html table
 *
 * @param $model
 * @param array $fields
 * @param bool $horizontal
 * @param array $options $tableAttributes, $trAttributes, $tdAttributes
 * @return string
 */
function table($model, array $fields, $horizontal = false, array $options = [])
{
    $table = '';
    $nl = "\n";
    $tableAttributes = isset($options['tableAttributes']) ? $options['tableAttributes'] : '';
    $trAttributes = isset($options['trAttributes']) ? $options['trAttributes'] : '';
    $tdAttributes = isset($options['tdAttributes']) ? $options['tdAttributes'] : '';

    $data = $model->all();

    $table .= "$nl<table $tableAttributes class='table table-striped table-bordered table-hover dt-responsive'>";

    // cause horizintally usually one record is shown
    if ($horizontal) {
        $data = $model->first();

        foreach ($fields as $key => $title) {
            $table .= "$nl<tr>";
            $value = $data->$key;
            $table .= "$nl<td $tdAttributes><strong>$title</strong></td>";
            $table .= "$nl<td $tdAttributes>$value</td>";
            $table .= "$nl</tr>";
        }

    } else {
        $table .= "$nl<thead>";
        $table .= "$nl<tr>";

        foreach (array_values($fields) as $title) {
            $table .= "$nl<th>$title</th>";
        }

        $table .= "$nl</tr>";
        $table .= "$nl</thead>";
        $table .= "$nl<tbody>";

        foreach ($data as $row) {
            $table .= "$nl<tr $trAttributes>";

            foreach (array_keys($fields) as $field) {
                $value = $row->$field;
                $table .= "$nl<td $tdAttributes>$value</td>";
            }

            $table .= "$nl</tr>";
        }
    }

    $table .= "$nl</tbody>";
    $table .= "$nl</table>";

    return $table;
}

/**
 * Returns html table row
 *
 * Usage: tr($model->fieldName);
 *
 * @param $value
 * @param string $title
 * @param bool $strong
 * @param string $default
 * @return string
 */
function tr($value, $title = '', $strong = false, $default = '')
{

    if (!trim($value)) {
        $value = $default;
    }

    $tr = '<tr>';

    if (!$title) {
        $title = ucwords(str_replace(['_', '-'], ['', ''], $value));
    }

    if ($strong) {
        $tr .= '<td><strong>' . $title . '</strong></td>';
    } else {
        $tr .= '<td>' . $title . '</td>';
    }

    $tr .= '<td>' . $value . '</td>';
    $tr .= '</tr>';

    return $tr;
}

/**
 * create BTS popover with text cut off
 *
 * @param $text
 * @param int $length
 * @param string $title
 * @return string
 */
function popoverShortText($text, $length = 30, $title = 'Info')
{
    return '<span style="cursor:pointer;" data-container="body" rel="popover" data-original-title="' . $title . '" data-content="' . nl2br($text) . '">' . str_limit($text,
            $length) . '</span>';
}

// create BTS popover with smaller help icon
function popoverTip($text, $title = 'Info')
{
    return '<span data-placement="top" data-tooltip data-toggle="tooltip" title="' . $text . '"><b style="margin-top:2px;" class="fa fa-question-circle"></b></span>';
}

function tdModal($text, $title = 'Details')
{
    if (!$text) {
        return '';
    }

    $id = str_random() . time() . uniqid() . substr(str_slug($text), 0, 10);
    $text = trim($text);

    $html = <<< HTML
<div id="mod_dtls_$id" class="modal fade move_modal" tabindex="-1" role="dialog" style="z-index: 9999999999;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title">
                    $title
                </h4>
            </div>

            <div class="modal-body" style="width:100%; white-space: normal;">
                $text
            </div>

            <div class="modal-footer" style="padding: 7px 10px 5px 10px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<a data-toggle="modal" data-target="#mod_dtls_$id" href="javascript:void(0);" style="text-decoration: none;">
    <b class="btn btn-primary fa fa-info-circle"></b>
</a>

HTML;

    return $html;
}

function tdModalPicture($path, $title = 'Details')
{
    $id = str_random() . time() . uniqid() . substr(str_slug($path), 0, 10);

    $html = <<< HTML
<div id="mod_dtls_pic_$id" class="modal fade move_modal" tabindex="-1" role="dialog" style="z-index:9999999999;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title">
                    $title
                </h4>
            </div>

            <div class="modal-body" style="width:100%; white-space: normal; text-align: center;">
                <img src="$path" class="img-thumbnail" alt="avatar">
            </div>

            <div class="modal-footer" style="padding: 7px 10px 5px 10px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<a data-toggle="modal" data-target="#mod_dtls_pic_$id" href="javascript:void(0);" style="text-decoration: none;">
    <b class="btn btn-primary fa fa-camera"></b>
</a>

HTML;

    return $html;
}

/**
 * Centers content on dataTable.
 *
 * @param $data
 * @return string
 */
function tdCenter($data, $width = 'auto')
{
    return "<span class='tdcenter' style='width: $width; text-align: center; display: inline-block;'>$data</span>";
}

function tdBold($data)
{
    return "<span style='font-weight: bold;'>$data</span>";
}

function tdCheckBox($id, $column, $target, $checked = false)
{
    $checked = $checked ? 'checked' : '';

    return "<input data-id='$id' data-column='$column' data-target='$target' class='dt_chk' type='checkbox' $checked>";
}

/**
 * Returns label style for column of dataTable
 *
 * @param $type
 * @param $text
 * @param string $width
 * @return string
 */
function tdLabel($type, $text, $width = '60px')
{
    return "<label class='badge badge-$type tdcenter' style='width: $width;  line-height: 15px; margin-top: 7px; display: inline-block;'>$text</label>";
}

function dropdown($data, $appendEmptyOption = false)
{
    if (is_array($data)) {
        $array = [];

        foreach ($data as $value) {
            $array[$value] = $value;
        }

        return ['' => 'Select'] + $array;
    }

    $menus = $data->pluck('name', 'id')->toArray();

    if ($appendEmptyOption) {
        return ['' => 'Select'] + $menus;
    }

    return $menus;
}

function substr_text_only($string, $limit, $end = '...')
{
    $with_html_count = strlen($string);
    $without_html_count = strlen(strip_tags($string));
    $html_tags_length = $with_html_count - $without_html_count;
    //return str_limit($string, $limit + $html_tags_length, $end);

    $string = mb_substr($string, 0, $without_html_count + $limit);

    libxml_use_internal_errors(true);
    $dom = new DOMDocument;
    $dom->loadHTML(mb_convert_encoding($string, 'HTML-ENTITIES', 'UTF-8'));

    return $dom->saveHTML() . $end;
}