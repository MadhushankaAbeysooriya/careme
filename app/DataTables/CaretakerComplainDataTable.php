<?php

namespace App\DataTables;

use App\Models\Complain;
use App\Models\CaretakerComplain;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class CaretakerComplainDataTable extends DataTable
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
            ->addColumn('status', function ($complain) {
                switch ($complain->status) {
                    case 0:
                        return '<h5><span class="badge badge-warning">Pending</span></h5>';
                        break;
                    case 1:
                        return '<h5><span class="badge badge-primary">Action Taken</span></h5>';
                        break;
                    // case 2:
                    //     return '<h5><span class="badge badge-success">Refunded</span></h5>';
                    //     break;
                    default:
                        return '<h5><span class="badge badge-danger">Error</span></h5>';
                        break;
                }
            })
            ->addColumn('action', function ($complain) {
                $id = $complain->id;
                $btn = '';

                $btn .= '<a href="'.route('complains.show',$id).'"
                class="btn btn-xs btn-info" data-toggle="tooltip" title="Show">
                <i class="fa fa-eye"></i> </a> ';

                return $btn;
            })
            ->rawColumns(['action','status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Complain $model): QueryBuilder
    {
        return $model->newQuery()
        ->whereHas('user', function ($query) {
            $query->where('user_type', 2);
        })
        ->with('user','patientrequest')->orderBy('status', 'asc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('caretakercomplain-table')
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
            Column::make('topic')->data('topic')->title('Topic'),
            Column::make('complain')->data('complain')->title('Complain'),
            Column::make('user.name')->data('user.name')->title('User'),
            Column::make('patientrequest.id')->data('patientrequest.id')->title('Job Ref'),
            Column::computed('status'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'CaretakerComplain_' . date('YmdHis');
    }
}
