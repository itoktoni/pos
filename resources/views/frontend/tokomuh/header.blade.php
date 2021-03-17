<header class="header header-mobile">

    <!-- End of HeaderTop -->
    <div class="header-middle sticky-header fix-top sticky-content">
        <div class="container">
            <div class="header-left">
                <a href="#" class="mobile-menu-toggle">
                    <i class="d-icon-bars2"></i>
                </a>
            </div>
            <div class="header-center">
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ Helper::files('logo/'.config('website.logo')) }}" alt="logo" width="163" height="39" />
                </a>
                <!-- End of Logo -->
                @include(Helper::setExtendFrontend('navigation'))
                <!-- End of Header Search -->
            </div>
            <div class="header-right">
                @auth
                <a class="login" href="{{ route('profile') }}">
                    <i class="fa fa-user-edit"></i>
                    <span>{{ auth()->user()->username ?? 'Profile' }}</span>
                </a>
                <a class="login" href="{{ route('account') }}">
                    <i class="fa fa-clipboard-list"></i>
                    <span>My Order</span>
                </a>
                <a class="login" href="{{ route('wishlist') }}">
                    <i class="fa fa-heart"></i>
                    <span>Wishlist</span>
                </a>
                <span class="divider"></span>

                <a class="login" href="{{ route('logout') }}">
                    <i class="fa fa-user-slash"></i>
                    <span>Logout</span>
                </a>
                @else
                <a class="login auth" href="{{ route('auth') }}">
                    <i class="d-icon-user"></i>
                    <span>Login</span>
                </a>
                @endauth
                <!-- End of Login -->
                
                @livewire('ecommerce.bag-livewire')

                <!-- <div class="header-search hs-toggle mobile-search">
                    <a href="#" class="search-toggle">
                        <i class="d-icon-search"></i>
                    </a>
                    <form action="#" class="input-wrapper">
                        <input type="text" class="form-control" name="search" autocomplete="off"
                            placeholder="Search your keyword..." required />
                        <button class="btn btn-search" type="submit">
                            <i class="d-icon-search"></i>
                        </button>
                    </form>
                </div> -->
                <!-- End of Header Search -->
            </div>
        </div>
    </div>
</header>