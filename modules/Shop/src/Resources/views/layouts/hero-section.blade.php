<!-- for desktop screen -->
<section class="relative w-full flex flex-col items-center justify-center text-center hidden lg:flex hero-section">
  <!-- Main Title -->
  <h1 class="text-[7vw] md:text-[6vw] lg:text-[120px] font-bold mb-1 mt-[6.5rem]"
    style="font-family: 'Thunder'; font-weight: 500; font-style: normal; letter-spacing: 1%; line-height: 100%;">
    <span class="gradient-text"> LOOPLYNKS </span>
  </h1>
  <h2 class="mt-1 mb-1 text-3xl md:text-7xl lg:text-[60px] font-thunder font-bold text-white"> Global
    Recognition Initiative </h2>
  <p class="mt-1 mb-0 text-lg md:text-xl lg:text-[24px] text-white font-lato"> A Global Tribute in Tbilisi
    for Those Who Redefine Leadership </p>
  <div class="flex justify-center items-end gap-4 mb-5 w-full px-4 mb-2">
    <img src="{{ asset('looplynks/images/herosection vector.png') }}" alt="Statue Center"
      class="max-w-full md:h-full lg:h-[500px] object-contain" />
  </div>
</section>

<!-- for mobile screen -->
<section
  class="relative w-full flex flex-col items-start justify-center text-left px-6 md:px-16 overflow-hidden lg:hidden pt-0 -mt-[10px] mobile-section">
  <!-- Content (above the background) -->
  <div class="relative z-10 max-w-3xl space-y-4">
    <h1 class="text-[13vw] md:text-[7vw] lg:text-[160px] font-bold leading-tight mb-0">
      <span class="gradient-text block" style="font-family: 'Thunder';"> LOOPLYNKS </span>
    </h1>
    <h2 class="text-3xl md:text-8xl lg:text-[120px] font-bold gradient-text mb-0" style="font-family: 'thunder';">
      Global Recognition Initiative </h2>
    <p class="text-lg md:text-2xl text-white font-normal mt-1 mb-4" style="font-family: 'Lato';"> A
      Global Tribute in Tbilisi for Those Who Redefine Leadership </p>
  </div>

  <!-- Image card -->
  <div class="relative z-10 mt-4 w-full max-w-3xl">
    <div class="relative overflow-hidden rounded-xl shadow-2xl h-[420px] md:h-[520px] lg:h-[600px] card-mask">
      <img src="{{ asset('looplynks/images/About the program.png') }}" alt="Tbilisi" class="object-cover w-full h-full" />
    </div>
  </div>
</section>
