<?php

namespace Modules\Sales\Dao\Repositories\report;

use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Dao\Models\Order;
use Modules\Item\Dao\Models\Product;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Modules\Procurement\Dao\Repositories\PurchaseRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;

class ReportSummaryOrderRepository extends Order implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithMapping
{
    public $model;
    public function headings(): array
    {
        return [
            'Sales ID',
            'Date',
            'Branch',
            'Status',
            'Total',
            'Bayar',
            'Kembali',
            'Fee',
        ];
    }


    public function __construct()
    {
        $this->model = new OrderRepository();
    }

    public function collection()
    {
        $query = $this->model
            ->select([
                'sales_order_id',
                'sales_order_date_order',
                'sales_order_from_name',
                'sales_order_status',
                'sales_order_sum_total',
                'sales_order_sum_bayar',
                'sales_order_sum_kembalian',
            ]);
        
        if ($promo = request()->get('promo')) {
            $query->where('sales_order_marketing_promo_code', $promo);
        }
        if ($courier = request()->get('courier')) {
            $query->where('sales_order_courier_code', $courier);
        }
        if ($branch = request()->get('branch')) {
            $query->where('sales_order_from_id', $branch);
        }
        if ($status = request()->get('status')) {
            $query->where('sales_order_status', $status);
        }
        if ($from = request()->get('from')) {
            $query->where('sales_order_date_order', '>=', $from);
        }
        if ($to = request()->get('to')) {
            $query->where('sales_order_date_order','<=', $to);
        }
        return $query->get();
    }

    public function map($data): array
    {
        return [
           $data->sales_order_id, 
        //    $data->sales_order_created_at ? $data->sales_order_created_at->format('d-m-Y') : '', 
           $data->sales_order_date_order ? $data->sales_order_date_order->format('d-m-Y H:i:s') : '', 
           $data->sales_order_from_name, 
        //    $data->sales_order_to_name, 
           $data->status[$data->sales_order_status][0] ?? '', 
        //    $data->sales_order_sum_product, 
        //    $data->sales_order_discount_name, 
        //    $data->sales_order_discount_value, 
        //    $data->sales_order_sum_weight, 
        //    $data->sales_order_courier_code, 
        //    $data->sales_order_courier_name, 
        //    $data->sales_order_courier_waybill, 
        //    $data->sales_order_sum_ongkir,
           $data->sales_order_sum_total, 
           $data->sales_order_sum_bayar, 
           $data->sales_order_sum_kembalian, 
           Helper::calculate(config('website.fee')) * $data->sales_order_sum_total
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'C' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
            'G' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}