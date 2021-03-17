<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    {!! SEO::generate() !!}

    <link
        href="{{ config('website.favicon') ? Helper::files('logo/'.config('website.favicon')) : Avatar::create(config('website.name'))->setShape('square')->setBackground(config('website.color')) }}"
        rel="shortcut icon">

    <script>
    WebFontConfig = {
        google: {
            families: ['Open+Sans:400,600,700', 'Poppins:400,600,700,900']
        }
    };
    (function(d) {
        var wf = d.createElement('script'),
            s = d.scripts[0];
        wf.src = '{{ Helper::frontend("js/webfont.js") }}';
        wf.async = true;
        s.parentNode.insertBefore(wf, s);
    })(document);
    </script>