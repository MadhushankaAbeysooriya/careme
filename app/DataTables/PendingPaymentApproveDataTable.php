<?php

namespace App\DataTables;

use App\Models\PatientRequest;
use App\Models\PendingPaymentApprove;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PendingPaymentApproveDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($patient_request) {
                $id = $patient_request->id;
                $btn = '';

                    if($patient_request->status == 3)
                    {
                        $btn .='<a href="'.route('patient_requests.approveView',$id).'"
                        class="btn btn-xs btn-success" data-toggle="tooltip"
                        title="Approve"><i class="fa fa-check"></i> </a> ';
                    }

                return $btn;
            })
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PatientRequest $model): QueryBuilder
    {
        return $model->newQuery()
        ->where('status',3)
        ->with('patient','hospital');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pendingpaymentapprove-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderColumn(false)->width(40),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-center'),
            Column::make('patient.name')->data('patient.name')->title('Patient'),
            Column::make('patient.phone')->data('patient.phone')->title('Phone'),
            Column::make('hospital.name')->data('hospital.name')->title('Hospital'),
            Column::make('total_price')->data('total_price')->title('Total Price'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PendingPaymentApprove_' . date('YmdHis');
    }
}
