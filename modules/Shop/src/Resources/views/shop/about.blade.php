@extends('shop::layouts.app')

@section('hero-section')
<!-- About Hero Section -->
<section class="relative w-full flex flex-col items-center justify-center text-center hidden lg:flex hero-section">
  <div class="bg-black min-h-[50vh] w-full flex items-center justify-center">
    <h1 class="text-[7vw] md:text-[6vw] lg:text-[120px] font-bold mb-1 mt-[6.5rem]"
      style="font-family: 'Thunder'; font-weight: 500; font-style: normal; letter-spacing: 1%; line-height: 100%;">
      <span class="gradient-text"> ABOUT US </span>
    </h1>
  </div>
</section>

<!-- Mobile About Hero -->
<section class="relative w-full flex flex-col items-start justify-center text-left px-6 md:px-16 overflow-hidden lg:hidden pt-0 -mt-[10px] mobile-section">
  <div class="bg-black min-h-[50vh] w-full flex items-center justify-start">
    <h1 class="text-[13vw] md:text-[7vw] lg:text-[160px] font-bold leading-tight mb-0">
      <span class="gradient-text block" style="font-family: 'Thunder';"> ABOUT US </span>
    </h1>
  </div>
</section>
@endsection

@section('content')

<!-- Main Content Section -->
<main class="min-h-screen bg-black relative overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-100"></div>

    <div class="relative z-10 flex flex-col justify-left items-left min-h-screen px-6 py-20 mb-16">
        <div class="text-left">
            <h1
                class="text-5xl md:text-7xl md:pl-[158px] lg:text-8xl gradient-text font-vegawanty font-normal mb-8 py-2 tracking-wide">
                A Gateway To
            </h1>
        </div>

        <div class="max-w-4xl mx-auto text-left mt-[158px] pt-[30px] pb-[60px] bg-center bg-cover"
            style="background-image: url('{{ asset('looplynks/images/about/about banner.jpg') }}')">
            <p
                class="text-white text-base md:text-xl lg:text-xl leading-relaxed font-lato font-normal tracking-wide">
                LoopLynks is a next-generation recognition brand rooted in the idea that
                leadership is a living loop, not a linear finish line. Born out of a desire to honour
                those who make meaningful contributions, we celebrate symbolic awards as
                emblems of journeys that go beyond success – stories of vision, grit, and timeless
                impact. They embody influence, integrity, and innovation.
            </p>
        </div>

        <div class="text-left mt-[50px]">
            <h2
                class="text-5xl md:text-7xl lg:text-8xl md:pl-[300px] gradient-text font-vegawanty font-normal tracking-wide mt-16 py-2">
                LoopLynks Award Show
            </h2>
        </div>
    </div>

    <div
        class="absolute top-1/2 left-0 w-1 h-32 bg-gradient-to-b from-transparent via-yellow-400 to-transparent opacity-20">
    </div>
    <div
        class="absolute top-1/2 right-0 w-1 h-32 bg-gradient-to-b   from-transparent via-yellow-400 to-transparent opacity-20">
    </div>
</main>

    <section class="relative w-full min-h-screen flex items-center justify-center overflow-hidden bg-center bg-cover"
        style="background-image: url('{{ asset('looplynks/images/about/about banner.jpg') }}')">
        <!-- Background Waves -->


        <!-- Content -->
        <div class="relative z-10 max-w-4xl px-6 text-left">
            <!-- Heading -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-serif font-bold 
               bg-gradient-to-r from-yellow-400 to-orange-600 bg-clip-text text-transparent">
                Welcome to Loop Lynks
            </h1>

            <!-- Paragraph -->
            <p class="mt-6 text-base sm:text-lg md:text-xl text-gray-200 leading-relaxed">
                Loop Lynks is a next-generation recognition brand rooted in the idea that leadership
                is a living loop, not a linear finish line. Born out of a desire to honor those who
                make meaningful contributions, we celebrate symbolic awards as emblems of journeys
                that go beyond success – stories of vision, grit, and timeless impact. They embody
                influence, integrity, and innovation.
            </p>
        </div>
    </section>


    <section class="bg-center bg-cover text-white min-h-screen flex flex-col justify-center px-6"
        style="background-image: url('{{ asset('looplynks/images/about/mision.jpg') }}')">

        <div class="w-full mx-auto grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">

            <!-- Column 1 - Heading -->
            <div class="mb-16">
                <h2 id="tab-title"
                    class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-vegawanty font-normal text-yellow-400 leading-tight transition-opacity duration-500 text-right md:mt-[-33px]">
                    Mission
                </h2>


            </div>

            <!-- Column 2 - Line + Paragraph -->
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-3 h-3 rounded-full border-2 border-yellow-400"></div>
                    <div class="flex-1 border-t border-gray-500"></div>
                </div>
                <p id="tab-text" class="text-gray-300 leading-relaxed text-lg transition-opacity duration-500">
                    Loop Lynks is a next-generation recognition brand rooted in the idea that leadership is a living
                    loop, not a linear finish line. Born out of a desire to honor those who make meaningful
                    contributions, we celebrate symbolic awards as emblems of journeys that go beyond success –
                    stories of vision, grit, and timeless impact. They embody influence, integrity, and innovation.
                </p>
            </div>

            <!-- Column 3 - Image -->
            <div>
                <img id="tab-image" src="{{ asset('looplynks/images/slide1.png') }}" alt="Mission"
                    class="w-[342px] h-[396px] object-cover rounded-md transition-opacity duration-500 md:mt-[-175px]">
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex justify-center gap-6 mt-[120px] text-lg">
            <button class="tab-btn text-yellow-400 font-semibold" data-index="0">Mission</button>
            <button class="tab-btn hover:text-yellow-400" data-index="1">Vision</button>
            <button class="tab-btn hover:text-yellow-400" data-index="2">Values</button>
        </div>
    </section>
    <script>
        // Smooth update with fade
        function updateTab(index) {
            currentIndex = index;

            // fade out
            titleEl.classList.add("opacity-0");
            textEl.classList.add("opacity-0");
            imageEl.classList.add("opacity-0");

            setTimeout(() => {
                // change content
                titleEl.textContent = tabs[index].title;
                textEl.textContent = tabs[index].text;
                imageEl.src = tabs[index].image;
                imageEl.alt = tabs[index].title;

                // fade in
                titleEl.classList.remove("opacity-0");
                textEl.classList.remove("opacity-0");
                imageEl.classList.remove("opacity-0");
            }, 300);

            // tab highlight
            buttons.forEach((btn, i) => {
                btn.classList.toggle("text-yellow-400", i === index);
                btn.classList.toggle("font-semibold", i === index);
            });
        }

        // Tab click
        buttons.forEach((btn, i) => {
            btn.addEventListener("click", () => updateTab(i));
        });

        // Mouse scroll
        window.addEventListener("wheel", (e) => {
            if (e.deltaY > 0) {
                currentIndex = (currentIndex + 1) % tabs.length;
            } else {
                currentIndex = (currentIndex - 1 + tabs.length) % tabs.length;
            }
            updateTab(currentIndex);
        });
    </script>



    <section class="bg-black text-white px-6 md:px-12 lg:px-24 py-16 w-full min-h-screen">
        <!-- Header Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            <!-- Left: Heading -->
            <h2 class="text-4xl md:text-5xl font-vegawanty font-normal text-yellow-400">
                Our Team
            </h2>

            <!-- Right: Content -->
            <p class="text-gray-300 text-sm md:text-base leading-relaxed max-w-xl">
                Lorem ipsum dolor sit amet consectetur. Augue et tincidunt sapien ut egestas eu leo volutpat.
                Odio arcu ipsum ipsum maecenas blandit porttitor phasellus molestie.
            </p>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 bg-center bg-contain bg-no-repeat"
            style="background-image: url('{{ asset('looplynks/images/team.png') }}')">

            <!-- CARD 1 -->
            <div
                class="relative rounded-[32px] p-[1px] bg-gradient-to-b from-[#222] via-[#111] to-[#000] transition-transform duration-300 hover:scale-105 hover:shadow-xl hover:shadow-green-200/10">
                <div class="bg-black rounded-[32px] h-[380px] flex flex-col justify-end relative overflow-hidden cursor-pointer">
                    <img src="{{ asset('looplynks/images/card1.jpg') }}" alt="Team Member"
                        class="absolute inset-0 w-full h-full object-cover rounded-[32px] transition-transform duration-500 hover:scale-110" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent rounded-[32px]">
                    </div>
                    <div class="relative z-10 p-6">
                        <h3 class="text-white font-semibold">John Doe</h3>
                        <p class="text-gray-400 text-sm">CEO</p>
                    </div>
                </div>
            </div>

            <!-- CARD 2 -->
            <div
                class="relative rounded-[32px] p-[1px] bg-gradient-to-b from-[#222] via-[#111] to-[#000] transition-transform duration-300 hover:scale-105 hover:shadow-xl hover:shadow-green-200/10">
                <div class="bg-black rounded-[32px] h-[380px] flex flex-col justify-end relative overflow-hidden cursor-pointer">
                    <img src="{{ asset('looplynks/images/card1.jpg') }}" alt="Team Member"
                        class="absolute inset-0 w-full h-full object-cover rounded-[32px] transition-transform duration-500 hover:scale-110" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent rounded-[32px]">
                    </div>
                    <div class="relative z-10 p-6">
                        <h3 class="text-white font-semibold">Jane Smith</h3>
                        <p class="text-gray-400 text-sm">CTO</p>
                    </div>
                </div>
            </div>

            <!-- CARD 3 -->
            <div
                class="relative rounded-[32px] p-[1px] bg-gradient-to-b from-[#222] via-[#111] to-[#000] transition-transform duration-300 hover:scale-105 hover:shadow-xl hover:shadow-green-200/10">
                <div class="bg-black rounded-[32px] h-[380px] flex flex-col justify-end relative overflow-hidden cursor-pointer">
                    <img src="{{ asset('looplynks/images/card1.jpg') }}" alt="Team Member"
                        class="absolute inset-0 w-full h-full object-cover rounded-[32px] transition-transform duration-500 hover:scale-110" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent rounded-[32px]">
                    </div>
                    <div class="relative z-10 p-6">
                        <h3 class="text-white font-semibold">Michael Lee</h3>
                        <p class="text-gray-400 text-sm">Designer</p>
                    </div>
                </div>
            </div>

            <!-- CARD 4 -->
            <div
                class="relative rounded-[32px] p-[1px] bg-gradient-to-b from-[#222] via-[#111] to-[#000] transition-transform duration-300 hover:scale-105 hover:shadow-xl hover:shadow-green-200/10">
                <div class="bg-black rounded-[32px] h-[380px] flex flex-col justify-end relative overflow-hidden cursor-pointer">
                    <img src="{{ asset('looplynks/images/card1.jpg') }}" alt="Team Member"
                        class="absolute inset-0 w-full h-full object-cover rounded-[32px] transition-transform duration-500 hover:scale-110" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent rounded-[32px]">
                    </div>
                    <div class="relative z-10 p-6">
                        <h3 class="text-white font-semibold">Emily Davis</h3>
                        <p class="text-gray-400 text-sm">Developer</p>
                    </div>
                </div>
            </div>

            <!-- CARD 5 -->
            <div
                class="relative rounded-[32px] p-[1px] bg-gradient-to-b from-[#222] via-[#111] to-[#000] transition-transform duration-300 hover:scale-105 hover:shadow-xl hover:shadow-green-200/10">
                <div class="bg-black rounded-[32px] h-[380px] flex flex-col justify-end relative overflow-hidden cursor-pointer">
                    <img src="{{ asset('looplynks/images/card1.jpg') }}" alt="Team Member"
                        class="absolute inset-0 w-full h-full object-cover rounded-[32px] transition-transform duration-500 hover:scale-110" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent rounded-[32px]">
                    </div>
                    <div class="relative z-10 p-6">
                        <h3 class="text-white font-semibold">Chris Brown</h3>
                        <p class="text-gray-400 text-sm">Marketing</p>
                    </div>
                </div>
            </div>

            <!-- CARD 6 -->
            <div
                class="relative rounded-[32px] p-[1px] bg-gradient-to-b from-[#222] via-[#111] to-[#000] transition-transform duration-300 hover:scale-105 hover:shadow-xl hover:shadow-green-200/10">
                <div class="bg-black rounded-[32px] h-[380px] flex flex-col justify-end relative overflow-hidden cursor-pointer">
                    <img src="{{ asset('looplynks/images/card1.jpg') }}" alt="Team Member"
                        class="absolute inset-0 w-full h-full object-cover rounded-[32px] transition-transform duration-500 hover:scale-110" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent rounded-[32px]">
                    </div>
                    <div class="relative z-10 p-6">
                        <h3 class="text-white font-semibold">Sophia Wilson</h3>
                        <p class="text-gray-400 text-sm">Project Manager</p>
                    </div>
                </div>
            </div>

            <!-- CARD 7 -->
            <div
                class="relative rounded-[32px] p-[1px] bg-gradient-to-b from-[#222] via-[#111] to-[#000] transition-transform duration-300 hover:scale-105 hover:shadow-xl hover:shadow-green-200/10">
                <div class="bg-black rounded-[32px] h-[380px] flex flex-col justify-end relative overflow-hidden cursor-pointer">
                    <img src="{{ asset('looplynks/images/card1.jpg') }}" alt="Team Member"
                        class="absolute inset-0 w-full h-full object-cover rounded-[32px] transition-transform duration-500 hover:scale-110" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent rounded-[32px]">
                    </div>
                    <div class="relative z-10 p-6">
                        <h3 class="text-white font-semibold">Daniel Clark</h3>
                        <p class="text-gray-400 text-sm">HR</p>
                    </div>
                </div>
            </div>

            <!-- CARD 8 -->
            <div
                class="relative rounded-[32px] p-[1px] bg-gradient-to-b from-[#222] via-[#111] to-[#000] transition-transform duration-300 hover:scale-105 hover:shadow-xl hover:shadow-green-200/10">
                <div class="bg-black rounded-[32px] h-[380px] flex flex-col justify-end relative overflow-hidden cursor-pointer">
                    <img src="{{ asset('looplynks/images/card1.jpg') }}" alt="Team Member"
                        class="absolute inset-0 w-full h-full object-cover rounded-[32px] transition-transform duration-500 hover:scale-110" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent rounded-[32px]">
                    </div>
                    <div class="relative z-10 p-6">
                        <h3 class="text-white font-semibold">Olivia Johnson</h3>
                        <p class="text-gray-400 text-sm">Finance</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="bg-center bg-cover py-24 px-6 sm:px-8 lg:px-0 min-h-[700px] drop-shadow-lg"
        style="background-image: url({{ asset('looplynks/images/Faq.png') }});">
        <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-b from-[#01120c]/80 to-transparent"></div>

        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-[10rem]">
            <!-- Left: Heading -->
            <div>
                <span class="text-white text-lg mb-2 block">FAQ</span>
                <h2 class="text-5xl md:text-[72px] font-thunder font-normal gradient-text mb-6 leading-tight">
                    Frequently<br>asked<br>questions.</h2>
                <p class="text-gray-300 text-base mb-4">Find quick answers to some of the most common<br> questions
                    about
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
                                LoopLynks is a global recognition initiative that celebrates innovation, leadership, and
                                meaningful
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
                                Individuals, teams, and organizations driving impactful change in fields such as
                                business, technology,
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
                                The LoopLynks team will notify winners personally, with a public announcement made ahead
                                of the event.
                            </div>
                        </div>
                    </div>
                    <!-- FAQ Item 5 -->
                    <div class="pb-2">
                        <button class="w-full flex justify-between items-center text-left group" data-faq>
                            <span class="text-lg font-medium text-white">How can I Connect With The LoopLynks
                                team?</span>
                            <span class="text-2xl text-white transition-all duration-300">+</span>
                        </button>
                        <div class="mt-2 text-gray-300 text-base overflow-hidden transition-all duration-500 ease-in-out max-h-0"
                            data-faq-content>
                            <div class="border-b border-white/30 pb-2 pt-2">
                                Feel free to get in touch via the contact form on our website. Our team will respond
                                promptly to assist
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

    // Tab functionality scripts
    const tabs = [
        {
            title: "Mission",
            text: "Loop Lynks is a next-generation recognition brand rooted in the idea that leadership is a living loop, not a linear finish line. Born out of a desire to honor those who make meaningful contributions, we celebrate symbolic awards as emblems of journeys that go beyond success – stories of vision, grit, and timeless impact. They embody influence, integrity, and innovation.",
            image: "{{ asset('looplynks/images/slide1.png') }}"
        },
        {
            title: "Vision",
            text: "Loop Lynks is a next-generation recognition brand rooted in the idea that leadership is a living loop, not a linear finish line. Born out of a desire to honor those who make meaningful contributions, we celebrate symbolic awards as emblems of journeys that go beyond success – stories of vision, grit, and timeless impact. They embody influence, integrity, and innovation.",
            image: "{{ asset('looplynks/images/slide2.png') }}"
        },
        {
            title: "Values",
            text: "Loop Lynks is a next-generation recognition brand rooted in the idea that leadership is a living loop, not a linear finish line. Born out of a desire to honor those who make meaningful contributions, we celebrate symbolic awards as emblems of journeys that go beyond success – stories of vision, grit, and timeless impact. They embody influence, integrity, and innovation.",
            image: "{{ asset('looplynks/images/slide3.png') }}"
        }
    ];

    let currentIndex = 0;
    const titleEl = document.getElementById("tab-title");
    const textEl = document.getElementById("tab-text");
    const imageEl = document.getElementById("tab-image");
    const buttons = document.querySelectorAll(".tab-btn");

    // Smooth update with fade
    function updateTab(index) {
        currentIndex = index;

        // fade out
        titleEl.classList.add("opacity-0");
        textEl.classList.add("opacity-0");
        imageEl.classList.add("opacity-0");

        setTimeout(() => {
            // change content
            titleEl.textContent = tabs[index].title;
            textEl.textContent = tabs[index].text;
            imageEl.src = tabs[index].image;
            imageEl.alt = tabs[index].title;

            // fade in
            titleEl.classList.remove("opacity-0");
            textEl.classList.remove("opacity-0");
            imageEl.classList.remove("opacity-0");
        }, 300);

        // tab highlight
        buttons.forEach((btn, i) => {
            btn.classList.toggle("text-yellow-400", i === index);
            btn.classList.toggle("font-semibold", i === index);
        });
    }

    // Tab click
    buttons.forEach((btn, i) => {
        btn.addEventListener("click", () => updateTab(i));
    });

    // Mouse scroll
    window.addEventListener("wheel", (e) => {
        if (e.deltaY > 0) {
            currentIndex = (currentIndex + 1) % tabs.length;
        } else {
            currentIndex = (currentIndex - 1 + tabs.length) % tabs.length;
        }
        updateTab(currentIndex);
    });
</script>
@endsection

    <!-- footer start -->
   

    <!-- for mobile device -->

    <!-- Mobile Menu (Visible only on mobile) -->
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
                <a href="#" class="block hover:text-[#D4AF37] transition">Home</a>
                <a href="#" class="block hover:text-[#D4AF37] transition">About us</a>
                <a href="#" class="block hover:text-[#D4AF37] transition">Award Categories</a>
                <a href="#" class="block hover:text-[#D4AF37] transition">Jury</a>
                <a href="#" class="block hover:text-[#D4AF37] transition">Agenda</a>
                <a href="#" class="block hover:text-[#D4AF37] transition">Why Georgia?</a>
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

</body>

</html>