
<div class="product-details">

    <h1 class="product-name">{{ $oproduct->item_product_name }}</h1>
    <div class="product-meta">
        SKU : <span
            class="product-sku">{{ !empty($oproduct->item_product_sku) ? $oproduct->item_product_sku : 'Default' }}</span>
        BRAND : <span class="product-brand">{{ Str::upper($oproduct->item_brand_name ?? $oproduct->brand->item_brand_name) }}</span>
    </div>
    <div class="product-price">Rp{{ Helper::createRupiah($oproduct->item_product_price) }}</div>

    <p class="product-short-desc">
        {!! $oproduct->item_product_description !!}
    </p>

    @auth
    <a wire:click="actionWishlist('{{ $oproduct->item_product_id }}')" class="size-guide">
        <i class="fa fas fa-heart mr-2 button-love {{ $love ? 'love' : '' }}">
        </i> Wishlist
    </a>
    @endauth

    <hr class="product-divider">
    <div class="product-form">
        <label>Color:</label>
        <div class="select-box">
            <select wire:model="color" class="form-control">
                <option value="" selected="selected">Choose an Option</option>
                <option value="white">White</option>
                <option value="black">Black</option>
                <option value="brown">Brown</option>
                <option value="red">Red</option>
                <option value="green">Green</option>
                <option value="yellow">Yellow</option>
            </select>
        </div>
    </div>
    <div class="product-form">
        <label>Size:</label>
        <div class="product-form-group">
            <div class="select-box">
                <select wire:model="size" class="form-control">
                    <option value="" selected="selected">Choose an Option</option>
                    <option value="s">Small</option>
                    <option value="m">Medium</option>
                    <option value="l">Large</option>
                    <option value="xl">Extra Large</option>
                </select>
            </div>
        </div>
    </div>
    <div class="product-form">
        <label>Variant:</label>
        <div class="product-form-group">
            <div class="select-box">
                <select wire:model="variant" class="form-control">
                    <option value="" selected="selected">Choose Variant</option>
                    <option value="1">Varian 1</option>
                    <option value="2">Variant 2</option>
                </select>
            </div>
        </div>
    </div>
    <hr class="product-divider">

    <div class="product-form product-qty">
        <label>QTY:</label>
        <div class="product-form-group">
            <div class="input-group">
                <button class="quantity-minus d-icon-minus"></button>
                <input class="quantity form-control" type="number" min="1" max="1000000">
                <button class="quantity-plus d-icon-plus"></button>
            </div>
            <button class="btn-product btn-cart">
                <i class="d-icon-bag"></i>Add To Cart
            </button>
        </div>
    </div>

</div>