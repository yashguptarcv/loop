<header class="flowing-lines relative z-10 bg-cover bg-center"
  style="background-image: url('{{ asset('looplynks/images/HeroSection.png') }}');">
  <div class="container mx-auto px-4 py-4">
    <!-- Mobile Header Row: Logo left, Hamburger right -->
    <div class="flex items-center justify-between lg:hidden mb-8">
      <a href="#" class="flex-shrink-0">
        <img src="{{ asset('looplynks/images/logo_png.png') }}" alt="LoopLynks Logo" class="h-[4rem] w-full" />
      </a>
      <button id="mobile-menu-btn" class="flex flex-col justify-center items-center w-20 h-20 z-50"
        aria-label="Open menu">
        <span class="block w-7 h-1 bg-white mb-1 transition-all duration-300"></span>
        <span class="block w-7 h-1 bg-white mb-1 transition-all duration-300"></span>
        <span class="block w-7 h-1 bg-white transition-all duration-300"></span>
      </button>
    </div>

    <nav class="flex items-center justify-between relative">
      <!-- Left Navigation Links (desktop) -->
      <div class="hidden lg:flex items-center space-x-[80px] mb-8">
        <a href="{{ url('/') }}"
          class="nav-link text-white font-medium text-base capitalize tracking-wide hover:text-yellow-400">Home</a>
        <a href="{{ url('/about') }}"
          class="nav-link text-white font-medium text-base capitalize tracking-wide hover:text-yellow-400">About
          us</a>
        <a href="#"
          class="nav-link text-white font-medium text-base capitalize tracking-wide hover:text-yellow-400">Award
          Categories</a>
        <a href="#"
          class="nav-link text-white font-medium text-base capitalize tracking-wide hover:text-yellow-400">Jury</a>
      </div>
      <div class="absolute bottom-0 items-start left-[-30px] w-[37.33rem] hidden lg:block"
        style="border-bottom: 1px solid rgba(255,255,255,0.8);"></div>

      <!-- Central Logo (desktop only) -->
      <div class="absolute left-1/2 transform -translate-x-1/2 hidden lg:block">
        <a href="{{ url('/') }}">
          <img src="{{ asset('looplynks/images/logo_png.png') }}" alt="LoopLynks Logo" class="h-1/5 w-auto mx-auto" />
        </a>
      </div>

      <!-- Right Navigation Links (desktop) -->
      <div class="hidden lg:flex items-center space-x-[80px] mb-8 font-lato">
        <a href="#"
          class="nav-link text-white font-medium text-base capitalize tracking-wide hover:text-yellow-400">Agenda</a>
        <a href="{{ url('/destination') }}"
          class="nav-link text-white font-medium text-base capitalize tracking-wide hover:text-yellow-400">Why
          georgia?</a>
        <a href="#"
          class="nav-link text-white font-medium text-base capitalize tracking-wide hover:text-yellow-400">Legend</a>
        <a href="#"
          class="nav-link text-white font-medium text-base capitalize tracking-wide hover:text-yellow-400">Contact
          us</a>
      </div>
      <div class="absolute bottom-0 right-[-30px] items-end w-[37.33rem] hidden lg:block"
        style="border-bottom: 1px solid rgba(255,255,255,0.8);"></div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu"
      class="fixed inset-0 bg-black bg-opacity-100 flex flex-col z-40 transition-all duration-300 opacity-0 pointer-events-none lg:hidden">
      <div class="flex items-center justify-between w-full px-6 py-4">
        <a href="{{ url('/') }}" class="flex-shrink-0">
          <img src="{{ asset('looplynks/images/logo.png') }}" alt="LoopLynks Logo" class="h-100 w-100" />
        </a>
        <button id="mobile-menu-close" class="flex flex-col justify-center items-center w-10 h-10"
          aria-label="Close menu">
          <span class="block w-7 h-0.5 bg-white rotate-45 absolute"></span>
          <span class="block w-7 h-0.5 bg-white -rotate-45 absolute"></span>
        </button>
      </div>
      <div class="flex flex-col items-center justify-start flex-1 space-y-8 mt-[80px]">
        <a href="{{ url('/') }}" class="text-white text-2xl font-medium uppercase tracking-wide hover:text-yellow-400"
          onclick="closeMobileMenu()">Home</a>
        <a href="{{ url('/about') }}"
          class="text-white text-2xl font-medium uppercase tracking-wide hover:text-yellow-400"
          onclick="closeMobileMenu()">About us</a>
        <a href="#" class="text-white text-2xl font-medium uppercase tracking-wide hover:text-yellow-400"
          onclick="closeMobileMenu()">Award Categories</a>
        <a href="#" class="text-white text-2xl font-medium uppercase tracking-wide hover:text-yellow-400"
          onclick="closeMobileMenu()">Jury</a>
        <a href="#" class="text-white text-2xl font-medium uppercase tracking-wide hover:text-yellow-400"
          onclick="closeMobileMenu()">Agenda</a>
        <a href="{{ url('/destination') }}" class="text-white text-2xl font-medium uppercase tracking-wide hover:text-yellow-400"
          onclick="closeMobileMenu()">Why georgia?</a>
        <a href="#" class="text-white text-2xl font-medium uppercase tracking-wide hover:text-yellow-400"
          onclick="closeMobileMenu()">Legend</a>
        <a href="#" class="text-white text-2xl font-medium uppercase tracking-wide hover:text-yellow-400"
          onclick="closeMobileMenu()">Contact us</a>
      </div>
    </div>

    @yield('hero-section')
  </div>
</header>

<!-- Sticky Header (hidden by default, shows on scroll) -->
<header id="sticky-header"
  class="fixed top-0 left-1/2 -translate-x-1/2 w-full flex justify-center items-center z-50 bg-transparent bg-opacity-100 hidden transition-all duration-300">
  <div class="flex justify-center items-center px-6 py-1">
    <div
      class="flex items-center space-x-0 bg-black bg-opacity-30 backdrop-blur-md rounded-lg shadow-lg p-6 pr-[100px] w-full max-w-6xl">
      <a href="{{ url('/') }}" class="flex-shrink-0 w-full h-1/4">
        <img src="{{ asset('looplynks/images/logo_png.png') }}" alt="LoopLynks Logo" class="ml-[34px]" />
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
      <a href="{{ url('/') }}">
        <img src="{{ asset('looplynks/images/logo_png.png') }}" alt="LoopLynks Logo" class="h-14 w-auto" />
      </a>
      <button id="sticky-dropdown-close" class="group text-white text-xl flex items-center gap-4 focus:outline-none">
        <span class="hidden sm:inline text-base font-medium">Close</span>
        <span
          class="inline-flex items-center justify-center w-10 h-10 text-3xl leading-none bg-transparent rounded-full transition-colors duration-200 cursor-pointer hover:bg-white hover:text-black">
          &times; </span>
      </button>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col lg:flex-row w-full px-8 py-8 gap-12 bg-[#0c0c0c] opacity-100">
      <!-- Left -->
      <div class="flex flex-col justify-between lg:w-1/2 mb-8 lg:mb-0">
        <!-- Headline -->
        <div>
          <h2 class="text-white text-4xl font-bold mb-8 leading-tight"> Lorem ipsum<br>dolor sit
            amet<br>consectetur. </h2>
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
              <span class="opacity-100"> - <a href="tel:+1 (307) 215-0728"
                  class="hover:text-yellow-400 transition-colors"> +1 (307) 215-0728 </a> </span>
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
            <a href="{{ url('/') }}"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">Home</a>
            <a href="#"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">Agenda</a>
            <a href="{{ url('/about') }}"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">About us</a>
            <a href="{{ url('/destination') }}"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">Why Georgia?</a>
            <a href="#"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">Award Categories</a>
            <a href="#"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">Legend</a>
            <a href="#"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">Jury</a>
            <a href="#"
              class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
              onclick="closeStickyDropdown()">Contact us</a>
          </div>
        </nav>

        <!-- Social Icons -->
        <div class="flex justify-end items-center space-x-6 mt-8">
          @guest('customer')
          <a href="{{route('customer.login.form')}}"
            class="btn-hover-effect bg-transparent font-semibold px-[1.25rem] py-[0.5rem] rounded-md border-2 border-yellow-400 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-300">
            <span class="gradient-text">Enroll</span>
          </a>

          <a href="{{route('customer.login.form')}}" 
            class=" bg-radial text-black font-semibold px-4 py-2 rounded-md transition focus:outline-none focus:ring-2 focus:ring-yellow-300">
            Login </a>
          @else
          <div class="flex items-center space-x-4">
            <span class="text-white font-medium">Welcome, {{ auth('customer')->user()->name ?? 'Customer' }}</span>
            <form method="POST" action="{{ route('customer.logout') }}" class="inline">
              @csrf
              <button type="submit" 
                class="bg-red-600 text-white font-semibold px-4 py-2 rounded-md hover:bg-red-700 transition focus:outline-none focus:ring-2 focus:ring-red-300">
                Logout
              </button>
            </form>
          </div>
          @endguest
          <a href="https://www.facebook.com/profile.php?id=61577338746098" target="_blank"
            class="text-white text-2xl hover:text-[#D4AF37] transition"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.instagram.com/looplynks/" target="_blank"
            class="text-white text-2xl hover:text-[#D4AF37] transition"><i class="fab fa-instagram"></i></a>
          <a href="https://www.linkedin.com/company/107705254/admin/page-posts/published/" target="_blank"
            class="text-white text-2xl hover:text-[#D4AF37] transition"><i class="fab fa-linkedin-in"></i></a>
          <a href="https://x.com/looplynks" target="_blank"
            class="text-white text-2xl hover:text-[#D4AF37] transition"><i class="fas fa-x"></i></a>
        </div>
      </div>
    </div>
  </div>
</header>
