<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Finance\Dao\Repositories\PaymentRepository;
use Modules\Finance\Emails\ApprovePaymentEmail;
use Modules\Finance\Emails\ConfirmationPaymentEmail;
use Modules\Finance\Emails\OrderWaybillEmail;
use Modules\Sales\Dao\Facades\OrderFacades;
use Modules\Sales\Dao\Facades\OrderGroupFacades;
use Modules\Sales\Emails\ApproveOrderEmail;
use Modules\Sales\Emails\CreateGroupEmail;
use Modules\Sales\Emails\CreateOrderEmail;

class SendEmail extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:cronjob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Commands To Sending Email';

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
        $order_data = OrderGroupFacades::where('sales_group_status', 2)->whereNull('sales_group_date_email_created_order')->whereNotNull('sales_group_customer_email')->limit(1)->get();
        if ($order_data) {

            foreach ($order_data as $order_item) {

                Mail::to([config('website.email')])->send(new CreateGroupEmail($order_item));
                $order_item->sales_group_customer_email = date('Y-m-d H:i:s');
                $order_item->save();
            }
        }

        $payment = new PaymentRepository();
        $payment_data = $payment->dataRepository()->whereNull('finance_payment_date_email_created')->limit(2)->get();
        if ($payment_data) {

            foreach ($payment_data as $payment_item) {
                $data = $payment->showRepository($payment_item->finance_payment_id);
                Mail::to([$payment_item->finance_payment_email, config('website.email')])->send(new ConfirmationPaymentEmail($data));
                $data->finance_payment_date_email_created = date('Y-m-d H:i:s');
                $data->save();
            }
        }

        $payment_approve = $payment->dataRepository()->whereNull('finance_payment_date_email_approved')->whereNotNull('finance_payment_email')->whereNotNull('finance_payment_approved_at')->limit(2)->get();
        if ($payment_approve) {

            foreach ($payment_approve as $payment_approve) {
                $data = $payment->showRepository($payment_approve->finance_payment_id);
                Mail::to([$data->finance_payment_email, config('website.email')])->send(new ApprovePaymentEmail($data));
                $data->finance_payment_date_email_approved = date('Y-m-d H:i:s');
                $data->save();
            }
        }

        $order_data = OrderGroupFacades::where('sales_group_status', 3)->whereNull('sales_group_date_email_approved_order')->limit(1)->get();
        if ($order_data) {

            foreach ($order_data as $order_item) {
                if ($order_item->sales_group_customer_email) {

                    Mail::to([config('website.email')])->send(new ApproveOrderEmail($order_item));
                    $order_item->sales_group_date_email_approved_order = date('Y-m-d H:i:s');
                    $order_item->save();
                }

                if ($order_item->order->count() > 0) {

                    foreach ($order_item->order as $branch) {

                        Mail::to([$branch->sales_order_from_email])->send(new CreateOrderEmail($branch));
                        $branch->sales_order_date_email_approved_order = date('Y-m-d H:i:s');
                        $branch->save();
                    }
                }

            }
        }

       $tracking = OrderFacades::whereNotNull('sales_order_courier_waybill')->whereNotNull('sales_order_to_email')->whereNull('sales_order_date_email_track_order')->limit(2)->get();
        if ($tracking) {

            foreach ($tracking as $tracking) {
                if(!empty($tracking->sales_order_courier_waybill)){

                    Mail::to([$tracking->sales_order_to_email, config('website.email')])->send(new OrderWaybillEmail($tracking));
                    $tracking->sales_order_date_email_track_order = date('Y-m-d H:i:s');
                    $tracking->save();
                }
            }
        }

        $this->info('The system has been sent successfully!');
    }
}
