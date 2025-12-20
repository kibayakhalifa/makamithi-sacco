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

        /* Form input styling */
        .form-input-custom {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            padding: 0.625rem 0.75rem;
            width: 100%;
            font-size: 0.875rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        
        .form-input-custom:focus {
            outline: none;
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }
        
        .form-input-custom:focus-within {
            border-color: #059669;
        }

        /* SHORT SCREEN OPTIMIZATION */
        @media (max-height: 750px) {
            .compact-y {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }
        }
        
        /* Login button styling */
        .login-btn {
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            padding: 0.625rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
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
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        /* Checkbox styling */
        .checkbox-custom {
            border-radius: 0.25rem;
            border: 1px solid #d1d5db;
            width: 1rem;
            height: 1rem;
            cursor: pointer;
        }
        
        .checkbox-custom:checked {
            background-color: #059669;
            border-color: #059669;
        }
    </style>
</head>

<body class="antialiased">

<div class="min-h-screen flex items-start lg:items-center justify-center px-4 py-4">

    <!-- MAIN CARD -->
    <div class="w-full max-w-6xl bg-white rounded-2xl card-shadow overflow-hidden
                max-h-[100vh] lg:max-h-[92vh]">

        <div class="flex flex-col lg:flex-row h-full">

            <!-- LEFT PANEL: Welcome/Hero Section -->
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
                            <p class="text-xs text-emerald-100">Restricted to authorized personnel</p>
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

            <!-- RIGHT PANEL: Login Form -->
            <div class="lg:w-3/5 px-6 py-6 sm:px-8 sm:py-8 compact-y
                        flex items-center justify-center overflow-y-auto">

                @auth
                    <!-- AUTH VIEW: Already logged in -->
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
                           class="block w-full accent-gradient text-white py-3 rounded-xl font-semibold hover:opacity-90 transition">
                            Continue to Dashboard
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-orange-600">
                                Switch account
                            </button>
                        </form>
                    </div>

                @else
                    <!-- LOGIN VIEW: Regular Laravel Form -->
                    <div class="w-full max-w-md space-y-6">
                        <div>
                            <h3 class="text-2xl font-semibold text-gray-800 mb-2">
                                Welcome to Makamithi SACCO
                            </h3>
                            <p class="text-gray-600 text-sm">
                                Login using your employee credentials.
                            </p>
                        </div>

                        <!-- Session Status Messages -->
                        @if(session('status'))
                            <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm">
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
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
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
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
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
                            <div class="flex items-center mb-6">
                                <input 
                                    id="remember" 
                                    type="checkbox" 
                                    name="remember"
                                    class="checkbox-custom mr-2"
                                >
                                <label for="remember" class="text-sm text-gray-600">
                                    Remember me
                                </label>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-between">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" 
                                       class="text-sm text-gray-600 hover:text-gray-900 underline">
                                        Forgot your password?
                                    </a>
                                @endif

                                <button type="submit" class="login-btn">
                                    Log in
                                </button>
                            </div>
                        </form>

                        <!-- Help Links -->
                        <div class="grid grid-cols-2 gap-3 pt-6 border-t">
                            <a href="#" class="border border-gray-200 rounded-lg py-2.5 text-sm text-center hover:bg-gray-50 transition flex items-center justify-center">
                                <i class="fas fa-question-circle mr-2 text-gray-500"></i>
                                <span>Help Center</span>
                            </a>
                            <a href="#" class="border border-gray-200 rounded-lg py-2.5 text-sm text-center hover:bg-gray-50 transition flex items-center justify-center">
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

<footer class="hidden sm:block text-center text-xs text-gray-400 py-3">
    Regulated by SASRA • Secured Platform • © {{ date('Y') }} Makamithi SACCO
</footer>

</body>
</html>