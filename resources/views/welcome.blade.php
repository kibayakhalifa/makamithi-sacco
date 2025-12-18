<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makamithi Sacco | Employee Portal</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        }

        .card-shadow {
            box-shadow: 0 20px 40px -15px rgba(0,0,0,.08),
                        0 10px 20px -5px rgba(0,0,0,.04);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #059669, #047857);
        }

        .accent-gradient {
            background: linear-gradient(135deg, #f97316, #ea580c);
        }

        .accent-gradient:hover {
            background: linear-gradient(135deg, #ea580c, #c2410c);
        }

        .glass {
            background: rgba(255,255,255,.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,.2);
        }

        /* SHORT SCREEN OPTIMIZATION */
        @media (max-height: 750px) {
            .compact-y {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }
        }
    </style>
</head>

<body class="antialiased">

<div class="min-h-screen flex items-start lg:items-center justify-center px-4 py-4">

    <!-- MAIN CARD -->
    <div class="w-full max-w-6xl bg-white rounded-2xl card-shadow overflow-hidden
                max-h-[100vh] lg:max-h-[92vh]">

        <div class="flex flex-col lg:flex-row h-full">

            <!-- LEFT PANEL -->
            <div class="lg:w-2/5 gradient-bg text-white px-6 py-6 sm:px-8 sm:py-8 compact-y flex-shrink-0">

                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-emerald-700 text-xl font-bold">M</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Makamithi</h1>
                        <p class="text-emerald-100 text-xs">SACCO</p>
                    </div>
                </div>

                <h2 class="text-[1.6rem] sm:text-3xl lg:text-[2.1rem] font-light leading-snug mb-6">
                    Empowering Employees Through
                    <span class="font-semibold">Financial Solutions</span>
                </h2>

                <div class="space-y-3">
                    <div class="flex items-center space-x-3 p-3 rounded-xl glass">
                        <i class="fas fa-users"></i>
                        <div>
                            <p class="font-medium">Employee Access</p>
                            <p class="text-xs text-emerald-100">Staff-only portal</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 p-3 rounded-xl glass">
                        <i class="fas fa-piggy-bank"></i>
                        <div>
                            <p class="font-medium">Savings & Loans</p>
                            <p class="text-xs text-emerald-100">Flexible terms</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 p-3 rounded-xl glass">
                        <i class="fas fa-shield-alt"></i>
                        <div>
                            <p class="font-medium">Secure Platform</p>
                            <p class="text-xs text-emerald-100">Regulated & safe</p>
                        </div>
                    </div>
                </div>

                <p class="mt-6 text-xs text-emerald-100">
                    © {{ date('Y') }} Makamithi SACCO
                </p>
            </div>

            <!-- RIGHT PANEL -->
            <div class="lg:w-3/5 px-6 py-6 sm:px-8 sm:py-8 compact-y
                        flex items-center justify-center overflow-y-auto">

                @auth
                    <!-- AUTH VIEW -->
                    <div class="w-full max-w-md text-center space-y-6">

                        <div class="w-20 h-20 mx-auto rounded-full bg-emerald-600 text-white
                                    flex items-center justify-center text-2xl font-bold">
                            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">
                                Welcome back,
                            </h3>
                            <p class="text-emerald-600 text-lg font-medium">
                                {{ auth()->user()->name }}
                            </p>
                        </div>

                        <a href="{{ route('dashboard') }}"
                           class="block w-full accent-gradient text-white py-3 rounded-xl font-semibold">
                            Continue to Dashboard
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-sm text-gray-500 hover:text-orange-600">
                                Switch account
                            </button>
                        </form>
                    </div>

                @else
                    <!-- LOGIN VIEW -->
                    <div class="w-full max-w-md space-y-6">

                        <div>
                            <h3 class="text-2xl font-semibold text-gray-800 mb-2">
                                Welcome to Makamithi SACCO
                            </h3>
                            <p class="text-gray-600 text-sm">
                                Login using your employee credentials.
                            </p>
                        </div>

                        <a href="{{ route('login') }}"
                           class="block w-full accent-gradient text-white py-3 rounded-xl
                                  font-semibold text-center">
                            Login to Your Account
                        </a>

                        <div class="grid grid-cols-2 gap-3">
                            <a href="#" class="border rounded-lg py-2 text-sm text-center">
                                Help Center
                            </a>
                            <a href="#" class="border rounded-lg py-2 text-sm text-center">
                                User Guide
                            </a>
                        </div>
                    </div>
                @endauth
            </div>

        </div>
    </div>
</div>

<footer class="hidden sm:block text-center text-xs text-gray-400 py-3">
    Regulated by SASRA • Secured Platform
</footer>

</body>
</html>
