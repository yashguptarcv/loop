<header
    class="h-18 bg-[var(--color-sidebar-bg)] text-[var(--color-text-inverted)] shadow-sm flex items-center justify-between px-6 sticky top-0 z-10 border-b border-[var(--color-border)]">
    <!-- Page Title & Mobile Menu Button -->
    <div class="flex items-center">
        <div class="relative hidden md:block">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-icons-outlined text-[var(--color-primary-300)]">search</span>
            </div>
            <input type="text" class="block w-full pl-10 pr-3 py-2 rounded-lg bg-[var(--color-primary-dark)] 
           border border-[var(--color-border)] focus:border-[var(--color-primary)] 
           focus:ring-2 focus:ring-[var(--color-primary)] 
           text-[var(--color-text-inverted)] placeholder-[var(--color-primary-300)] 
           transition-all duration-200 outline-none" placeholder="Search...">

        </div>
    </div>

    <!-- Right Controls -->
    <div class="flex items-center space-x-4">
        <!-- Search Bar -->


        <!-- Notification Bell -->
        <div class="relative">
            <button
                class="p-2 rounded-full hover:bg-[var(--color-hover)] text-[var(--color-primary-300)] hover:text-[var(--color-text-inverted)] relative transition-colors duration-200"
                aria-label="Notifications">
                <span class="material-icons-outlined">notifications</span>
                <span class="sr-only">Notifications</span>
                <span
                    class="absolute top-0 right-0 w-2.5 h-2.5 bg-[var(--color-notification-badge)] rounded-full border border-[var(--color-sidebar-bg)]"></span>
            </button>
        </div>

        <!-- User Menu -->
        <div class="relative">
            <button class="flex items-center space-x-2 focus:outline-none group" id="userMenuButton">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('admin')->user()->name ?? 'User') }}&background=ffffff&color=014732"
                    alt="Avatar" class="w-8 h-8 rounded-full border-2 border-[var(--color-primary)]">
                <span class="hidden md:inline-block text-sm font-medium">
                     {{ Str::limit(Auth::guard('admin')->user()->name ?? 'User', 20) }}
                </span>
            </button>

            <!-- Dropdown Menu -->
            <div class="hidden absolute right-0 mt-2 w-56 bg-[var(--color-sidebar-bg)] rounded-lg shadow-lg border border-[var(--color-border)] py-1 z-20 text-[var(--color-text-inverted)]"
                id="userMenu">
               
                <div class="px-4 py-3 border-b border-[var(--color-border)]">
                    <p class="text-sm font-medium" title="{{ Auth::guard('admin')->user()->name }}">
                        {{ Str::limit(Auth::guard('admin')->user()->name ?? 'User', 20) }}
                    </p>
                    <p class="text-xs text-[var(--color-primary-300)]">
                        {{ Auth::guard('admin')->user()->email ?? 'abc@email.com' }}
                    </p>
                </div>


                <div class="border-t border-[var(--color-border)]"></div>
                <form method="POST" action="{{ route('admin.logout') }}" class="form-ajax">
                    @csrf
                    <button type="submit" name="button"
                        class="block w-full text-left px-4 py-2 text-sm hover:bg-[var(--color-hover)] flex items-center">
                        <span class="material-icons-outlined mr-2 text-[var(--color-primary-300)]">logout</span>
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>