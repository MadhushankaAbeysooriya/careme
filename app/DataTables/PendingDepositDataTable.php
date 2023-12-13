<?php

namespace App\DataTables;

use App\Models\PatientRequest;
use App\Models\PendingDeposit;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class PendingDepositDataTable extends DataTable
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

                    if($patient_request->status == 4)
                    {
                        $btn .='<a href="'.route('patient_requests.deposit',$id).'"
                        class="btn btn-xs btn-success" data-toggle="tooltip"
                        title="deposit"><i class="fa fa-check"></i> </a> ';
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
        ->where('status',4)
        ->with('caretaker','hospital');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pendingdeposit-table')
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
            Column::make('caretaker.name')->data('caretaker.name')->title('Care Taker'),
            Column::make('caretaker.phone')->data('caretaker.phone')->title('Phone'),
            Column::make('hospital.name')->data('hospital.name')->title('Hospital'),
            Column::make('total_price')->data('total_price')->title('Total Price'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PendingDeposit_' . date('YmdHis');
    }
}
