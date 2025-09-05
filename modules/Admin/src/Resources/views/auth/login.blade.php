<!DOCTYPE html>
<html class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Favicon -->
    <link rel="icon" href="{{fn_get_image('company_favicon', 0)['url'] ?? ''}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{fn_get_image('company_favicon', 0)['url'] ?? ''}}" type="image/x-icon">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @vite(['resources/css/app.css', 'resources/css/toast.css', 'resources/css/fontawesome/all.min.css', 'resources/js/app.js'])
    @include('admin::layouts.tailwind-config')
</head>

<body class="h-full font-sans antialiased">
    <div id="toast-container" class="toast-container"></div>
    <div
        class="min-h-full flex items-center justify-center p-4 sm:px-6 lg:px-8 bg-gradient-to-br from-[var(--color-primary-light)] to-[var(--color-primary-lighter)]">
        <div class="w-full max-w-md space-y-8">

            <div class=" bg-white-100 rounded-2xl shadow-xl border border-gray-100/50 p-8 sm:p-10">
                <form class="form-ajax space-y-6" method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-[var(--color-primary-dark)]">
                            @lang('admin::app.admin.login.email')
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex mt-4 pointer-events-none">
                                <i class="fas fa-envelope primary-100"></i>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" class="block w-full pl-10 pr-3 py-3 border border-primary-100 rounded-xl bg-white/70
           focus:ring-2 focus:ring-primary-100 focus:border-primary-100
           placeholder-[var(--color-gray-400)] text-[var(--color-gray-800)] 
           transition-all duration-200 outline-none" placeholder="admin@example.com" />

                        </div>
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium text-[var(--color-primary-dark)]">
                                @lang('admin::app.admin.login.password')
                            </label>
                            <a href="#"
                                class="text-xs font-medium primary-100 hover:text-primary-200">
                                @lang('admin::app.admin.login.forget-password-link')
                            </a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-primary-100"></i>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                class="block w-full pl-10 pr-3 py-3 border border-primary-100 rounded-xl bg-white/70 
           focus:ring-2 focus:ring-primary-100 focus:border-primary-100 
           placeholder-[var(--color-gray-400)] text-[var(--color-gray-800)] 
           transition-all duration-200 outline-none" placeholder="••••••••" />

                        </div>
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox"
                            class="h-4 w-4 text-primary-100 focus:ring-primary-100 border-primary-100 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-primary-100">
                            @lang('admin::app.admin.login.remember')
                        </label>
                    </div>

                    <button type="submit" class="items-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 hover:text-amber-200 text-amber-100 bg-primary-100 w-full" name="button">

                        @lang('admin::app.admin.login.submit-btn')
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/toast.js') }}"></script>
</body>

</html>