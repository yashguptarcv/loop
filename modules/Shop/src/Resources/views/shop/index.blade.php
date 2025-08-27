@extends('shop::layouts.app')

@section('hero-section')
@include('shop::layouts.hero-section')
@endsection

@section('content')




  <!-- Main Header (as before) -->



  <!-- Logo Slider Section -->
  <section class="w-full bg-[#121212] py-8 shadow-2xl">
    <div class="overflow-hidden relative">
      <div id="logo-slider" class="flex items-center space-x-16 animate-logo-scroll w-max">
        <!-- First set of logos -->
        <img src="{{ asset('looplynks/logos/logo-white.png') }}" alt="Logo 1" class="h-10 w-auto opacity-100" />
        <img src="{{ asset('looplynks/logos/logo-white.png') }}" alt="Logo 1" class="h-10 w-auto opacity-100" />
        <img src="{{ asset('looplynks/logos/logo-white.png') }}" alt="Logo 3" class="h-10 w-auto opacity-100" />
        <img src="{{ asset('looplynks/logos/logo-white.png') }}" alt="Logo 4" class="h-10 w-auto opacity-100" />
        <img src="{{ asset('looplynks/logos/logo-white.png') }}" alt="Logo 5" class="h-10 w-auto opacity-100" />
        <img src="{{ asset('looplynks/logos/logo-white.png') }}" alt="Logo 6" class="h-10 w-auto opacity-100" />
        <img src="{{ asset('looplynks/logos/logo-white.png') }}" alt="Logo 7" class="h-10 w-auto opacity-100" />
        <!-- Second set of logos (to create the infinite scroll effect) -->
        <img src="{{ asset('looplynks/logos/logo-white.png') }}" alt="Logo 1" class="h-10 w-auto opacity-100" />
        <img src="{{ asset('looplynks/logos/logo-white.png') }}" alt="Logo 1" class="h-10 w-auto opacity-100" />
        <img src="{{ asset('looplynks/logos/logo-white.png') }}" alt="Logo 3" class="h-10 w-auto opacity-100" />
        <img src="{{ asset('looplynks/logos/logo-white.png') }}" alt="Logo 4" class="h-10 w-auto opacity-100" />
        <img src="{{ asset('looplynks/logos/logo-white.png') }}" alt="Logo 5" class="h-10 w-auto opacity-100" />
        <img src="{{ asset('looplynks/logos/logo-white.png') }}" alt="Logo 6" class="h-10 w-auto opacity-100" />
        <img src="{{ asset('looplynks/logos/logo-white.png') }}" alt="Logo 7" class="h-10 w-auto opacity-100" />
      </div>
    </div>
  </section>

  <!-- About the program Section -->

  <section class="relative w-full h-screen bg-black/80 flex items-center justify-center bg-center bg-cover"
    style="background-image: url('{{ asset('looplynks/images/About the program.png') }}');">

    <div
      class="relative z-10 flex flex-col md:flex-row items-center md:items-start justify-between w-full px-4 sm:px-6 md:px-10 lg:px-6 xl:px-16 py-20 max-w-[1400px] mx-auto gap-12">

      <!-- Left: Heading -->
      <div class="w-full md:w-1/2 flex-shrink-0">
        <h2
          class="whitespace-nowrap text-4xl sm:text-4xl md:text-5xl lg:text-6xl font-vegawanty font-semibold text-left gradient-text leading-tight">
          About the program
        </h2>
      </div>

      <!-- Right: Text -->
      <div class="w-full md:w-1/2 text-white text-base md:text-lg flex flex-col gap-6">
        <p>
          LoopLynks is a next-generation recognition brand rooted in the idea that leadership is a living loop,
          not a linear finish line. Born out of a desire to honour those who make meaningful contributions, we celebrate
          symbolic awards as emblems of journeys that go beyond success – stories of vision, grit, and timeless impact.
          They embody
          influence, integrity, and innovation.
        </p>

        <p>
          Our organisation represents and recognises the continuous nature of growth and the ripple
          effect of great leadership. Whether it's within companies, communities, or causes, we serve those
          who strive to make a difference not just once, but always. LoopLynks doesn't just reward the now,
          it honours the next. We recognise organisations that embody deeper values and individuals who lead beyond the
          ordinary.
        </p>

        <a href="#" class="relative mt-2 inline-block w-fit text-lg font-semibold uppercase tracking-wide text-white 
        px-6 py-3 border-b-2 border-white bg-transparent rounded-none transition-all duration-200 
        hover:text-black font-medium hover:bg-gradient-to-r hover:from-[#b4882a] hover:via-[#D4AF37] hover:to-yellow-500 
        hover:shadow-lg hover:border-b-transparent hover:rounded-lg">
          Explore More
        </a>
      </div>
    </div>
  </section>


  <section id="georgiaSection"
    class="relative px-4 py-20 md:px-[120px] md:py-[120px] hidden md:block bg-center bg-cover position-sticky"
    style="background-image: url('{{ asset('looplynks/images/why georgia_bg_gradient.png') }}');">
    <!-- Background Image -->
    <img src="{{ asset('looplynks/images/why georgia.png') }}" alt="Georgia City"
      class="sticky inset-x-0 top-0 w-full h-[300px] md:h-full object-cover" />

    <!-- Text + Subtext with Scroll Animation -->
    <div class="absolute left-4 bottom-20 md:left-[156px] md:bottom-[176px] z-10 text-white
           flex flex-col md:flex-row items-start md:items-end gap-2 md:gap-4
           max-w-[90%] md:max-w-[80%]">
      <h2 class="text-2xl sm:text-3xl md:text-5xl font-thunder font-semibold uppercase
             leading-tight drop-shadow-lg whitespace-nowrap">
        Why Georgia?
      </h2>
      <p class="text-sm sm:text-base md:text-xl font-lato drop-shadow-sm">
        A Crossroads of Culture, Innovation & Charm
      </p>
    </div>

    <!-- Map Image Container -->
    <div id="georgiaMap" class="absolute right-4 bottom-4 md:right-[256px] md:bottom-[77px] z-10">
      <img src="{{ asset('looplynks/images/Georgia pin location.png') }}" alt="Georgia Map"
        class="w-40 sm:w-52 md:w-[352px] rounded-lg shadow-xl border border-white" />
    </div>

    <style>
      /* initial state: hidden and shifted down */
      #georgiaMap img {
        opacity: 0;
        transform: translateY(100%);
        transition: opacity 0.1s linear, transform 0.1s linear;
        will-change: opacity, transform;
      }
    </style>

    <script>
      (function () {
        const section = document.getElementById('georgiaSection');
        const mapImg = document.querySelector('#georgiaMap img');

        function onScroll() {
          const rect = section.getBoundingClientRect();
          const winH = window.innerHeight;

          // progress: 0 when section top == viewport bottom,
          //          1 when section bottom == viewport top
          let progress = (winH - rect.top) / (winH + rect.height);
          progress = Math.min(Math.max(progress, 0.5), 1);

          let opacity;
          if (progress <= 1) {
            opacity = progress * 2;
          } else {
            opacity = (1 - progress) * 2;
          }

          // translateY: 50px → 0px as it scrolls in, then 0px → -50px as it scrolls out
          const translateY = 2 * (1 - 2 * (progress - 0.5) * (progress > 0.5 ? 1 : 0));
          // simpler: map moves up from +50px (offscreen) → 0 → –50px

          mapImg.style.opacity = opacity;
          mapImg.style.transform = `translateY(${(1 - progress) * 50 - (progress > 0.5 ? (progress - 0.5) * 100 : 0)}px)`;
        }

        window.addEventListener('scroll', onScroll, { passive: true });

        onScroll();
      })();
    </script>
  </section>


  <!-- for mibile screen -->
  <section
    class="relative w-full h-full flex flex-col justify-between items-center px-6 overflow-hidden bg-center bg-cover block md:hidden"
    style="background-image: url('{{ asset('looplynks/images/why georgia_bg_gradient.png') }}');">

    <!-- Background Image Container -->
    <div class="relative w-full h-[50rem]">
      <img src="{{ asset('looplynks/images/why georgia.png') }}" alt="Georgia Landscape"
        class="w-full h-full object-cover rounded-[10px] pb-8" />

      <!-- Overlaid Content -->
      <div class="absolute inset-0 flex flex-col justify-end items-start text-left px-6">

        <h2 class="text-white text-3xl font-bold mb-2" style="font-family: 'Thunder', sans-serif;">
          WHY GEORGIA?
        </h2>
        <p class="text-white text-base font-lato mb-6">
          A Crossroads of Culture, Innovation & Charm
        </p>


        <div class="w-[100%] max-w-sm rounded-[10px] overflow-hidden shadow-lg border">
          <img src="{{ asset('looplynks/images/Georgia pin location.png') }}" alt="Map of Georgia" class="w-full object-cover" />
        </div>
      </div>
    </div>

  </section>


  <!-- SECTION START -->
  <section class="h-[100%] w-full bg-cover bg-center py-[120px] px-4 md:px-16"
    style="background-image: url('{{ asset('looplynks/images/Why should you participate.jpg') }}');">
    <div class="max-w-[1440px] mx-auto flex flex-col lg:flex-row items-start gap-10">

      <!-- Left Content -->
      <div class="lg:w-1/2">
        <h2 class="text-[3rem] md:text-[72px] font-vegawanty font-semibold gradient-text leading-tight mb-4"><span
            class="gradient-text">Why should you <br /> participate?</span></h2>
        <p class="text-white text-base md:text-lg max-w-md">
          LoopLynks is where bold leaders are seen, heard, and celebrated. It’s not just recognition -- it’s a platform
          to amplify your impact, connect globally, and be part of something that shapes the future.
        </p>
      </div>

      <!-- Right Swiper -->
      <div class="lg:w-1/2 w-full relative">
        <div class="swiper mySwiper">
          <div class="swiper-wrapper">

            <!-- Slide 1 -->
            <div class="swiper-slide relative p-[2.3rem] text-white border-l border-white/20">
              <h3 class="text-white font-lato font-bold text-2xl mb-[1.2rem]">01<br><span
                  class="gradient-text">Celebrate Leadership</span></h3>
              <p class="text-sm mb-3">
                At LoopLynks, we honor those who uplift others and create lasting impact—not with noise,
                but through consistent, meaningful leadership.

              </p>
              <img src="{{ asset('looplynks/images/slide1.png') }}" alt="Leadership" class="rounded-md w-full h-full object-cover">
              <!-- Vertical Divider Line -->

            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide relative p-[2.3rem] text-white border-l border-white/20">
              <h3 class="text-white font-lato font-bold text-2xl mb-[1.2rem]">02<br><span class="gradient-text">Build
                  Legacy</span></h3>
              <p class="text-sm mb-3">
                LoopLynks celebrates leaders who leave lasting impact—shaping people, culture, and systems
                through integrity, innovation, and purposeful action.
              </p>
              <img src="{{ asset('looplynks/images/slide2.png') }}" alt="Legacy" class="rounded-md w-full h-full object-cover">

            </div>

            <!-- Slide 3 -->
            <div class="swiper-slide relative p-[2.3rem] text-white border-l border-white/20">
              <h3 class="text-white font-lato font-bold text-2xl mb-[1.2rem]">03<br><span class="gradient-text">Inspire
                  Others</span></h3>
              <p class="text-sm mb-3">
                At LoopLynks, purposeful leadership speaks volumes—quiet courage becomes a milestone that inspires
                teams, peers, and the future of leadership.
              </p>
              <img src="{{ asset('looplynks/images/slide3.png') }}" alt="Growth" class="rounded-md w-full h-full object-cover">

            </div>

            <!-- Slide 4 -->
            <div class="swiper-slide relative p-[2.3rem] text-white border-l border-white/20">
              <h3 class="text-white font-lato font-bold text-2xl mb-[1.2rem]">04<br><span class="gradient-text">Elevate
                  Presence</span></h3>
              <p class="text-sm mb-3">
                LoopLynks recognition isn’t about image—it’s about visibility rooted in values, where your presence
                reflects your impact, intention, and authentic leadership.
              </p>
              <img src="{{ asset('looplynks/images/slide4.png') }}" alt="Innovation" class="rounded-md w-full h-full object-cover">
              <!-- <div class="absolute top-0 right-0 h-full w-[1px] bg-white/30"></div> -->
            </div>

            <!-- Slide 5 -->
            <div class="swiper-slide relative p-[2.3rem] text-white border-l border-white/20">
              <h3 class="text-white font-lato font-bold text-2xl mb-[1.2rem]">05<br><span class="gradient-text">Join
                  Visionaries</span></h3>
              <p class="text-sm mb-3">
                At LoopLynks, join leaders who define success on their terms—where influence is shared,
                growth is constant, and legacies are shaped together.
              </p>
              <img src="{{ asset('looplynks/images/slide5.png') }}" alt="Empowerment" class="rounded-md w-full h-full object-cover">
              <!-- <div class="absolute top-0 right-0 h-full w-[1px] bg-white/30"></div> -->
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- <section class="py-20 px-6 md:px-12 bg-center bg-cover position-relative"
    style="background-image: url(./images/Gallery\ bg.jpg);">


    <div id="gallery" class="gallery-3d grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">

      <img src="./images/slide1.png" class="rounded-lg w-full h-[250px] object-cover" />
      <img src="./images/slide2.png" class="rounded-lg w-full h-[250px] object-cover" />
      <img src="./images/slide3.png" class="rounded-lg w-full h-[250px] object-cover" />
      <img src="./images/slide4.png" class="rounded-lg w-full h-[250px] object-cover" />
      <img src="./images/slide4.png" class="rounded-lg w-full h-[250px] object-cover" />
      <img src="./images/slide5.png" class="rounded-lg w-full h-[250px] object-cover" />

    </div>
  </section> -->

  <section class="bg-black text-white py-8 md:py-12 w-full px-4 md:px-[4rem] relative">
    <div class="w-full h-full md:px-[5rem] md:pr-0">

      <!-- Section Heading - Made sticky -->
      <div class="sticky top-0 z-10 bg-black pb-4 pt-[3.5rem] md:pt-[5.5rem]">
        <h2 class="text-3xl md:text-6xl font-thunder font-semibold text-transparent gradient-text mb-2">
          Podcasts
        </h2>
      </div>

      <div class="relative space-y-[30vh] md:space-y-[90vh]">

        <!-- Card 01 -->
        <div
          class="sticky top-[4rem] md:top-[5rem] flex flex-col-reverse md:flex-row gap-6 md:gap-[12rem] items-center h-[80vh] md:h-[50vh] min-h-[300px] bg-black">
          <!-- Left Content -->
          <div class="flex flex-col justify-center items-start w-full md:w-1/2 pt-8 md:pt-0">
            <p class="text-xs md:text-sm text-gray-300 mb-2">Media · Jul 2025</p>
            <h3 class="text-xl md:text-4xl font-semibold mb-3 md:mb-4">Lorem Ipsum Dolor Sit Amet Consectetur.</h3>
            <p class="text-sm md:text-base text-gray-400 mb-6 md:mb-8">Lorem ipsum dolor sit amet consectetur. Nibh amet
              quis porttitor vulputate
              viverra vitae consequat turpis.</p>
            <a href="#" class="inline-block w-fit text-base md:text-lg font-semibold capitalize tracking-wide text-white 
              px-4 py-2 md:px-6 md:py-3 border-b-2 border-white bg-transparent rounded-none transition-all duration-200 
              hover:text-black hover:bg-gradient-to-r hover:from-[#b4882a] hover:via-[#D4AF37] hover:to-yellow-500 
              hover:shadow-lg hover:border-b-transparent hover:rounded-lg">
              View Podcast
            </a>
          </div>

          <!-- Right Image -->
          <div class="relative flex justify-center w-full md:w-1/2 h-[40vh] md:h-auto">
            <img src="{{ asset('looplynks/images/why georgia.png') }}" alt="Podcast Cover"
              class="w-3/4 md:w-72 aspect-square object-cover rounded-md shadow-lg">
            <span
              class="absolute left-2 top-4 md:-left-[13.75rem] md:top-2 lg:ml-[422px] text-yellow-500 text-xl md:text-2xl font-light">01</span>
          </div>

          <!-- Horizontal Line -->
          <div class="absolute bottom-0 w-full h-px bg-white md:w-[98rem]"></div>
        </div>

        <!-- Card 02 -->
        <div
          class="sticky top-[2rem] md:top-4 flex flex-col-reverse md:flex-row gap-6 md:gap-[12rem] items-center h-[80vh] md:h-[70vh] min-h-[300px] bg-black">
          <!-- Left Content -->
          <div class="flex flex-col justify-center items-start w-full md:w-1/2 pt-8 md:pt-0">
            <p class="text-xs md:text-sm text-gray-300 mb-2">Media · Jul 2025</p>
            <h3 class="text-xl md:text-4xl font-semibold mb-3 md:mb-4">Lorem Ipsum Dolor Sit Amet Consectetur.</h3>
            <p class="text-sm md:text-base text-gray-400 mb-6 md:mb-8">Lorem ipsum dolor sit amet consectetur. Nibh amet
              quis porttitor vulputate
              viverra vitae consequat turpis.</p>
            <a href="#" target="_blank" class="inline-block w-fit text-base md:text-lg font-semibold capitalize tracking-wide text-white 
              px-4 py-2 md:px-6 md:py-3 border-b-2 border-white bg-transparent rounded-none transition-all duration-200 
              hover:text-black hover:bg-gradient-to-r hover:from-[#b4882a] hover:via-[#D4AF37] hover:to-yellow-500 
              hover:shadow-lg hover:border-b-transparent hover:rounded-lg">
              View Podcast
            </a>
          </div>

          <!-- Right Image -->
          <div class="relative flex justify-center w-full md:w-1/2 h-[40vh] md:h-auto">
            <img src="{{ asset('looplynks/images/why georgia.png') }}" alt="Podcast Cover"
              class="w-3/4 md:w-72 aspect-square object-cover rounded-md shadow-lg">
            <span
              class="absolute left-4 top-4 md:-left-[13.75rem] md:top-2 lg:ml-[422px] text-yellow-500 text-xl md:text-2xl font-light">02</span>


          </div>

          <!-- Horizontal Line -->
          <div class="absolute bottom-0 w-full h-px bg-white md:w-[98rem]"></div>
        </div>

        <!-- Final spacer -->
        <!-- <div class="h-[20vh] md:h-[50vh]"></div> -->
      </div>
    </div>
  </section>

  <!-- Event Cards Section CSS -->

  <!-- Event Cards Section -->
  <div class="event-cards-section bg-center bg-cover bg-no-repeat bg-fixed w-full overflow-hidden"
    style="background-image: url('{{ asset('looplynks/images/About the program.png') }}');">
    <!-- Floating background elements -->
    <div class="floating-elements" id="floatingElements"></div>




    <div class="cards-wrapper overflow-hidden">


      <div class="cards-bg-heading gradient-text mt-10 text-3xl md:text-4xl lg:text-5xl xl:text-[6rem]">
        Event Schedule
      </div>


      <div class="cards-container" id="cardsContainer">

        <!-- Card 1 -->
        <div class="event-card initially-hidden" data-card="1">
          <div class="card-time text-[1.8rem] font-milki walky">8:00 am - 9:15 am</div>
          <h3 class="card-title font-lato text-[18.26px]">Brew, Bites, and Beginnings</h3>
          <p class="card-desc text-[14.80px] text-[14.80px]">Join fellow professionals for a focused morning of
            specialty coffee and strategic networking designed to spark ideas and open doors.</p>
          <div class="card-image">
            <img src="{{ asset('looplynks/images/card1.jpg') }}" alt="Registration">

          </div>
        </div>

        <!-- Card 2 -->
        <div class="event-card initially-hidden" data-card="2">
          <div class="card-image">
            <img src="https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=400&h=300&fit=crop"
              alt="Welcome Speech">

          </div>
          <div class="card-time text-[1.8rem] font-milki walky">9:15 AM - 9:30 AM</div>
          <h3 class="card-title font-lato text-[18.26px]">Opening Note: LoopLynks, Dubai, 2026</h3>
          <p class="card-desc text-[14.80px]">A formal welcome to set the stage, aligning minds, purpose, and momentum
            as we begin this landmark gathering.
          </p>
        </div>

        <!-- Card 3 - Initially Hidden -->
        <div class="event-card initially-hidden" data-card="3">
          <div class="card-time text-[1.8rem] font-milki walky">9:30 AM - 10:00 AM</div>
          <h3 class="card-title font-lato text-[18.26px]">Keynote - Topic TBD</h3>
          <p class="card-desc text-[14.80px]">A headline session led by a distinguished voice. setting the vision,
            provoking thought, and anchoring the day’s dialogue.</p>
          <div class="card-image">
            <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?w=400&h=300&fit=crop"
              alt="Panel Discussion">

          </div>
        </div>

        <!-- Card 4 - Initially Hidden -->
        <div class="event-card initially-hidden" data-card="4">
          <div class="card-image">
            <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=400&h=300&fit=crop"
              alt="Lunch Break">

          </div>
          <div class="card-time text-[1.8rem] font-milki walky">10:00 AM - 10:40 AM</div>
          <h3 class="card-title font-lato text-[18.26px]">Boosting ROI with Attention Metrics: A Game-Changer for
            Performance Marketers</h3>
          <p class="card-desc text-[14.80px]">Explore how attention metrics boost performance marketing, real strategies
            to measure focus, optimize ROI, and drive smarter results.</p>
        </div>

        <!-- Card 5 - Initially Hidden -->
        <div class="event-card initially-hidden" data-card="5">
          <div class="card-time text-[1.8rem] font-milki walky">10:40 AM - 11:20 AM</div>
          <h3 class="card-title font-lato text-[18.26px]">Equitable Access in Conflict Settings</h3>
          <p class="card-desc text-[14.80px]">Tackling access in conflict zones, this panel unpacks barriers and
            solutions in health, aid, education, and digital inclusion.</p>

          <div class="card-image">
            <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=400&h=300&fit=crop"
              alt="Award Ceremony">

          </div>
        </div>

        <!-- Card 6 - Initially Hidden -->
        <div class="event-card initially-hidden" data-card="6">
          <div class="card-image">
            <img src="https://images.unsplash.com/photo-1478737270239-2f02b77fc618?w=400&h=300&fit=crop"
              alt="Keynote Address">

          </div>
          <div class="card-time text-[1.8rem] font-milki walky">11:20 AM - 12:00 PM</div>
          <h3 class="card-title font-lato text-[18.26px]">Triumphs & Trophies</h3>
          <p class="card-desc text-[14.80px]">Celebrating excellence, honoring game-changers, and recognizing the
            milestones that moved industries forward.</p>
        </div>

        <!-- Card 7 - Initially Hidden -->
        <div class="event-card initially-hidden" data-card="8">
          <div class="card-time text-[1.8rem] font-milki walky">12:00 PM - 01:15 PM</div>
          <h3 class="card-title font-lato text-[18.26px]">The Business Lunch</h3>
          <p class="card-desc text-[14.80px]">A curated mid-day break where conversations continue over cuisine,
            network, reflect, and connect in a more relaxed setting.</p>

          <div class="card-image">
            <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=400&h=300&fit=crop"
              alt="Closing Remarks">

          </div>
        </div>

        <!-- Card 8 - Initially Hidden -->
        <div class="event-card initially-hidden" data-card="9">

          <div class="card-image">
            <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=400&h=300&fit=crop"
              alt="Closing Remarks">

          </div>
          <div class="card-time text-[1.8rem] font-milki walky">01:15 PM - 01:55 PM</div>
          <h3 class="card-title font-lato text-[18.26px]">Is Coding the New Literacy or Just a Buzzword?</h3>
          <p class="card-desc text-[14.80px]">Is coding the new literacy or just hype? This panel dives into its value,
            accessibility, and role in shaping future careers and education.</p>

        </div>
        <!-- Card 9 - Initially Hidden -->
        <div class="event-card initially-hidden" data-card="10">
          <div class="card-time text-[1.8rem] font-milki walky">01:55 PM - 02:15 PM</div>
          <h3 class="card-title font-lato text-[18.26px]">Keynote - Topic TBD</h3>
          <p class="card-desc text-[14.80px]">A flagship address from a leading voice, offering fresh perspective,
            strategic insight, and inspiration for what lies ahead.</p>
          <div class="card-image">
            <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=400&h=300&fit=crop"
              alt="Closing Remarks">

          </div>
        </div>

        <!-- Card 10 - Initially Hidden -->

        <div class="event-card initially-hidden" data-card="11">
          <!-- Image first -->
          <div class="card-image">
            <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=400&h=300&fit=crop"
              alt="Closing Remarks">
          </div>

          <!-- Content after image -->
          <div class="card-time text-[1.8rem] font-milki walky">02:15 PM - 02:55 PM</div>
          <h3 class="card-title font-lato text-[18.26px]">Triumphs & Trophies</h3>
          <p class="card-desc text-[14.80px]">Celebrating excellence, honoring game-changers, and recognizing the
            milestones that moved industries forward.</p>
        </div>


        <!-- Card 11 - Initially Hidden -->

        <div class="event-card initially-hidden" data-card="12">
          <div class="card-time text-[1.8rem] font-milki walky">02:55 PM - 03:15 PM</div>
          <h3 class="card-title font-lato text-[18.26px]">The Coffee Connection</h3>
          <p class="card-desc text-[14.80px]">An networking session powered by caffeine and conversation, meet peers,
            share ideas, and spark new collaborations.</p>
          <div class="card-image">
            <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=400&h=300&fit=crop"
              alt="Closing Remarks">

          </div>
        </div>

        <!-- Card 12 - Initially Hidden -->

        <div class="event-card initially-hidden" data-card="12">
          <!-- Image first -->
          <div class="card-image">
            <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=400&h=300&fit=crop"
              alt="Closing Remarks">
          </div>

          <!-- Content after -->
          <div class="card-time text-[1.8rem] font-milki walky">03:15 PM - 03:55 PM</div>
          <h3 class="card-title font-lato text-[18.26px]">The Power of the Pivot: Navigating Change with Purpose and
            Clarity</h3>
          <p class="card-desc text-[14.80px]">How do leaders turn change into opportunity? This panel shares tools,
            stories, and strategies to lead with clarity, resilience, and purpose.</p>
        </div>


        <!-- Card 13 - Initially Hidden -->

        <div class="event-card initially-hidden" data-card="13">
          <div class="card-time text-[1.8rem] font-milki walky">03:55 PM - 04:35 PM</div>
          <h3 class="card-title font-lato text-[18.26px]">Triumphs & Trophies</h3>
          <p class="card-desc text-[14.80px]">Celebrating excellence, honoring game-changers, and recognizing the
            milestones that moved industries forward.</p>
          <div class="card-image">
            <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=400&h=300&fit=crop"
              alt="Closing Remarks">

          </div>
        </div>

        <!-- Card 14 - Initially Hidden -->

        <div class="event-card initially-hidden" data-card="14">
          <!-- Image first -->
          <div class="card-image">
            <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=400&h=300&fit=crop"
              alt="Closing Remarks">
          </div>

          <!-- Content after -->
          <div class="card-time text-[1.8rem] font-milki walky">04:35 PM - 04:45 PM</div>
          <h3 class="card-title font-lato text-[18.26px]">Curtain Call</h3>
          <p class="card-desc text-[14.80px]">A closing moment to reflect, recognize, and recharge,wrapping up the
            LoopLynks experience with clarity, gratitude, and forward momentum.</p>
        </div>


        <!-- Card 15 - Initially Hidden -->

        <div class="event-card initially-hidden" data-card="15">
          <div class="card-time text-[1.8rem] font-milki walky">04:45 PM - 05:00 PM</div>
          <h3 class="card-title font-lato text-[18.26px]">Group Click</h3>
          <p class="card-desc text-[14.80px]">A collective snapshot to capture the faces behind the ideas, one frame,
            many futures.</p>
          <div class="card-image">
            <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=400&h=300&fit=crop"
              alt="Closing Remarks">

          </div>
        </div>

        <!-- Card 16 - Initially Hidden -->

        <div class="event-card initially-hidden" data-card="16">
          <!-- Image first -->
          <div class="card-image">
            <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=400&h=300&fit=crop"
              alt="Closing Remarks">
          </div>

          <!-- Content after -->
          <div class="card-time text-[1.8rem] font-milki walky">05:00 PM onwards</div>
          <h3 class="card-title font-lato text-[18.26px]">Bites & Business</h3>
          <p class="card-desc text-[14.80px]">Where casual dining meets purposeful dialogue, forge connections, exchange
            insights, and keep the ideas flowing over shared plates.</p>
        </div>


      </div>
    </div>
  </div>


  <!-- <section class="bg-black text-white py-20 px-6 lg:px-24 ">
    <div class="max-w-10xl mx-auto grid lg:grid-cols-2 items-start mt-0 lg:mt-[90px]">

      
      <div class="lg:ml-[268px] py-10 lg:py-0">
        <h2
          class="text-6xl font-extrabold leading-tight bg-gradient-to-r from-white via-[#D4AF37] to-yellow-500 bg-clip-text text-transparent">
          Jury Members
        </h2>
        <p class="mt-6 text-gray-300 leading-relaxed text-lg ">
          Lorem ipsum dolor sit amet consectetur. In leo placerat nunc nulla aliquam dignissim sed blandit quis. Viverra
          id commodo nisi quis lectus purus.
        </p>
      </div>

      
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-1 px-2 sm:px-4">

        
        <div
          class="invisible lg:visible hidden lg:block bg-transparent text-black p-2 mt-5 rounded-lg relative aspect-square">
        </div>

        <div class="bg-gray-100 text-black p-2 rounded-lg relative aspect-square overflow-hidden">
          <div class="w-2 h-2 bg-black rounded-full absolute top-2 left-2"></div>

          <img src="{{ asset('looplynks/images/slide1.png') }}" alt="Jury Member" class="w-full h-full object-cover rounded-lg" />
          <div class="absolute top-1/2 -translate-y-1/2 left-0 right-0 flex justify-start px-2">
          </div>
        </div>


        
        <div class="bg-gray-100 text-black p-4 rounded-lg relative aspect-square">
          <div class="w-2 h-2 bg-black rounded-full absolute top-2 left-2"></div>
          <img src="{{ asset('looplynks/images/slide2.png') }}" alt="Jury Member" class="w-full h-full object-cover rounded-lg" />

          
          <div class="absolute top-1/2 -translate-y-1/2 left-[-15px] right-0 flex align-items-left">
            <div class="w-6 h-1 bg-gradient-to-r from-yellow-500 to-yellow-700 rounded-sm shadow-md"></div>
          </div>
          
        </div>

        
        <div class="bg-gray-100 text-black p-4 rounded-lg relative aspect-square">
          <div class="w-2 h-2 bg-black rounded-full absolute top-2 left-2"></div>
          <img src="{{ asset('looplynks/images/slide3.png') }}" alt="Jury Member" class="w-full h-full object-cover rounded-lg" />
          
        </div>

        
        <div class="bg-gray-100 text-black p-4 rounded-lg relative aspect-square">
          <div class="w-2 h-2 bg-black rounded-full absolute top-2 left-2"></div>
          <img src="./images/slide4.png" alt="Jury Member" class="w-full h-full object-cover rounded-lg" />
        
          <div class="absolute top-1/2 -translate-y-1/2 left-[-15px] right-0 flex align-items-left">
            <div class="w-6 h-1 bg-gradient-to-r from-yellow-500 to-yellow-700 rounded-sm shadow-md "></div>
          </div>
          
        </div>

        
        <div
          class="invisible lg:visible hidden lg:block bg-transparent text-black p-4 rounded-lg relative aspect-square">
          <div class="w-2 h-2 bg-black rounded-full absolute top-2 left-2"></div>

        </div>



      </div>
    </div>
  </section> -->

  <!-- Testimonial Section -->
  <section class="relative overflow-hidden py-24 px-4 sm:px-8 lg:px-24 bg-center bg-no-repeat bg-cover"
    style="background-image: url('{{ asset('looplynks/images/Testimonials_bg_gradient.png') }}');">


    <!-- Bottom shadow overlay -->
    <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-[#01120c]/80 to-transparent"></div>

    <div class="hidden lg:block">
      <div class="max-w-10xl mx-auto grid lg:grid-cols-2 items-start mt-0 lg:mt-[90px] ">

        <!-- Left Section -->
        <div class="lg:ml-[268px] py-10 lg:py-0">
          <h2 class="text-6xl font-semibold leading-tight gradient-text">
            Jury Members
          </h2>
          <p class="mt-6 text-gray-300 leading-relaxed text-lg ">
            Lorem ipsum dolor sit amet consectetur. In leo placerat nunc nulla aliquam dignissim sed blandit quis.
            Viverra
            id commodo nisi quis lectus purus.
          </p>
        </div>

        <!-- Right Card Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-1 px-2 sm:px-4">

          <!-- Card 1 - Transparent -->
          <div
            class="invisible lg:visible hidden lg:block bg-transparent text-black p-2 mt-5 rounded-lg relative aspect-square">
          </div>

          <div class="bg-gray-100 text-black p-4 rounded-lg relative aspect-square overflow-hidden">
            <div class="w-2 h-2 bg-black rounded-full absolute top-2 left-2"></div>

            <img src="{{ asset('looplynks/images/slide1.png') }}" alt="Jury Member" class="w-full h-full object-cover rounded-lg" />
            <div class="absolute top-1/2 -translate-y-1/2 left-0 right-0 flex justify-start px-2">
            </div>
          </div>


          <!-- Card 3 -->
          <div class="bg-gray-100 text-black p-4 rounded-lg relative aspect-square">
            <div class="w-2 h-2 bg-black rounded-full absolute top-2 left-2"></div>
            <img src="{{ asset('looplynks/images/slide2.png') }}" alt="Jury Member" class="w-full h-full object-cover rounded-lg" />

            <!-- Horizontal Accent -->
            <div class="absolute top-1/2 -translate-y-1/2 left-[-15px] right-0 flex align-items-left">
              <div class="hidden md:block w-6 h-1 bg-gradient-to-r from-yellow-500 to-yellow-700 rounded-sm shadow-md">
              </div>
            </div>
            <!-- <p class="absolute bottom-2 left-4 font-medium">Name of Jury Member</p> -->
          </div>

          <!-- Card 4 -->
          <div class="bg-gray-100 text-black p-4 rounded-lg relative aspect-square">
            <div class="w-2 h-2 bg-black rounded-full absolute top-2 left-2"></div>
            <img src="{{ asset('looplynks/images/slide3.png') }}" alt="Jury Member" class="w-full h-full object-cover rounded-lg" />
            <!-- <p class="absolute bottom-2 left-4 font-medium">Name of Jury Member</p> -->
          </div>

          <!-- Card 5 -->
          <div class="bg-gray-100 text-black p-4 rounded-lg relative aspect-square">
            <div class="w-2 h-2 bg-black rounded-full absolute top-2 left-2"></div>
            <img src="{{ asset('looplynks/images/slide4.png') }}" alt="Jury Member" class="w-full h-full object-cover rounded-lg" />
            <!-- Horizontal Accent -->
            <div class="absolute top-1/2 -translate-y-1/2 left-[-15px] right-0 flex align-items-left">
              <div class="hidden md:block w-6 h-1 bg-gradient-to-r from-yellow-500 to-yellow-700 rounded-sm shadow-md">
              </div>
            </div>
            <!-- <p class="absolute bottom-2 left-4 font-medium">Name of Jury Member</p> -->
          </div>

          <!-- Card 6 - Transparent -->
          <div
            class="invisible lg:visible hidden lg:block bg-transparent text-black p-4 rounded-lg relative aspect-square">
            <div class="w-2 h-2 bg-black rounded-full absolute top-2 left-2"></div>

          </div>



        </div>

      </div>
    </div>

    <!-- for mibile screen start -->

    <div class="max-w-10xl mx-auto block lg:hidden">

      <!-- Mobile-only Section Heading -->
      <div class="px-4 py-8">
        <h2 class="text-5xl sm:text-5xl font-semibold leading-tight gradient-text">
          Jury Members
        </h2>
        <p class="mt-4 text-gray-300 leading-relaxed text-base sm:text-lg">
          Lorem ipsum dolor sit amet consectetur. In leo placerat nunc nulla aliquam dignissim sed blandit quis. Viverra
          id commodo nisi quis lectus purus.
        </p>
      </div>

      <!-- Mobile Card Grid -->
      <div class="grid grid-cols-1 gap-2 px-16">

        <!-- Card 1 -->
        <div class="bg-gray-100 text-black p-3 rounded-lg relative aspect-square">
          <div class="w-2 h-2 bg-black rounded-full absolute top-2 left-2"></div>
          <img src="{{ asset('looplynks/images/slide1.png') }}" alt="Jury Member" class="w-full h-full object-cover rounded-lg" />
        </div>

        <!-- Card 2 -->
        <div class="bg-gray-100 text-black p-3 rounded-lg relative aspect-square">
          <div class="w-2 h-2 bg-black rounded-full absolute top-2 left-2"></div>
          <img src="{{ asset('looplynks/images/slide2.png') }}" alt="Jury Member" class="w-full h-full object-cover rounded-lg" />
        </div>

        <!-- Card 3 -->
        <div class="bg-gray-100 text-black p-3 rounded-lg relative aspect-square">
          <div class="w-2 h-2 bg-black rounded-full absolute top-2 left-2"></div>
          <img src="{{ asset('looplynks/images/slide3.png') }}" alt="Jury Member" class="w-full h-full object-cover rounded-lg" />
        </div>

        <!-- Card 4 -->
        <div class="bg-gray-100 text-black p-3 rounded-lg relative aspect-square">
          <div class="w-2 h-2 bg-black rounded-full absolute top-2 left-2"></div>
          <img src="{{ asset('looplynks/images/slide4.png') }}" alt="Jury Member" class="w-full h-full object-cover rounded-lg" />
        </div>

      </div>

    </div>
    <!-- for mibile screen end -->

    <!-- <div class="relative z-10 max-w-5xl mx-auto flex flex-col gap-12 mt-[5rem] md:mt-[5rem] lg:mt-[13.75rem]">
      
      <blockquote id="testimonial-quote"
        class="text-2xl sm:text-3xl lg:text-5xl leading-snug font-light tracking-tight text-white">
        “Lorem ipsum dolor sit amet consectetur. Quam lorem diam sed id volutpat eget duis. Leo libero egestas aenean
        facilisi justo ultricies faucibus. Ullamcorper platea morbi feugiat et turpis. Vel tellus urna nisl ut odio
        duis.”
      </blockquote>
      
      <div class="flex flex-col sm:flex-row items-start sm:items-center gap-8">
        <div class="flex flex-col items-start gap-4 flex-1 min-w-0">
          <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0">
            <img id="testimonial-avatar" src="https://i.pravatar.cc/100?img=12" alt="Avatar"
              class="w-full h-full object-cover">
          </div>
          <div class="flex flex-col min-w-0">
            <div id="testimonial-name" class="text-2xl font-medium truncate text-white">John Doe</div>
            <div id="testimonial-role" class="text-sm text-gray-300">CEO, Tech Innovations</div>
          </div>
          
          <div class="flex gap-4 mt-4">
            <button id="testimonial-prev" aria-label="Previous"
              class="w-12 h-12 flex items-center justify-center rounded-full border-2 border-white text-white text-2xl hover:bg-white/10 transition">
              &lsaquo;
            </button>
            <button id="testimonial-next" aria-label="Next"
              class="w-12 h-12 flex items-center justify-center rounded-full border-2 border-white text-white text-2xl hover:bg-white/10 transition">
              &rsaquo;
            </button>
          </div>

        </div>
      </div>
    </div> -->
  </section>
  <script>
    const testimonials = [
      {
        quote: "“Lorem ipsum dolor sit amet consectetur. Quam lorem diam sed id volutpat eget duis. Leo odio duis Leo odio duisLeo odio duisLeo odio duisLeo odio duis.”",
        name: "John Doe",
        role: "CEO, Tech Innovations",
        avatar: "https://i.pravatar.cc/100?img=12"
      },
      {
        quote: "“Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium Leo odio duisLeo odio duisLeo odio duisLeo odio duis.”",
        name: "Jane Smith",
        role: "Founder, Creative Minds",
        avatar: "https://i.pravatar.cc/100?img=32"
      },
      {
        quote: "“At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium Leo odio duisLeo odio duisLeo odio duisLeo odio duisLeo odio duis.”",
        name: "Alex Lee",
        role: "Director, Future Labs",
        avatar: "https://i.pravatar.cc/100?img=45"
      }
    ];

    let current = 0;
    const quoteEl = document.getElementById('testimonial-quote');
    const nameEl = document.getElementById('testimonial-name');
    const roleEl = document.getElementById('testimonial-role');
    const avatarEl = document.getElementById('testimonial-avatar');
    const prevBtn = document.getElementById('testimonial-prev');
    const nextBtn = document.getElementById('testimonial-next');

    function showTestimonial(idx) {
      const t = testimonials[idx];
      quoteEl.textContent = t.quote;
      nameEl.textContent = t.name;
      roleEl.textContent = t.role;
      avatarEl.src = t.avatar;
    }

    prevBtn.onclick = function () {
      current = (current - 1 + testimonials.length) % testimonials.length;
      showTestimonial(current);
    };
    nextBtn.onclick = function () {
      current = (current + 1) % testimonials.length;
      showTestimonial(current);
    };

    showTestimonial(current);
  </script>

  <section class="bg-center bg-cover py-24 px-6 sm:px-8 lg:px-0 min-h-[700px] drop-shadow-lg"
    style="background-image: url('{{ asset('looplynks/images/Faq.png') }}');">
    <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-b from-[#01120c]/80 to-transparent"></div>

    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-[10rem]">
      <!-- Left: Heading -->
      <div>
        <span class="text-white text-lg mb-2 block">FAQ</span>
        <h2 class="text-5xl md:text-[72px] font-thunder font-normal gradient-text mb-6 leading-tight">
          Frequently<br>asked<br>questions.</h2>
        <p class="text-gray-300 text-base mb-4">Find quick answers to some of the most common<br> questions about
          LoopLynks. <a href="#" class="text-blue-400 underline">Contact Us?</a></p>
      </div>
      <!-- Right: FAQ List -->
      <div>
        <div id="faq-list" class="space-y-6">
          <!-- FAQ Item 1 -->
          <div class="pb-2">
            <button class="w-full flex justify-between items-center text-left group" data-faq>
              <span class="text-lg font-medium text-white">What Is LoopLynks?</span>
              <span class="text-2xl text-white transition-all duration-300">+</span>
            </button>
            <div class="mt-2 text-gray-300 text-base overflow-hidden transition-all duration-500 ease-in-out max-h-0"
              data-faq-content>
              <div class="border-b border-white/30 pb-2 pt-2">
                LoopLynks is a global recognition initiative that celebrates innovation, leadership, and meaningful
                accomplishments through prestigious awards and curated, invite-only events.
              </div>
            </div>
          </div>
          <!-- FAQ Item 2 -->
          <div class="pb-2">
            <button class="w-full flex justify-between items-center text-left group" data-faq>
              <span class="text-lg font-medium text-white"> Who Is Eligible To Participate?</span>
              <span class="text-2xl text-white transition-all duration-300">+</span>
            </button>
            <div class="mt-2 text-gray-300 text-base overflow-hidden transition-all duration-500 ease-in-out max-h-0"
              data-faq-content>
              <div class="border-b border-white/30 pb-2 pt-2">
                Individuals, teams, and organizations driving impactful change in fields such as business, technology,
                sustainability, and social innovation are eligible for nomination or application.
              </div>
            </div>
          </div>
          <!-- FAQ Item 3 -->
          <div class="pb-2">
            <button class="w-full flex justify-between items-center text-left group" data-faq>
              <span class="text-lg font-medium text-white">Do I Have To Pay Any Participation Fee?</span>
              <span class="text-2xl text-white transition-all duration-300">+</span>
            </button>
            <div class="mt-2 text-gray-300 text-base overflow-hidden transition-all duration-500 ease-in-out max-h-0"
              data-faq-content>
              <div class="border-b border-white/30 pb-2 pt-2">
                Yes, there is a fee of USD 99 per category.
              </div>
            </div>
          </div>
          <!-- FAQ Item 4 -->
          <div class="pb-2">
            <button class="w-full flex justify-between items-center text-left group" data-faq>
              <span class="text-lg font-medium text-white">How Will Winners Be Notified?</span>
              <span class="text-2xl text-white transition-all duration-300">+</span>
            </button>
            <div class="mt-2 text-gray-300 text-base overflow-hidden transition-all duration-500 ease-in-out max-h-0"
              data-faq-content>
              <div class="border-b border-white/30 pb-2 pt-2">
                The LoopLynks team will notify winners personally, with a public announcement made ahead of the event.
              </div>
            </div>
          </div>
          <!-- FAQ Item 5 -->
          <div class="pb-2">
            <button class="w-full flex justify-between items-center text-left group" data-faq>
              <span class="text-lg font-medium text-white">How can I Connect With The LoopLynks team?</span>
              <span class="text-2xl text-white transition-all duration-300">+</span>
            </button>
            <div class="mt-2 text-gray-300 text-base overflow-hidden transition-all duration-500 ease-in-out max-h-0"
              data-faq-content>
              <div class="border-b border-white/30 pb-2 pt-2">
                Feel free to get in touch via the contact form on our website. Our team will respond promptly to assist
                you.

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Decorative frame -->
    <div class="relative w-full mt-2 hidden lg:block">
      <img src="{{ asset('looplynks/images/Golden frame.png') }}" alt="Decorative wave" class="block w-full h-auto object-contain" />
    </div>

  </section>

@endsection

@section('scripts')
<script>
  document.querySelectorAll('[data-faq]').forEach(btn => {
    btn.addEventListener('click', function () {
      const content = this.parentElement.querySelector('[data-faq-content]');
      const plusMinus = this.querySelector('span:last-child');

      // Toggle the current item
      if (content.style.maxHeight) {
        // Close
        content.style.maxHeight = null;
        plusMinus.textContent = '+';
      } else {
        // Open
        content.style.maxHeight = content.scrollHeight + 'px';
        plusMinus.textContent = '-';

        // Close others (optional - remove if you want multiple open)
        document.querySelectorAll('[data-faq-content]').forEach(otherContent => {
          if (otherContent !== content && otherContent.style.maxHeight) {
            otherContent.style.maxHeight = null;
            otherContent.previousElementSibling.querySelector('span:last-child').textContent = '+';
          }
        });
      }
    });
  });
</script>
@endsection