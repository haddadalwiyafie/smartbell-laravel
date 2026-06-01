<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartBell</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen font-sans">

{{-- Sidebar --}}
<aside class="fixed left-0 top-0 h-full w-[120px] bg-white border-r border-gray-100 flex flex-col z-40">

    {{-- Logo --}}
    <div class="px-4 py-5 border-b border-gray-100">
        <span class="block text-[#C0001D] font-bold text-sm leading-tight">SmartBell</span>
        <span class="block text-[10px] text-gray-400 mt-0.5">System Online</span>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 flex flex-col gap-1 px-2 py-4">
        <a href="{{ route('dashboard') }}"
           class="flex flex-col items-center gap-1.5 px-2 py-3 rounded-lg text-[10px] font-medium transition-colors
                  {{ request()->routeIs('dashboard') ? 'bg-[#C0001D] text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
            </svg>
            Dashboard
        </a>
        <a href="{{ route('schedule') }}"
           class="flex flex-col items-center gap-1.5 px-2 py-3 rounded-lg text-[10px] font-medium transition-colors
                  {{ request()->routeIs('schedule') ? 'bg-[#C0001D] text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Schedule
        </a>
        <a href="{{ route('audio') }}"
           class="flex flex-col items-center gap-1.5 px-2 py-3 rounded-lg text-[10px] font-medium transition-colors
                  {{ request()->routeIs('audio') ? 'bg-[#C0001D] text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
            </svg>
            Audio Library
        </a>
        <a href="{{ route('settings') }}"
           class="flex flex-col items-center gap-1.5 px-2 py-3 rounded-lg text-[10px] font-medium transition-colors
                  {{ request()->routeIs('settings') ? 'bg-[#C0001D] text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
            </svg>
            Settings
        </a>
    </nav>

    {{-- Emergency Bell --}}
    <div class="px-3 pb-4">
        <button class="w-full bg-[#C0001D] hover:bg-[#a0001a] text-white text-[9px] font-bold uppercase tracking-wide py-3 px-2 rounded-lg flex flex-col items-center gap-1 transition-colors">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            Trigger Emergency Bell
        </button>
    </div>

    {{-- Bottom Links --}}
    <div class="border-t border-gray-100 px-2 py-3 flex flex-col gap-1">
        <a href="#" class="flex flex-col items-center gap-1 px-2 py-2 rounded-lg text-[10px] text-gray-400 hover:text-gray-600 hover:bg-gray-50 transition-colors">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            Help
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex flex-col items-center gap-1 px-2 py-2 rounded-lg text-[10px] text-gray-400 hover:text-gray-600 hover:bg-gray-50 transition-colors">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                    <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>

{{-- Main Content --}}
<div class="ml-[120px] pb-14 bg-gray-50 min-h-screen">
    @if(session('success'))
        <div class="mx-6 mt-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif
    {{ $slot }}
</div>

{{-- Footer Bar --}}
<div class="fixed bottom-0 left-[120px] right-0 h-10 bg-[#C0001D] flex items-center justify-between px-6 z-30">
    <span class="text-xs font-medium text-white/90">
        @if(isset($_nextBell) && $_nextBell)
            Next Bell: {{ $_nextBell->name }} ({{ \Carbon\Carbon::createFromFormat('H:i:s', $_nextBell->time)->format('h:i A') }})
        @else
            No upcoming bells
        @endif
    </span>
    <div class="flex gap-4">
        <a href="#" class="text-[11px] text-white/60 hover:text-white transition-colors">Privacy Policy</a>
        <a href="#" class="text-[11px] text-white/60 hover:text-white transition-colors">Support</a>
    </div>
</div>

</body>
</html>
