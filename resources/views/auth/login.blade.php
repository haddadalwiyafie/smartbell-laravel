<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartBell – Sign In</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6 font-sans">

<div class="w-full max-w-sm">

    {{-- Brand --}}
    <div class="flex flex-col items-center mb-8">
        <div class="w-12 h-12 rounded-xl bg-[#C0001D] flex items-center justify-center mb-3">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 01-3.46 0"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-[#C0001D] tracking-tight">SmartBell</h1>
        <div class="flex items-center gap-1.5 mt-1">
            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
            <span class="text-xs text-gray-400">System Online</span>
        </div>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-7">
        <h2 class="text-lg font-bold text-gray-800">Welcome back</h2>
        <p class="text-sm text-gray-400 mt-0.5 mb-6">Sign in to manage your bell schedule.</p>

        <form method="POST" action="{{ route('login') }}" id="login-form">
            @csrf

            {{-- Email --}}
            <label class="text-xs font-medium text-gray-500 mb-1.5 block">Email Address</label>
            <div class="relative mb-4">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="you@school.edu"
                       class="w-full rounded-lg border border-gray-200 bg-gray-50/60 pl-9 pr-3 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:border-[#C0001D] focus:bg-white transition-colors @error('email') border-red-400 @enderror">
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <label class="text-xs font-medium text-gray-500 mb-1.5 block">Password</label>
            <div class="relative">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0110 0v4"/>
                </svg>
                <input type="password" name="password" id="pw-field" required
                       placeholder="••••••••"
                       class="w-full rounded-lg border border-gray-200 bg-gray-50/60 pl-9 pr-10 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:border-[#C0001D] focus:bg-white transition-colors">
                <button type="button" id="pw-toggle"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg id="eye-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>

            {{-- Remember + Forgot --}}
            <div class="flex items-center justify-between mt-4">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 accent-[#C0001D] cursor-pointer">
                    <span class="text-xs text-gray-500">Remember me</span>
                </label>
                <a href="#" class="text-xs font-medium text-[#C0001D] hover:text-[#a0001a] transition-colors">Forgot password?</a>
            </div>

            {{-- Submit --}}
            <button type="submit" id="submit-btn"
                    class="w-full mt-6 bg-gray-300 cursor-not-allowed text-white text-sm font-semibold py-2.5 rounded-lg transition-colors">
                Sign In
            </button>
        </form>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">© {{ date('Y') }} SmartBell. All rights reserved.</p>
</div>

<script>
// Show/hide password
const pwField = document.getElementById('pw-field');
const pwToggle = document.getElementById('pw-toggle');
pwToggle.addEventListener('click', () => {
    pwField.type = pwField.type === 'password' ? 'text' : 'password';
});

// Enable button only when both fields filled
const emailField = document.querySelector('[name="email"]');
const submitBtn = document.getElementById('submit-btn');
function checkForm() {
    const filled = emailField.value.trim() !== '' && pwField.value !== '';
    submitBtn.className = filled
        ? 'w-full mt-6 bg-[#C0001D] hover:bg-[#a0001a] text-white text-sm font-semibold py-2.5 rounded-lg transition-colors cursor-pointer'
        : 'w-full mt-6 bg-gray-300 cursor-not-allowed text-white text-sm font-semibold py-2.5 rounded-lg transition-colors';
    submitBtn.disabled = !filled;
}
emailField.addEventListener('input', checkForm);
pwField.addEventListener('input', checkForm);
</script>

</body>
</html>
