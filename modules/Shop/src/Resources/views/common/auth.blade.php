<!-- Nominate Button -->
@guest('customer')
<a href="./nominate.html"
    class="btn-hover-effect bg-transparent font-semibold px-[1.25rem] py-[0.5rem] rounded-md border-2 border-yellow-400 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-300">
    <span class="gradient-text">Nominate</span>
</a>
<!-- Login Button -->
<a href="{{route('customer.login.form')}}"
    class="bg-radial text-black font-semibold px-4 py-2 rounded-md transition focus:outline-none focus:ring-2 focus:ring-yellow-300">
    Login
</a>
@else

<div class="relative">
    <button onclick="toggleUserDropdown()"
        class="flex items-center gap-2 text-white font-semibold px-4 rounded-md transition">
        Welcome, {{ auth('customer')->user()->name ?? 'Customer' }}
        <i data-lucide="chevron-down" class="w-4 h-4 text-yellow-400 transition-transform duration-300"
            id="dropdownIcon"></i>
    </button>

    <ul id="userDropdown"
        class="absolute left-0 mt-2 w-44 bg-[#0f0f0f] border border-yellow-400/30 rounded-md shadow-lg text-white text-sm hidden z-20">
        <li class=""><a href="{{ route('customer.dashboard') }}"
                class="block px-4 py-2 hover:bg-yellow-400 hover:text-black transition-colors">Dashboard</a></li>
        <li class=""><a href="{{ route('customer.profile') }}"
                class="block px-4 py-2 hover:bg-yellow-400 hover:text-black transition-colors">Profile</a></li>
        <li class="">
            <form method="POST" action="{{ route('customer.logout') }}" class="w-full">
                @csrf
                <button type="submit"
                    class="w-full text-left px-4 py-2 hover:bg-yellow-400 hover:text-black transition-colors transition-colors">
                    Logout
                </button>
            </form>
        </li>
    </ul>
</div>

<script>
    function toggleUserDropdown() {
        const dropdown = document.getElementById('userDropdown');
        const icon = document.getElementById('dropdownIcon');
        dropdown.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        const button = event.target.closest('button[onclick*="toggleUserDropdown"]');

        if (!dropdown.classList.contains('hidden') && !button) {
            dropdown.classList.add('hidden');
            const icon = document.getElementById('userDropdownIcon');
            if (icon) icon.classList.remove('rotate-180');
        }
    });
</script>

@endguest