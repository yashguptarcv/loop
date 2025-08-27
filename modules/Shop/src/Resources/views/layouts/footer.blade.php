<!-- Footer Section - Hidden on mobile -->
<section class="relative w-full bg-black text-white hidden md:block"
  style="background-image: url('{{ asset('looplynks/images/FAQ.png') }}'); background-size: cover; background-position: center;">

  <div class="w-full px-[80px] py-12 flex flex-col gap-8" style="background: rgba(0,0,0,0.85); border-radius: 1rem;">
    <!-- Contact Row -->
    <div class="flex flex-col md:flex-row md:justify-center md:items-center gap-2 text-sm mb-4 text-center lg:mt-10">
      <span>
        <a href="mailto:info@looplynks.com" class="hover:text-[#D4AF37] transition">
          info@looplynks.com
        </a>
      </span>
      <span class="mx-2">
        <a href="tel:+1 (307) 215-0728" class="hover:text-[#D4AF37] transition">
          +1 (307) 215-0728
        </a>
      </span>
      <span class="mx-2 text-white opacity-80">Tbilisi, Georgia</span>
    </div>

    <!-- Navigation Row -->
    <nav class="flex flex-wrap justify-center gap-4 md:gap-8 text-base mb-4">
      <a href="{{ url('/') }}" class="hover:text-[#D4AF37] transition">Home</a>
      <a href="{{ url('/about') }}" class="hover:text-[#D4AF37] transition">About us</a>
      <a href="#" class="hover:text-[#D4AF37] transition">Award Categories</a>
      <a href="#" class="hover:text-[#D4AF37] transition">Jury</a>
      <a href="#" class="hover:text-[#D4AF37] transition">Agenda</a>
      <a href="{{ url('/destination') }}" class="hover:text-[#D4AF37] transition">Why georgia?</a>
      <a href="#" class="hover:text-[#D4AF37] transition">Legend</a>
      <a href="#" class="hover:text-[#D4AF37] transition">Contact us</a>
    </nav>
    
    <!-- Large Gradient Text Centered -->
    <div class="flex justify-center mb-4 w-full">
      <!-- Desktop image (hidden on mobile) -->
      <img src="{{ asset('looplynks/images/Loop Lynks_footer_looplynks.png') }}" alt="Loop Lynks"
        class="hidden md:block h-[6vw] lg:h-[322px] w-auto object-contain"
        style="font-family: 'Thunder', sans-serif;">
    </div>
    
    <!-- Divider -->
    <div class="border-b border-white/60 mb-4"></div>
    
    <!-- Policy & Social Row -->
    <div class="flex flex-col md:flex-row justify-between items-center w-full">
      <!-- Policy Links -->
      <div class="flex gap-4 text-base mb-4 md:mb-0">
        <a href="#" class="hover:text-[#D4AF37] transition">Refund Policy</a>
        <a href="#" class="hover:text-[#D4AF37] transition">Terms and Conditions</a>
        <a href="#" class="hover:text-[#D4AF37] transition">GDPR Policy</a>
      </div>
      
      <!-- Social Icons -->
      <div class="flex gap-6 text-2xl">
        <a href="https://www.facebook.com/profile.php?id=61577338746098" target="_blank"
          class="hover:text-[#D4AF37] transition"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.instagram.com/looplynks/" target="_blank" class="hover:text-[#D4AF37] transition"><i
            class="fab fa-instagram"></i></a>
        <a href="https://www.linkedin.com/company/107705254/admin/page-posts/published/" target="_blank"
          class="hover:text-[#D4AF37] transition"><i class="fab fa-linkedin-in"></i></a>
        <a href="https://x.com/looplynks" target="_blank" class="hover:text-[#D4AF37] transition"><i
            class="fas fa-x"></i></a>
        <a href="https://in.pinterest.com/looplynks/" target="_blank" class="hover:text-[#D4AF37] transition"><i
            class="fab fa-pinterest-p"></i></a>
        <a href="https://www.youtube.com/@Looplynks" target="_blank" class="hover:text-[#D4AF37] transition"><i
            class="fab fa-youtube"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- Mobile Footer -->
<div class="block lg:hidden bg-black text-white px-6 py-8 space-y-2 text-sm font-light">
  <!-- Top Logo Center -->
  <div class="text-[56px] font-bold text-left bg-clip-text text-transparent leading-[1] tracking-[0.01em]">
    <img src="{{ asset('looplynks/images/Loop Lynks_footer_looplynks.png') }}" alt="Loop Lynks Logo"
      class="inline-block h-[95px] w-auto object-contain" />
  </div>

  <!-- Content in 2 columns: Menu | Contact -->
  <div class="flex justify-between gap-2">
    <!-- Left: Navigation Menu -->
    <nav class="space-y-2">
      <a href="{{ url('/') }}" class="block hover:text-[#D4AF37] transition">Home</a>
      <a href="{{ url('/about') }}" class="block hover:text-[#D4AF37] transition">About us</a>
      <a href="#" class="block hover:text-[#D4AF37] transition">Award Categories</a>
      <a href="#" class="block hover:text-[#D4AF37] transition">Jury</a>
      <a href="#" class="block hover:text-[#D4AF37] transition">Agenda</a>
      <a href="{{ url('/destination') }}" class="block hover:text-[#D4AF37] transition">Why Georgia?</a>
      <a href="#" class="block hover:text-[#D4AF37] transition">Legend</a>
      <a href="#" class="block hover:text-[#D4AF37] transition">Contact us</a>
    </nav>

    <!-- Right: Contact Info -->
    <div class="space-y-2 text-left text-[14px]">
      <p>
        <a href="mailto:info@looplynks.com" class="hover:text-[#D4AF37] transition">
          info@looplynks.com
        </a>
      </p>
      <p>
        <a href="tel:+1 (307) 215-0728" class="hover:text-[#D4AF37] transition">
          +1 (307) 215-0728
        </a>
      </p>
      <p class="text-white opacity-80">Tbilisi, Georgia</p>
    </div>
  </div>

  <!-- Bottom Links -->
  <div class="border-t border-white/20 pt-4 flex flex-wrap gap-4 text-xs justify-left">
    <a href="#" class="hover:text-[#D4AF37] transition">Refund Policy</a>
    <a href="#" class="hover:text-[#D4AF37] transition">Terms and Conditions</a>
    <a href="#" class="hover:text-[#D4AF37] transition">GDPR Policy</a>
  </div>

  <!-- Social Icons -->
  <div class="flex justify-left gap-6 text-xl pt-2">
    <a href="https://www.facebook.com/profile.php?id=61577338746098" target="_blank"
      class="hover:text-[#D4AF37] transition"><i class="fab fa-facebook-f"></i></a>
    <a href="https://www.instagram.com/looplynks/" target="_blank" class="hover:text-[#D4AF37] transition"><i
        class="fab fa-instagram"></i></a>
    <a href="https://www.linkedin.com/company/107705254/admin/page-posts/published/" target="_blank"
      class="hover:text-[#D4AF37] transition"><i class="fab fa-linkedin-in"></i></a>
    <a href="https://x.com/looplynks" target="_blank" class="hover:text-[#D4AF37] transition"><i
        class="fas fa-x"></i></a>
    <a href="https://in.pinterest.com/looplynks/" target="_blank" class="hover:text-[#D4AF37] transition"><i
        class="fab fa-pinterest-p"></i></a>
    <a href="https://www.youtube.com/@Looplynks" target="_blank" class="hover:text-[#D4AF37] transition"><i
        class="fab fa-youtube"></i></a>
  </div>
</div>
