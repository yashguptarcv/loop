<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
        <!-- Favicon -->
    <link rel="icon" href="{{fn_get_image('company_favicon', 0)['url'] ?? ''}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{fn_get_image('company_favicon', 0)['url'] ?? ''}}" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @vite([
        'resources/css/app.css', 
        'resources/css/toast.css', 
        'resources/css/fontawesome/all.min.css', 
        'resources/js/jquery-3.7.1.min.js',
        'resources/js/app.js'
    ])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- meta -->
    @yield('meta')
    <!-- styles -->
    @yield('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #000;
            --primary-dark: #000;
            --secondary: #10b981;
            --accent: #f59e0b;
            --light: #f8fafc;
            --dark: #1e293b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7fafc;
            color: #334155;
            transition: background-color 0.3s, color 0.3s;
        }

        body.dark {
            background-color: #0f172a;
            color: #cbd5e1;
        }

        .nav-icon {
            width: 20px;
            text-align: center;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            color: #64748b;
            position: relative;
        }

        .nav-item.active {
            background-color: var(--primary);
            color: white;
        }

        .nav-item:hover:not(.active) {
            background-color: #eef2ff;
            color: var(--primary);
        }

        .dark .nav-item:hover:not(.active) {
            background-color: #1e293b;
            color: var(--primary);
        }

        .nav-text {
            margin-left: 0.5rem;
            white-space: nowrap;
            display: none;
        }

        .nav-item.active .nav-text {
            display: inline;
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
            border-radius: 1rem;
            font-weight: 500;
        }

        .progress-bar {
            height: 0.5rem;
            border-radius: 0.25rem;
            background-color: #e2e8f0;
            overflow: hidden;
        }

        .dark .progress-bar {
            background-color: #334155;
        }

        .progress-fill {
            height: 100%;
            border-radius: 0.25rem;
            transition: width 0.5s ease;
        }

        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .dark .card-hover:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.3);
        }

        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 2px;
            height: 100%;
            background-color: #e2e8f0;
        }

        .dark .timeline::before {
            background-color: #334155;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2rem;
            top: 0.25rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--primary);
            border: 2px solid white;
            box-shadow: 0 0 0 2px var(--primary);
        }

        .dark .timeline-item::before {
            border-color: #0f172a;
        }

        .timeline-item.completed::before {
            background-color: var(--secondary);
            box-shadow: 0 0 0 2px var(--secondary);
        }

        .timeline-item.current::before {
            background-color: white;
            box-shadow: 0 0 0 2px var(--primary);
            animation: pulse 2s infinite;
        }

        .dark .timeline-item.current::before {
            background-color: #0f172a;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4);
            }

            70% {
                box-shadow: 0 0 0 6px rgba(99, 102, 241, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0);
            }
        }

        .page {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .page.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card {
            background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .dark .stat-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
        }

        .application-card {
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }

        .application-card:hover {
            border-left: 4px solid var(--primary-dark);
        }

        .avatar-upload {
            position: relative;
            cursor: pointer;
        }

        .avatar-upload:hover .avatar-edit {
            display: flex;
        }

        .avatar-edit {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            color: white;
        }

        /* Dark theme overrides */
        .dark {
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-card: #1e293b;
            --border-color: #334155;
        }

        .dark .bg-white {
            background-color: var(--bg-card);
        }

        .dark .text-gray-900 {
            color: var(--text-primary);
        }

        .dark .text-gray-500 {
            color: var(--text-secondary);
        }

        .dark .text-gray-700 {
            color: var(--text-secondary);
        }

        .dark .border-gray-200 {
            border-color: var(--border-color);
        }

        .dark .divide-gray-200> :not([hidden])~ :not([hidden]) {
            border-color: var(--border-color);
        }

        .dark .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3), 0 1px 2px 0 rgba(0, 0, 0, 0.2) !important;
        }

        .dark .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3) !important;
        }

        .dark .bg-gray-50 {
            background-color: #1e293b;
        }

        .dark .border-gray-300 {
            border-color: var(--border-color);
        }

        .dark input,
        .dark select {
            background-color: #1e293b;
            color: #f1f5f9;
            border-color: #334155;
        }

        .dark input::placeholder {
            color: #64748b;
        }

        .theme-toggle {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border-radius: 0.5rem;
            color: #64748b;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background-color: #eef2ff;
            color: var(--primary);
        }

        .dark .theme-toggle:hover {
            background-color: #1e293b;
            color: var(--primary);
        }

        @media (max-width: 768px) {
            .nav-item {
                padding: 0.5rem;
            }

            .nav-text {
                display: none !important;
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Top Navigation -->
    @include('customers::dashboard.layouts.topbar')
    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')            
        </div>
    </main>

    <footer class="mt-12 border-t border-gray-200 py-6 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-500 dark:text-gray-400">© 2023 AwardsHub. All rights reserved.</p>
        </div>
    </footer>


    <script>
        // Theme toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const body = document.body;

        // Check for saved theme preference or respect OS preference
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            body.classList.add('dark');
            themeIcon.classList.replace('fa-moon', 'fa-sun');
        }

        themeToggle.addEventListener('click', () => {
            body.classList.toggle('dark');

            if (body.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
                themeIcon.classList.replace('fa-moon', 'fa-sun');
            } else {
                localStorage.setItem('theme', 'light');
                themeIcon.classList.replace('fa-sun', 'fa-moon');
            }
        });

        // User dropdown toggle
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = document.querySelector('[onclick="toggleDropdown()"]');

            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Simulate progress animation
        setTimeout(function() {
            document.querySelectorAll('.progress-fill').forEach(fill => {
                const width = fill.style.width;
                fill.style.width = '0';
                setTimeout(() => {
                    fill.style.width = width;
                }, 300);
            });
        });
    </script>
   
</body>
</html>