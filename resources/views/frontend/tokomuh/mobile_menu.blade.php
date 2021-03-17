 <!-- MobileMenu -->
 <div class="mobile-menu-wrapper">
     <div class="mobile-menu-overlay">
     </div>
     <!-- End of Overlay -->
     <a class="mobile-menu-close" href="#"><i class="d-icon-times"></i></a>
     <!-- End of CloseButton -->
     <div class="mobile-menu-container scrollable">
         <!-- End of Search Form -->
         <ul class="mobile-menu mmenu-anim">
             <li class="active">
                 <a href="{{ url('/') }}">Home</a>
             </li>
             <li>
                 <a href="{{ route('shop') }}">Shop</a>
             </li>
             <li>
                 <a href="{{ route('confirmation') }}">Payment</a>
             </li>

             <li>
                 <a href="{{ route('contact') }}">Contact Us</a>
             </li>
         </ul>
     </div>
 </div>