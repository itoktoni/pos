<?php

namespace Modules\Sales\Http\Services;

use Plugin\Alert;
use App\Http\Services\MasterService;
use App\Dao\Interfaces\MasterInterface;
use Modules\Sales\Dao\Facades\PurchaseDetailFacades;
use Modules\Sales\Dao\Facades\DeliveryDetailFacades;
use Modules\Sales\Dao\Facades\DeliveryFacades;

class PurchaseService extends MasterService
{
    public function save(MasterInterface $repository, $request)
    {
        $check = false;
        try {
            $check = $repository->saveRepository($request);
            PurchaseDetailFacades::insert($request['detail']);
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
                PurchaseDetailFacades::getKeyName() => $item[PurchaseDetailFacades::getKeyName()],
                PurchaseDetailFacades::getForeignKey() => $item[PurchaseDetailFacades::getForeignKey()],
            ];
            PurchaseDetailFacades::updateOrInsert($where, $item);
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