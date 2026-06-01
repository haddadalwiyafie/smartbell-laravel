<x-layout>

<div class="p-6 grid grid-cols-[420px_1fr] gap-5">

    {{-- Next Bell Card --}}
    <div class="bg-[#C0001D] rounded-xl p-6 flex flex-col text-white">
        <p class="text-xs font-medium text-red-200 mb-1">Next Bell</p>
        @if($next)
            <p class="text-sm font-semibold text-white/90 mb-6">{{ $next->name }}</p>
        @else
            <p class="text-sm font-semibold text-white/90 mb-6">No upcoming bell</p>
        @endif

        <div class="flex-1 flex items-center justify-center flex-col">
            <span class="text-6xl font-bold tabular-nums tracking-tight">
                @if($next)
                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $next->time)->format('h:i') }}
                @else
                    --:--
                @endif
            </span>
            <span class="text-xs text-red-200 mt-2">Minutes until trigger</span>
        </div>

        <div class="flex gap-3 mt-6">
            <button class="flex-1 flex items-center justify-center gap-2 bg-white/15 hover:bg-white/25 border border-white/30 text-white text-sm font-medium py-2.5 px-4 rounded-lg transition-colors">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                Play Now
            </button>
            <button class="flex-1 flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 border border-white/30 text-white text-sm font-medium py-2.5 px-4 rounded-lg transition-colors">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="5 4 15 12 5 20 5 4"/><line x1="19" y1="5" x2="19" y2="19"/>
                </svg>
                Skip
            </button>
        </div>
    </div>

    {{-- Today's Overview --}}
    <div class="bg-white rounded-xl border border-gray-100 p-6 flex flex-col">
        <div class="flex items-start justify-between mb-6">
            <h2 class="text-base font-semibold text-gray-800">Today's Overview</h2>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-300">
                <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 01-3.46 0"/>
            </svg>
        </div>

        <div class="flex gap-10 mb-6">
            <div>
                <p class="text-4xl font-bold text-[#C0001D]">{{ $total }}</p>
                <p class="text-xs text-gray-400 mt-1">Total Bells Scheduled</p>
            </div>
            <div>
                <p class="text-4xl font-bold text-gray-700">{{ $remaining }}</p>
                <p class="text-xs text-gray-400 mt-1">Bells Remaining</p>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-4">
            <div class="flex items-center gap-2">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C0001D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span class="text-xs text-gray-500">Regular Day Schedule active</span>
            </div>
        </div>
    </div>

</div>

{{-- Bell Schedule Table --}}
<div class="px-6 pb-6">
    <div class="bg-white rounded-xl border border-gray-100">

        {{-- Table Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-800">Bell Schedule</h2>
            <a href="{{ route('schedule') }}" class="flex items-center gap-1.5 text-xs text-[#C0001D] hover:text-[#a0001a] font-medium transition-colors">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit Schedule
            </a>
        </div>

        {{-- Column Headers --}}
        <div class="grid grid-cols-[2fr_1fr_2fr_1fr] px-6 py-3 border-b border-gray-50">
            @foreach(['Period','Time','Sound/Tone Name','Status'] as $col)
                <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">{{ $col }}</span>
            @endforeach
        </div>

        {{-- Rows --}}
        <div class="divide-y divide-gray-50">
            @foreach($periods as $period)
            @php $isNext = $period->status === 'Next'; @endphp
            <div class="grid grid-cols-[2fr_1fr_2fr_1fr] items-center px-6 py-4 transition-colors {{ $isNext ? 'bg-red-50/60' : 'hover:bg-gray-50/60' }}">
                <span class="text-sm font-medium {{ $isNext ? 'text-[#C0001D]' : 'text-gray-700' }}">
                    {{ $period->name }}
                </span>
                <span class="text-sm tabular-nums {{ $isNext ? 'text-[#C0001D] font-semibold' : 'text-gray-500' }}">
                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $period->time)->format('h:i A') }}
                </span>
                <span class="text-sm text-gray-600">{{ $period->sound }}</span>
                <div>
                    @if($period->status === 'Played')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-500">Played</span>
                    @elseif($period->status === 'Next')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#C0001D] text-white">
                            <span class="w-1.5 h-1.5 rounded-full bg-white mr-1.5 animate-pulse"></span>Next
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-gray-50 text-gray-400 border border-gray-200">Pending</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>

</x-layout>
