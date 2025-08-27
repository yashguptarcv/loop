
@extends('shop::layouts.app')

@section('content')
    <!-- Main Content Section -->
    <section id="georgiaSection"
        class="relative bg-black px-4 py-20 md:px-[120px] md:py-[120px] hidden md:block bg-center bg-cover position-sticky">
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
    </section>

    <!-- for mibile screen -->
    <section
        class="relative w-full h-full flex flex-col justify-between items-center px-6 overflow-hidden bg-center bg-cover block md:hidden"
        style="background-image: url({{ asset('looplynks/images/why%20georgia_bg_gradient.png') }});">

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

    <section class="w-full py-16 md:px-[100px] bg-cover bg-center"
        style="background-image: url({{ asset('looplynks/images/destination\ bg.jpg') }});">
        <div class="max-w-[1300px] mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- Card -->
            <div class="bg-[#1A1A1A] rounded-2xl border border-white/10 shadow-lg shadow-gray-800/50 
                p-5 hover:shadow-xl hover:shadow-green-200/10 transition duration-300 w-[417px] h-[475px] mx-auto">
                <!-- Image Placeholder -->
                <div class="w-full h-72 rounded-md mb-4 overflow-hidden">
                    <img src="{{ asset('looplynks/images/card1.jpg') }}" alt="Strategic Location" class="w-full h-full object-cover" />
                </div>
                <!-- Title -->

                <a href="#" class="block">
                    <h3 class="text-yellow-500 font-semibold text-lg mb-2 hover:text-white transition-colors">
                        Strategic Location
                    </h3>
                </a>
                <!-- Description -->
                <p class="text-gray-300 text-base leading-relaxed">
                    Nestled at the intersection of Europe and Asia, Georgia offers easy access for
                    international attendees, making it an ideal hub for global gatherings.
                </p>
            </div>

            <!-- Copy same card for more items -->
            <div class="bg-[#1A1A1A] rounded-2xl border border-white/10 shadow-lg shadow-gray-800/50 
                p-5 hover:shadow-xl hover:shadow-green-200/10 transition duration-300 w-[417px] h-[475px] mx-auto">
                <div class="w-full h-72 rounded-md mb-4 overflow-hidden">
                    <img src="{{ asset('looplynks/images/card1.jpg') }}" alt="Strategic Location" class="w-full h-full object-cover" />
                </div>

                <a href="#" class="block">
                    <h3 class="text-yellow-500 font-semibold text-lg mb-2 hover:text-white transition-colors">
                        Rich Cultural Tapestry
                    </h3>
                </a>
                <p class="text-gray-300 text-base leading-relaxed">
                    With ancient traditions, warm hospitality, and urban contemporary energy, Georgia provides
                    an unforgettable cultural backdrop for any event.
                </p>
            </div>

            <div class="bg-[#1A1A1A] rounded-2xl border border-white/10 shadow-lg shadow-gray-800/50 
                p-5 hover:shadow-xl hover:shadow-green-200/10 transition duration-300 w-[417px] h-[475px] mx-auto">
                <div class="w-full h-72 rounded-md mb-4 overflow-hidden">
                    <img src="{{ asset('looplynks/images/card1.jpg') }}" alt="Strategic Location" class="w-full h-full object-cover" />
                </div>
                <a href="#" class="block">
                    <h3 class="text-yellow-500 font-semibold text-lg mb-2 hover:text-white transition-colors">
                        Stunning Venues
                    </h3>
                </a>
                <p class="text-gray-300 text-base leading-relaxed">
                    From historic castles to sleek modern auditoriums, Georgia offers a wide variety of venues
                    that elevate every experience – whether intimate or grand.
                </p>
            </div>

            <div class="bg-[#1A1A1A] rounded-2xl border border-white/10 shadow-lg shadow-gray-800/50 
                p-5 hover:shadow-xl hover:shadow-green-200/10 transition duration-300 w-[417px] h-[475px] mx-auto">
                <div class="w-full h-72 rounded-md mb-4 overflow-hidden">
                    <img src="{{ asset('looplynks/images/card1.jpg') }}" alt="Strategic Location" class="w-full h-full object-cover" />
                </div>
                <a href="#" class="block">
                    <h3 class="text-yellow-500 font-semibold text-lg mb-2 hover:text-white transition-colors">
                        Affordable Excellence
                    </h3>
                </a>
                <p class="text-gray-300 text-base leading-relaxed">
                    Georgia delivers exceptional value. World-class facilities, accommodations, and services
                    come at a fraction of the cost compared to other international locations.
                </p>
            </div>

            <div class="bg-[#1A1A1A] rounded-2xl border border-white/10 shadow-lg shadow-gray-800/50 
                p-5 hover:shadow-xl hover:shadow-green-200/10 transition duration-300 w-[417px] h-[475px] mx-auto">
                <div class="w-full h-72 rounded-md mb-4 overflow-hidden">
                    <img src="{{ asset('looplynks/images/card1.jpg') }}" alt="Strategic Location" class="w-full h-full object-cover" />
                </div>

                <a href="#" class="block">
                    <h3 class="text-yellow-500 font-semibold text-lg mb-2 hover:text-white transition-colors">
                        Growing Global Reputation
                    </h3>
                </a>
                <p class="text-gray-300 text-base leading-relaxed">
                    Georgia has rapidly become one of the most attractive emerging destinations for
                    international conferences, festivals, and high-profile events.
                </p>
            </div>

            <div class="bg-[#1A1A1A] rounded-2xl border border-white/10 shadow-lg shadow-gray-800/50 
                p-5 hover:shadow-xl hover:shadow-green-200/10 transition duration-300 w-[417px] h-[475px] mx-auto">
                <div class="w-full h-72 rounded-md mb-4 overflow-hidden">
                    <img src="{{ asset('looplynks/images/card1.jpg') }}" alt="Strategic Location" class="w-full h-full object-cover" />
                </div>

                <a href="#" class="block">
                    <h3 class="text-yellow-500 font-semibold text-lg mb-2 hover:text-white transition-colors">
                        Safety & Accessibility
                    </h3>
                </a>

                <p class="text-gray-300 text-base leading-relaxed">
                    A welcoming visa policy, efficient transport infrastructure, and a reputation for safety
                    make Georgia both convenient and comforting for guests.
                </p>
            </div>

        </div>
    </section>

    <section class="bg-black py-16 px-24">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Industry Dropdown -->
            <div class="relative">
                <select class="w-full bg-[#1A1A1A] text-gray-200 px-4 py-3 pr-10 rounded-full
               border border-white/10 shadow-lg shadow-gray-800/40
               focus:outline-none focus:ring-2 focus:ring-yellow-500 appearance-none">
                    <option class="bg-[#1A1A1A] text-gray-200">Industry</option>
                    <option class="bg-[#1A1A1A] text-gray-200">Tech</option>
                    <option class="bg-[#1A1A1A] text-gray-200">Finance</option>
                    <option class="bg-[#1A1A1A] text-gray-200">Health</option>
                </select>
                <!-- Custom Arrow -->
                <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-gray-400">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <!-- Category Dropdown -->
            <div class="relative">
                <select class="w-full bg-[#1A1A1A] text-gray-200 px-4 py-3 pr-10 rounded-full
               border border-white/10 shadow-lg shadow-gray-800/40
               focus:outline-none focus:ring-2 focus:ring-yellow-500 appearance-none">
                    <option class="bg-[#1A1A1A] text-gray-200">Category</option>
                    <option class="bg-[#1A1A1A] text-gray-200">Business</option>
                    <option class="bg-[#1A1A1A] text-gray-200">Education</option>
                    <option class="bg-[#1A1A1A] text-gray-200">Entertainment</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-gray-400">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <!-- Number of Categories Dropdown -->
            <div class="relative">
                <select class="w-full bg-[#1A1A1A] text-gray-200 px-4 py-3 pr-10 rounded-full
               border border-white/10 shadow-lg shadow-gray-800/40
               focus:outline-none focus:ring-2 focus:ring-yellow-500 appearance-none">
                    <option class="bg-[#1A1A1A] text-gray-200">No. of Categories</option>
                    <option class="bg-[#1A1A1A] text-gray-200">1</option>
                    <option class="bg-[#1A1A1A] text-gray-200">2</option>
                    <option class="bg-[#1A1A1A] text-gray-200">3</option>
                    <option class="bg-[#1A1A1A] text-gray-200">4+</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-gray-400">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

        </div>
    </section>


    <section class="flex items-center justify-center min-h-screen px-6 py-12 bg-center bg-cover"
        style="background-image: url('{{ asset('looplynks/images/HeroSection.png') }}');">
        <div class="flex flex-col lg:flex-row items-center justify-center w-full max-w-8xl gap-2">

            <!-- Form Section -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-xl w-full max-w-3xl">

                <!-- Personal Details -->
                <h2
                    class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-5xl font-thunder font-bold text-yellow-500 mb-6">
                    Personal Details
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Full Name -->
                    <div class="relative">
                        <input type="text" placeholder="Full Name" class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-12 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 
             focus:outline-none focus:ring-1 focus:ring-white placeholder-gray-400">
                        <!-- Icon Right -->
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <!-- User Icon -->
                            <!-- User Icon (recommended) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A9 9 0 0112 15a9 9 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>

                        </span>
                    </div>

                    <!-- Email -->
                    <div class="relative">
                        <input type="email" placeholder="Email" class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-12 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 
             focus:outline-none focus:ring-1 focus:ring-white placeholder-gray-400">
                        <!-- Icon Right -->
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <!-- Envelope Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8z" />
                            </svg>
                        </span>
                    </div>

                    <!-- Contact Number -->
                    <div class="relative">
                        <input type="text" placeholder="Contact Number" class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-12 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 
             focus:outline-none focus:ring-1 focus:ring-white placeholder-gray-400">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <!-- Phone Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h1.28a1 1 0 01.95.684l1.22 3.66a1 1 0 01-.272 1.09l-1.4 1.4a11.042 11.042 0 005.657 5.657l1.4-1.4a1 1 0 011.09-.272l3.66 1.22a1 1 0 01.684.95V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </span>
                    </div>

                    <!-- Alternate Email -->
                    <div class="relative">
                        <input type="email" placeholder="Alternate Email" class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-12 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 
             focus:outline-none focus:ring-1 focus:ring-white placeholder-gray-400">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <!-- Envelope Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8z" />
                            </svg>
                        </span>
                    </div>

                    <!-- Designation -->
                    <div class="relative">
                        <input type="text" placeholder="Designation" class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-12 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 
             focus:outline-none focus:ring-1 focus:ring-white placeholder-gray-400">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <!-- Briefcase Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11c.667 0 1 .333 1 1v6c0 .667-.333 1-1 1H4c-.667 0-1-.333-1-1V12c0-.667.333-1 1-1h8zm6 0c.667 0 1 .333 1 1v6c0 .667-.333 1-1 1h-2c-.667 0-1-.333-1-1v-6c0-.667.333-1 1-1h2z" />
                            </svg>
                        </span>
                    </div>

                    <!-- Company -->
                    <div class="relative">
                        <input type="text" placeholder="Company" class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-12 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 
             focus:outline-none focus:ring-1 focus:ring-white placeholder-gray-400">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <!-- Building Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 21h16M4 10h16M10 6h4m-7 4v11m10-11v11" />
                            </svg>
                        </span>
                    </div>

                </div>


                <!-- Award Category -->
                <h2
                    class="text-3xl sm:text-3xl md:text-4xl lg:text-4xl xl:text-5xl font-thunder font-bold text-yellow-500 mt-10 mb-6">
                    Award Category
                </h2>

                <div class="flex items-center justify-between w-full max-w-[56rem] mb-6">
                    <p class="text-gray-300 text-base">How many categories would you like to nominate?</p>
                    <div class="relative w-1/2">
                        <select
                            class="w-full bg-[#1A1A1A] text-gray-200 px-4 py-3 pr-10 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 focus:outline-none focus:ring-1 focus:ring-white appearance-none">
                            <option>No. of Categories</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                        <div
                            class="pointer-events-none absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- 1st Award Category -->
                <h3 class="text-white font-thunder font-bold mt-6 mb-2">1st Award Category</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" placeholder="Country"
                        class="w-full bg-[#222] text-gray-200 px-4 py-3 rounded-full border border-white/10 focus:outline-none focus:ring-1 focus:ring-white placeholder-gray-400">
                    <div class="relative w-full">
                        <select
                            class="w-full bg-[#222] text-gray-200 px-4 py-3 pr-10 rounded-full border border-white/10 focus:outline-none focus:ring-1 focus:ring-white appearance-none">
                            <option>Industry</option>
                            <option>Tech</option>
                            <option>Finance</option>
                            <option>Health</option>
                        </select>
                        <div
                            class="pointer-events-none absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <div class="relative w-full md:col-span-2">
                        <select
                            class="w-full bg-[#222] text-gray-200 px-4 py-3 pr-10 rounded-full border border-white/10 focus:outline-none focus:ring-1 focus:ring-white appearance-none">
                            <option>Category</option>
                            <option>Startup</option>
                            <option>Enterprise</option>
                        </select>
                        <div
                            class="pointer-events-none absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <p class="text-white mt-6">Total: <span class="text-yellow-500 font-semibold">$99</span></p>

                <!-- Terms -->
                <div class="flex items-center mt-4">
                    <input type="checkbox" id="terms" class="mr-2">
                    <label for="terms" class="text-sm text-gray-300">I accept the <span
                            class="text-yellow-500 cursor-pointer">TERMS AND CONDITIONS</span></label>
                </div>

                <!-- Submit -->
                <button
                    class="w-full bg-white text-black font-semibold py-3 mt-6 rounded-full hover:bg-yellow-500 hover:text-white transition">
                    SUBMIT
                </button>
            </div>

            <!-- Trophy Image -->
            <!-- Trophy Image -->
            <div class="flex items-end justify-center lg:justify-end w-full lg:w-auto">
                <img src="{{ asset('looplynks/images/trophy.png') }}" alt="Dummy Trophy"
                    class="w-[350px] md:w-[400px] lg:w-[450px] drop-shadow-2xl object-contain" />
            </div>

        </div>
    </section>


    <!-- FAQ Section -->
    <section class="bg-center bg-cover py-24 px-6 sm:px-8 lg:px-0 w-full [700px] drop-shadow-lg"
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


    <!-- Sticky Header (hidden by default, shows on scroll) -->
    <header id="sticky-header"
        class="fixed top-0 left-1/2 -translate-x-1/2 w-full flex justify-center items-center z-50 bg-transparent bg-opacity-100 hidden transition-all duration-300">
        <div class="flex justify-center items-center px-6 py-1">
            <div
                class="flex items-center space-x-0 bg-black bg-opacity-30 backdrop-blur-md rounded-lg shadow-lg p-6 pr-[100px] w-full max-w-6xl">
                <a href="#" class="flex-shrink-0 w-full h-1/4">
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
                <a href="index.html">
                    <img src="{{ asset('looplynks/images/logo_png.png') }}" alt="LoopLynks Logo" class="h-14 w-auto" />
                </a>
                <button id="sticky-dropdown-close"
                    class="group text-white text-xl flex items-center gap-4 focus:outline-none">
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
                        <!-- <div class="w-[16rem] border-b-4 border-yellow-400 mb-8"></div> -->
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
                            <a href="#"
                                class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
                                onclick="closeStickyDropdown()">Home</a>
                            <a href="#"
                                class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
                                onclick="closeStickyDropdown()">Agenda</a>
                            <a href="#"
                                class="block text-white text-[1.30rem] pb-[0.5rem] font-medium border-b border-gray-700 hover:text-yellow-400 transition-all"
                                onclick="closeStickyDropdown()">About us</a>
                            <a href="#"
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
                        <a href="{{route('customer.login.form')}}" target="_blank"
                            class="btn-hover-effect bg-transparent font-semibold px-[1.25rem] py-[0.5rem] rounded-md border-2 border-yellow-400 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                            <span class="gradient-text">Enroll</span>
                        </a>
                        <a href="{{route('customer.login.form')}}" target="_blank"
                            class=" bg-radial text-black font-semibold px-4 py-2 rounded-md transition focus:outline-none focus:ring-2 focus:ring-yellow-300">
                            Login </a>
                        </a>
                        <a href="https://www.facebook.com/profile.php?id=61577338746098" target="_blank"
                            class="text-white text-2xl :text-[#D4AF37] transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/looplynks/" target="_blank"
                            class="text-white text-2xl hover:text-[#D4AF37] transition"><i
                                class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/107705254/admin/page-posts/published/" target="_blank"
                            class="text-white text-2xl hover:text-[#D4AF37] transition"><i
                                class="fab fa-linkedin-in"></i></a>
                        <a href="https://x.com/looplynks" target="_blank"
                            class="text-white text-2xl hover:text-[#D4AF37] transition"><i class="fas fa-x"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <!-- footer start -->
    <section class="relative w-full bg-black text-white hidden md:block"
        style="background-image: url('{{ asset('looplynks/images/FAQ.png') }}'); background-size: cover; background-position: center;">

        <div class="w-full px-[80px] py-12 flex flex-col gap-8"
            style="background: rgba(0,0,0,0.85); border-radius: 1rem;">
            <!-- Contact Row -->
            <div
                class="flex flex-col md:flex-row md:justify-center md:items-center gap-2 text-sm mb-4 text-center lg:mt-10">
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
                <a href="#" class="hover:text-[#D4AF37] transition">Home</a>
                <a href="#" class="hover:text-[#D4AF37] transition">About us</a>
                <a href="#" class="hover:text-[#D4AF37] transition">Award Categories</a>
                <a href="#" class="hover:text-[#D4AF37] transition">Jury</a>
                <a href="#" class="hover:text-[#D4AF37] transition">Agenda</a>
                <a href="#" class="hover:text-[#D4AF37] transition">Why georgia?</a>
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
                    <a href="https://www.instagram.com/looplynks/" target="_blank"
                        class="hover:text-[#D4AF37] transition"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/107705254/admin/page-posts/published/" target="_blank"
                        class="hover:text-[#D4AF37] transition"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://x.com/looplynks" target="_blank" class="hover:text-[#D4AF37] transition"><i
                            class="fas fa-x"></i></a>
                    <a href="https://in.pinterest.com/looplynks/" target="_blank"
                        class="hover:text-[#D4AF37] transition"><i class="fab fa-pinterest-p"></i></a>
                    <a href="https://www.youtube.com/@Looplynks" target="_blank"
                        class="hover:text-[#D4AF37] transition"><i class="fab fa-youtube"></i></a>


                </div>
            </div>
        </div>
    </section>


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
@endsection