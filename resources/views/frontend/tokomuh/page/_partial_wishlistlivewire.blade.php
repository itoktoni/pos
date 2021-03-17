<button class="btn-product-icon btn-cart {{ $flag ? 'love' : '' }}" wire:click="action('{{ $product_id }}')">
    <i class="fa fas fa-heart"></i>
</button>