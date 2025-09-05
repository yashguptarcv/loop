<header
    class="h-18 bg-primary-100 text-amber-100 shadow-sm flex items-center justify-between px-6 sticky top-0 z-10 border-b border-blue-100">
    <!-- Page Title & Mobile Menu Button -->
    <div class="flex items-center">
        <div class="relative hidden md:block">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-icons-outlined text-amber-300">search</span>
            </div>
            <input type="text" class="block w-full pl-10 pr-3 py-2 rounded-lg bg-primary-100 
           border border-amber-100 focus:border-amber-100 
           focus:ring-2 focus:ring-amber-100 
           text-white-200 placeholder-amber-100 
           transition-all duration-200 outline-none" placeholder="Search...">

        </div>
    </div>

    <!-- Right Controls -->
    <div class="flex items-center space-x-4">
        <!-- Search Bar -->
        
        <!-- Notification Bell -->
        <div class="relative">
            <button
                class="p-2 rounded-full hover:bg-amber-100 text-amber-100 hover:text-primary-100 relative transition-colors duration-200"
                aria-label="Notifications">
                <span class="material-icons-outlined">notifications</span>
                <span
                    class="absolute top-0 right-0 w-2.5 h-2 bg-amber-100 rounded-full border border-amber-100"></span>
            </button>
        </div>

        <!-- User Menu -->
        <div class="relative">
            <button class="flex items-center space-x-2 focus:outline-none group" id="userMenuButton">
                @include('admin::components.common.profile-icon')
            </button>

            <!-- Dropdown Menu -->
            <div class="hidden absolute right-0 mt-2 w-56 bg-primary-100 rounded-lg shadow-lg border border-primary-100 py-1 z-20 text-amber-100"
                id="userMenu">
               
                <div class="px-4 py-3 border-b border-primary-600">
                    <p class="text-sm font-medium" title="{{ Auth::guard('admin')->user()->name }}">
                        {{ Str::limit(Auth::guard('admin')->user()->name ?? 'User', 20) }}
                    </p>
                    <p class="text-xs text-amber-100">
                        {{ Auth::guard('admin')->user()->email ?? 'abc@email.com' }}
                    </p>
                </div>

                <div class="px-4 py-3 border-b border-primary-600">
                    <a href="/" target="_blank" class="w-full text-sm font-medium" title="website">Website</a>
                </div>

                <div class="border-t border-amber-100"></div>
                <form method="POST" action="{{ route('admin.logout') }}" class="form-ajax">
                    @csrf
                    <button type="submit" name="button"
                        class="block w-full text-left px-4 py-2 text-sm hover:bg-amber-100 hover:text-primary-100 flex items-center">
                        <span class="material-icons-outlined mr-2">logout</span>
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>