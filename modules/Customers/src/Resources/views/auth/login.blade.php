<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ asset('looplynks/input.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('looplynks/animation.css') }}">
  <link rel="stylesheet" href="{{ asset('looplynks/gsap.css') }}">
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('looplynks/images/Favicon Looplynks-01.png') }}" sizes="32x32">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>
  <script src="{{ asset('looplynks/assets/script.js') }}"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Inter&family=Montserrat&family=Open+Sans&family=Poppins&display=swap"
    rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

  <style>
    /* Additional styles to fix the overflow issue */
    body.overflow-hidden {
      overflow-x: hidden !important;

    }

    /* Ensure header background scales properly */
    .flowing-lines {
      min-height: 100vh;
      height: auto !important;
    }

    /* Fix for mobile section */
    @media (max-width: 1023px) {
      .mobile-section {
        min-height: auto !important;
        height: auto;
        padding-bottom: 2rem;
      }
    }

    /* Adjust hero section for desktop */
    @media (min-width: 1024px) {
      .hero-section {
        height: auto !important;
        min-height: 100vh;
        padding: 2rem 0;
      }
    }
  </style>

  @yield('head')
</head>

<body class="overflow-hidden">


<section class="flex items-center justify-center min-h-screen px-6 py-12 bg-center bg-cover"
    style="background-image: url('{{ asset('looplynks/images/HeroSection.png') }}');">
    <div class="flex flex-col lg:flex-row items-center justify-center w-full max-w-6xl gap-8 lg:gap-12">

        <!-- Login Form Section -->
        <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-xl w-full max-w-md">
            
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('looplynks/images/logo_png.png') }}" alt="LoopLynks Logo" class="h-16 w-auto mx-auto mb-4" />
                <h2 class="text-3xl font-thunder font-bold text-yellow-500 mb-2">Welcome Back</h2>
                <p class="text-gray-300 text-sm">Sign in to your account</p>
            </div>

           <!-- Error Messages -->
            <div id="error-messages" class="hidden mb-4 p-3 bg-red-500/20 border border-red-500/50 rounded-lg">
                <div class="text-red-300 text-sm" id="error-text"></div>
            </div>

            <!-- Success Messages -->
            <div id="success-messages" class="hidden mb-4 p-3 bg-green-500/20 border border-green-500/50 rounded-lg">
                <div class="text-green-300 text-sm" id="success-text"></div>
            </div>

            <!-- Login Form -->
            <form id="login-form" method="POST" action="{{ route('customer.login') }}">
                @csrf
                
                <!-- Email -->
                <div class="relative mb-4">
                    <input type="email" 
                           name="email" 
                           id="email"
                           placeholder="Email Address" 
                           required
                           class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-12 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 placeholder-gray-400 transition-all duration-300">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8z" />
                        </svg>
                    </span>
                </div>

                <!-- Password -->
                <div class="relative mb-6">
                    <input type="password" 
                           name="password" 
                           id="password"
                           placeholder="Password" 
                           required
                           class="w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-12 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 placeholder-gray-400 transition-all duration-300">
                    <button type="button" 
                            id="toggle-password"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-200 transition-colors">
                        <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                        </svg>
                        <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center text-sm text-gray-300">
                        <input type="checkbox" name="remember" class="mr-2 rounded border-gray-600 bg-gray-700 text-yellow-500 focus:ring-yellow-500">
                        Remember me
                    </label>
                    <a href="#" class="text-sm text-yellow-500 hover:text-yellow-400 transition-colors">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        id="login-btn"
                        class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 text-black font-semibold py-3 rounded-full hover:from-yellow-400 hover:to-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-300 transform hover:scale-105">
                    <span id="login-text">Sign In</span>
                    <span id="login-loading" class="hidden">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-black inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Signing in...
                    </span>
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6 flex items-center">
                <div class="flex-1 border-t border-gray-600"></div>
                <span class="px-4 text-gray-400 text-sm">or</span>
                <div class="flex-1 border-t border-gray-600"></div>
            </div>

            <!-- Sign Up Link -->
            <div class="text-center">
                <p class="text-gray-300 text-sm">
                    Don't have an account? 
                    <a href="#" class="text-yellow-500 hover:text-yellow-400 font-medium transition-colors">
                        Sign up here
                    </a>
                </p>
            </div>
        </div>

        <!-- Welcome Image/Content -->
        <div class="flex flex-col items-center justify-center lg:justify-start w-full lg:w-auto lg:flex-shrink-0 text-center lg:text-left">
            <div class="mb-8">
                <h1 class="text-4xl lg:text-6xl font-thunder font-bold text-white mb-4 leading-tight">
                    Join the<br>
                    <span class="text-yellow-500">LoopLynks</span><br>
                    Community
                </h1>
                <p class="text-gray-300 text-lg lg:text-xl max-w-md">
                    Connect with industry leaders and be part of something extraordinary.
                </p>
            </div>
            <img src="{{ asset('looplynks/images/trophy.png') }}" alt="Trophy" 
                 class="w-[250px] md:w-[300px] lg:w-[350px] drop-shadow-2xl object-contain" />
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    const loginBtn = document.getElementById('login-btn');
    const loginText = document.getElementById('login-text');
    const loginLoading = document.getElementById('login-loading');
    const errorMessages = document.getElementById('error-messages');
    const successMessages = document.getElementById('success-messages');
    const errorText = document.getElementById('error-text');
    const successText = document.getElementById('success-text');
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    const eyeClosed = document.getElementById('eye-closed');
    const eyeOpen = document.getElementById('eye-open');

    // Password toggle functionality
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        if (type === 'text') {
            eyeClosed.classList.add('hidden');
            eyeOpen.classList.remove('hidden');
        } else {
            eyeClosed.classList.remove('hidden');
            eyeOpen.classList.add('hidden');
        }
    });

    // Form submission
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Hide previous messages
        errorMessages.classList.add('hidden');
        successMessages.classList.add('hidden');
        
        // Show loading state
        loginText.classList.add('hidden');
        loginLoading.classList.remove('hidden');
        loginBtn.disabled = true;

        const formData = new FormData(loginForm);

        fetch(loginForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token')
            }
        })
        .then(response => response.json())
        .then(data => {
            // Reset loading state
            loginText.classList.remove('hidden');
            loginLoading.classList.add('hidden');
            loginBtn.disabled = false;

            if (data.success) {
                successText.textContent = data.message;
                successMessages.classList.remove('hidden');
                
                // Redirect after success
                if (data.redirect_url) {
                    setTimeout(() => {
                        window.location.href = data.redirect_url;
                    }, 1500);
                }
            } else if (data.errors) {
                let errorMessage = '';
                if (typeof data.errors === 'object') {
                    for (const [field, messages] of Object.entries(data.errors)) {
                        errorMessage += messages.join(', ') + ' ';
                    }
                } else {
                    errorMessage = data.errors;
                }
                
                errorText.textContent = errorMessage.trim();
                errorMessages.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Reset loading state
            loginText.classList.remove('hidden');
            loginLoading.classList.add('hidden');
            loginBtn.disabled = false;
            
            errorText.textContent = 'An error occurred. Please try again.';
            errorMessages.classList.remove('hidden');
        });
    });
});
</script>

<style>
/* Custom styles for better form appearance */
.font-thunder {
    font-family: 'Thunder', sans-serif;
}

/* Enhanced focus states */
input:focus {
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

/* Loading animation */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* Smooth transitions */
* {
    transition: all 0.3s ease;
}

/* Custom scrollbar for better UX */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

::-webkit-scrollbar-thumb {
    background: rgba(245, 158, 11, 0.5);
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(245, 158, 11, 0.7);
}
</style>

</body>

</html>