@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    @if ($errors->any())
    <div class="p-4 mb-4 text-sm text-red-800 bg-red-50 rounded-2xl border border-red-100 font-semibold">
        <div class="flex items-center mb-1 text-red-900 font-bold">
            <span>✕ Setup Validation Failed:</span>
        </div>
        <ul class="list-disc pl-5 space-y-0.5 text-xs text-red-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 bg-green-50 rounded-2xl border border-green-100 font-semibold">
        ✓ {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-6 text-center flex flex-col items-center justify-center">
            
            <div class="w-32 h-32 max-w-[128px] max-h-[128px] min-w-[128px] min-h-[128px] rounded-full bg-slate-100 border border-slate-200 overflow-hidden mb-4 flex items-center justify-center font-bold text-3xl text-slate-700 shadow-inner relative z-10">
                @if($user->profile_image)
                    <img id="avatar-preview" src="{{ asset('storage/' . $user->profile_image) }}" class="w-full h-full object-cover block absolute inset-0 min-w-full min-h-full max-w-full max-h-full" style="display: block !important;" alt="Avatar" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=E67E5A&color=fff';">
                @else
                    <span class="uppercase tracking-wider text-slate-500 select-none">{{ substr($user->name, 0, 1) }}</span>
                @endif
            </div>

            <h2 class="text-xl font-bold text-slate-800 mt-2">{{ $user->name }}</h2>
            <p class="text-sm text-gray-400 mb-6">{{ $user->email }}</p>
            
            <div class="w-full border-t border-gray-50 pt-4 text-left space-y-3">
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Phone</span>
                    <span class="text-sm text-slate-600 font-medium">{{ $user->phone ?? 'Not set' }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Gender</span>
                    <span class="text-sm text-slate-600 font-medium">{{ $user->gender ?? 'Not set' }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Address</span>
                    <span class="text-sm text-slate-600 font-medium">{{ $user->address ?? 'Not set' }}</span>
                </div>
            </div>
        </div>

        <div class="md:col-span-2 bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
            <h3 class="text-xl font-bold text-slate-800 mb-2">Edit Profile Information</h3>
            <p class="text-xs text-gray-400 mb-6 uppercase tracking-wider">Keep your system profile information current</p>
            
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                        @error('name') <span class="text-xs text-red-500 block mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                        @error('email') <span class="text-xs text-red-500 block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Gender</label>
                        <select name="gender" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Home Address</label>
                    <textarea name="address" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-blue-500">{{ old('address', $user->address) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Update Profile Picture</label>
                    <input type="file" id="profile_image_input" name="profile_image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:uppercase file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    @error('profile_image') <span class="text-xs text-red-500 block mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="border-t border-gray-50 pt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">New Password <span class="text-gray-400 font-normal">(Optional)</span></label>
                        <input type="password" name="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                        @error('password') <span class="text-xs text-red-500 block mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-[#E67E5A] hover:bg-[#d46f4b] text-white px-6 py-3 rounded-xl font-bold transition-colors text-sm shadow-sm">
                        Update Information
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('profile_image_input').onchange = evt => {
        const [file] = document.getElementById('profile_image_input').files;
        if (file) {
            let previewEl = document.getElementById('avatar-preview');
            if(!previewEl) {
                // If user doesn't have an image set yet, replace letter with dynamic image tag
                const container = document.querySelector('.bg-slate-100');
                container.innerHTML = `<img id="avatar-preview" class="w-full h-full object-cover block absolute inset-0 min-w-full min-h-full max-w-full max-h-full" style="display: block !important;" alt="Avatar">`;
                previewEl = document.getElementById('avatar-preview');
            }
            previewEl.src = URL.createObjectURL(file);
        }
    }
</script>
@endsection