<?php

namespace App\Console\Commands;

use App\Dao\Facades\BranchFacades;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Ixudra\Curl\Facades\Curl;
use Modules\Finance\Emails\OrderTrackingEmail;
use Modules\Item\Dao\Facades\ProductFacades;
use Modules\Item\Dao\Models\ProductDetail;
use Modules\Sales\Dao\Facades\OrderFacades;
use Modules\Sales\Dao\Models\OrderTracking as ModelsOrderTracking;
use Plugin\Whatsapp;

class CheckStock extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:check';

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
        $detail = new ProductDetail();
        $data_product = DB::table(ProductFacades::getTable())
        ->join($detail->getTable(),'item_detail_product_id', ProductFacades::getKeyName())
        ->join(BranchFacades::getTable(),'item_detail_branch_id', BranchFacades::getKeyName())
        ->where('item_detail_stock_enable', 1)
        ->get();
        
        $message = null;
        $message = "*STOCK MENIPIS* \n \n";
        foreach ($data_product as $product) {
            if($product->item_product_min_stock >= $product->item_detail_stock_qty){

                $message = $message . "*Product : " . $product->item_product_name . "* \n \n";
                $message = $message . "*Branch : " . $product->branch_name . "* \n \n";
                $message = $message . "Stock : $product->item_detail_stock_qty \n";
                $message = $message . "Min Stock : $product->item_product_min_stock \n";
            }
        }
        Whatsapp::send(config('website.phone'), $message);
        Log::info($message);
        $this->info('The system stock has been checked !');

    }

}
