@extends('layouts.app')
@section('content')
<div class="page-wrap" style="max-width:900px;">

    @if($errors->any())
    <script>document.addEventListener('DOMContentLoaded',()=>showToast(@json($errors->first()),'error'));</script>
    @endif

    <div style="margin-bottom:2rem;">
        <h1 class="page-title">My Profile</h1>
        <p class="page-desc">Manage your account information, photo, and password.</p>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- Avatar Card --}}
        <div class="card-p" style="padding:1.5rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;">
            @if($user->profile_picture)
                <img src="{{ asset($user->profile_picture) }}" style="width:80px;height:80px;border-radius:16px;object-fit:cover;border:2px solid var(--border);flex-shrink:0;">
            @else
                <div style="width:80px;height:80px;border-radius:16px;background:linear-gradient(135deg,var(--primary),#8B5CF6);display:flex;align-items:center;justify-content:center;font-size:1.875rem;font-weight:800;color:#fff;flex-shrink:0;box-shadow:0 4px 16px rgba(99,102,241,0.3);">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
            @endif
            <div style="flex:1;min-width:200px;">
                <div style="font-weight:700;color:var(--t1);font-size:0.9375rem;margin-bottom:0.25rem;">{{ $user->name }}</div>
                <div style="font-size:0.8125rem;color:var(--t3);margin-bottom:0.875rem;">{{ $user->email }}</div>
                <div>
                    <label class="lbl-p" style="margin-bottom:0.5rem;">Change Profile Photo</label>
                    <input type="file" name="profile_picture" accept="image/*" class="inp-p" style="max-width:320px;">
                    <div style="font-size:0.6875rem;color:var(--t4);margin-top:0.375rem;">PNG, JPG or GIF. Max 2MB.</div>
                </div>
            </div>
        </div>

        {{-- Info Card --}}
        <div class="card-p" style="padding:1.5rem;margin-bottom:1.25rem;">
            <div style="font-size:0.8125rem;font-weight:700;color:var(--t1);margin-bottom:1.25rem;display:flex;align-items:center;gap:0.5rem;">
                <i class="fas fa-user" style="color:var(--primary);font-size:0.875rem;"></i>
                Personal Information
            </div>
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="lbl-p">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="inp-p" placeholder="Your full name">
                </div>
                <div class="col-12 col-md-6">
                    <label class="lbl-p">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="inp-p" placeholder="your@email.com">
                </div>
                <div class="col-12 col-md-6">
                    <label class="lbl-p">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="inp-p" placeholder="+63 900 000 0000">
                </div>
                <div class="col-12 col-md-6">
                    <label class="lbl-p">Gender</label>
                    <select name="gender" class="inp-p sel-p">
                        <option value="">Select gender</option>
                        <option value="Male" {{ old('gender',$user->gender)=='Male'?'selected':'' }}>Male</option>
                        <option value="Female" {{ old('gender',$user->gender)=='Female'?'selected':'' }}>Female</option>
                        <option value="Other" {{ old('gender',$user->gender)=='Other'?'selected':'' }}>Other</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="lbl-p">Address</label>
                    <textarea name="address" rows="2" class="inp-p" style="resize:vertical;" placeholder="Your mailing address">{{ old('address', $user->address) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Password Card --}}
        <div class="card-p" style="padding:1.5rem;margin-bottom:1.5rem;">
            <div style="font-size:0.8125rem;font-weight:700;color:var(--t1);margin-bottom:0.375rem;display:flex;align-items:center;gap:0.5rem;">
                <i class="fas fa-lock" style="color:var(--warning);font-size:0.875rem;"></i>
                Change Password
            </div>
            <div style="font-size:0.75rem;color:var(--t4);margin-bottom:1.25rem;">Leave blank to keep your current password.</div>
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="lbl-p">New Password</label>
                    <input type="password" name="password" class="inp-p" placeholder="Minimum 8 characters">
                </div>
                <div class="col-12 col-md-6">
                    <label class="lbl-p">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="inp-p" placeholder="Repeat new password">
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div style="display:flex;justify-content:flex-end;gap:0.625rem;">
            <button type="submit" class="btn-p btn-primary-p" style="padding:0.625rem 1.5rem;">
                <i class="fas fa-floppy-disk" style="font-size:0.8rem;"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
