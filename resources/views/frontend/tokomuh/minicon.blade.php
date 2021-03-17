<div class="sticky-footer sticky-content fix-bottom">
    <a href="{{ url('/') }}" class="sticky-link active">
        <i class="d-icon-home"></i>
        <span>Home</span>
    </a>

    @auth
    <a href="{{ route('wishlist') }}" class="sticky-link auth">
        <i class="d-icon-heart"></i>
        <span>Wishlist</span>
    </a>
    @endauth

    @guest
    <a href="{{ route('auth') }}" class="sticky-link auth">
        <i class="d-icon-heart"></i>
        <span>Wishlist</span>
    </a>
    @endguest

    <a href="{{ route('shop') }}" class="sticky-link">
        <i class="d-icon-card"></i>
        <span>Shop</span>
    </a>

    @auth
    <a href="{{ route('profile') }}" class="sticky-link">
        <i class="d-icon-user"></i>
        <span>Account</span>
    </a>
    @endauth

    @guest
    <a href="{{ route('auth') }}" class="auth sticky-link">
        <i class="d-icon-user"></i>
        <span>Login</span>
    </a>
    @endguest

    <div class="dropdown cart-dropdown dir-up">
        <!-- End of Cart Toggle -->
       @livewire('ecommerce.minicart-livewire')
        <!-- End of Dropdown Box -->
    </div>
</div>