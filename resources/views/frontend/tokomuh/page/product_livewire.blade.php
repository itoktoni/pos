<div class="product-details">

    <h1 class="product-name">{{ $data->item_product_name }}</h1>
    <div class="product-meta">
        WEIGHT : <span class="product-sku">{{ round($data->item_product_weight /1000,2) }}Kg</span>
        BRAND : <span class="product-brand">{{ Str::upper($data->item_brand_name ?? $data->brand->item_brand_name) }}</span>
        CATEGORY :
        <a href="{{ route('category', ['slug' => $data->item_category_slug ?? $data->category->item_category_slug]) }}">
            <span class="product-brand">
                {{ Str::upper($data->item_category_name ?? $data->category->item_category_name) }}
            </span>
        </a>

    </div>
    <div class="product-price">{{ $mask_price }}</div>

    <p class="product-short-desc">
        {!! $data->item_product_description !!}
    </p>

    @auth
    <a wire:click="actionWishlist('{{ $data->item_product_id }}')" class="size-guide mb-5">
        <i class="fa fas fa-heart mr-2 button-love {{ $love ? 'love' : '' }}">
        </i> Wishlist
    </a>
    @endauth

    @if($data_branch)
    <div class="product-form">
        <label>Branch:</label>
        <div class="select-box">
            <select wire:model="branch_id" class="form-control">
                <option value="none">Choose a Branch</option>
                @foreach($data_branch->unique('item_detail_branch_id') as $brc)
                <option value="{{ $brc->item_detail_branch_id }}">{{ $brc->item_detail_branch_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif

    @if($data_color)
    <div class="product-form">
        <label>Color:</label>
        <div class="select-box">
            <select wire:model="color_id" class="form-control">
                <option value="none">Choose a color</option>
                @foreach($data_color->unique('item_detail_color_id') as $col)
                <option value="{{ $col->item_detail_color_id }}">{{ $col->item_detail_color_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif

    @if($data_size)
    <div class="product-form">
        <label>Size:</label>
        <div class="product-form-group">
            <div class="select-box">
                <select wire:model="size_id" class="form-control">
                    <option value="none">Choose a Size</option>
                    @foreach($data_size->unique('item_detail_size_id') as $siz)
                    <option value="{{ $siz->item_detail_size_id }}">{{ $siz->item_detail_size_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @endif

    @if($data_variant)
    <div class="product-form">
        <label>Variant:</label>
        <div class="product-form-group">
            <div class="select-box">
                <select wire:model="variant_id" class="form-control">
                    <option value="none" selected="selected">Choose Variant</option>
                    @foreach($data_variant->unique('item_detail_variant_id') as $var)
                    <option value="{{ $var->item_detail_variant_id }}">{{ $var->item_detail_variant_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @endif

    <div class="product-form" style="width: 82.2%">
        <label class="text-center">Chat:</label>
        <a target="_blank" class="btn-product btn-wa"
            href="https://api.whatsapp.com/send?phone={{ Helper::convertPhone(config('website.phone')) }}&text=Saya%20tertarik%20untuk%20membeli%20produk%20{{ str_replace(' ','%20', $data->item_product_name) }}%20segera.">
            <i class="fab fa-lg fa-whatsapp mr-2"></i>Tanya Product
        </a>
    </div>

    <div class="product-form product-qty" style="width: 70%">
        <label class="text-center">Notes:</label>
        <textarea wire:model="notes" class="form-group" rows="3"></textarea>
    </div>

    <hr class="product-divider mt-5">

    <div class="product-form product-qty">

        <div class="product-form-group">
            <div class="input-group">
                <button wire:click="actionMinus" class="d-icon-minus"></button>
                <input wire:model="qty" value="{{ $qty }}" class="quantity form-control" type="number">
                <button wire:click="actionPlus" class="d-icon-plus"></button>
            </div>
            <button wire:click="actionCart" class="btn-product btn-cart">
                <i class="d-icon-bag"></i>
                @if($stock_enable && $stock_qty < 5)
                Grab it fast
                @elseif($price > 0)
                Add to cart
                @else
                Out of stock
                @endif
            </button>
        </div>

    </div>

    @if($errors->any())
    <div class="alert text-default">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

</div>