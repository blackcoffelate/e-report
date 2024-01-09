<?php

namespace App\DataTables;

use App\Models\Quotation;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class QuotationDataTable extends DataTable
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
                $downloadButton = "<button type='button' class='btn btn-sm btn-icon btn-dark download' data-file='".$query->file."'><span class='tf-icons bx bx-download'></span></button>";
                $updateButton = "<button type='button' class='btn btn-sm btn-icon btn-dark update' data-id='".$query->id."' data-bs-toggle='modal' data-bs-target='#formModal'><span class='tf-icons bx bx-pencil'></span></button>";
                $deleteButton = "<button type='button' class='btn btn-sm btn-icon btn-dark delete' data-id='".$query->id."' data-bs-toggle='modal' data-bs-target='#formDelete'><span class='tf-icons bx bx-trash'></span></button>";

                return $downloadButton.' '.$updateButton.' '.$deleteButton;
            })
            ->editColumn('nomor', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d', $data->tanggal)->format('d/m/Y');

                return '<small><strong style="text-transform: uppercase;">'.$data->type.'</strong><br/>'.$data->nomor.'<br/>'.$formatedDate.'</small>';
            })
            ->editColumn('customer', function ($data) {
                return '<small>'.$data->customer.'<br/>'.$data->telepon.'<br/>'.$data->street.'<br/>'.$data->district.'<br/>'.$data->city.'</small>';
            })
            ->editColumn('amount', function ($data) {
                $amount = 'Rp. '.number_format($data->amount, 0, ',', '.');

                return '<small>'.$amount.'</small>';
            })
            ->editColumn('marketing', function ($data) {
                return '<small>'.$data->marketing.'</small>';
            })
            ->rawColumns(['nomor', 'marketing', 'amount', '#', 'customer'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Quotation $model)
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
                    ->setTableId('quotation-table')
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
          Column::make('nomor'),
          Column::make('marketing'),
          Column::make('customer')->width(150),
          Column::make('amount'),
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
        return 'Quotation_'.date('YmdHis');
    }
}
