<?php

namespace App\DataTables;

use App\Models\AdvertisementCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdvertisementCategoryDataTable extends DataTable
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
            ->addColumn('status', function($advertisement_category){
                return ($advertisement_category->status==1)?'<h5><span class="badge badge-primary">Active</span></h5>':
                '<h5><span class="badge badge-warning">Inactive</span></h5>';
            })
            ->addColumn('action', function ($advertisement_category) {
                $id = $advertisement_category->id;
                $btn = '';
                    $btn .= '<a href="'.route('advertisement_categories.edit',$id).'"
                    class="btn btn-xs btn-info" data-toggle="tooltip" title="Edit">
                    <i class="fa fa-pen-alt"></i> </a> ';

                    if($advertisement_category->status==1)
                    {
                        $btn .='<a href="'.route('advertisement_categories.inactive',$id).'"
                        class="btn btn-xs btn-danger" data-toggle="tooltip"
                        title="Suspend"><i class="fa fa-trash"></i> </a> ';

                    }elseif($advertisement_category->status==0)
                    {
                        $btn .='<a href="'.route('advertisement_categories.activate',$id).'"
                        class="btn btn-xs btn-danger" data-toggle="tooltip"
                        title="Activate"><i class="fa fa-unlock"></i> </a> ';
                    }

                return $btn;
            })
            ->rawColumns(['action','status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(AdvertisementCategory $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('advertisementcategory-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('add'),
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
            Column::make('name')->data('name')->title('Name'),
            Column::make('amount')->data('amount')->title('Amount'),
            Column::computed('status'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AdvertisementCategory_' . date('YmdHis');
    }
}
