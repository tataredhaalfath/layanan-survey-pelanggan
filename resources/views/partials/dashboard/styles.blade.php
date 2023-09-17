<!-- Fonts and icons -->
<script src="{{ asset('js/plugin/webfont/webfont.min.js') }}"></script>
<script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                "simple-line-icons"
            ],
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>
<script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                "simple-line-icons"
            ],
            urls: ['{{ asset("css/fonts.min.css") }}']
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>


<!-- CSS Files -->
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/atlantis.css') }}">

<!-- CSS Just for demo purpose, don't include it in your project -->
<link rel="stylesheet" href="{{ asset('css/demo.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

{{-- icon --}}
<link rel="stylesheet" href="{{ asset('icon/themify-icons/themify-icons.css') }}">
<link rel="stylesheet" href="{{ asset('icon/icofont/css/icofont.css') }}">
<link rel="stylesheet" href="{{ asset('icon/ion-icon/css/ionicons.min.css') }}">
