@extends(Helper::setExtendFrontend())

@section('content')
<main class="main">

    <hr>
    <div class="page-content mt-10 pt-4">
        <section class="contact-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-4 col-xs-5 ls-m pt-3">

                        <h2 class="font-weight-bold text-uppercase ls-m mb-2">Contact us</h2>
                        <p>Looking for help? Fill the form and start a new adventure.</p>

                        <h4 class="mb-1 text-uppercase">Phone</h4>
                        <p>
                            <a href="tel:{{ config('website.phone') }}">{{ config('website.phone') }}</a>
                            <br>
                            <a href="mailto:{{ config('website.email') }}">{{ config('website.email') }}</a><br>
                        </p>

                        {!!Form::open(['route' => 'contact', 'class' => 'pt-8 pb-10 pl-4 pr-4 pl-lg-6 pr-lg-6 grey-section']) !!}
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <input class="form-control {{ $errors->has('marketing_contact_name') ? 'error' : ''}}" name="marketing_contact_name" type="text" placeholder="Name *" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <input class="form-control {{ $errors->has('marketing_contact_email') ? 'error' : ''}}" name="marketing_contact_email" type="email" placeholder="Email *" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <input class="form-control {{ $errors->has('marketing_contact_phone') ? 'error' : ''}}" name="marketing_contact_phone" type="text" placeholder="Phone *" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <input class="form-control {{ $errors->has('marketing_contact_subject') ? 'error' : ''}}" name="marketing_contact_subject" type="text" placeholder="Subject *" required>
                                </div>
                                <div class="col-12 mb-4">
                                    <textarea name="marketing_contact_message" class="form-control {{ $errors->has('marketing_contact_message') ? 'error' : ''}}" required placeholder="Your Message *"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-md btn-primary mb-2">Send Message</button>
                            {!! Form::close() !!}



                    </div>
                    <div class="col-lg-5 col-md-8 col-xs-7">

                        <h4 class="mb-1 mt-7 text-uppercase">Headquarters</h4>
                        <p>{{ config('website.address') }}</p>

                        <div class="map">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.343870831869!2d106.85455891402778!3d-6.218303895498569!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3a4c91ec34d%3A0x8c8fd94abf686418!2sHerinkuh%20Rent%20House!5e0!3m2!1sid!2sid!4v1587514228645!5m2!1sid!2sid"
                                width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""
                                aria-hidden="false" tabindex="0"></iframe>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- End About Section-->

        <section class="store-section pt-10 pb-10">
            <div class="container">
                <h2 class="title mt-2">Our Stores</h2>
                <div class="row cols-sm-2 cols-lg-4">
                    <div class="store">
                        <figure>
                            <img src="{{ Helper::frontend('images/subpages/store-1.jpg') }}" alt="store" width="280"
                                height="280">
                            <h4 class="overlay-visible">New York</h4>
                            <div class="overlay overlay-transparent">
                                <a class="mt-8" href="mail:#">mail@newyorkdonaldstore.com</a>
                                <a href="tel:#">Phone: (123) 456-7890</a>

                            </div>
                        </figure>
                    </div>
                    <div class="store">
                        <figure>
                            <img src="{{ Helper::frontend('images/subpages/store-2.jpg') }}" alt="store" width="280"
                                height="280">
                            <h4 class="overlay-visible">London</h4>
                            <div class="overlay overlay-transparent">
                                <a class="mt-8" href="mail:#">{{ config('website.phone') }}</a>
                                <a href="tel:#">Phone: (123) 456-7890</a>
                            </div>
                        </figure>
                    </div>
                    <div class="store">
                        <figure>
                            <img src="{{ Helper::frontend('images/subpages/store-3.jpg') }}" alt="store" width="280"
                                height="280">
                            <h4 class="overlay-visible">Oslo</h4>
                            <div class="overlay overlay-transparent">
                                <a class="mt-8" href="mail:#">mail@oslodonaldstore.com</a>
                                <a href="tel:#">Phone: (123) 456-7890</a>

                            </div>
                        </figure>
                    </div>
                    <div class="store">
                        <figure>
                            <img src="{{ Helper::frontend('images/subpages/store-4.jpg') }}" alt="store" width="280"
                                height="280">
                            <h4 class="overlay-visible">Stockholm</h4>
                            <div class="overlay overlay-transparent">
                                <a class="mt-8" href="mail:#">mail@stockholmdonaldstore.com</a>
                                <a href="tel:#">Phone: (123) 456-7890</a>

                            </div>
                        </figure>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Store Section -->
    </div>
</main>
@endsection