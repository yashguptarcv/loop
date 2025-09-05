<nav class="bg-white shadow-sm sticky top-0 z-10 ">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">                
                @php
                    $logo = fn_get_image('company_logo', 0)['url'] ?? '';
                @endphp
                @if($logo)
                    <img src="{{$logo}}" alt="{{fn_get_setting('general.company.name')}}" width="120px" height="auto">
                @else
                    <span class="ml-2 text-xl font-bold text-gray-800 dark:text-white">{{fn_get_setting('general.company.name')}}</span>
                @endif
            </div>

            <!-- Menus -->
            @include('customers::dashboard.layouts.navbar.desktop.header')

            <!-- Notification, Theme Toggle & User Profile -->
            @include('customers::dashboard.layouts.navbar.profile')
        </div>
    </div>

    <!-- Mobile menu -->
    @include('customers::dashboard.layouts.navbar.mobile.header')
    
</nav>