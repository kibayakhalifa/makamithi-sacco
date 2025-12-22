<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Makamithi Sacco | Employee Portal</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            min-height: 100vh;
        }

        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0,0,0,.08),
                        0 5px 15px -3px rgba(0,0,0,.04);
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

        /* Form input styling */
        .form-input-custom {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            padding: 0.75rem;
            width: 100%;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        
        .form-input-custom:focus {
            outline: none;
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }
        
        /* Login button styling */
        .login-btn {
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
        }
        
        .login-btn:hover {
            background: linear-gradient(135deg, #ea580c, #c2410c);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(234, 88, 12, 0.2);
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        /* Error message styling */
        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        /* Checkbox styling */
        .checkbox-custom {
            border-radius: 0.25rem;
            border: 1px solid #d1d5db;
            width: 1.25rem;
            height: 1.25rem;
            cursor: pointer;
            flex-shrink: 0;
        }
        
        .checkbox-custom:checked {
            background-color: #059669;
            border-color: #059669;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .mobile-stack {
                flex-direction: column !important;
            }
            
            .mobile-full-width {
                width: 100% !important;
                max-width: 100% !important;
            }
            
            .mobile-p-4 {
                padding: 1rem !important;
            }
            
            .mobile-p-5 {
                padding: 1.25rem !important;
            }
            
            .mobile-text-center {
                text-align: center !important;
            }
            
            .mobile-space-y-4 > * + * {
                margin-top: 1rem !important;
            }
            
            .mobile-btn-lg {
                padding: 0.875rem !important;
                font-size: 1rem !important;
            }
            
            .mobile-h-auto {
                height: auto !important;
                min-height: auto !important;
            }
            
            .mobile-overflow-visible {
                overflow: visible !important;
            }
            
            .mobile-mt-3 {
                margin-top: 0.75rem !important;
            }
            
            .mobile-gap-2 {
                gap: 0.5rem !important;
            }
        }

        /* Small mobile devices (phones) */
        @media (max-width: 480px) {
            .mobile-sm-p-3 {
                padding: 0.75rem !important;
            }
            
            .mobile-sm-text-lg {
                font-size: 1.5rem !important;
            }
            
            .mobile-sm-text-sm {
                font-size: 0.875rem !important;
            }
            
            .mobile-sm-hide {
                display: none !important;
            }
            
            .form-input-custom {
                padding: 0.875rem !important;
                font-size: 1rem !important;
            }
            
            .login-btn {
                padding: 1rem !important;
                font-size: 1.125rem !important;
            }
        }

        /* Very small screens */
        @media (max-height: 600px) and (max-width: 768px) {
            .mobile-compact {
                padding-top: 0.5rem !important;
                padding-bottom: 0.5rem !important;
            }
            
            .mobile-compact .mobile-sm-hide {
                display: none !important;
            }
        }
    </style>
</head>

<body class="antialiased">

<div class="min-h-screen flex items-start justify-center px-4 py-4 md:px-6 md:py-6 mobile-p-4">
    <!-- MAIN CARD -->
    <div class="w-full max-w-6xl bg-white rounded-2xl card-shadow overflow-hidden mobile-full-width mobile-h-auto mobile-overflow-visible">

        <div class="flex flex-col lg:flex-row h-full mobile-stack">
            <!-- LEFT PANEL: Welcome/Hero Section -->
            <div class="lg:w-2/5 gradient-bg text-white px-6 py-6 sm:px-8 sm:py-8 mobile-full-width mobile-p-5 mobile-compact">
                <div class="flex items-center space-x-4 mb-6 mobile-mt-3">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-emerald-700 text-xl font-bold">M</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Makamithi</h1>
                        <p class="text-emerald-100 text-xs">SACCO</p>
                    </div>
                </div>

                <h2 class="text-xl sm:text-2xl md:text-[1.6rem] lg:text-[2.1rem] font-light leading-snug mb-6 mobile-text-center mobile-sm-text-lg">
                    Empowering Employees Through
                    <span class="font-semibold block mt-2">Financial Solutions</span>
                </h2>

                <div class="space-y-3 mobile-space-y-4 mobile-sm-hide">
                    <div class="flex items-center space-x-3 p-3 rounded-xl glass">
                        <i class="fas fa-users text-lg"></i>
                        <div>
                            <p class="font-medium">Employee Access</p>
                            <p class="text-xs text-emerald-100">Restricted to authorized personnel</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 p-3 rounded-xl glass">
                        <i class="fas fa-piggy-bank text-lg"></i>
                        <div>
                            <p class="font-medium">Savings & Loans</p>
                            <p class="text-xs text-emerald-100">Flexible terms</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 p-3 rounded-xl glass">
                        <i class="fas fa-shield-alt text-lg"></i>
                        <div>
                            <p class="font-medium">Secure Platform</p>
                            <p class="text-xs text-emerald-100">Regulated & safe</p>
                        </div>
                    </div>
                </div>

                <p class="mt-6 text-xs text-emerald-100 mobile-text-center mobile-sm-text-sm">
                    © {{ date('Y') }} Makamithi SACCO
                </p>
            </div>

            <!-- RIGHT PANEL: Login Form -->
            <div class="lg:w-3/5 px-6 py-6 sm:px-8 sm:py-8 mobile-full-width mobile-p-5 flex items-center justify-center mobile-h-auto mobile-overflow-visible">

                @auth
                    <!-- AUTH VIEW: Already logged in -->
                    <div class="w-full max-w-md text-center space-y-6 mobile-full-width">
                        <div class="w-20 h-20 mx-auto rounded-full bg-emerald-600 text-white flex items-center justify-center text-2xl font-bold">
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
                           class="block w-full accent-gradient text-white py-3 rounded-xl font-semibold hover:opacity-90 transition mobile-btn-lg">
                            Continue to Dashboard
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-orange-600 w-full py-2">
                                Switch account
                            </button>
                        </form>
                    </div>

                @else
                    <!-- LOGIN VIEW: Regular Laravel Form -->
                    <div class="w-full max-w-md space-y-6 mobile-full-width">
                        <div class="mobile-text-center">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-2 mobile-sm-text-lg">
                                Welcome to Makamithi SACCO
                            </h3>
                            <p class="text-gray-600 text-sm mobile-sm-text-sm">
                                Login using your employee credentials.
                            </p>
                        </div>

                        <!-- Session Status Messages -->
                        @if(session('status'))
                            <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm mobile-text-center">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="mb-4 p-3 bg-red-50 text-red-700 rounded-lg text-sm">
                                @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}" class="space-y-4">
                            @csrf

                            <!-- Email Address -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1 mobile-sm-text-sm">
                                    Email Address
                                </label>
                                <input 
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email') }}"
                                    required 
                                    autofocus 
                                    autocomplete="email"
                                    class="form-input-custom"
                                    placeholder="Enter your email address"
                                >
                                @error('email')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1 mobile-sm-text-sm">
                                    Password
                                </label>
                                <input 
                                    id="password" 
                                    type="password" 
                                    name="password" 
                                    required 
                                    autocomplete="current-password"
                                    class="form-input-custom"
                                    placeholder="Enter your password"
                                >
                                @error('password')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center">
                                <input 
                                    id="remember" 
                                    type="checkbox" 
                                    name="remember"
                                    class="checkbox-custom mr-2"
                                >
                                <label for="remember" class="text-sm text-gray-600 mobile-sm-text-sm">
                                    Remember me
                                </label>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mobile-gap-2">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" 
                                       class="text-sm text-gray-600 hover:text-gray-900 underline w-full sm:w-auto text-center sm:text-left mobile-sm-text-sm">
                                        Forgot your password?
                                    </a>
                                @endif

                                <button type="submit" class="login-btn mobile-btn-lg">
                                    Log in
                                </button>
                            </div>
                        </form>

                        <!-- Help Links -->
                        <div class="grid grid-cols-2 gap-3 pt-6 border-t mobile-gap-2">
                            <a href="#" class="border border-gray-200 rounded-lg py-2.5 text-sm text-center hover:bg-gray-50 transition flex items-center justify-center mobile-sm-text-sm">
                                <i class="fas fa-question-circle mr-2 text-gray-500"></i>
                                <span>Help Center</span>
                            </a>
                            <a href="#" class="border border-gray-200 rounded-lg py-2.5 text-sm text-center hover:bg-gray-50 transition flex items-center justify-center mobile-sm-text-sm">
                                <i class="fas fa-book mr-2 text-gray-500"></i>
                                <span>User Guide</span>
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>

<footer class="text-center text-xs text-gray-400 py-3 px-4 mobile-sm-text-sm mobile-text-center">
    Regulated by SASRA • Secured Platform • © {{ date('Y') }} Makamithi SACCO
</footer>

</body>
</html>