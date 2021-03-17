<?php

namespace Modules\Sales\Dao\Repositories\report;

use App\Dao\Models\Branch;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Finance\Dao\Models\Payment;
use Modules\Item\Dao\Models\Category;
use Modules\Item\Dao\Models\Product;
use Modules\Item\Dao\Models\Variant;
use Modules\Rajaongkir\Dao\Models\Delivery;
use Modules\Sales\Dao\Models\OrderDetail;
use Modules\Sales\Dao\Models\OrderDetailVariant;
use Modules\Sales\Dao\Repositories\OrderRepository;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReportPaymentRepository extends Payment implements WithHeadings, ShouldAutoSize, WithColumnFormatting, FromCollection, WithMapping
{
    public $order;
    public $detail;
    public $product;
    public $branch;
    public $payment;
    public $key = [];

    public function __construct()
    {
        $this->order = new OrderRepository();
        $this->detail = new OrderDetail();
        $this->product = new Product();
        $this->category = new Category();
        $this->branch = new Branch();
        $this->variant_detail = new OrderDetailVariant();
        $this->variant = new Variant();
        $this->delivery = new Delivery();
        $this->payment = new Payment();
    }

    public function collection()
    {
        $query = $this->payment
            ->leftJoin($this->order->getTable(), $this->order->getKeyName(), 'finance_payment_sales_order_id')
            ->leftJoin($this->branch->getTable(), 'sales_order_from_id', $this->branch->getKeyName())
            ->select([
                'sales_order_id',
                'finance_payment.*',
            ]);

     
        if ($status = request()->get('status')) {
            $query->where('finance_payment_status', $status);
        }
        if ($from = request()->get('from')) {
            $query->where('finance_payment_date', '>=', $from);
        }
        if ($to = request()->get('to')) {
            $query->where('finance_payment_date', '<=', $to);
        }
        
        if ($in_out = request()->get('in_out')) {
            $query->where('finance_payment_in_out', $in_out);
        }
        
        return $query->orderBy('finance_payment_date', 'ASC')->get();
    }

    public function headings(): array
    {
        return [
            'From',
            'To',
            'Tanggal Order',
            'Tanggal Pembayaran',
            'No. Order',
            'Person',
            'Type Uang',
            'Total Order',
            'Status',
            'Diapprove Oleh',
            'Total Order',
            'Total Bayar',
            'Total Di Approve',
        ];
    }

    public function map($data): array
    {
        return [
            $data->finance_payment_from,
            $data->finance_payment_to,
            $data->sales_order_date_order ? $data->sales_order_date_order->format('d-m-Y') : '',
            $data->finance_payment_date ? $data->finance_payment_date->format('d-m-Y') : '',
            $data->sales_order_id,
            $data->finance_payment_person,
            $data->finance_payment_in_out ? 'Uang Masuk' : 'Uang Keluar',
            $data->status[$data->finance_payment_status][0] ?? '',
            $data->finance_payment_approved_by,
            $data->sales_order_sum_total,
            $data->finance_payment_amount,
            $data->finance_payment_approve_amount,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'E' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
