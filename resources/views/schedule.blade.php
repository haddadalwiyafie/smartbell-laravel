<x-layout>

<div class="p-6">

    {{-- Header --}}
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Weekly Schedule</h1>
            <p class="text-sm text-gray-400 mt-1">Manage bell timings, assigned audio, and active days.</p>
        </div>
        <button onclick="openAdd()"
                class="flex items-center gap-2 bg-gray-700 hover:bg-gray-800 text-white text-sm font-medium py-2.5 px-4 rounded-lg transition-colors shrink-0">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add New Bell
        </button>
    </div>

    {{-- Panel --}}
    <div class="bg-white rounded-xl border border-gray-100 mt-6">

        {{-- Toolbar --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div class="flex gap-1 bg-gray-100 rounded-lg p-1">
                <button id="btn-list" onclick="setView('list')"
                        class="flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-md transition-colors bg-white text-gray-800 shadow-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
                        <line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/>
                        <line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
                    </svg>
                    List View
                </button>
                <button id="btn-cal" onclick="setView('calendar')"
                        class="flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-md transition-colors text-gray-500 hover:text-gray-700">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Calendar
                </button>
            </div>

            <form method="GET" action="{{ route('schedule') }}">
                <select name="day" onchange="this.form.submit()"
                        class="rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 focus:outline-none focus:border-[#C0001D] transition-colors">
                    @foreach($days as $day)
                        <option value="{{ $day }}" {{ $dayFilter === $day ? 'selected' : '' }}>{{ $day }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- List View --}}
        <div id="view-list">
            @forelse($schedules as $s)
            @php
                $isInactive = $s->status === 'Inactive';
                $displayTime = \Carbon\Carbon::createFromFormat('H:i:s', $s->time)->format('h:i');
                $meridiem = (int)\Carbon\Carbon::createFromFormat('H:i:s', $s->time)->format('H') >= 12 ? 'PM' : 'AM';
                $days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
                $dayLabels = ['Mon'=>'M','Tue'=>'T','Wed'=>'W','Thu'=>'T','Fri'=>'F','Sat'=>'S','Sun'=>'S'];
            @endphp
            <div class="flex items-center gap-5 px-6 py-5 border-b border-gray-100 transition-colors {{ $isInactive ? 'bg-gray-50/60' : 'hover:bg-gray-50/40' }}">

                {{-- Time --}}
                <div class="w-20 shrink-0">
                    <p class="text-2xl font-bold tabular-nums leading-none {{ $isInactive ? 'text-gray-400' : 'text-gray-800' }}">{{ $displayTime }}</p>
                    <p class="text-xs font-medium text-gray-400 mt-1">{{ $meridiem }}</p>
                </div>

                {{-- Divider --}}
                <div class="w-px self-stretch bg-gray-200"></div>

                {{-- Title + Audio --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold {{ $isInactive ? 'text-gray-400' : 'text-gray-800' }}">{{ $s->title }}</p>
                    <div class="flex items-center gap-1.5 mt-1">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-300 shrink-0">
                            <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
                        </svg>
                        <span class="text-xs text-gray-400 truncate">{{ $s->audio_file }}</span>
                    </div>
                </div>

                {{-- Day Pills --}}
                <div class="flex items-center gap-1.5">
                    @foreach($days as $d)
                        <span class="w-7 h-7 rounded-full flex items-center justify-center text-[11px] font-semibold
                            {{ in_array($d, $s->days)
                                ? ($isInactive ? 'bg-red-50 text-[#C0001D]/60' : 'bg-red-100 text-[#C0001D]')
                                : 'bg-gray-100 text-gray-300' }}">
                            {{ $dayLabels[$d] }}
                        </span>
                    @endforeach
                </div>

                {{-- Status Badge --}}
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold shrink-0
                    {{ $isInactive ? 'bg-gray-100 text-gray-400' : 'bg-green-50 text-green-600' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $isInactive ? 'bg-gray-300' : 'bg-green-500' }}"></span>
                    {{ $s->status }}
                </span>

                {{-- Actions --}}
                <div class="flex items-center gap-3 shrink-0">
                    <button onclick="openEdit({{ $s->id }}, {{ json_encode($s->title) }}, '{{ \Carbon\Carbon::createFromFormat('H:i:s', $s->time)->format('H:i') }}', {{ json_encode($s->audio_file) }}, {{ json_encode($s->status) }}, {{ json_encode($s->days) }})"
                            class="text-gray-400 hover:text-[#C0001D] transition-colors">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                    <button onclick="requestDelete({{ $s->id }}, {{ json_encode($s->title) }})"
                            class="text-gray-400 hover:text-[#C0001D] transition-colors">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                            <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                    <form id="del-form-{{ $s->id }}" method="POST" action="{{ route('schedule.destroy', $s) }}" class="hidden">
                        @csrf @method('DELETE')
                    </form>
                </div>
            </div>
            @empty
            <p class="px-6 py-12 text-center text-sm text-gray-400">No bells scheduled.</p>
            @endforelse
        </div>

        {{-- Calendar View --}}
        <div id="view-calendar" class="hidden">
            <p class="px-6 py-16 text-center text-sm text-gray-400">Calendar view coming soon.</p>
        </div>

    </div>
</div>

{{-- Add / Edit Modal --}}
<div id="schedule-modal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
        {{-- Header --}}
        <div class="flex items-center gap-2 px-6 py-4 border-b border-gray-100">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C0001D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
            </svg>
            <h3 id="modal-title" class="text-base font-semibold text-gray-800">Add New Bell</h3>
        </div>

        <form id="schedule-form" method="POST" action="{{ route('schedule.store') }}" class="p-6 space-y-4">
            @csrf
            <span id="method-field"></span>
            <input type="hidden" name="edit_id" id="edit-id-field" value="">

            @if($errors->any())
            <div class="rounded-lg bg-red-50 border border-red-200 px-4 py-3">
                <p class="text-xs font-semibold text-red-700 mb-1">Please fix the following errors:</p>
                <ul class="text-xs text-red-600 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Status Banner --}}
            <div class="flex items-center justify-between rounded-lg bg-red-50/70 border-l-4 border-[#C0001D] px-4 py-3">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Schedule Status</p>
                    <p id="status-desc" class="text-xs text-gray-500 mt-0.5">Currently active and participating in the master schedule.</p>
                </div>
                {{-- Toggle --}}
                <button type="button" id="status-toggle" onclick="toggleActive()"
                        class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors bg-[#C0001D]">
                    <span id="toggle-knob" class="inline-block h-3.5 w-3.5 transform rounded-full bg-white transition-transform translate-x-4.5 translate-x-[18px]"></span>
                </button>
                <input type="hidden" name="status" id="status-input" value="Active">
            </div>

            {{-- Bell Name --}}
            <div>
                <label class="text-xs font-medium text-gray-500 mb-1.5 block">Bell Name</label>
                <input type="text" name="title" id="f-title" required
                       placeholder="e.g. Period 1 Warning"
                       class="w-full rounded-lg border border-gray-200 bg-gray-50/60 px-3 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:border-[#C0001D] focus:bg-white transition-colors">
            </div>

            {{-- Time + Audio --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-medium text-gray-500 mb-1.5 block">Time</label>
                    <input type="time" name="time_display" id="f-time" required
                           class="w-full rounded-lg border border-gray-200 bg-gray-50/60 px-3 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#C0001D] focus:bg-white transition-colors">
                    <input type="hidden" name="time" id="f-time-hidden">
                    <input type="hidden" name="meridiem" id="f-meridiem-hidden">
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500 mb-1.5 block">Audio Track</label>
                    <div class="relative">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
                        </svg>
                        <select name="audio_file" id="f-audio"
                                class="w-full appearance-none rounded-lg border border-gray-200 bg-gray-50/60 pl-9 pr-8 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#C0001D] focus:bg-white transition-colors">
                            <option value="" disabled selected>Select a track</option>
                            @foreach($audioTracks as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Active Days --}}
            <div>
                <label class="text-xs font-medium text-gray-500 mb-2 block">Active Days</label>
                <div class="flex gap-1.5">
                    @foreach(['Mon'=>'M','Tue'=>'T','Wed'=>'W','Thu'=>'T','Fri'=>'F','Sat'=>'S','Sun'=>'S'] as $code => $label)
                    <label class="cursor-pointer">
                        <input type="checkbox" name="days[]" value="{{ $code }}" class="sr-only peer day-check">
                        <span class="w-9 h-9 rounded-full flex items-center justify-center text-[11px] font-semibold border border-gray-200 bg-white
                                     peer-checked:bg-[#C0001D] peer-checked:text-white peer-checked:border-[#C0001D]
                                     hover:border-[#C0001D]/50 text-gray-400 transition-colors select-none">
                            {{ $label }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeModal()"
                        class="text-sm font-medium text-gray-500 hover:text-gray-700 px-3 py-2 transition-colors">Cancel</button>
                <button type="submit"
                        class="flex items-center gap-2 bg-[#C0001D] hover:bg-[#a0001a] text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09"/>
                    </svg>
                    Save Schedule
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Confirm --}}
<div id="delete-dialog" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-2">Delete Bell</h3>
        <p id="delete-msg" class="text-sm text-gray-500 mb-6"></p>
        <div class="flex justify-end gap-2">
            <button onclick="document.getElementById('delete-dialog').classList.add('hidden')"
                    class="text-sm font-medium text-gray-500 hover:text-gray-700 px-3 py-2 transition-colors">Cancel</button>
            <button id="delete-ok"
                    class="bg-[#C0001D] hover:bg-[#a0001a] text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors">
                Delete
            </button>
        </div>
    </div>
</div>

<script>
const ADD_ACTION = '{{ route('schedule.store') }}';
let activeStatus = true;

function setActiveStatus(isActive) {
    activeStatus = isActive;
    const toggle = document.getElementById('status-toggle');
    const knob   = document.getElementById('toggle-knob');
    const desc   = document.getElementById('status-desc');
    const input  = document.getElementById('status-input');
    toggle.className = 'relative inline-flex h-5 w-9 items-center rounded-full transition-colors ' + (isActive ? 'bg-[#C0001D]' : 'bg-gray-200');
    knob.className   = 'inline-block h-3.5 w-3.5 transform rounded-full bg-white transition-transform ' + (isActive ? 'translate-x-[18px]' : 'translate-x-[2px]');
    input.value      = isActive ? 'Active' : 'Inactive';
    desc.textContent = isActive
        ? 'Currently active and participating in the master schedule.'
        : 'Currently inactive. This bell will not ring.';
}

function toggleActive() { setActiveStatus(!activeStatus); }

function openAdd() {
    document.getElementById('modal-title').textContent = 'Add New Bell';
    document.getElementById('schedule-form').action = ADD_ACTION;
    document.getElementById('method-field').innerHTML = '';
    document.getElementById('edit-id-field').value = '';
    document.getElementById('f-title').value = '';
    document.getElementById('f-time').value = '';
    document.getElementById('f-audio').value = '';
    document.querySelectorAll('.day-check').forEach(cb => cb.checked = false);
    setActiveStatus(true);
    document.getElementById('schedule-modal').classList.remove('hidden');
}

function openEdit(id, title, time24, audio, status, days) {
    document.getElementById('modal-title').textContent = 'Edit Bell Schedule';
    document.getElementById('schedule-form').action = '/schedule/' + id;
    document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('edit-id-field').value = id;
    document.getElementById('f-title').value = title;
    document.getElementById('f-time').value = time24; // "HH:MM" 24-hour
    document.getElementById('f-audio').value = audio;
    document.querySelectorAll('.day-check').forEach(cb => { cb.checked = days.includes(cb.value); });
    setActiveStatus(status === 'Active');
    document.getElementById('schedule-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('schedule-modal').classList.add('hidden');
}

// Convert time input (HH:MM 24h) → hidden fields before submit
document.getElementById('schedule-form').addEventListener('submit', function() {
    const raw = document.getElementById('f-time').value; // "HH:MM" from <input type="time">
    if (raw) {
        const [h, m] = raw.split(':').map(Number);
        document.getElementById('f-time-hidden').value    = String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':00';
        document.getElementById('f-meridiem-hidden').value = h >= 12 ? 'PM' : 'AM';
    }
});

// View toggle
function setView(v) {
    document.getElementById('view-list').classList.toggle('hidden', v !== 'list');
    document.getElementById('view-calendar').classList.toggle('hidden', v !== 'calendar');
    document.getElementById('btn-list').className = v === 'list'
        ? 'flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-md transition-colors bg-white text-gray-800 shadow-sm'
        : 'flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-md transition-colors text-gray-500 hover:text-gray-700';
    document.getElementById('btn-cal').className = v === 'calendar'
        ? 'flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-md transition-colors bg-white text-gray-800 shadow-sm'
        : 'flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-md transition-colors text-gray-500 hover:text-gray-700';
}

// Delete confirm
let pendingDeleteId = null;
function requestDelete(id, title) {
    pendingDeleteId = id;
    document.getElementById('delete-msg').textContent = `Are you sure you want to delete "${title}"? This action cannot be undone.`;
    document.getElementById('delete-dialog').classList.remove('hidden');
}
document.getElementById('delete-ok').addEventListener('click', () => {
    if (pendingDeleteId) document.getElementById('del-form-' + pendingDeleteId).submit();
});

// Auto-reopen modal with old values after validation failure
@if($errors->any())
@php
    $oldDays   = old('days', []);
    $oldStatus = old('status', 'Active');
    $oldEditId = old('edit_id', '');
    $isEditRetry = old('_method') === 'PUT' && $oldEditId;
@endphp
(function() {
    @if($isEditRetry)
    document.getElementById('modal-title').textContent = 'Edit Bell Schedule';
    document.getElementById('schedule-form').action = '/schedule/{{ $oldEditId }}';
    document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('edit-id-field').value = '{{ $oldEditId }}';
    @else
    document.getElementById('modal-title').textContent = 'Add New Bell';
    document.getElementById('schedule-form').action = ADD_ACTION;
    @endif
    document.getElementById('f-title').value = @json(old('title', ''));
    document.getElementById('f-time').value  = @json(old('time_display', ''));
    document.getElementById('f-audio').value = @json(old('audio_file', ''));
    const oldDays = @json($oldDays);
    document.querySelectorAll('.day-check').forEach(cb => { cb.checked = oldDays.includes(cb.value); });
    setActiveStatus(@json($oldStatus) === 'Active');
    document.getElementById('schedule-modal').classList.remove('hidden');
})();
@endif
</script>

</x-layout>
