<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-[var(--color-text-primary)]">{{$title}}</h1>

        

    </div>

    <!-- Top Controls -->
    <x-topbar :data="$data" />

    <div class="flex flex-col">
        <!-- Main Content -->
        <div class="flex-1">
            <x-table :data="$data" />
            <x-pagination :data="$data['meta']" />
        </div>
    </div>

    <x-sidebar :data="$data" />
    <!-- Overlay -->
    <div id="filterOverlay" class="fixed inset-0 z-40 bg-black/50 bg-opacity-50 hidden"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterToggle = document.getElementById('filterToggle');
        const filterSidebar = document.getElementById('filterSidebar');
        const filterOverlay = document.getElementById('filterOverlay');
        const closeFilter = document.getElementById('closeFilter');

        // Function to open sidebar
        function openSidebar() {
            filterSidebar.classList.remove('translate-x-full');
            filterOverlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        // Function to close sidebar
        function closeSidebar() {
            filterSidebar.classList.add('translate-x-full');
            filterOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Toggle sidebar
        filterToggle?.addEventListener('click', openSidebar);

        // Close sidebar
        closeFilter?.addEventListener('click', closeSidebar);

        // Close when clicking overlay
        filterOverlay?.addEventListener('click', closeSidebar);

        // Close when pressing Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });

        // Remove empty fields before submit
        document.getElementById('filterForm')?.addEventListener('submit', function (e) {
            const inputs = this.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                if (
                    (input.type === 'checkbox' && !input.checked) ||
                    (input.type !== 'checkbox' && input.value.trim() === '')
                ) {
                    input.disabled = true;
                }
            });
        });
    });
</script>