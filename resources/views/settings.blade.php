<x-layout>

<div class="p-6">

    {{-- Page Title --}}
    <h1 class="text-3xl font-bold text-gray-800">System Settings</h1>
    <p class="text-sm text-gray-400 mt-1">Manage global configuration, schedules, and administrative preferences.</p>

    {{-- Top Row: General Config + Admin Profile --}}
    <div class="grid grid-cols-[1.7fr_1fr] gap-5 mt-6">

        {{-- General Configuration --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 flex flex-col">
            <div class="flex items-center gap-2 pb-3 border-b border-gray-100">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C0001D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="20" y2="12"/>
                    <line x1="12" y1="18" x2="20" y2="18"/>
                    <circle cx="2" cy="6" r="1"/><circle cx="6" cy="12" r="1"/><circle cx="10" cy="18" r="1"/>
                </svg>
                <h2 class="text-base font-semibold text-gray-800">General Configuration</h2>
            </div>

            <form method="POST" action="{{ route('settings.general') }}">
                @csrf
                <div class="grid grid-cols-2 gap-4 mt-5">
                    <div>
                        <label class="text-xs font-medium text-gray-500 mb-1.5 block">School Name</label>
                        <input type="text" name="school_name" value="{{ $setting->school_name }}" required
                               class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-[#C0001D] transition-colors">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 mb-1.5 block">Timezone</label>
                        <select name="timezone" class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-[#C0001D] transition-colors">
                            @foreach(['Eastern Time (ET)','Central Time (CT)','Mountain Time (MT)','Pacific Time (PT)'] as $tz)
                                <option value="{{ $tz }}" {{ $setting->timezone === $tz ? 'selected' : '' }}>{{ $tz }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Speaker Status --}}
                <div class="mt-5">
                    <label class="text-xs font-medium text-gray-500 mb-1.5 block">Speaker Status</label>
                    <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50/60 px-3 py-2.5">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full {{ $setting->speaker_connected ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                            <span class="text-sm text-gray-700">{{ $setting->speaker_name }}</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold text-gray-500 border border-gray-200 bg-white">
                            {{ $setting->speaker_connected ? 'Connected' : 'Offline' }}
                        </span>
                    </div>
                    <input type="hidden" name="speaker_name" value="{{ $setting->speaker_name }}">
                    <input type="hidden" name="speaker_connected" value="{{ $setting->speaker_connected ? '1' : '0' }}">
                    <input type="hidden" name="weekly_auto_repeat" value="{{ $setting->weekly_auto_repeat ? '1' : '0' }}">
                    <input type="hidden" name="holiday_mode" value="{{ $setting->holiday_mode ? '1' : '0' }}">
                </div>

                <div class="flex justify-end mt-5">
                    <button type="submit"
                            class="border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium py-2 px-4 rounded-lg transition-colors">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        {{-- Admin Profile Card --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 flex flex-col">
            {{-- Avatar + Name --}}
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 rounded-full bg-gray-100 overflow-hidden flex items-center justify-center mb-3">
                    @if($admin->avatar_path)
                        <img src="{{ Storage::url($admin->avatar_path) }}" alt="{{ $admin->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-xl font-semibold text-gray-400">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}{{ strtoupper(substr(strstr($admin->name, ' ') ?: ' ', 1, 1)) }}
                        </span>
                    @endif
                </div>
                <p class="text-base font-semibold text-gray-800">{{ $admin->name }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $admin->role }}</p>
            </div>

            {{-- Contact --}}
            <div class="border-t border-gray-100 mt-5 pt-4 flex flex-col gap-2.5">
                <div class="flex items-center gap-2.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-300 shrink-0">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <span class="text-sm text-gray-600">{{ $admin->email }}</span>
                </div>
                @if($admin->phone)
                <div class="flex items-center gap-2.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-300 shrink-0">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.11 1.18 2 2 0 012.11 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.09a16 16 0 006 6l.46-.46a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/>
                    </svg>
                    <span class="text-sm text-gray-600">{{ $admin->phone }}</span>
                </div>
                @endif
            </div>

            <button onclick="document.getElementById('modal-profile').classList.remove('hidden')"
                    class="mt-5 w-full border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium py-2 rounded-lg transition-colors">
                Manage Account
            </button>
        </div>
    </div>

    {{-- Bottom Row: Schedule Rules + Recent Activity --}}
    <div class="grid grid-cols-2 gap-5 mt-5">

        {{-- Schedule Rules --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 flex flex-col">
            <div class="flex items-center gap-2 mb-4">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C0001D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
                </svg>
                <h2 class="text-base font-semibold text-gray-800">Schedule Rules</h2>
            </div>
            <div class="flex flex-col gap-3">
                @foreach([
                    ['key'=>'weekly_auto_repeat','title'=>'Weekly Auto-Repeat','desc'=>'Automatically load next week\'s standard schedule.'],
                    ['key'=>'holiday_mode','title'=>'Holiday Mode','desc'=>'Suppress all automated bells during designated breaks.'],
                ] as $rule)
                <form method="POST" action="{{ route('settings.general') }}" class="flex items-center justify-between rounded-lg border border-gray-100 px-4 py-3">
                    @csrf
                    <input type="hidden" name="school_name" value="{{ $setting->school_name }}">
                    <input type="hidden" name="timezone" value="{{ $setting->timezone }}">
                    <input type="hidden" name="speaker_name" value="{{ $setting->speaker_name }}">
                    <input type="hidden" name="speaker_connected" value="{{ $setting->speaker_connected ? '1' : '0' }}">
                    <input type="hidden" name="weekly_auto_repeat" value="{{ $setting->weekly_auto_repeat ? '1' : '0' }}">
                    <input type="hidden" name="holiday_mode" value="{{ $setting->holiday_mode ? '1' : '0' }}">
                    <div class="pr-4">
                        <p class="text-sm font-medium text-gray-800">{{ $rule['title'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $rule['desc'] }}</p>
                    </div>
                    @php $isOn = $setting->{$rule['key']}; @endphp
                    <button type="submit" name="{{ $rule['key'] }}" value="{{ $isOn ? '0' : '1' }}"
                            class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors {{ $isOn ? 'bg-[#C0001D]' : 'bg-gray-200' }}">
                        <span class="inline-block h-3.5 w-3.5 transform rounded-full bg-white transition-transform {{ $isOn ? 'translate-x-[18px]' : 'translate-x-[2px]' }}"></span>
                    </button>
                </form>
                @endforeach
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C0001D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 8 12 12 14 14"/>
                    </svg>
                    <h2 class="text-base font-semibold text-gray-800">Recent Activity</h2>
                </div>
                <button class="text-xs font-medium text-[#C0001D] hover:text-[#a0001a] transition-colors">View All</button>
            </div>
            <div class="flex flex-col gap-1">
                @forelse($activity as $item)
                <div class="flex items-start gap-3 py-2">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center shrink-0 {{ $item->kind === 'manual' ? 'bg-[#C0001D]' : 'bg-gray-100' }}">
                        @if($item->kind === 'manual')
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 11l19-9-9 19-2-8-8-2z"/>
                            </svg>
                        @else
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                                <path d="M13.73 21a2 2 0 01-3.46 0"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-700">{{ $item->description }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $item->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400">No recent activity.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

{{-- Manage Account Modal --}}
<div id="modal-profile" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-800">Edit Profile</h3>
            <button onclick="document.getElementById('modal-profile').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('settings.profile') }}" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="text-xs font-medium text-gray-500 mb-1.5 block">Full Name</label>
                <input type="text" name="name" value="{{ $admin->name }}" required
                       class="w-full rounded-lg border border-gray-200 bg-gray-50/60 px-3 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#C0001D] focus:bg-white transition-colors">
            </div>
            <div>
                <label class="text-xs font-medium text-gray-500 mb-1.5 block">Role</label>
                <input type="text" name="role" value="{{ $admin->role }}" required
                       class="w-full rounded-lg border border-gray-200 bg-gray-50/60 px-3 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#C0001D] focus:bg-white transition-colors">
            </div>
            <div>
                <label class="text-xs font-medium text-gray-500 mb-1.5 block">Email Address</label>
                <input type="email" name="email" value="{{ $admin->email }}" required
                       class="w-full rounded-lg border border-gray-200 bg-gray-50/60 px-3 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#C0001D] focus:bg-white transition-colors">
            </div>
            <div>
                <label class="text-xs font-medium text-gray-500 mb-1.5 block">Profile Photo</label>
                <input type="file" name="avatar" accept=".jpg,.jpeg,.png"
                       class="block text-sm text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-red-50 file:text-[#C0001D] hover:file:bg-red-100 cursor-pointer">
            </div>
            <div class="border-t border-gray-100 pt-4">
                <p class="text-xs text-gray-400 mb-3">Leave blank to keep current password</p>
                <div class="space-y-3">
                    <input type="password" name="current_password" placeholder="Current password"
                           class="w-full rounded-lg border border-gray-200 bg-gray-50/60 px-3 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:border-[#C0001D] focus:bg-white transition-colors">
                    <input type="password" name="new_password" placeholder="New password"
                           class="w-full rounded-lg border border-gray-200 bg-gray-50/60 px-3 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:border-[#C0001D] focus:bg-white transition-colors">
                    <input type="password" name="new_password_confirmation" placeholder="Confirm new password"
                           class="w-full rounded-lg border border-gray-200 bg-gray-50/60 px-3 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:border-[#C0001D] focus:bg-white transition-colors">
                    @error('current_password')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('modal-profile').classList.add('hidden')"
                        class="text-sm font-medium text-gray-500 hover:text-gray-700 px-3 py-2 transition-colors">Cancel</button>
                <button type="submit"
                        class="bg-[#C0001D] hover:bg-[#a0001a] text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

</x-layout>
