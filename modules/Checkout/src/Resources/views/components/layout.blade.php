<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Checkout')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- meta -->
    @yield('meta')
    <!-- styles -->
    @yield('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .step-active {
            transform: scale(1.1);
            transition: all 0.3s ease;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
        }

        .product-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .checkout-card {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }

        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
        }
    </style>
</head>

<body class="p-4">
    @yield('content')

    @yield('scripts')
    <script>
        // Simple step indicator update (for demonstration)
        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.step');

            // This would be updated based on the actual step in a real application
            function setActiveStep(stepNumber) {
                steps.forEach((step, index) => {
                    if (index < stepNumber) {
                        step.classList.add('step-active');
                        step.querySelector('div').classList.remove('bg-opacity-20');
                        step.querySelector('div').classList.add('bg-white', 'text-primary', 'shadow-lg');
                        step.classList.remove('text-white');
                        step.classList.add('text-white');
                    } else if (index === stepNumber) {
                        step.classList.add('step-active');
                        step.querySelector('div').classList.remove('bg-white', 'text-primary');
                        step.querySelector('div').classList.add('bg-opacity-20', 'text-white');
                    } else {
                        step.classList.remove('step-active');
                        step.querySelector('div').classList.remove('bg-white', 'text-primary', 'shadow-lg');
                        step.querySelector('div').classList.add('bg-opacity-20', 'text-white');
                    }
                });
            }

            // For demo purposes, set step 2 as active
            setActiveStep(2);
        });
    </script>
</body>

</html>