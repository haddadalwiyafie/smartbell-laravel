@php $p = $prefix ?? ''; @endphp

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
    <input type="text" name="{{ $p }}title" required
           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
</div>

<div class="grid grid-cols-2 gap-3">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu</label>
        <input type="time" name="{{ $p }}time" required
               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">AM/PM</label>
        <select name="{{ $p }}meridiem" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            <option value="AM">AM</option>
            <option value="PM">PM</option>
        </select>
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Audio</label>
    <select name="{{ $p }}audio_file" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
        @forelse($audioTracks as $track)
            <option value="{{ $track }}">{{ $track }}</option>
        @empty
            <option value="Standard Chime 1.mp3">Standard Chime 1.mp3</option>
            <option value="Short Ring.mp3">Short Ring.mp3</option>
            <option value="Upbeat Tone.mp3">Upbeat Tone.mp3</option>
        @endforelse
    </select>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">Hari</label>
    <div class="flex gap-2 flex-wrap">
        @foreach(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $d)
        <label class="cursor-pointer">
            <input type="checkbox" name="{{ $p }}days[]" value="{{ $d }}" class="sr-only peer">
            <span class="w-10 h-10 flex items-center justify-center rounded-full text-xs font-medium border border-gray-200 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 hover:border-indigo-300 transition-colors select-none">
                {{ $d[0] }}
            </span>
        </label>
        @endforeach
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
    <select name="{{ $p }}status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select>
</div>
