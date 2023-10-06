<?php

namespace App\DataTables;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InventoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($data) {
                $csrf =  csrf_token();
                $btn = '<div class="btn-group">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">Action</button>
                <ul class="dropdown-menu">
                  <li>  <button type="button" class="dropdown-item mb-2 open_edit_inventory" value="' . $data->id . '" data-name="' . $data->name . '" data-code="' . $data->code . '" data-price="' . $data->price . '" data-stock="' . $data->stock . '"><i class="mdi mdi-square-edit-outline text-warning"></i> Ubah</button> </li>
                  <li>  <form action="/inventory/' . $data->id . '" method="POST" id="form-delete-inventory">
                  <input type="hidden" name="_token" value="' . $csrf . '">
                  <input type="hidden" name="_method" value="delete" />
                    <button class="dropdown-item" ><i class="mdi mdi-delete text-danger"></i> Hapus</button>
                  </form> </li>
                </ul>
              </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Inventory $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('inventory-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'dom'          => 'Bfrtip',
                'buttons'      => ['excel', 'pdf', 'csv'],
                'scrollX'      => true,

            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id'),
            Column::make('code'),
            Column::make('name'),
            Column::make('price'),
            Column::make('stock'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Inventory_' . date('YmdHis');
    }
}
