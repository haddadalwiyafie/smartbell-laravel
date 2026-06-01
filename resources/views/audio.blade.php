<x-layout>

<div class="p-6">

    {{-- Page Header --}}
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Audio Management</h1>
            <p class="text-sm text-gray-400 mt-0.5">Manage your daily announcements and bell sounds.</p>
        </div>
        <button onclick="document.getElementById('modal-add-audio').classList.remove('hidden')"
                class="flex items-center gap-2 bg-[#C0001D] hover:bg-[#a0001a] text-white text-sm font-medium py-2.5 px-4 rounded-lg transition-colors shrink-0">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add New Audio
        </button>
    </div>

    {{-- Top Cards --}}
    <div class="grid grid-cols-[1.6fr_1fr] gap-5 mt-6">

        {{-- Text-to-Speech Card --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 flex flex-col">
            <div class="flex items-center gap-2 mb-5">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C0001D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/>
                    <path d="M19.07 4.93a10 10 0 010 14.14M15.54 8.46a5 5 0 010 7.07"/>
                </svg>
                <h2 class="text-base font-semibold text-gray-800">Text-to-Speech Broadcast</h2>
            </div>

            <label class="text-xs font-medium text-gray-500 mb-1.5 block">Announcement Text</label>
            <div class="relative">
                <textarea id="tts-text" rows="3" maxlength="250"
                          placeholder="Type announcement here..."
                          class="w-full resize-none rounded-lg border border-gray-200 bg-gray-50/60 px-3 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:border-[#C0001D] focus:bg-white transition-colors"></textarea>
                <span id="tts-count" class="absolute bottom-2 right-3 text-[10px] text-gray-400">0 / 250 characters</span>
            </div>

            <label class="text-xs font-medium text-gray-500 mb-1.5 mt-4 block">Voice Selection</label>
            <div class="flex gap-3">
                <select class="flex-1 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-[#C0001D] transition-colors">
                    <option>English (US) - Female</option>
                    <option>English (US) - Male</option>
                    <option>English (UK) - Female</option>
                    <option>English (UK) - Male</option>
                </select>
                <button class="flex items-center justify-center gap-2 border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium py-2 px-4 rounded-lg transition-colors">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    Play Preview
                </button>
                <button class="flex items-center justify-center gap-2 bg-[#C0001D] hover:bg-[#a0001a] text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="2"/><path d="M16.24 7.76a6 6 0 010 8.49m-8.48-.01a6 6 0 010-8.49m11.31-2.82a10 10 0 010 14.14m-14.14 0a10 10 0 010-14.14"/>
                    </svg>
                    Broadcast
                </button>
            </div>
        </div>

        {{-- MP3 Upload Card --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 flex flex-col">
            <div class="flex items-center gap-2 mb-5">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C0001D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
                </svg>
                <h2 class="text-base font-semibold text-gray-800">MP3 Upload</h2>
            </div>

            <form method="POST" action="{{ route('audio.upload') }}" enctype="multipart/form-data" class="flex-1 flex flex-col">
                @csrf
                <div id="drop-zone"
                     onclick="document.getElementById('mp3-file-input').click()"
                     class="flex-1 flex flex-col items-center justify-center text-center rounded-lg border-2 border-dashed border-gray-200 bg-gray-50/40 hover:border-gray-300 px-4 py-8 cursor-pointer transition-colors">
                    <svg id="drop-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2 text-gray-300">
                        <polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/>
                        <path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3"/>
                    </svg>
                    <p id="drop-text" class="text-sm font-medium text-gray-500">Drag and drop audio file here</p>
                    <p id="drop-sub" class="text-xs text-gray-400 mt-1">or click to browse (.mp3, .wav)</p>
                    <input type="file" id="mp3-file-input" name="audio_file" accept=".mp3,.wav" class="hidden">
                </div>
                @error('audio_file')
                    <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                @enderror
                <button type="submit" class="mt-3 w-full py-2 bg-[#C0001D] hover:bg-[#a0001a] text-white text-sm font-medium rounded-lg transition-colors">
                    Upload
                </button>
            </form>
        </div>

    </div>

    {{-- Audio Library Table --}}
    <div class="mt-5 bg-white rounded-xl border border-gray-100">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C0001D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
                </svg>
                <h2 class="text-base font-semibold text-gray-800">Audio Library</h2>
            </div>
            <button class="text-gray-400 hover:text-[#C0001D] transition-colors">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="20" y2="12"/>
                    <line x1="12" y1="18" x2="20" y2="18"/>
                    <circle cx="2" cy="6" r="1"/><circle cx="6" cy="12" r="1"/><circle cx="10" cy="18" r="1"/>
                </svg>
            </button>
        </div>

        {{-- Column Headers --}}
        <div class="grid grid-cols-[3fr_1fr_1.5fr_1fr] px-6 py-3 border-b border-gray-50">
            <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">File Name</span>
            <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Duration</span>
            <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Date Added</span>
            <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide text-right">Actions</span>
        </div>

        {{-- Rows --}}
        <div class="divide-y divide-gray-50">
            @forelse($tracks as $track)
            <div class="grid grid-cols-[3fr_1fr_1.5fr_1fr] items-center px-6 py-4 hover:bg-gray-50/60 transition-colors">
                <div class="flex items-center gap-2.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-300 shrink-0">
                        <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">{{ $track->file_name }}</span>
                </div>
                <span class="text-sm text-gray-500 tabular-nums">{{ $track->duration ?? '—' }}</span>
                <span class="text-sm text-gray-500">{{ $track->created_at->format('M d, Y') }}</span>
                <div class="flex items-center justify-end gap-3">
                    <button class="text-gray-400 hover:text-[#C0001D] transition-colors">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    </button>
                    <form method="POST" action="{{ route('audio.destroy', $track) }}" id="del-{{ $track->id }}">
                        @csrf @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $track->id }}, '{{ $track->file_name }}')"
                                class="text-gray-400 hover:text-[#C0001D] transition-colors">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <p class="px-6 py-10 text-center text-sm text-gray-400">No audio files in the library.</p>
            @endforelse
        </div>
    </div>

</div>

{{-- Add New Audio Modal --}}
<div id="modal-add-audio" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C0001D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
                </svg>
                <h3 class="text-base font-semibold text-gray-800">Add New Audio</h3>
            </div>
            <button onclick="document.getElementById('modal-add-audio').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Tabs --}}
        <div class="flex border-b border-gray-100 px-6">
            <button id="tab-upload" onclick="switchTab('upload')"
                    class="tab-btn py-3 px-1 mr-6 text-sm font-medium border-b-2 border-[#C0001D] text-[#C0001D] transition-colors">
                Upload MP3
            </button>
            <button id="tab-tts" onclick="switchTab('tts')"
                    class="tab-btn py-3 px-1 mr-6 text-sm font-medium border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-colors">
                Text to Speech
            </button>
        </div>

        {{-- Tab: Upload --}}
        <div id="panel-upload" class="p-6">
            <form method="POST" action="{{ route('audio.upload') }}" enctype="multipart/form-data">
                @csrf
                <div id="modal-drop-zone" onclick="document.getElementById('modal-file-input').click()"
                     class="flex flex-col items-center justify-center text-center rounded-lg border-2 border-dashed border-gray-200 bg-gray-50/40 hover:border-gray-300 px-4 py-10 cursor-pointer transition-colors mb-4">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2 text-gray-300">
                        <polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/>
                        <path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3"/>
                    </svg>
                    <p id="modal-drop-text" class="text-sm font-medium text-gray-500">Drag and drop audio file here</p>
                    <p class="text-xs text-gray-400 mt-1">or click to browse (.mp3, .wav) — Max 10MB</p>
                    <input type="file" id="modal-file-input" name="audio_file" accept=".mp3,.wav" class="hidden"
                           onchange="document.getElementById('modal-drop-text').textContent = this.files[0]?.name || 'Drag and drop audio file here'">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modal-add-audio').classList.add('hidden')"
                            class="text-sm font-medium text-gray-500 hover:text-gray-700 px-3 py-2 transition-colors">Cancel</button>
                    <button type="submit"
                            class="flex items-center gap-2 bg-[#C0001D] hover:bg-[#a0001a] text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors">
                        Add to Library
                    </button>
                </div>
            </form>
        </div>

        {{-- Tab: TTS --}}
        <div id="panel-tts" class="p-6 hidden">
            <label class="text-xs font-medium text-gray-500 mb-1.5 block">Announcement Text</label>
            <textarea rows="3" maxlength="250" placeholder="Type announcement here..."
                      class="w-full resize-none rounded-lg border border-gray-200 bg-gray-50/60 px-3 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:border-[#C0001D] mb-4"></textarea>
            <label class="text-xs font-medium text-gray-500 mb-1.5 block">Voice</label>
            <select class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-[#C0001D] mb-4">
                <option>English (US) - Female</option>
                <option>English (US) - Male</option>
                <option>English (UK) - Female</option>
                <option>English (UK) - Male</option>
            </select>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modal-add-audio').classList.add('hidden')"
                        class="text-sm font-medium text-gray-500 hover:text-gray-700 px-3 py-2 transition-colors">Cancel</button>
                <button type="button"
                        class="flex items-center gap-2 bg-[#C0001D] hover:bg-[#a0001a] text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors">
                    Generate & Add
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirm Dialog --}}
<div id="confirm-dialog" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-2">Delete Audio</h3>
        <p id="confirm-msg" class="text-sm text-gray-500 mb-6"></p>
        <div class="flex justify-end gap-2">
            <button onclick="document.getElementById('confirm-dialog').classList.add('hidden')"
                    class="text-sm font-medium text-gray-500 hover:text-gray-700 px-3 py-2 transition-colors">Cancel</button>
            <button id="confirm-ok"
                    class="bg-[#C0001D] hover:bg-[#a0001a] text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors">
                Delete
            </button>
        </div>
    </div>
</div>

<script>
// TTS character count
const ttsText = document.getElementById('tts-text');
if (ttsText) {
    ttsText.addEventListener('input', () => {
        document.getElementById('tts-count').textContent = ttsText.value.length + ' / 250 characters';
    });
}

// MP3 drag drop visual
const dropZone = document.getElementById('drop-zone');
if (dropZone) {
    dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-[#C0001D]', 'bg-red-50/50'); });
    dropZone.addEventListener('dragleave', () => { dropZone.classList.remove('border-[#C0001D]', 'bg-red-50/50'); });
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-[#C0001D]', 'bg-red-50/50');
        const f = e.dataTransfer.files[0];
        if (f) document.getElementById('drop-text').textContent = f.name;
        document.getElementById('mp3-file-input').files = e.dataTransfer.files;
    });
}

// Tab switching
function switchTab(tab) {
    document.getElementById('panel-upload').classList.toggle('hidden', tab !== 'upload');
    document.getElementById('panel-tts').classList.toggle('hidden', tab !== 'tts');
    document.getElementById('tab-upload').className = tab === 'upload'
        ? 'tab-btn py-3 px-1 mr-6 text-sm font-medium border-b-2 border-[#C0001D] text-[#C0001D] transition-colors'
        : 'tab-btn py-3 px-1 mr-6 text-sm font-medium border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-colors';
    document.getElementById('tab-tts').className = tab === 'tts'
        ? 'tab-btn py-3 px-1 mr-6 text-sm font-medium border-b-2 border-[#C0001D] text-[#C0001D] transition-colors'
        : 'tab-btn py-3 px-1 mr-6 text-sm font-medium border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-colors';
}

// Delete confirm
let pendingDeleteId = null;
function confirmDelete(id, name) {
    pendingDeleteId = id;
    document.getElementById('confirm-msg').textContent = `Are you sure you want to delete "${name}"? This action cannot be undone.`;
    document.getElementById('confirm-dialog').classList.remove('hidden');
}
document.getElementById('confirm-ok').addEventListener('click', () => {
    if (pendingDeleteId) document.getElementById('del-' + pendingDeleteId).submit();
});
</script>

</x-layout>
