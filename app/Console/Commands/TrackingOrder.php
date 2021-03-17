<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Ixudra\Curl\Facades\Curl;
use Modules\Finance\Emails\OrderTrackingEmail;
use Modules\Sales\Dao\Facades\OrderFacades;
use Modules\Sales\Dao\Models\OrderTracking as ModelsOrderTracking;
use Plugin\Whatsapp;

class TrackingOrder extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This commands to cancel order if order is not paid';

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

        $list = OrderFacades::where('sales_order_status', 4)->whereNotNull('sales_order_courier_waybill')->whereNull('sales_order_courier_received_date')->where('sales_order_courier_date', '!=', date('Y-m-d'))->limit(1);
        foreach ($list->get() as $data) {

            if ($data) {
                try {

                    // 'waybill' => '18266319393',
                    // 'courier' => 'pos',
                    $response = Curl::to(route('waybill'))->withData([
                        'waybill' => $data->sales_order_courier_waybill,
                        'courier' => $data->sales_order_courier_code,
                    ])->post();
                    $waybill = json_decode($response);
                    Cache::put('waybill', $waybill);
                    if (isset($waybill->rajaongkir->result->manifest) && !empty($waybill->rajaongkir->result->manifest)) {

                        $check_tracking = ModelsOrderTracking::where('order_tracking_order_id', $data->sales_order_id)->orderByDesc('order_tracking_date')->first();
                        $manifest = collect($waybill->rajaongkir->result->manifest)->sortDesc()->first();

                        if ($check_tracking) {

                            if($manifest->manifest_date != $check_tracking->order_tracking_date){

                                ModelsOrderTracking::create([
                                    'order_tracking_order_id' => $data->sales_order_id,
                                    'order_tracking_location' => $manifest->city_name,
                                    'order_tracking_date' => $manifest->manifest_date,
                                    'order_tracking_description' => str_replace('~~', '', $manifest->manifest_description),
                                ]);
                            }

                        } else {
                            foreach ($waybill->rajaongkir->result->manifest as $result) {

                                ModelsOrderTracking::create([
                                    'order_tracking_order_id' => $data->sales_order_id,
                                    'order_tracking_location' => $result->city_name,
                                    'order_tracking_date' => $result->manifest_date,
                                    'order_tracking_description' => str_replace('~~', '', $result->manifest_description),
                                ]);

                            }
                        }

                        $message = 'TRACKING NO. ORDER : '.$data->sales_order_id.' \n \n';
                        $message = $message.'*Customer '.$data->sales_order_to_name.'* \n \n';
                        $message = $message.'Status : '.$manifest->manifest_code.' \n';
                        $message = $message.'Notes : '.str_replace('~~', '',$manifest->manifest_description).' \n \n';
                        $message = $message.'Location : '.$manifest->city_name.' \n';
                        $message = $message.'Last Update : '.$manifest->manifest_date.' '.$manifest->manifest_time.' \n';

                        Whatsapp::send($data->sales_order_to_phone, $message);

                        $data->sales_order_courier_date = date('Y-m-d');
                        $data->save();

                        if($data->sales_order_to_email){

                            Mail::to([$data->sales_order_to_email])->send(new OrderTrackingEmail($data, $manifest));
                        }

                        if ($waybill->rajaongkir->result->delivered) {

                            $branch = '*HALO '.$data->sales_order_from_name.'* \n \n';
                            Whatsapp::send($data->sales_order_from_phone, $branch.$message);

                            $dl = $waybill->rajaongkir->result->delivery_status;
                            $data->sales_order_courier_received_date = $dl->pod_date;
                            $data->sales_order_courier_received_by = $dl->pod_receiver;
                            $data->sales_order_status = 5;
                            $data->sales_order_courier_date = date('Y-m-d');
                            $data->save();
                        }
                    }

                } catch (\Throwable $th) {
                    abort(403, $th->getMessage());
                    //throw $th;
                }
            }
        }

        $this->info('The system tracking order has been recorded !');

    }

}
