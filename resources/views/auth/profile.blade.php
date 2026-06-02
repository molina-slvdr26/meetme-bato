@extends('layouts.app')
@section('content')
<div style="padding: 2rem; max-width: 860px; margin: 0 auto;">

    @if(session('toast_success'))
    <script>document.addEventListener('DOMContentLoaded',()=>showToast("{{ session('toast_success') }}",'success'));</script>
    @endif

    @if($errors->any())
    <script>document.addEventListener('DOMContentLoaded',()=>showToast("{{ $errors->first() }}",'error'));</script>
    @endif

    <div style="margin-bottom:2rem;">
        <h1 class="page-title">My Profile</h1>
        <p class="page-sub">Manage your account information and credentials.</p>
    </div>

    <div class="card-premium p-4">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- Avatar Section --}}
            <div style="display:flex;align-items:center;gap:1.5rem;padding-bottom:1.5rem;margin-bottom:1.5rem;border-bottom:1px solid #F1F5F9;flex-wrap:wrap;">
                @if($user->profile_picture)
                    <img src="{{ asset($user->profile_picture) }}" style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid #E2E8F0;flex-shrink:0;">
                @else
                    <div style="width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,#4F46E5,#818CF8);display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:800;color:#fff;flex-shrink:0;">
                        {{ substr($user->name,0,1) }}
                    </div>
                @endif
                <div>
                    <div style="font-weight:700;color:#0F172A;margin-bottom:0.25rem;">Profile Picture</div>
                    <div style="font-size:0.8rem;color:#94A3B8;margin-bottom:0.75rem;">PNG, JPG or GIF. Max 2MB.</div>
                    <input type="file" name="profile_picture" accept="image/*" class="form-control-premium" style="max-width:280px;">
                </div>
            </div>

            {{-- Fields --}}
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-6">
                    <label class="form-label-premium">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-control-premium" placeholder="Your full name">
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label-premium">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-control-premium" placeholder="your@email.com">
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label-premium">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control-premium" placeholder="+63 900 000 0000">
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label-premium">Gender</label>
                    <select name="gender" class="form-control-premium form-select-premium">
                        <option value="">Select gender</option>
                        <option value="Male" {{ old('gender',$user->gender)=='Male'?'selected':'' }}>Male</option>
                        <option value="Female" {{ old('gender',$user->gender)=='Female'?'selected':'' }}>Female</option>
                        <option value="Other" {{ old('gender',$user->gender)=='Other'?'selected':'' }}>Other</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label-premium">Address</label>
                    <textarea name="address" rows="2" class="form-control-premium" placeholder="Your mailing address">{{ old('address', $user->address) }}</textarea>
                </div>

                <div class="col-12" style="padding-top:0.5rem;border-top:1px solid #F1F5F9;margin-top:0.5rem;">
                    <div style="font-size:0.875rem;font-weight:600;color:#0F172A;margin-bottom:1rem;">Change Password <span style="font-weight:400;color:#94A3B8;font-size:0.8rem;">(leave blank to keep current)</span></div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label-premium">New Password</label>
                    <input type="password" name="password" class="form-control-premium" placeholder="Min. 8 characters">
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label-premium">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control-premium" placeholder="Repeat new password">
                </div>
            </div>

            <div style="display:flex;justify-content:flex-end;padding-top:1rem;border-top:1px solid #F1F5F9;">
                <button type="submit" class="btn-primary-custom" style="display:flex;align-items:center;gap:0.5rem;">
                    <i class="fas fa-save" style="font-size:0.8rem;"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
