<?php

namespace Modules\Item\Http\Requests;

use App\Dao\Facades\BranchFacades;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Modules\Item\Dao\Facades\BrandFacades;
use Modules\Item\Dao\Facades\ColorFacades;
use Modules\Item\Dao\Facades\ProductFacades;
use Modules\Item\Dao\Facades\SizeFacades;
use Modules\Item\Dao\Facades\VariantFacades;

class ProductDetailRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function prepareForValidation()
    {
        $color = $size = $branch = $variant = null;
        $colorid = null;
        if($this->item_detail_color_id){
            $color = ColorFacades::find($this->item_detail_color_id)->item_color_name ?? null;
            
        }
        if($this->item_detail_size_id){
            $size = SizeFacades::find($this->item_detail_size_id)->item_size_name ?? null;
        }
        if($this->item_detail_branch_id){
            $branch = BranchFacades::find($this->item_detail_branch_id)->branch_name ?? null;
        }
        if($this->item_detail_variant_id){
            $variant = VariantFacades::find($this->item_detail_variant_id)->item_variant_name ?? null;
        }
        
        $colorid = $this->item_detail_color_id ? $this->item_detail_color_id : null;
        $sizeid = $this->item_detail_size_id ? $this->item_detail_size_id : null;
        $branchid = $this->item_detail_branch_id ? $this->item_detail_branch_id : null;
        $variantid = $this->item_detail_variant_id ? $this->item_detail_variant_id : null;
    
        $this->merge([
            
            'item_detail_color_id' => $colorid,
            'item_detail_size_id' => $sizeid,
            'item_detail_branch_id' => $branchid,
            'item_detail_variant_id' => $variantid,
            'item_detail_color_name' => $color,
            'item_detail_size_name' => $size,
            'item_detail_branch_name' => $branch,
            'item_detail_variant_name' => $variant,
            'item_detail_user_id' => auth()->user()->id,
            'item_detail_user_name' => auth()->user()->username

            ]);
    }

    public function rules()
    {
        if (request()->isMethod('POST')) {
            return [
                'item_detail_name' => 'required',
                'item_detail_product_id' => 'required',
                'item_detail_branch_id' => 'required',
            ];
        }
        return [];
    }

    public function attributes()
    {
        return [
            'item_detail_name' => 'Custom Name',
            'item_detail_product_id' => 'Product',
            'item_detail_branch_id' => 'Branch',
        ];
    }

    public function messages()
    {
        return [
            'item_detail_name.required' => 'Please input Custom name !',
            'item_detail_product_id.required' => 'Please input Product name !',
            'item_detail_branch_id.required' => 'Please input Branch name !',
        ];
    }
}