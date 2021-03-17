<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Sales\Dao\Facades\OrderGroupFacades;
use Plugin\Helper;
use Plugin\Whatsapp;

class WaOrderApproved extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wa:order_approved';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Commands To Sending Wa to customer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $order_group = $message = null;
        $order_group = OrderGroupFacades::where('sales_group_status', 3)->whereNull('sales_group_date_wa_approved_order')->limit(1)->get();
        if ($order_group) {
            foreach ($order_group as $group_item) {

                $message = "*PESANAN DI PROSES* \n \n";
                $message = $message . "*No. Order : " . $group_item->sales_group_id . "* \n \n";
                $message = $message . "Customer : $group_item->sales_group_customer_name \n";
                $message = $message . "Alamat : $group_item->sales_group_customer_address \n";

                $data_order = $group_item->order;
                if ($data_order->count() > 0) {

                    $branch = null;
                    foreach ($data_order as $order_item) {
                        $branch = "*NOTIFIKASI PESANAN* \n \n";
                        $branch = $branch . "*No. Order : " . $order_item->sales_order_id . "* \n";
                        $branch = $branch. "$order_item->sales_order_from_name \n \n";
                        $branch = $branch . "Customer : $group_item->sales_group_customer_name \n";
                        $branch = $branch . "Alamat : $group_item->sales_group_customer_address \n \n";

                        $message = $message . "*No. Order : " . $order_item->sales_order_id . "* \n";
                        $message = $message . "\nBranch : $order_item->sales_order_from_name \n";
                        foreach ($order_item->detail as $detail) {
                            $message = $message . "Produk : \n";
                            $branch = $branch . "Produk : \n";
                            $num = 1;
                            $number = 1;

                            $message = $message . $detail->sales_order_detail_item_product_description . ' (' . $detail->sales_order_detail_qty . ') x ' . Helper::createRupiah($detail->sales_order_detail_price) . '' . ' = ' . Helper::createRupiah($detail->sales_order_detail_total) . '\n';
                            $branch = $branch . $detail->sales_order_detail_item_product_description . ' (' . $detail->sales_order_detail_qty . ') x ' . Helper::createRupiah($detail->sales_order_detail_price) . '' . ' = ' . Helper::createRupiah($detail->sales_order_detail_total) . '\n';
                            
                            $number++;
                            $num++;
                        }

                        $message = $message . '\nSub Total : ' . Helper::createRupiah($order_item->sales_order_sum_product);
                        $message = $message . '\nOngkir : ' . $order_item->sales_order_courier_name;
                        $message = $message . '\nTotal : ' . Helper::createRupiah($order_item->sales_order_sum_total).' \n';

                        $branch = $branch . '\nSub Total : ' . Helper::createRupiah($order_item->sales_order_sum_product);
                        $branch = $branch . '\nOngkir : ' . $order_item->sales_order_courier_name;
                        $branch = $branch . '\n*Total : ' . Helper::createRupiah($order_item->sales_order_sum_total).'*';

                        $order_item->sales_order_date_wa_approved_wa = date('Y-m-d H:i:s');
                        $order_item->save();

                        Whatsapp::send($order_item->sales_order_from_phone, $branch);
                    }

                }

                $message = $message . '\nTOTAL VALUE : ' . Helper::createRupiah($group_item->sales_group_sum_total) . '\n';
                if ($group_item->sales_group_discount_value > 0) {

                    $message = $message . 'PROMO : ' . $group_item->sales_group_discount_name . ' ( ' . Helper::createRupiah($group_item->sales_group_discount_value) . ' ) \n';
                }
                $message = $message . 'TOTAL ONGKIR : ' . Helper::createRupiah($group_item->sales_group_sum_ongkir) . '\n';
                $message = $message . 'TOTAL ORDER : *' . Helper::createRupiah($group_item->sales_group_sum_total) . '*\n';

                $message = $message . '\n' . config('website.promo') . '\n';

                $group_item->sales_group_date_wa_approved_order = date('Y-m-d H:i:s');
                $group_item->save();

                Whatsapp::send($group_item->sales_group_customer_phone, $message);
            }

        }

        $this->info('The system has been sent successfully!');
    }
}
