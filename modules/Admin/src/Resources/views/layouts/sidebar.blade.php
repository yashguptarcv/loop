<aside
    class="w-64 bg-[var(--color-sidebar-bg)] text-[var(--color-text-inverted)] flex flex-col justify-between h-full border-r border-[var(--color-border)] transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 fixed lg:static z-20">
    <!-- Logo/Brand -->
    <div class="p-6 pb-4 text-2xl font-bold border-b border-[var(--color-border)] flex items-center space-x-2">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
        </svg>
        <span>MyApp</span>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto" id="sidebarMenu">
        @foreach (config('core::menu') as $item)
            @if (!isset($item['permission']) || bouncer()->hasPermission($item['permission']))
                @if (isset($item['children']))
                    {{-- Parent with Toggle --}}
                    <div class="sidebar-parent-group">
                        <button
                            type="button"
                            class="flex items-center w-full text-sm font-medium px-4 py-3 rounded-lg transition-colors text-left hover:bg-[var(--color-hover)] text-[var(--color-text-inverted)] sidebar-toggle-btn"
                            data-target="submenu-{{ Str::slug($item['label']) }}"
                        >
                            <span class="material-icons-outlined mr-2 text-base">{{ $item['icon'] ?? 'folder' }}</span>
                            <span class="flex-1">{{ $item['label'] }}</span>
                            <span class="material-icons-outlined transition-transform duration-200 toggle-icon">chevron_right</span>
                        </button>

                        <div class="pl-6 space-y-1 mt-1 hidden submenu" id="submenu-{{ Str::slug($item['label']) }}">
                            @foreach ($item['children'] as $child)
                                @if (!isset($child['permission']) || bouncer()->hasPermission($child['permission']))
                                    <x-sidebar.link
                                        href="{{ route($child['route']) }}"
                                        label="{{ $child['label'] }}"
                                        icon="{{ $child['icon'] ?? 'chevron_right' }}"
                                        :active="request()->routeIs($child['route'] . '*')"
                                    />
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else
                    {{-- Regular Link --}}
                    <x-sidebar.link
                        href="{{ route($item['route']) }}"
                        label="{{ $item['label'] }}"
                        icon="{{ $item['icon'] }}"
                        :active="request()->routeIs($item['route'] . '*')"
                    />
                @endif
            @endif
        @endforeach
    </nav>

    <!-- User & Logout -->
    <div class="p-4 border-t border-[var(--color-border)] flex items-center justify-between">
        <div class="flex items-center ">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('admin')->user()->name ?? 'User') }}&background=ffffff&color=014732"
                alt="Avatar" class="w-10 h-10 rounded-full mr-3 border-2 border-[var(--color-primary)]">
            <div>
               
                <p class="font-medium">  {{ Str::limit(Auth::guard('admin')->user()->name ?? 'User', 15) }}</p>
                <p class="text-xs text-[var(--color-primary-300)]">{{ Auth::guard('admin')->user()->role->name ?? 'Admin' }}</p>
            </div>
        </div>
        <form method="POST" class="form-ajax" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" name="button"
                class="w-full flex items-center justify-start px-4 py-2 rounded-lg hover:bg-[var(--color-hover)] transition-colors duration-200 text-[var(--color-primary-300)] hover:text-[var(--color-text-inverted)]">
                <span class="material-icons-outlined mr-2">logout</span>
                
            </button>
        </form>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButtons = document.querySelectorAll('.sidebar-toggle-btn');

        toggleButtons.forEach(button => {
            const targetId = button.getAttribute('data-target');
            const submenu = document.getElementById(targetId);
            const icon = button.querySelector('.toggle-icon');

            // Toggle submenu on click
            button.addEventListener('click', () => {
                submenu.classList.toggle('hidden');
                icon.classList.toggle('rotate-90');
            });

            // Auto-open if any of its child routes is active
            const activeLink = submenu.querySelector('.active');
            if (activeLink) {
                submenu.classList.remove('hidden');
                icon.classList.add('rotate-90');
            }
        });
    });
</script>