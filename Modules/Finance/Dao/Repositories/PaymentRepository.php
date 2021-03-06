<?php

namespace Modules\Finance\Dao\Repositories;

use Plugin\Notes;
use Plugin\Helper;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Modules\Finance\Dao\Models\Payment;
use Modules\Sales\Dao\Repositories\OrderRepository;

class PaymentRepository extends Payment implements MasterInterface
{
    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list);
    }

    public function saveRepository($request)
    {
        try {
            $activity = $this->create($request);
            return Notes::create($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function paidRepository($id)
    {
        try {
            $order = new OrderRepository();
            $activity = $order->updateRepository($id, ['sales_order_status' => 3]);
            return Notes::update($activity);
        } catch (QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function updateRepository($id, $request)
    {
        try {
            $activity = $this->findOrFail($id)->update($request);
            return Notes::update($activity);
        } catch (QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function deleteRepository($data)
    {
        try {
            $activity = $this->Destroy(array_values($data));
            return Notes::delete($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function showRepository($id)
    {
        return $this->findOrFail($id);
    }

    public function soRepository($id, $relation = null)
    {
        if ($relation) {
            return $this->with($relation)->where('finance_payment_sales_order_id', $id)->first();
        }
        return $this->where('finance_payment_sales_order_id', $id)->first();
    }
}
