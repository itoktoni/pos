<?php

namespace Modules\Marketing\Http\Controllers;

use App\Dao\Repositories\FontAwesomeRepository;
use Plugin\Helper;
use Plugin\Response;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use App\Http\Requests\GeneralRequest;
use Modules\Marketing\Dao\Repositories\SosmedRepository;

class SosmedController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new SosmedRepository();
        }

        $this->template  = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $icon = Helper::createOption((new FontAwesomeRepository()));
        $view = [
            'template' => $this->template,
            'icon' => $icon,
        ];


        return array_merge($view, $data);
    }

    public function create(MasterService $service, GeneralRequest $request)
    {
        if (request()->isMethod('POST')) {

            $service->save(self::$model, $request->all());
        }
        return view(Helper::setViewCreate())->with($this->share());
    }

    public function update(MasterService $service, GeneralRequest $request)
    {
        if (request()->isMethod('POST')) {

            $service->update(self::$model, $request->all());
            return redirect()->route($this->getModule() . '_data');
        }

        if (request()->has('code')) {

            $data = $service->show(self::$model);

            return view(Helper::setViewUpdate())->with($this->share([
                'model'        => $data,
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function delete(MasterService $service)
    {
        $service->delete(self::$model);
        return Response::redirectBack();;
    }

    public function data(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $datatable = $service->setRaw(['marketing_slider_image'])->datatable(self::$model);
            $datatable->editColumn('marketing_slider_image', function ($select) {
                return Helper::createImage(Helper::getTemplate(__CLASS__) . '/thumbnail_' . $select->marketing_slider_image);
            });
            return $datatable->make(true);
        }

        return view(Helper::setViewData())->with([
            'fields'   => Helper::listData(self::$model->datatable),
            'template' => $this->template,
        ]);
    }

    public function show(MasterService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model);
            return view(Helper::setViewShow())->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model'   => $data,
                'key'   => self::$model->getKeyName()
            ]));
        }
    }
}
