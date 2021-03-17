<section class="mt-md-9 mt-6 mb-10 container">
    <h2 class="title">Category</h2>
    <div class="owl-carousel owl-theme row owl-nav-full cols-lg-4 cols-md-3 cols-sm-2 cols-1" data-owl-options="{
                            'nav': true,
                            'dots': false,
                            'items': 4,
                            'margin':  20,
                            'responsive': {
                                '0': {
                                    'items': 1 
                                },
                                '576': {
                                    'items': 2
                                },
                                '768': {
                                    'items': 3
                                },
                                '992': {
                                    'items': 4
                                }
                            }
                        }">
        @forelse($categories as $category)
        <div class="category category-light category-absolute">
            <a href="{{ route('category', ['slug' => $category->item_category_slug]) }}">
                <figure class="category-media">
                    <img src="{{ Helper::files('category/'.$category->item_category_image) }}" alt="{{ $category->item_category_name }}" width="280"
                        height="245" />
                </figure>
            </a>
            <div class="category-content">
                <a href="{{ route('category', ['slug' => $category->item_category_slug]) }}"><h4 class="category-name">{{ $category->item_category_name }}</h4></a>
            </div>
        </div>
        @empty
        @endforelse
        
    </div>
</section>