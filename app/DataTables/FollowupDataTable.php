<?php

namespace App\DataTables;

use App\Models\FollowUp;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FollowupDataTable extends DataTable
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
            ->addColumn('#', function ($query) {
                $updateButton = "<button type='button' class='btn btn-sm btn-icon btn-dark update' data-id='".$query->id."' data-bs-toggle='modal' data-bs-target='#formModal'><span class='tf-icons bx bx-pencil'></span></button>";
                $deleteButton = "<button type='button' class='btn btn-sm btn-icon btn-dark delete' data-id='".$query->id."' data-bs-toggle='modal' data-bs-target='#formDelete'><span class='tf-icons bx bx-trash'></span></button>";

                return $updateButton.' '.$deleteButton;
            })
            ->editColumn('type', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d', $data->tanggal)->format('d/m/Y');

                return '<small><strong style="text-transform: uppercase;">'.$data->type.'</strong><br/>'.$formatedDate.'</small>';
            })
            ->editColumn('customer', function ($data) {
                return '<small>'.$data->customer.'<br/>'.$data->telepon.'</small>';
            })
            ->editColumn('marketing', function ($data) {
                return '<small>'.$data->marketing.'</small>';
            })
            ->editColumn('keterangan', function ($data) {
                return '<small>'.$data->keterangan.'</small>';
            })
            ->rawColumns(['type', 'marketing', '#', 'customer', 'keterangan'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FollowUp $model)
    {
        $query = $model->newQuery()->orderBy('id', 'desc');

        if (auth()->user()->roles->map->name[0] === 'marketing') {
            $query->where('marketing', '=', auth()->user()->nama_lengkap)->orderBy('id', 'desc');
        }

        $bulan = request('bulan');
        $tahun = request('tahun');

        if (isset($bulan) && isset($tahun)) {
            $query->where('bulan', '=', $bulan)
                  ->where('tahun', '=', $tahun)->orderBy('id', 'desc');
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('followup-table')
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
          Column::make('type'),
          Column::make('marketing'),
          Column::make('customer')->width(150),
          Column::make('keterangan'),
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
        return 'Followup_'.date('YmdHis');
    }
}
