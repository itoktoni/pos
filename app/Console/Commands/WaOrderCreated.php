<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Finance\Dao\Facades\BankFacades;
use Modules\Sales\Dao\Facades\OrderGroupFacades;
use Plugin\Helper;
use Plugin\Whatsapp;

class WaOrderCreated extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wa:order_created';

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
        $order_group = OrderGroupFacades::where('sales_group_status', 1)->whereNull('sales_group_date_wa_created_order')->limit(1)->get();
        if ($order_group) {
            foreach ($order_group as $group_item) {

                $message = "*PESANAN BERHASIL DIBUAT* \n \n";
                $message = $message . "*No. Order : " . $group_item->sales_group_id . "* \n \n";
                $message = $message . "Customer : $group_item->sales_group_customer_name \n";
                $message = $message . "Alamat : $group_item->sales_group_customer_address \n";

                $data_order = $group_item->order;
                if ($data_order->count() > 0) {

                    $branch = null;
                    foreach ($data_order as $order_item) {
                        $message = $message . "\nBranch : $order_item->sales_order_from_name \n";

                        foreach ($order_item->detail as $detail) {
                            $message = $message . "Produk : \n";
                            $number = 1;

                            $message = $message . $detail->sales_order_detail_item_product_description . ' (' . $detail->sales_order_detail_qty . ') x ' . Helper::createRupiah($detail->sales_order_detail_price) . '' . ' = ' . Helper::createRupiah($detail->sales_order_detail_total) . '\n';
                            $number++;
                        }

                        $message = $message . 'Sub Total : ' . Helper::createRupiah($order_item->sales_order_sum_product);
                        $message = $message . '\nOngkir : ' . $order_item->sales_order_courier_name;
                        $message = $message . '\nTotal: ' . Helper::createRupiah($order_item->sales_order_sum_total).' \n';
                    }

                }

                $message = $message . '\n \nTOTAL VALUE : ' . Helper::createRupiah($group_item->sales_group_sum_total) . '\n';
                if ($group_item->sales_group_discount_value > 0) {

                    $message = $message . 'PROMO : ' . $group_item->sales_group_discount_name . ' ( ' . Helper::createRupiah($group_item->sales_group_discount_value) . ' ) \n';
                }
                $message = $message . 'TOTAL ONGKIR : ' . Helper::createRupiah($group_item->sales_group_sum_ongkir) . '\n';
                $message = $message . '*TOTAL ORDER: ' . Helper::createRupiah($group_item->sales_group_sum_total) . '*\n';

                $message = $message . '\nPembayaran ke Rekening : \n';
                foreach (BankFacades::where('finance_bank_active', 1)->get() as $account) {
                    $message = $message . $account->finance_bank_name . ' a.n ' . $account->finance_bank_account_name . ' : ' . $account->finance_bank_account_number . '\n';
                }

                $group_item->sales_group_date_wa_created_order = date('Y-m-d H:i:s');
                $group_item->save();

                Whatsapp::send($group_item->sales_group_customer_phone, $message);
            }

        }

        $this->info('The system has been sent successfully!');
    }
}
