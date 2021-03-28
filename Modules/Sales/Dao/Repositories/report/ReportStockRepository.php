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
use Modules\Item\Dao\Models\ProductDetail;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Procurement\Dao\Repositories\PurchaseRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;

class ReportStockRepository extends ProductDetail implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithMapping
{
    public $model;
    public function headings(): array
    {
        return [
            'Product ID',
            'Category',
            'Nama Product',
            'Branch',
            'Harga Jual',
            'Stock',
        ];
    }


    public function __construct()
    {
        $this->model = new ProductRepository();
    }

    public function collection()
    {
        $query = $this->model->stockRepository()
            ->select([
                'item_detail_product_id',
                'item_category_name',
                'item_product_name',
                'branch_name',
                'item_product_sell',
                DB::raw('sum(item_detail_stock_qty) as qty'),
            ]);
        
        // if ($promo = request()->get('promo')) {
        //     $query->where('sales_order_marketing_promo_code', $promo);
        // }
        // if ($courier = request()->get('courier')) {
        //     $query->where('sales_order_courier_code', $courier);
        // }
        if ($branch = request()->get('branch')) {
            $query->where('item_detail_branch_id', $branch);
        }
        if ($product = request()->get('product')) {
            $query->where('item_detail_product_id', $product);
        }
        // if ($status = request()->get('status')) {
        //     $query->where('sales_order_status', $status);
        // }
        // if ($from = request()->get('from')) {
        //     $query->where('item_detail_date_sync', '>=', $from);
        // }
        // if ($to = request()->get('to')) {
        //     $query->where('item_detail_date_sync','<=', $to);
        // }
        return $query->get();
    }

    public function map($data): array
    {
        return [
           $data->item_detail_product_id, 
        //    $data->sales_order_created_at ? $data->sales_order_created_at->format('d-m-Y') : '', 
        //    $data->sales_order_date_order ? $data->sales_order_date_order->format('d-m-Y') : '', 
        //    $data->sales_order_to_name, 
        //    $data->status[$data->sales_order_status][0] ?? '', 
        //    $data->sales_order_sum_product, 
        //    $data->sales_order_discount_name, 
        //    $data->sales_order_discount_value, 
        //    $data->sales_order_sum_weight, 
        //    $data->sales_order_courier_code, 
        //    $data->sales_order_courier_name, 
        //    $data->sales_order_courier_waybill, 
        //    $data->sales_order_sum_ongkir,
           $data->item_category_name, 
           $data->item_product_name, 
           $data->branch_name, 
           $data->item_product_sell, 
           $data->qty, 
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}