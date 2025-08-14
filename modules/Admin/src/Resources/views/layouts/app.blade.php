<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    <link rel="icon" href="@yield('favicon', asset('favicon.ico'))" type="image/x-icon">
    <link rel="shortcut icon" href="@yield('favicon', asset('favicon.ico'))" type="image/x-icon">


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- meta -->
    @yield('meta')
    <!-- styles -->
    @yield('styles')
</head>

<body class="bg-white text-black-300 font-sans">
    <div id="toast-container" class="toast-container"></div>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('admin::layouts.sidebar')

        <!-- Main Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            @include('admin::layouts.topbar')

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-white-100">
                <div class="container mx-auto px-4 py-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <x-delete-modal />
    <x-status-modal />
    <script src="{{ asset('js/toast.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/{{fn_get_setting('general.settings.editor.tiny_api_key')}}/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    @yield('scripts')

    {{-- notification toggle --}}
    <script>
        // Toggle notification dropdown
        const notificationButton = document.querySelector('.relative button[aria-label="Notifications"]');
        const notificationDropdown = document.querySelector('.relative .hidden');

        if (notificationButton && notificationDropdown) {
            notificationButton.addEventListener('click', (e) => {
                e.stopPropagation();
                notificationDropdown.classList.toggle('hidden');
            });

            // Close when clicking outside
            document.addEventListener('click', (e) => {
                if (!notificationButton.contains(e.target) && !notificationDropdown.contains(e.target)) {
                    notificationDropdown.classList.add('hidden');
                }
            });
        }

        // User dropdown menu
        const userMenuButton = document.getElementById('userMenuButton');
        const userMenu = document.getElementById('userMenu');

        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', (e) => {
                e.stopPropagation();
                userMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        }

        // Close dropdowns when pressing Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                notificationDropdown?.classList.add('hidden');
                userMenu?.classList.add('hidden');
            }
        });

        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('aside');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('-translate-x-full');
                });
            }
        });
    </script>

    <script>
        @if (session('success'))
            showToast(@json(session('success')), 'success', 'Success');
        @elseif (session('error'))
            showToast(@json(session('error')), 'error', 'Error');
        @elseif (session('info'))
            showToast(@json(session('info')), 'info', 'Information');
        @elseif (session('warning'))
            showToast(@json(session('warning')), 'warning', 'Warning');
        @endif
    </script>

    {{-- toast modal throgh sessions --}}
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const toast = sessionStorage.getItem('toastMessage');
            if (toast) {
                const { message, type, title } = JSON.parse(toast);
                showToast(message, type, title);  // Your existing toast function
                sessionStorage.removeItem('toastMessage');  // Clear after showing
            }
        });
    </script>

    {{-- deleet modal --}}
    <script>
        function openDeleteModal(actionUrl) {
            const modal = document.getElementById('global-delete-modal');
            const form = document.getElementById('global-delete-form');

            form.setAttribute('action', actionUrl);
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('global-delete-modal');
            const form = document.getElementById('global-delete-form');

            form.setAttribute('action', '');
            modal.classList.add('hidden');
        }
    </script>

    {{-- status Chnage modal --}}

    <script>
        function openStatusModal(actionUrl) {
            const modal = document.getElementById('status-modal');
            const form = document.getElementById('status-form');

            form.setAttribute('action', actionUrl);
            modal.classList.remove('hidden');
        }

        function closeStatusModal() {
            const modal = document.getElementById('status-modal');
            const form = document.getElementById('status-form');

            form.setAttribute('action', '');
            modal.classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const cancelBtn = document.getElementById('status-cancel-btn');
            if (cancelBtn) {
                cancelBtn.addEventListener('click', closeStatusModal);
            }
        });
    </script>
</body>

</html>