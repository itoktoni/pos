<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Finance\Dao\Facades\PaymentFacades;
use Modules\Finance\Dao\Models\Payment;
use Modules\Sales\Dao\Facades\OrderGroupFacades;
use Plugin\Helper;
use Plugin\Whatsapp;

class WaPaymentApproved extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wa:payment_approved';

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
        $payment_data = $data_order = $data = $message = null;
        $payment_data = PaymentFacades::whereNull('finance_payment_date_wa_approved')->whereNotNull('finance_payment_approved_at')->limit(1)->get();
        if ($payment_data) {
            foreach ($payment_data as $payment_item) {
                $message = "*PEMBAYARAN TELAH DITERIMA* \n \n";
                $message = $message. "No. Order : $payment_item->finance_payment_sales_order_id \n";
                $message = $message. "Nama : $payment_item->finance_payment_person \n";
                $message = $message. "Tgl Terima Pembayaran : ".$payment_item->finance_payment_approved_at->format('d M Y')." \n";
                $message = $message. "Jumlah Diterima : ". Helper::createRupiah($payment_item->finance_payment_approve_amount)." \n";
                $message = $message. "Catatan admin : $payment_item->finance_payment_description \n";
                
                // Mail::to([$payment_item->finance_payment_email, config('website.email')])->send(new ApprovePaymentEmail($payment_item));
                Whatsapp::send($payment_item->finance_payment_phone, $message);
                
                $payment_item->finance_payment_date_wa_approved = date('Y-m-d H:i:s');
                $payment_item->save();
                
            }
        }

        $this->info('The system has been sent successfully!');
    }
}
