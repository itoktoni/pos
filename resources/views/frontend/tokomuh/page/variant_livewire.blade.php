<div>
    <form>
        <hr class="product-divider">
        <div class="product-form product-variations product-color">
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
        <div class="product-form product-variations product-size">
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
        <div class="product-variation-price">
            <span>$239.00</span>
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
    </form>
</div>