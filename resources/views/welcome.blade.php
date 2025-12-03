<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makamithi Sacco</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-4xl mx-auto px-4">
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-blue-800 mb-4">Makamithi Sacco</h1>
            <p class="text-xl text-gray-600">Employee Savings & Credit Cooperative Society</p>
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Welcome to Our SACCO System</h2>
                    <p class="text-gray-600 mb-6">
                        A comprehensive management system for Makamithi Enterprises employees' 
                        savings, loans, and financial cooperatives.
                    </p>
                    
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center">
                            <span class="text-green-500 mr-3">✅</span>
                            <span>Track savings contributions</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-3">✅</span>
                            <span>Apply for loans with 5% fixed interest</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-3">✅</span>
                            <span>Role-based access for all stakeholders</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-3">✅</span>
                            <span>Real-time financial reporting</span>
                        </div>
                    </div>
                    
                    @if(auth()->check())
                        <div class="bg-blue-50 p-4 rounded-lg mb-6">
                            <p class="text-blue-800 font-semibold">You are logged in as:</p>
                            <p class="text-lg">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</p>
                        </div>
                        
                        <a href="{{ route('dashboard') }}" 
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-lg font-semibold text-lg transition duration-300">
                            Go to My Dashboard →
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-800">
                                Not you? Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-lg font-semibold text-lg transition duration-300">
                            Login to Dashboard
                        </a>
                        
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600 mb-2">Test Accounts:</p>
                            <div class="grid grid-cols-2 gap-2 text-left">
                                <div class="text-xs">
                                    <span class="font-semibold">Member:</span><br>
                                    member@makamithi.com<br>
                                    password
                                </div>
                                <div class="text-xs">
                                    <span class="font-semibold">Chairman:</span><br>
                                    chairman@makamithi.com<br>
                                    password
                                </div>
                                <div class="text-xs">
                                    <span class="font-semibold">Treasurer:</span><br>
                                    treasurer@makamithi.com<br>
                                    password
                                </div>
                                <div class="text-xs">
                                    <span class="font-semibold">Secretary:</span><br>
                                    secretary@makamithi.com<br>
                                    password
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="hidden md:block">
                    <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl p-2">
                        <div class="bg-white rounded-lg p-6">
                            <div class="text-center mb-6">
                                <div class="text-6xl mb-4">🏦</div>
                                <h3 class="text-xl font-bold text-gray-800">SACCO Features</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                        <span class="text-blue-600">💰</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold">Savings Management</h4>
                                        <p class="text-sm text-gray-600">Track contributions & withdrawals</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-3 bg-green-50 rounded-lg">
                                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                                        <span class="text-green-600">📝</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold">Loan Processing</h4>
                                        <p class="text-sm text-gray-600">5% fixed interest rate</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-3 bg-purple-50 rounded-lg">
                                    <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                        <span class="text-purple-600">👥</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold">Member Portal</h4>
                                        <p class="text-sm text-gray-600">Employee self-service</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-3 bg-yellow-50 rounded-lg">
                                    <div class="bg-yellow-100 p-2 rounded-lg mr-3">
                                        <span class="text-yellow-600">📊</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold">Financial Reports</h4>
                                        <p class="text-sm text-gray-600">Real-time analytics</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-8 text-gray-500 text-sm">
            <p>Makamithi Enterprises Limited Employee SACCO • Version 1.0.0</p>
            <p class="mt-2">For demonstration purposes only</p>
        </div>
    </div>
</body>
</html>