@extends('shop::layouts.app')

@section('content')
<section class="flex items-center justify-center min-h-screen px-6 py-12 bg-center bg-cover"
    style="background-image: url('{{ asset('looplynks/images/HeroSection.png') }}');">
    <div class="flex flex-col lg:flex-row items-center justify-center w-full max-w-8xl gap-8 lg:gap-4">

        <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-xl w-full max-w-3xl">
            @if(!empty(session('success')))
                <h4
                    class="text-md sm:text-md md:text-md lg:text-md xl:text-md font-thunder font-bold text-yellow-500 mb-6">
                    {{session('success')}}
                </h4>
            @endif
            <form class="" method="post" action="{{route('checkout.nomination')}}">
            
            @csrf
            @if(!empty($cart) && !empty($checkout['application']))
                @method('PUT')
            @endif
                <!-- Personal Details -->
                <h2
                    class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-5xl font-thunder font-bold text-yellow-500 mb-6">
                    Personal Details
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Full Name -->
                    <div class="relative">
                        <input type="text" value="{{$checkout['application']['full_name'] ?? ''}}" name="full_name" ids="full_name" placeholder="Full Name" class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-12 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 
                focus:outline-none focus:ring-1 focus:ring-white placeholder-gray-400" @error('full_name') style="border: 1px solid red !important;" @enderror>
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
                        <input type="email" value="{{$checkout['application']['email'] ?? ''}}" name="email" ids="email" placeholder="Email" class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-12 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 
                focus:outline-none focus:ring-1 focus:ring-white placeholder-gray-400" @error('email') style="border: 1px solid red !important;" @enderror>
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
                        <input type="text" value="{{$checkout['application']['mobile'] ?? ''}}" name="mobile" ids="mobile" placeholder="Contact Number" class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-12 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 
                focus:outline-none focus:ring-1 focus:ring-white placeholder-gray-400" @error('mobile') style="border: 1px solid red !important;" @enderror>
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
                        <input type="email" value="{{$checkout['application']['alternate_contact'] ?? ''}}" name="alternate_contact" ids="alternate_contact" placeholder="Alternate Email" class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-12 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 
                focus:outline-none focus:ring-1 focus:ring-white placeholder-gray-400" @error('alternate_contact') style="border: 1px solid red !important;" @enderror>
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
                        <input type="text" value="{{$checkout['application']['designation'] ?? ''}}" name="designation" ids="designation" placeholder="Designation" class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-12 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 
                focus:outline-none focus:ring-1 focus:ring-white placeholder-gray-400" @error('designation') style="border: 1px solid red !important;" @enderror>
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
                        <input type="text" value="{{$checkout['application']['organization'] ?? ''}}" name="organization" ids="organization" placeholder="Company" class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-12 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 
                focus:outline-none focus:ring-1 focus:ring-white placeholder-gray-400" @error('organization') style="border: 1px solid red !important;" @enderror>
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
    
                <div class="flex flex-col sm:flex-row items-center justify-between w-full max-w-[56rem] mb-6">
                    <p class="text-gray-300 text-base">
                        How many categories would you like<br> to nominate?
                    </p>
                    <div class="relative w-full sm:w-1/2 mt-4 sm:mt-0">
                        @php
                            $quantity   = !empty($cart['order_items']) ? array_column($cart['order_items'], 'quantity') ?? [] : [];
                            $options_data      = !empty($cart['order_items']) ? array_column($cart['order_items'], 'options') ?? [] : [];
                            $options = $options_data[0]['award_categories']['categories'] ?? [];
                        @endphp
                        <select id="categoryCount" name="award_categories"
                            class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-10 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 focus:outline-none focus:ring-1 focus:ring-white appearance-none"
                            onchange="renderCategoryInputs(this.value)" @if($errors->get('award_category.*.child')) style="border: 1px solid red !important;" @endif>
                            <option value="">No. of Categories</option>
                            @for ($i = 1; $i <= fn_get_setting('general.lead.award_category'); $i++)
                                <option value="{{ $i }}" @if(in_array($i, $quantity)) selected @endif>{{ $i }}</option>
                            @endfor
                        </select>
                        <div class="pointer-events-none absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        @foreach ($errors->get('award_category.*.child') as $messages)
                            @foreach ($messages as $msg)
                                <span class="text-sm text-red-600">{{ 'The award category is required' }}</span>
                            @endforeach
                        @endforeach
                    </div>
                </div>

                
                <!-- Container where categories will be injected -->
                <div id="categoriesContainer"></div>
                <!-- Total -->
                @php
                    $application =  fn_get_product_data(fn_get_setting('general.lead.product'));
                    $application_price = $application->price;
                    if(!empty($application->sale_price) && $application->sale_price > $application->price) {
                        $application_price = $application->sale_price;
                    }
                @endphp
                <p class="text-white mt-6">Total: <span class="text-yellow-500 font-semibold" id="total">{{fn_convert_currency($application_price * $quantity[0] ?? 1 ?? 0, session('currency'))}}</span></p>

                <!-- Terms -->
                <div class="flex items-center mt-4">
                    <label for="terms" class="text-sm text-gray-300" @error('terms') style="color: red !important;" @enderror>
                        <input type="hidden" name="terms" value="no">
                        <input type="checkbox" name="terms" value="yes" id="terms" class="mr-2">
                        I accept the <span
                            class="text-yellow-500 cursor-pointer"  @error('terms') style="color: red !important;" @enderror>TERMS AND CONDITIONS</span>
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit" name="button"
                    class="w-full bg-white text-black font-semibold py-3 mt-6 rounded-full hover:bg-yellow-500 hover:text-white transition">
                    SUBMIT
                </button>
                <script>
                    function renderCategoryInputs(count) {
                        const container = document.getElementById("categoriesContainer");
                        container.innerHTML = ""; // clear old inputs

                        count = parseInt(count) || 0;

                        for (let i = 1; i <= count; i++) {
                            const block = `
                                <h3 class="text-white font-thunder font-bold mt-6 mb-2">${i} Award Category</h3>
                                <div class="relative w-full mb-4">
                                     <x-category-selector 
                                            :parent-categories="fn_get_categories(0)->toArray()" 
                                            selected-parent="" 
                                            selected-child="" 
                                            parentname="award_category[${i}][parent]" 
                                            childname="award_category[${i}][child]" 
                                            othername="award_category[${i}][custom]" 
                                            :showLabel="false"
                                        />
                                </div>
                            `;
                            container.insertAdjacentHTML("beforeend", block);
                        }
                    }
                    
                    renderCategoryInputs({{$quantity[0]??1}});

                </script>
            </form>
        </div>

        <!-- Trophy Image -->
        <div class="flex items-center justify-center lg:justify-start w-full lg:w-auto lg:flex-shrink-0">
            <img src="{{ asset('looplynks/images/trophy.png')}}" alt="Dummy Trophy"
                class="w-[300px] md:w-[350px] lg:w-[400px] drop-shadow-2xl object-contain" />
        </div>

    </div>
</section>

<script>
    function toggleDropdown(id) {
        document.getElementById(id).classList.toggle('hidden');
    }

    function filterOptions(input, listId) {
        const filter = input.value.toLowerCase();
        const list = document.getElementById(listId);
        const items = list.querySelectorAll('li');
        list.classList.remove('hidden');

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(filter) ? 'block' : 'none';
        });
    }
</script>
@endsection