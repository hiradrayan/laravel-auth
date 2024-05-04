<title>@yield('title') | {{ isset($partner->options['settings']['title']) ? $partner->options['settings']['title'] : 'سامانه بامداد' }}</title>
<meta charset="utf-8" />

@yield('seo',view('auth::includes.app.seo-metas'))

<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="shortcut icon" href="@if (isset($partner->options['settings']['favicon_id'])) {{ asset(image_url($partner->options['settings']['favicon_id'], '100_100')) }} @else {{ asset('assets/img/favicon.ico') }} @endif" />
<link href="{{ asset('assets/plugins/bootstrap-toggle/bootstrap5-toggle.min.css') }}" rel="stylesheet" type="text/css" />


<link href="{{ asset('assets/css/admin/style.bundle.rtl.css') }}?v=1.1000" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/admin/plugins.bundle.rtl.css') }}?v=2" rel="stylesheet" type="text/css" />

<link href="{{ asset('assets/plugins/fontawesome-free-6.2.0-web/css/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/persian-datepicker/persian-datepicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/custom/main.css') }}?v=1.0" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/custom/responsive.css') }}" rel="stylesheet" type="text/css" />

@yield('styles')

