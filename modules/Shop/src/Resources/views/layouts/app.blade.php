<!doctype html>
<html>

<head>

  <title>{{ $meta['title'] ?? config('app.name') }}</title>
  <meta name="description" content="{{ $meta['description'] ?? '' }}">
  <meta name="keywords" content="{{ $meta['keywords'] ?? '' }}">

  <!-- Open Graph -->
  <meta property="og:title" content="{{ $meta['title'] ?? '' }}">
  <meta property="og:description" content="{{ $meta['description'] ?? '' }}">
  <meta property="og:image" content="{{ $meta['og_image'] ?? asset('default-og.jpg') }}">

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ asset('looplynks/input.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('looplynks/animation.css') }}">
  <link rel="stylesheet" href="{{ asset('looplynks/gsap.css') }}">
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('looplynks/images/Favicon Looplynks-01.png') }}" sizes="32x32">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>
  <script src="{{ asset('looplynks/assets/script.js') }}"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Inter&family=Montserrat&family=Open+Sans&family=Poppins&display=swap"
    rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

  <style>
    /* Additional styles to fix the overflow issue */
    body.overflow-hidden {
      overflow-x: hidden !important;

    }

    /* Ensure header background scales properly */
    .flowing-lines {
      min-height: 100vh;
      height: auto !important;
    }

    /* Fix for mobile section */
    @media (max-width: 1023px) {
      .mobile-section {
        min-height: auto !important;
        height: auto;
        padding-bottom: 2rem;
      }
    }

    /* Adjust hero section for desktop */
    @media (min-width: 1024px) {
      .hero-section {
        height: auto !important;
        min-height: 100vh;
        padding: 2rem 0;
      }
    }
  </style>

  @yield('head')

</head>

<body class="overflow-hidden">
  @include('shop::layouts.preloader')

  @include('shop::layouts.header')

  @yield('content')

  @include('shop::layouts.footer')

  @yield('scripts')
</body>

</html>