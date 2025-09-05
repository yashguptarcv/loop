<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ asset('looplynks/input.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('looplynks/animation.css')}}">
  <link rel="stylesheet" href="{{ asset('looplynks/gsap.css')}}">
  <!-- Favicon -->
  <link rel="icon" href="{{fn_get_image('company_favicon', 0)['url'] ?? ''}}" type="image/x-icon">
  <link rel="shortcut icon" href="{{fn_get_image('company_favicon', 0)['url'] ?? ''}}" type="image/x-icon">

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>
  <script src="{{ asset('looplynks/assets/script.js')}}"></script>
  <link
  href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Inter&family=Montserrat&family=Open+Sans&family=Poppins&display=swap"
  rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  @vite(['resources/css/toast.css', 'resources/css/fontawesome/all.min.css', 'resources/js/category-selector.js', 'resources/js/app.js'])

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
      section.relative.w-full.min-h-\[820px\] {
        min-height: auto !important;
        height: auto;
        padding-bottom: 2rem;
      }
    }

    /* Adjust hero section for desktop */
    @media (min-width: 1024px) {
      section.relative.w-full.h-\[995px\].lg\:h-\[850px\] {
        height: auto !important;
        min-height: 100vh;
        padding: 2rem 0;
      }
    }
  </style>
</head>

<body class="overflow-hidden">

  @include('shop::layouts.header')
  <div id="toast-container" class="toast-container"></div>

  @yield('content')

  <script src="{{ asset('js/toast.js') }}"></script>
  @include('shop::layouts.footer')
  
  <script>
  lucide.createIcons();
    </script>
  @yield('scripts')
</body>

</html>