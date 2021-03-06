<?php

namespace App\Dao\Repositories;

use App\Dao\Facades\CompanyFacades;
use Plugin\Notes;
use Plugin\Helper;
use App\Dao\Models\Branch;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Modules\Rajaongkir\Dao\Repositories\AreaRepository;

class BranchRepository extends Branch implements MasterInterface
{
    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        $area = new AreaRepository();
        return $this->select($list)
        ->leftJoin($area->getTable(), $area->getKeyName(), 'branch_rajaongkir_area_id')
        ->leftJoin(CompanyFacades::getTable(), CompanyFacades::getKeyName(), 'branch_company_id');
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

    public function showRepository($id, $relation = null)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }
}
