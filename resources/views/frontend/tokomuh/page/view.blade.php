<div class="product product-single row product-popup">
	<div class="col-md-6">
		<div class="product-gallery">
			<div class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1">
				<figure class="product-image">
					<img src="{{ Helper::files('product/'.$oproduct->item_product_image) }}"
						data-zoom-image="{{ Helper::files('product/'.$oproduct->item_product_image) }}" alt="Blue Pinafore Denim Dress"
						width="580" height="580">
				</figure>
				<figure class="product-image">
					<img src="{{ Helper::frontend('images/product/product-2-580x580.jpg') }}"
						data-zoom-image="{{ Helper::frontend('images/product/product-2-800x900.jpg') }}" alt="Blue Pinafore Denim Dress"
						width="580" height="580">
				</figure>
				<figure class="product-image">
					<img src="{{ Helper::frontend('images/product/product-3-580x580.jpg') }}"
						data-zoom-image="{{ Helper::frontend('images/product/product-3-800x900.jpg') }}" alt="Blue Pinafore Denim Dress"
						width="580" height="580">
				</figure>
				<figure class="product-image">
					<img src="{{ Helper::frontend('images/product/product-4-580x580.jpg') }}"
						data-zoom-image="{{ Helper::frontend('images/product/product-4-800x900.jpg') }}" alt="Blue Pinafore Denim Dress"
						width="580" height="580">
				</figure>
				<figure class="product-image">
					<img src="{{ Helper::frontend('images/product/product-5-580x580.jpg') }}"
						data-zoom-image="{{ Helper::frontend('images/product/product-5-800x900.jpg') }}" alt="Blue Pinafore Denim Dress"
						width="580" height="580">
				</figure>
			</div>
			<div class="product-thumbs-wrap">
				<div class="product-thumbs">
					<div class="product-thumb active">
						<img src="{{ Helper::frontend('images/product/product-1-137x137.jpg') }}" alt="product thumbnail" width="137"
							height="137">
					</div>
					<div class="product-thumb">
						<img src="{{ Helper::frontend('images/product/product-2-137x137.jpg') }}" alt="product thumbnail" width="137"
							height="137">
					</div>
					<div class="product-thumb">
						<img src="{{ Helper::frontend('images/product/product-3-137x137.jpg') }}" alt="product thumbnail" width="137"
							height="137">
					</div>
					<div class="product-thumb">
						<img src="{{ Helper::frontend('images/product/product-4-137x137.jpg') }}" alt="product thumbnail" width="137"
							height="137">
					</div>
					<div class="product-thumb">
						<img src="{{ Helper::frontend('images/product/product-5-137x137.jpg') }}" alt="product thumbnail" width="137"
							height="137">
					</div>
				</div>
				<button class="thumb-up disabled"><i class="fas fa-chevron-left"></i></button>
				<button class="thumb-down disabled"><i class="fas fa-chevron-right"></i></button>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="content-popup product-details scrollable pr-5">
			<h2 class="product-name"><a href="product.html">{{ $oproduct->item_product_name }}</a></h2>
			<div class="product-meta">
				SKU : <span class="product-sku">{{ $oproduct->item_product_sku ?? 'Default' }}</span>
				BRAND : <span class="product-brand">{{ Str::upper($oproduct->item_brand_name ?? 'No Brand') }}</span>
			</div>
			<div class="product-price">Rp{{ Helper::createRupiah($oproduct->item_product_price) }}</div>
			<p class="product-short-desc">
				{!! $oproduct->item_product_description !!}
			</p>
			<a href="#" class="size-guide"><i class="d-icon-heart"></i>Add To Wishlist</a>
			<hr class="product-divider mb-3">

			<div class="product-form product-color">
				<label>Color:</label>
				<div class="product-variations">
					<a class="color" data-src="{{ Helper::frontend('images/demos/demo7/products/big1.jpg') }}" href="#"
						style="background-color: #d99e76"></a>
					<a class="color" data-src="{{ Helper::frontend('images/demos/demo7/products/2.jpg') }}" href="#"
						style="background-color: #267497"></a>
					<a class="color" data-src="{{ Helper::frontend('images/demos/demo7/products/3.jpg') }}" href="#"
						style="background-color: #9a999d"></a>
					<a class="color" data-src="{{ Helper::frontend('images/demos/demo7/products/4.jpg') }}" href="#"
						style="background-color: #2b2b2b"></a>
				</div>
			</div>
			<div class="product-form product-size">
				<label>Size:</label>
				<div class="product-form-group">
					<div class="product-variations">
						<a class="size" href="#">S</a>
						<a class="size" href="#">M</a>
						<a class="size" href="#">L</a>
						<a class="size" href="#">XL</a>
						<a class="size" href="#">2XL</a>
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
					<a href="#" class="btn-product btn-cart"><i class="d-icon-bag"></i>Add To Cart</a>
				</div>
			</div>


		</div>
	</div>
</div>