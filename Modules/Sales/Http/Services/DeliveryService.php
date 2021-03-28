<?php

namespace Modules\Sales\Http\Services;

use Plugin\Alert;
use App\Http\Services\MasterService;
use App\Dao\Interfaces\MasterInterface;
use Modules\Item\Dao\Models\Product;
use Modules\Item\Dao\Models\ProductDetail;
use Modules\Sales\Dao\Facades\DeliveryDetailFacades;
use Modules\Sales\Dao\Facades\DeliveryFacades;

class DeliveryService extends MasterService
{
    public function save(MasterInterface $repository, $request)
    {
        $check = false;
        try {
            $check = $repository->saveRepository($request);
            DeliveryDetailFacades::insert($request['detail']);
            foreach($request['detail'] as $detail){

               $product = ProductDetail::where('item_detail_branch_id', $request['sales_delivery_from_id'])
               ->where('item_detail_product_id', $detail['sales_delivery_detail_item_product_id'])
               ->first();

               if($product){
                $product->item_detail_stock_qty = $product->item_detail_stock_qty - $detail['sales_delivery_detail_qty'];
                $product->save();
               }
            }

            Alert::create();
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return $th->getMessage();
        }

        return $check;
    }


    public function update(MasterInterface $repository, $request)
    {
        $id = request()->query('code');
        $check = $repository->updateRepository($id, $request);
        foreach ($request['detail'] as $item) {
            $where = [
                DeliveryDetailFacades::getKeyName() => $item[DeliveryDetailFacades::getKeyName()],
                DeliveryDetailFacades::getForeignKey() => $item[DeliveryDetailFacades::getForeignKey()],
            ];
            DeliveryDetailFacades::updateOrInsert($where, $item);
        }

        if ($check['status']) {
            Alert::update();
        } else {
            Alert::error($check['data']);
        }
    }

   public function delivery(MasterInterface $repository, $request)
    {
        $check = false;
        try {
            $check = $repository->saveRepository($request);
            DeliveryDetailFacades::insert($request['detail']);
            Alert::create();
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return $th->getMessage();
        }

        return $check;
    }

    public function updated(MasterInterface $repository, $request)
    {
        $id = request()->query('code');
        $check = $repository->updateRepository($id, $request);
        foreach ($request['detail'] as $item) {
            $where = [
                DeliveryDetailFacades::getKeyName() => $item[DeliveryDetailFacades::getKeyName()],
                DeliveryDetailFacades::getForeignKey() => $item[DeliveryDetailFacades::getForeignKey()],
            ];
            DeliveryDetailFacades::updateOrInsert($where, $item);
        }

        if ($check['status']) {
            Alert::update();
        } else {
            Alert::error($check['data']);
        }
    }


}