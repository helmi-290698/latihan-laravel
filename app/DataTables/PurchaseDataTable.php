<?php

namespace App\DataTables;

use App\Models\Purchase;
use App\Models\Purchase_detail;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PurchaseDataTable extends DataTable
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
                if (Auth::user()->hasRole('Manager')) {
                    $btn = '<a href="/purchase/cetak/' . $data->id . '" class="btn btn-icon me-2 btn-primary">
                                <span class="tf-icons mdi mdi-printer"></span>
                            </a>';
                } else {
                    $btn = '<div class="btn-group">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">Action</button>
                    <ul class="dropdown-menu">
                      <li>  <button type="button" class="dropdown-item mb-2 open_edit_purchase" value="' . $data->id . '" data-inventory="' . $data->inventory_id . '" data-qty="' . $data->qty . '" data-price="' . $data->price . '" data-date="' . $data->purchase->date . '"><i class="mdi mdi-square-edit-outline text-warning"></i> Ubah</button> </li>
                      <li>  <form action="/purchase/' . $data->purchase_id . '" method="POST" id="form-delete-purchase">
                      <input type="hidden" name="_token" value="' . $csrf . '">
                      <input type="hidden" name="_method" value="delete" />
                        <button class="dropdown-item" ><i class="mdi mdi-delete text-danger"></i> Hapus</button>
                      </form> </li>
                    </ul>
                  </div>';
                }

                return $btn;
            })
            ->addColumn('name', function ($data) {
                return $data->purchase->user->name;
            })
            ->addColumn('number', function ($data) {
                return $data->purchase->number;
            })
            ->addColumn('date', function ($data) {
                return $data->purchase->date;
            })
            ->addColumn('inventory', function ($data) {
                return $data->inventory->name;
            })
            ->addColumn('price', function ($data) {
                return 'Rp. ' . $data->price;
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Purchase_detail $model): QueryBuilder
    {
        $userId = Auth::user()->id;
        if (Auth::user()->hasRole('Purchase')) {
            return $model->newQuery()->join('purchases', 'purchases.id', '=', 'purchase_details.purchase_id')
                ->where('purchases.user_id', $userId);
        } else {
            return $model->newQuery();
        }
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('purchase-table')
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
            Column::make('number'),
            Column::make('name'),
            Column::make('date'),
            Column::make('inventory')->title('nama_barang'),
            Column::make('qty'),
            Column::make('price'),
            Column::make('action'),


        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Purchase_' . date('YmdHis');
    }
}
