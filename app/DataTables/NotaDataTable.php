<?php

namespace App\DataTables;

use App\Models\Nota;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NotaDataTable extends DataTable
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
            ->addColumn('#', function ($query) {
                $downloadButton = "<button type='button' class='btn btn-sm btn-icon btn-dark download' data-file='".$query->file."'><span class='tf-icons bx bx-download'></span></button>";
                $updateButton = "<button type='button' class='btn btn-sm btn-icon btn-dark update' data-id='".$query->id."' data-bs-toggle='modal' data-bs-target='#formModal'><span class='tf-icons bx bx-pencil'></span></button>";
                $deleteButton = "<button type='button' class='btn btn-sm btn-icon btn-dark delete' data-id='".$query->id."' data-bs-toggle='modal' data-bs-target='#formDelete'><span class='tf-icons bx bx-trash'></span></button>";

                return $downloadButton.' '.$updateButton.' '.$deleteButton;
            })
            ->editColumn('nomor', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d', $data->tanggal)->format('d/m/Y');

                return '<a class="show" style="cursor: pointer;" data-id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#formShow"><small><strong style="text-transform: uppercase;">'.$data->type.'</strong><br/>'.$data->nomor.'<br/>'.$formatedDate.'</small></a>';
            })
            ->editColumn('customer', function ($data) {
                return '<small>'.$data->customer.'<br/>'.$data->telepon.'</small>';
            })
            ->editColumn('payment', function ($data) {
                $payment = 'Rp. '.number_format($data->payment, 0, ',', '.');

                return '<small>'.$payment.'</small>';
            })
            ->editColumn('amount', function ($data) {
                $amount = 'Rp. '.number_format($data->amount, 0, ',', '.');

                return '<small>'.$amount.'</small>';
            })
            ->editColumn('paid', function ($data) {
                $paid = 'Rp. '.number_format($data->paid, 0, ',', '.');

                return '<small>'.$paid.'</small>';
            })
            ->editColumn('total', function ($data) {
                $total = 'Rp. '.number_format($data->total, 0, ',', '.');

                return '<small>'.$total.'</small>';
            })
            ->editColumn('alamat', function ($data) {
                return '<small>'.$data->street.'<br/>'.$data->district.'<br/>'.$data->city.'</small>';
            })
            ->rawColumns(['nomor', 'alamat', 'amount', 'payment', 'paid', 'total', '#', 'customer'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Nota $model)
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
                    ->setTableId('nota-table')
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
          Column::make('nomor'),
          Column::make('customer'),
          Column::make('alamat'),
          Column::make('amount'),
          Column::make('payment'),
          Column::make('paid'),
          Column::make('total'),
          Column::computed('#')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Nota_'.date('YmdHis');
    }
}
