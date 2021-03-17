<?php

namespace Modules\Item\Http\Controllers;

use App\Dao\Repositories\BranchRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralRequest;
use App\Http\Services\MasterService;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Modules\Item\Dao\Models\ProductDetail;
use Modules\Item\Dao\Repositories\BrandRepository;
use Modules\Item\Dao\Repositories\CategoryRepository;
use Modules\Item\Dao\Repositories\ColorRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Item\Dao\Repositories\SizeRepository;
use Modules\Item\Dao\Repositories\SubCategoryRepository;
use Modules\Item\Dao\Repositories\TagRepository;
use Modules\Item\Dao\Repositories\VariantRepository;
use Modules\Item\Http\Requests\ProductDetailRequest;
use Plugin\Alert;
use Plugin\Helper;
use Plugin\Response;

class ProductController extends Controller
{
    public $template;
    public $folder;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new ProductRepository();
        }

        $this->folder = 'Item';
        $this->template = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $brand = Helper::createOption((new BrandRepository()));
        $branch = Helper::createOption((new BranchRepository()));
        $product = Helper::createOption((new ProductRepository()));
        $category = Helper::createOption((new CategoryRepository()));
        $sub_category = Helper::createOption((new SubCategoryRepository()));
        $tag = Helper::shareTag((new TagRepository()), 'item_tag_slug');
        $variant = Helper::shareOption((new VariantRepository()), false);
        $type = Helper::shareStatus(self::$model->promo);
        $data_variant = [];

        $view = [
            'key' => self::$model->getKeyName(),
            'brand' => $brand,
            'branch' => $branch,
            'category' => $category,
            'sub_category' => $sub_category,
            'tag' => $tag,
            'product' => $product,
            'variant' => $variant,
            'data_variant' => $data_variant,
            'type' => $type,
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service, GeneralRequest $request)
    {
        if (request()->isMethod('POST')) {
            $check = $service->save(self::$model, $request->all());
            if (isset($check['status']) && $check['status']) {
                return redirect()->route($this->getModule() . '_update', ['code' => $check['data']->item_product_id]);
            }
            return redirect()->back();
        }
        return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
            'model' => self::$model,
        ]));
    }

    public function update(MasterService $service, GeneralRequest $request)
    {
        if (request()->isMethod('POST')) {
            $check = $service->update(self::$model, $request->all());
                if ($request['item_product_is_variant'] == 1) {
                return redirect()->route($this->getModule() . '_variant', ['code' => $request['code']]);
            }
            if (isset($check['status']) && $check['status']) {

                return redirect()->route($this->getModule() . '_data');
            }

            return redirect()->back();
        }

        if (request()->has('code')) {
            $data = $service->show(self::$model);
            return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
                'model' => $data,
                'image_detail' => self::$model->getImageDetail($data->item_product_id),
                'key' => self::$model->getKeyName(),
            ]));
        }
    }

    public function variant(MasterService $service, ProductDetailRequest $request)
    {
        if (request()->isMethod('POST')) {
            $arr = $request->all();
            unset($arr['_token'], $arr['code']);
            if ($request->item_detail_id) {
                $check = ProductDetail::find($request->item_detail_id);
            } else {
                $check = ProductDetail::where([
                    'item_detail_product_id' => $request->item_detail_product_id,
                    'item_detail_variant_id' => $request->item_detail_variant_id,
                    'item_detail_color_id' => $request->item_detail_color_id,
                    'item_detail_size_id' => $request->item_detail_size_id,
                    'item_detail_branch_id' => $request->item_detail_branch_id,
                ]);
            }

            if ($check->count() > 0) {
                $check->update($arr);

            } else {
                ProductDetail::insert($arr);
                Alert::create();
            }

            return redirect()->back();
        }

        if (request()->has('code')) {
            $model = $service->show(self::$model);
            $color = Helper::createOption((new ColorRepository()));
            $size = Helper::createOption((new SizeRepository()));
            $variant = Helper::createOption((new VariantRepository()));
            $detail = $model->detail;
            $data = null;

            if (request()->has('id')) {
                $data = ProductDetail::find(request()->get('id'));
            }

            if (request()->has('del')) {
                $data = ProductDetail::find(request()->get('del'))->delete();
                return redirect()->back();
            }

            return view(Helper::setViewForm($this->template, __FUNCTION__, $this->folder))->with($this->share([
                'model' => $model,
                'key' => self::$model->getKeyName(),
                'color' => $color,
                'size' => $size,
                'variant' => $variant,
                'detail' => $detail,
                'data' => $data,
            ]));
        }
    }

    public function delete_image()
    {
        if (request()->has('code')) {
            $code = request()->get('code');
            self::$model->deleteImageDetail($code);

            Helper::removeImage($code, 'product_detail');
            return response()->json(['status' => $code]);
        }
    }

    public function upload()
    {
        if (request()->has('code')) {
            $code = request()->get('code');
            $path = public_path('files/product_detail');
            $photos = request()->file('file');

            for ($i = 0; $i < count($photos); $i++) {
                $photo = $photos[$i];
                $name = sha1(date('YmdHis') . Str::random(30));
                $save_name = $name . '.' . $photo->getClientOriginalExtension();
                $resize_name = 'thumbnail_' . $save_name;

                Image::make($photo)
                    ->resize(250, null, function ($constraints) {
                        $constraints->aspectRatio();
                    })
                    ->save($path . '/' . $resize_name);

                $photo->move($path, $save_name);
                self::$model->saveImageDetail($code, $save_name);
            }

            return response()->json(['status' => 1]);
        }
    }

    public function delete(MasterService $service)
    {
        $service->delete(self::$model);
        return Response::redirectBack();

    }

    public function data(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $datatable = $service->setRaw(['item_product_image'])->datatable(self::$model);
            $datatable->editColumn('item_product_sell', function ($select) {
                return number_format($select->item_product_sell);
            });
            $datatable->editColumn('item_product_image', function ($select) {
                return Helper::createImage(Helper::getTemplate(__CLASS__) . '/thumbnail_' . $select->item_product_image);
            });
            $datatable->addColumn('action', Helper::setViewAction($this->template, $this->folder));
            return $datatable->make(true);
        }

        return view(Helper::setViewData())->with([
            'fields' => Helper::listData(self::$model->datatable),
            'template' => $this->template,
        ]);
    }

    public function show(MasterService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model);
            return view(Helper::setViewShow())->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model' => $data,
                'key' => self::$model->getKeyName(),
            ]));
        }
    }
}
