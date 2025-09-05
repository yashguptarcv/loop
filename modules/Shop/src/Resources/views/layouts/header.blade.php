<!-- Main Header -->
<header class="relative z-10 pt-8 bg-[#081312]">
  <div class="container mx-auto px-4 py-4">
    <!-- Mobile Header Row: Logo left, Hamburger right -->
    <div class="flex items-center justify-between lg:hidden mb-8">
      <a href="./index.html" class="flex-shrink-0">
        <img src="{{ asset('looplynks/images/logo_png.png')}}" alt="LoopLynks Logo" class="h-[4rem] w-full" />
      </a>
      <button id="mobile-menu-btn" class="flex flex-col justify-center items-center w-20 h-20 z-50"
        aria-label="Open menu">
        <span class="block w-7 h-1 bg-white mb-1 transition-all duration-300"></span>
        <span class="block w-7 h-1 bg-white mb-1 transition-all duration-300"></span>
        <span class="block w-7 h-1 bg-white transition-all duration-300"></span>
      </button>
    </div>

    <nav class="relative flex items-center justify-between">
        
      <!-- Left Navigation Links (desktop only) -->

      <div class="hidden lg:flex items-center justify-between gap-[7rem] mb-6">
        <a href="./index.html"
          class="nav-link text-white font-medium text-base capitalize tracking-wide hover:text-yellow-400">Home</a>
        <a href="./about.html"
          class="nav-link text-white font-medium text-base capitalize tracking-wide hover:text-yellow-400">About Us</a>
        <a href="./awardcategories.html"
          class="nav-link text-white font-medium text-base capitalize tracking-wide hover:text-yellow-400">Award
          Categories</a>
        <a href="./jury.html"
          class="nav-link text-white font-medium text-base capitalize tracking-wide hover:text-yellow-400">Jury</a>
      </div>

      <!-- Left Divider Line -->
      <div class="absolute bottom-0 left-0 w-[35rem] hidden lg:block"
        style="border-bottom: 1px solid rgba(255,255,255,0.8);"></div>

      <!-- Central Logo (desktop only) -->
      <div class="absolute left-1/2 transform -translate-x-1/2 hidden lg:block">
        <a href="./index.html">
          <img src="{{ asset('looplynks/images/logo_png.png')}}" alt="LoopLynks Logo" class="h-1/5 w-auto mx-auto" />
        </a>
      </div>

      <!-- Right Navigation Links (desktop only) -->
      <div class="hidden lg:flex items-start justify-start gap-[5rem] font-lato mb-6">
        <a href="./destination.html"
          class="nav-link text-white font-medium text-base capitalize tracking-wide hover:text-yellow-400">Agenda</a>
        <a href="./legend.html"
          class="nav-link text-white font-medium text-base capitalize tracking-wide hover:text-yellow-400">Legend</a>
        <a href="./contact.html"
          class="nav-link text-white font-medium text-base capitalize tracking-wide hover:text-yellow-400">Contact</a>

        <div class="flex justify-end items-center space-x-6">
          @include('shop::common.auth')
        </div>
      </div>

      <!-- Right Divider Line -->
      <div class="absolute bottom-0 right-0 w-[37rem] hidden lg:block"
        style="border-bottom: 1px solid rgba(255,255,255,0.8);"></div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu"
      class="fixed inset-0 bg-[#0c0c0c] bg-opacity-100 flex flex-col z-10 transition-all duration-300 opacity-0 pointer-events-none lg:hidden">
      <!-- Top Bar with Logo and Close -->
      <div class="flex items-center justify-between w-full px-6 py-6 border-b border-gray-800">
        <a href="./index.html" class="flex-shrink-0">
          <img src="{{ asset('looplynks/images/logo_png.png')}}" alt="LoopLynks Logo" class="h-12 w-auto" />
        </a>
        <button id="mobile-menu-close" class="text-white text-2xl" aria-label="Close menu">
          ✕
        </button>
      </div>

      <!-- Main Content Area -->
      <div class="flex-1 px-6 py-8 space-y-8 bg-black">
        <!-- Headline Section -->
        <div>
          <h2 class="text-white text-2xl font-bold leading-tight mb-6">
            Global<br>Recognition<br>Initiative
          </h2>
        </div>

        <!-- Contact Section -->
        <div class="space-y-2 mb-8">
          <div class="text-white text-sm">
            <span class="font-semibold">EMAIL</span>
            <span> - </span>
            <a href="mailto:info@looplynks.com" class="hover:text-yellow-400 transition-colors">
              info@looplynks.com
            </a>
          </div>
          <div class="text-white text-sm">
            <span class="font-semibold">PHONE</span>
            <span> - </span>
            <a href="tel:+13047173287" class="hover:text-yellow-400 transition-colors">
              +13047173287
            </a>
          </div>
          <div class="w-full h-px bg-white mt-4"></div>
        </div>

        <!-- Navigation Links Grid -->
        <div class="grid grid-cols-2 gap-4 mb-8">
          <a href="./index.html"
            class="text-white text-lg font-medium border-b border-gray-700 pb-2 hover:text-yellow-400 transition-colors"
            onclick="closeMobileMenu()">
            Home
          </a>
          <a href="./about.html"
            class="text-white text-lg font-medium border-b border-gray-700 pb-2 hover:text-yellow-400 transition-colors"
            onclick="closeMobileMenu()">
            About us
          </a>
          <a href="./destination.html"
            class="text-white text-lg font-medium border-b border-gray-700 pb-2 hover:text-yellow-400 transition-colors"
            onclick="closeMobileMenu()">
            Destination?
          </a>
          <a href="./legend.html"
            class="text-white text-lg font-medium border-b border-gray-700 pb-2 hover:text-yellow-400 transition-colors"
            onclick="closeMobileMenu()">
            Legend
          </a>
          <a href="./jury.html"
            class="text-white text-lg font-medium border-b border-gray-700 pb-2 hover:text-yellow-400 transition-colors"
            onclick="closeMobileMenu()">
            Jury
          </a>
          <a href="./contact.html"
            class="text-white text-lg font-medium border-b border-gray-700 pb-2 hover:text-yellow-400 transition-colors"
            onclick="closeMobileMenu()">
            Contact us
          </a>
        </div>

        <!-- User Dropdown and Buttons -->
        <div class="space-y-4">
          <!-- Welcome Dropdown -->
          @include('shop::common.auth')
        </div>

        <!-- Social Media Icons -->
        <div class="flex justify-center space-x-6 pt-4">
          <a href="https://www.facebook.com/profile.php?id=61577338746098" target="_blank"
            class="text-white text-xl hover:text-yellow-400 transition">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="https://www.instagram.com/looplynks/" target="_blank"
            class="text-white text-xl hover:text-yellow-400 transition">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="https://www.linkedin.com/company/107705254/admin/page-posts/published/" target="_blank"
            class="text-white text-xl hover:text-yellow-400 transition">
            <i class="fab fa-linkedin-in"></i>
          </a>
          <a href="https://x.com/looplynks" target="_blank"
            class="text-white text-xl hover:text-yellow-400 transition">
            <i class="fab fa-x"></i>
          </a>
          <a href="https://www.youtube.com/@Looplynks" target="_blank"
            class="text-white text-xl hover:text-yellow-400 transition">
            <i class="fab fa-youtube"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Sticky Header (hidden by default, shows on scroll) -->
<header id="sticky-header"
  class="fixed top-0 left-1/2 -translate-x-1/2 w-full flex justify-center items-center z-50 bg-transparent bg-opacity-100 hidden transition-all duration-300">
  <div class="flex justify-center items-center px-6 py-1">
    <div
      class="flex items-center space-x-0 bg-black bg-opacity-30 backdrop-blur-md rounded-lg shadow-lg p-6 pr-[100px] w-full max-w-6xl">
      <a href="./index.html" class="flex-shrink-0 w-full h-1/4">
        <img src="{{ asset('looplynks/images/logo_png.png')}}" alt="LoopLynks Logo" class="ml-[34px]" />
      </a>
      <button id="sticky-menu-btn" class="flex flex-col justify-center items-center w-full h-1/4 z-50"
        aria-label="Open menu">
        <span class="block w-10 h-1 bg-white mb-1 transition-all duration-300"></span>
        <span class="block w-10 h-1 bg-white mb-1 transition-all duration-300"></span>
        <span class="block w-10 h-1 bg-white transition-all duration-300"></span>
      </button>
    </div>
  </div>

  <!-- Floating Dropdown Menu -->
  <div id="sticky-dropdown-menu" class="fixed inset-0 bg-[#0c0c0c] bg-opacity-100 z-50 flex flex-wrap hidden">
    <!-- Top Bar -->
    <div class="flex items-center justify-between w-full px-8 py-6 border-b border-gray-800">
      <!-- Left: Logo -->
      <a href="./index.html" class="flex-shrink-0">
        <img src="{{ asset('looplynks/images/logo_png.png')}}" alt="LoopLynks Logo" class="h-14 w-auto" />
      </a>

      <!-- Right: Buttons + Close -->
      <div class="flex items-center gap-4">
        <!-- User Dropdown, Nominate & Login (hidden on mobile) -->
        <div class="hidden sm:flex items-center gap-4">
          <!-- User Dropdown -->

          @include('shop::common.auth')
          
        </div>

        <!-- Close Button (always visible) -->
        <button id="sticky-dropdown-close"
          class="group text-white text-xl flex items-center gap-4 focus:outline-none">
          <span
            class="inline-flex items-center justify-center w-10 h-10 text-3xl leading-none bg-transparent rounded-full transition-colors duration-200 cursor-pointer hover:bg-white hover:text-black">
            &times;
          </span>
        </button>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col lg:flex-row w-full px-8 py-8 gap-12 bg-[#0c0c0c] opacity-100">
      <!-- Left -->
      <div class="flex flex-col justify-between lg:w-1/2 mb-8 lg:mb-0">
        <!-- Headline -->
        <div>
          <h2 class="text-white text-4xl font-bold mb-8 leading-tight"> Global <br> Recognition <br> Initiative </h2>
        </div>

        <!-- Contact Section -->
        <div>
          <div class="flex flex-col sm:flex-row gap-2 sm:gap-8 text-white text-base font-light">
            <div>
              <span class="font-semibold">EMAIL</span>
              <span class="opacity-100"> - <a href="mailto:info@looplynks.com"
                  class="hover:text-yellow-400 transition-colors"> info@looplynks.com </a> </span>
            </div>
            <div>
              <span class="font-semibold">PHONE</span>
              <span class="opacity-100"> - <a href="tel:+13047173287"
                  class="hover:text-yellow-400 transition-colors"> +13047173287 </a> </span>
            </div>
          </div>
          <div class="w-[30rem] h-0.5 bg-white mt-4"></div>
        </div>
      </div>

      <!-- Right -->
      <div class="flex flex-col justify-between lg:w-1/2">
        <!-- Navigation Links -->
        <nav class="flex-1">
          <div class="grid grid-cols-2 gap-x-8 gap-y-0 w-full max-w-[56rem]">
            <a href="./index.html"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">Home</a>
            <a href="./agenda.html"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">Agenda</a>
            <a href="./about.html"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">About us</a>
            <a href="./destination.html"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">Destination?</a>
            <a href="./awardcategories.html"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">Award Categories</a>
            <a href="./legend.html"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">Legend</a>
            <a href="./jury.html"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">Jury</a>
            <a href="./contact.html"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">Contact us</a>
          </div>
        </nav>

        <div
          class="flex flex-col items-start space-y-4 mt-8 md:flex-row md:justify-end md:items-center md:space-x-6 md:space-y-0">
          <div class="flex space-x-4 items-center relative z-10 block lg:hidden">

            @include('shop::common.auth')
          </div>

          <!-- Social Media Icons -->
          <div class="flex space-x-4">
            <a href="https://www.facebook.com/profile.php?id=61577338746098" target="_blank"
              class="text-white text-2xl hover:text-[#D4AF37] transition"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/looplynks/" target="_blank"
              class="text-white text-2xl hover:text-[#D4AF37] transition"><i class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com/company/107705254/admin/page-posts/published/" target="_blank"
              class="text-white text-2xl hover:text-[#D4AF37] transition"><i class="fab fa-linkedin-in"></i></a>
            <a href="https://x.com/looplynks" target="_blank"
              class="text-white text-2xl hover:text-[#D4AF37] transition"><i class="fas fa-x"></i></a>
            <a href="https://www.youtube.com/@Looplynks" target="_blank"
              class="text-white text-2xl hover:text-[#D4AF37] transition"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
