<div id="preloader" class="hidden sm:flex fixed inset-0 items-center justify-center z-50 overflow-hidden">
  <div class="absolute inset-0 flex pointer-events-none z-20">
    <div id="left-curtain" class="flex-1 overflow-hidden relative">
      <div id="left-curtain-img" class="w-full h-full" style="background-image: url('{{asset('images/HeroSection.png')}}')">
      </div>
    </div>
    <div id="right-curtain" class="flex-1 overflow-hidden relative">
      <div id="right-curtain-img" class="w-full h-full transform scale-x-[-1]"
        style="background-image: url('{{asset('images/HeroSection.png')}}')"></div>
    </div>
  </div>
  <div class="absolute inset-0 z-30 flex flex-col items-center justify-center pointer-events-none">
    <div id="logoo" class="w-1/5 opacity-0 transition-opacity duration-500">
      <img src="{{ asset('looplynks/images/logo.png')}}" alt="Brand logo" class="w-full h-full object-contain" />
    </div>
    <div id="vline"
      class="absolute left-1/2 top-0 -translate-x-1/2 w-0.5 h-0 bg-white rounded opacity-0 overflow-hidden">
      <div class="absolute top-0 left-0 w-full h-full bg-white origin-top animate-line-draw"></div>
    </div>
  </div>
</div>
