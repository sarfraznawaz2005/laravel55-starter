<?php

namespace Modules\Admin\DataTables;

use Modules\User\Models\User;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @param $query
     * @return mixed
     * @throws \Exception
     */
    public function dataTable($query)
    {
        return datatables()
            ->of($query)
            ->editColumn('admin', function ($object) {
                $text = $object->admin == '1' ? 'Yes' : 'No';
                $type = $text === 'Yes' ? 'success' : 'primary';

                return tdLabel($type, $text);
            })
            ->editColumn('active', function ($object) {
                $text = $object->active == '1' ? 'Yes' : 'No';
                $type = $text === 'Yes' ? 'success' : 'danger';

                return tdLabel($type, $text);
            })
            ->rawColumns(['action', 'admin', 'active'])
            ->blacklist(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        // ->get() has impact on search/filters
        $query = User::latest();

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->addAction(['width' => '120px'])
            ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'name',
            'email',
            'admin' => ['width' => '1px'], // auto-width to content
            'active' => ['width' => '1px'],
            'created_at' => ['width' => '180px'],
        ];
    }

    /**
     * Get default builder parameters.
     *
     * @return array
     */
    protected function getBuilderParameters()
    {
        return [
            'order' => [[0, 'desc']],
            'dom' => 'Bfrtip',
            'ordering' => config('main.datatable.ordering'),
            'pageLength' => config('main.datatable.pageLength'),
            'autoWidth' => config('main.datatable.autoWidth'),
            'responsive' => config('main.datatable.responsive'),
            'bLengthChange' => config('main.datatable.bLengthChange'),
            'processing' => config('main.datatable.processing'),
            'buttons' => config('main.datatable.buttons'),
            ### for filters ###
            //'initComplete' => filterColumns(static::ajax(), static::filterColumns()),
        ];
    }

    /**
     * Columns for which filter dropdown will be displayed.
     *
     * @return array
     */
    public function filterColumns()
    {
        return [
            'name',
            'email',
            'created_at',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}
