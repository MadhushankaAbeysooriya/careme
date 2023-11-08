<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Crypt;

class UserDataTable extends DataTable
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
            ->addColumn('status', function($status){
                return ($status->status==1)?'<h5><span class="badge badge-primary">Active</span></h5>':
                '<h5><span class="badge badge-warning">Inactive</span></h5>';
            })
            ->addColumn('validated', function($validated){
                return ($validated->validated==1)?'<h5><span class="badge badge-primary">Validated</span></h5>':
                '<h5><span class="badge badge-warning">Not-Validate</span></h5>';
            })
            ->addColumn('action', function ($user) {
                $btn = '';
                $encryptedId = Crypt::encrypt($user->id);

                    $btn .= '<a href="'.route('users.edit',$encryptedId).'"
                    class="btn btn-xs btn-info" data-toggle="tooltip" title="Edit">
                    <i class="fa fa-pen-alt"></i> </a> ';

                    $btn .= '<a href="'.route('users.show',$encryptedId).'"
                    class="btn btn-xs btn-secondary" data-toggle="tooltip" title="View">
                    <i class="fa fa-eye"></i> </a> ';

                    $btn .= '<a href="'.route('users.resetpass',$encryptedId).'"
                    class="btn btn-xs btn-warning" data-toggle="tooltip" title="reset Password">
                    <i class="fa fa-redo"></i> </a> ';

                    if($user->status==1)
                    {
                        $btn .='<a href="'.route('users.inactive',$encryptedId).'"
                        class="btn btn-xs btn-danger" data-toggle="tooltip"
                        title="Suspend"><i class="fa fa-trash"></i> </a> ';

                    }elseif($user->status==0)
                    {
                        $btn .='<a href="'.route('users.activate',$encryptedId).'"
                        class="btn btn-xs btn-danger" data-toggle="tooltip"
                        title="Activate"><i class="fa fa-unlock"></i> </a> ';
                    }

                    if($user->validated==0)
                    {
                        $btn .='<a href="'.route('users.validated',$encryptedId).'"
                        class="btn btn-xs btn-success" data-toggle="tooltip"
                        title="Validated"><i class="fa fa-check"></i> </a> ';

                    }elseif($user->validated==1)
                    {
                        $btn .='<a href="'.route('users.notvalidated',$encryptedId).'"
                        class="btn btn-xs btn-danger" data-toggle="tooltip"
                        title="Non-Validate"><i class="fa fa-times"></i> </a> ';
                    }

           return $btn;
            })

            ->addColumn('roles', function ($user) {
                $roles = $user->getRoleNames();
                $badges = '';

                if (!empty($roles)) {
                    foreach ($roles as $role) {
                        $badges .= '<label class="badge badge-success">' . $role . '</label>';
                    }
                }

                return $badges;
            })
            ->rawColumns(['action','roles','status','validated']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('add'),
                        Button::make('excel'),
                        Button::make('csv'),
                        //Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
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
                  ->width(90)
                  ->addClass('text-center'),
            Column::make('name')->data('name')->title('Name'),
            Column::make('email')->data('email')->title('Email'),
            Column::computed('roles'),
            Column::computed('status'),
            Column::computed('validated'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
