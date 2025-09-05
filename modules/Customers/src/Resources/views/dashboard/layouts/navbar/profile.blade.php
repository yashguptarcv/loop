<div class="flex items-center">
    <!-- Currency Dropdown -->
    <div class="relative mr-4">
        <select id="currencySelect"
            class="bg-white dark:bg-slate-800 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @foreach (fn_get_currencies() as $currency)
            <option value="{{ $currency->code }}" {{ session('currency') == $currency->code ? 'selected' : '' }}>
                {{ $currency->code }} ({{ $currency->symbol }})
            </option>
            @endforeach
        </select>
    </div>

    <!-- Theme Toggle -->
    <button id="theme-toggle" class="theme-toggle mr-2">
        <i class="fas fa-moon text-xl" id="theme-icon"></i>
    </button>

    <!-- Notification -->
    <div class="relative mr-4">
        <button class="flex items-center p-1 text-sm rounded-full text-gray-400 hover:text-gray-600 focus:outline-none dark:hover:text-gray-300">
            <i class="fas fa-bell text-xl"></i>
            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
        </button>
    </div>

    <!-- User Profile -->
    <div class="relative">
        <button class="flex text-sm rounded-full focus:outline-none" onclick="toggleDropdown()">
            @include('customers::dashboard.common.profile-icon',['name' => auth('customer')->user()->name])
        </button>
        <div id="userDropdown" class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none  dark:ring-gray-700">
            <div class="py-1" role="menu" aria-orientation="vertical">
                <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700" role="menuitem">Profile</a>
                <hr>
                <form method="POST" action="{{ route('customer.logout') }}">
                    @csrf
                    <button type="submit" name="button"
                        class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700 text-left">
                        <span class="material-icons-outlined mr-2">logout</span>
                        
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>