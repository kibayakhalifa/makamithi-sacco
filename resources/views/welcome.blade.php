<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makamithi Sacco | Employee Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background-color: #f9fafb;
        }
        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }
    </style>
</head>

<body class="antialiased">
    <div class="container mx-auto px-4 min-h-screen flex flex-col justify-center items-center py-10">

        <!-- Main Card -->
        <div class="w-full max-w-5xl bg-white rounded-2xl card-shadow overflow-hidden">
            <div class="flex flex-col lg:flex-row">

                <!-- LEFT PANEL -->
                <div class="lg:w-2/5 bg-gray-900 text-white p-10 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center space-x-3 mb-8">
                            <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                                <span class="text-gray-900 text-2xl font-bold">M</span>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold tracking-tight">Makamithi</h1>
                                <p class="text-gray-300 text-sm">SACCO</p>
                            </div>
                        </div>

                        <h2 class="text-3xl font-light mb-6 leading-tight">
                            Employee Savings & Credit Cooperative Society
                        </h2>

                        <div class="space-y-4 mt-8">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center">👥</div>
                                <span class="text-gray-300">Employees Only</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center">💰</div>
                                <span class="text-gray-300">Mandatory Membership</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center">🏛️</div>
                                <span class="text-gray-300">Makamithi Enterprises</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 pt-6 border-t border-gray-800">
                        <p class="text-gray-400 text-sm">
                            © {{ date('Y') }} Makamithi Sacco. All rights reserved.<br>
                            For authorized employees only.
                        </p>
                    </div>
                </div>

                <!-- RIGHT PANEL -->
                <div class="lg:w-3/5 p-10 flex flex-col justify-center overflow-auto">

                    @auth
                        <!-- Logged-in View -->
                        <div class="text-center mb-8">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                                <span class="text-2xl text-gray-700">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                            <h3 class="text-2xl font-medium text-gray-800 mb-2">Welcome back</h3>
                            <p class="text-gray-600">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ ucfirst(auth()->user()->role) }} Account</p>
                        </div>

                        <div class="space-y-4">
                            <a href="{{ route('dashboard') }}"
                               class="block w-full bg-gray-900 hover:bg-gray-800 text-white text-center py-4 rounded-lg font-medium transition">
                                Continue to Dashboard →
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="text-center">
                                @csrf
                                <button type="submit"
                                        class="text-gray-500 hover:text-gray-700 text-sm transition">
                                    Not you? Switch account
                                </button>
                            </form>
                        </div>

                    @else
                        <!-- Login View -->
                        <div class="mb-10">
                            <h3 class="text-3xl font-light text-gray-800 mb-2">Employee Portal</h3>
                            <p class="text-gray-600">
                                Access your SACCO account using your company credentials.
                            </p>
                        </div>

                        <div class="space-y-6">
                            <a href="{{ route('login') }}"
                               class="block w-full bg-gray-900 hover:bg-gray-800 text-white text-center py-4 rounded-lg font-medium transition text-lg">
                                Login
                            </a>
                        </div>

                        <div class="mt-12 pt-8 border-t border-gray-100">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-600 text-center">
                                    <span class="font-medium">Need access?</span><br>
                                    Contact HR at Makamithi Enterprises.
                                </p>
                            </div>
                        </div>
                    @endauth

                </div>
            </div>
        </div>

        <!-- Bottom Notice -->
        <div class="mt-6 text-center px-4">
            <p class="text-gray-400 text-sm">
                This portal is restricted to Makamithi Enterprises employees only.<br>
                Unauthorized access is strictly prohibited.
            </p>
        </div>
    </div>
</body>
</html>
