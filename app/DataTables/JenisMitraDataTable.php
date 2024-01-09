<?php

namespace App\DataTables;

use App\Models\JenisMitra;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JenisMitraDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query results from query() method
     *
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('no', function ($data) {
                static $counter = 0;
                ++$counter;

                return $counter;
            })
            ->addColumn('published', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d M Y H:i');

                return $formatedDate;
            })
            ->addColumn('#', function ($query) {
                $updateButton = "<button type='button' class='btn btn-sm btn-icon btn-dark update' data-id='".$query->id."' data-bs-toggle='modal' data-bs-target='#formModal'><span class='tf-icons bx bx-pencil'></span></button>";
                $deleteButton = "<button type='button' class='btn btn-sm btn-icon btn-dark delete' data-id='".$query->id."' data-bs-toggle='modal' data-bs-target='#formDelete'><span class='tf-icons bx bx-trash'></span></button>";

                return $updateButton.' '.$deleteButton;
            })
            ->rawColumns(['#'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(JenisMitra $model)
    {
        return $model->newQuery()->orderBy('id', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('jenismitra-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('frtip')
                    ->orderBy(1);
        // ->buttons(
        //     Button::make('create'),
        //     Button::make('export'),
        //     Button::make('print'),
        //     Button::make('reset'),
        //     Button::make('reload')
        // );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
          Column::make('no'),
          Column::make('jenis_mitra'),
          Column::make('keterangan'),
          Column::make('published'),
          Column::computed('#')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'JenisMitra_'.date('YmdHis');
    }
}
