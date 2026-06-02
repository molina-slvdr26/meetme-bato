@extends('layouts.app')
@section('content')
<div class="page-wrap">

    {{-- Header --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;">
        <div>
            <h1 class="page-title">User Management</h1>
            <p class="page-desc">Manage all registered platform accounts and credentials.</p>
        </div>
        <button onclick="openAdd()" class="btn-p btn-primary-p">
            <i class="fas fa-plus" style="font-size:0.7rem;"></i> Add New User
        </button>
    </div>

    {{-- Table --}}
    <div class="card-p" style="overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:var(--surface-2);">
                    <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.6875rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--t3);border-bottom:1px solid var(--border);">User</th>
                    <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.6875rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--t3);border-bottom:1px solid var(--border);">Email</th>
                    <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.6875rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--t3);border-bottom:1px solid var(--border);">Joined</th>
                    <th style="padding:0.875rem 1.25rem;text-align:right;font-size:0.6875rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--t3);border-bottom:1px solid var(--border);">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="table-row-p">
                    <td style="padding:0.875rem 1.25rem;border-bottom:1px solid var(--border-light);">
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            <div style="width:34px;height:34px;border-radius:8px;background:linear-gradient(135deg,var(--primary),#8B5CF6);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.8rem;flex-shrink:0;box-shadow:0 2px 8px rgba(99,102,241,0.25);">
                                {{ strtoupper(substr($user->name,0,1)) }}
                            </div>
                            <span style="font-weight:600;color:var(--t1);font-size:0.875rem;">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="padding:0.875rem 1.25rem;color:var(--t3);font-size:0.8125rem;border-bottom:1px solid var(--border-light);">{{ $user->email }}</td>
                    <td style="padding:0.875rem 1.25rem;border-bottom:1px solid var(--border-light);">
                        <span style="font-size:0.75rem;color:var(--t4);font-weight:500;">{{ $user->created_at->format('M d, Y') }}</span>
                    </td>
                    <td style="padding:0.875rem 1.25rem;text-align:right;border-bottom:1px solid var(--border-light);">
                        <button class="chip-btn chip-edit" onclick="openEdit({{ $user->id }},'{{ addslashes($user->name) }}','{{ addslashes($user->email) }}')">
                            <i class="fas fa-pen" style="font-size:0.6rem;"></i> Edit
                        </button>
                        <button class="chip-btn chip-delete" style="margin-left:0.375rem;" onclick="openDelete({{ $user->id }},'{{ addslashes($user->name) }}')">
                            <i class="fas fa-trash" style="font-size:0.6rem;"></i> Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-state">
                        <div class="empty-icon"><i class="fas fa-users-slash"></i></div>
                        <div class="empty-title">No users found</div>
                        <div class="empty-desc">Click "Add New User" to create the first account.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.table-row-p { transition: background 0.1s ease; }
.table-row-p:hover { background: #FAFBFF; }
.table-row-p:last-child td { border-bottom: none; }
</style>

{{-- Add --}}
<div class="modal fade" id="mAdd" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-premium-head">
                <div class="modal-premium-title">Add New User</div>
                <div class="modal-premium-sub">Create a new platform account</div>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-premium-body" style="display:flex;flex-direction:column;gap:0.875rem;">
                    <div><label class="lbl-p">Full Name</label><input type="text" name="name" required class="inp-p" placeholder="e.g. John Doe"></div>
                    <div><label class="lbl-p">Email Address</label><input type="email" name="email" required class="inp-p" placeholder="john@example.com"></div>
                    <div><label class="lbl-p">Password</label><input type="password" name="password" required class="inp-p" placeholder="Minimum 8 characters"></div>
                </div>
                <div class="modal-premium-foot">
                    <button type="button" class="btn-p btn-ghost-p" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-p btn-primary-p">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit --}}
<div class="modal fade" id="mEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-premium-head">
                <div class="modal-premium-title">Edit Account</div>
                <div class="modal-premium-sub">Update user information</div>
            </div>
            <form id="fEdit" method="POST">
                @csrf @method('PUT')
                <div class="modal-premium-body" style="display:flex;flex-direction:column;gap:0.875rem;">
                    <div><label class="lbl-p">Full Name</label><input type="text" id="eName" name="name" required class="inp-p"></div>
                    <div><label class="lbl-p">Email Address</label><input type="email" id="eEmail" name="email" required class="inp-p"></div>
                    <div>
                        <label class="lbl-p">New Password <span style="font-weight:400;color:var(--t4);text-transform:none;letter-spacing:0;">(leave blank to keep)</span></label>
                        <input type="password" name="password" class="inp-p" placeholder="Leave blank to keep current">
                    </div>
                </div>
                <div class="modal-premium-foot">
                    <button type="button" class="btn-p btn-ghost-p" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-p btn-primary-p">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete --}}
<div class="modal fade" id="mDelete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:380px;">
        <div class="modal-content" style="text-align:center;">
            <div style="padding:2rem 1.5rem 0;">
                <div style="width:52px;height:52px;border-radius:14px;background:rgba(239,68,68,0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 1.125rem;">
                    <i class="fas fa-user-minus" style="color:#DC2626;font-size:1.25rem;"></i>
                </div>
                <div style="font-size:1.0625rem;font-weight:700;color:var(--t1);margin-bottom:0.5rem;">Delete User?</div>
                <p style="font-size:0.8125rem;color:var(--t3);line-height:1.6;">Are you sure you want to permanently delete <strong id="dName" style="color:var(--t1);"></strong>? This action cannot be undone.</p>
            </div>
            <form id="fDelete" method="POST" style="display:flex;justify-content:center;gap:0.5rem;padding:1.25rem 1.5rem 1.5rem;">
                @csrf @method('DELETE')
                <button type="button" class="btn-p btn-ghost-p" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn-p btn-danger-p">Delete User</button>
            </form>
        </div>
    </div>
</div>

<script>
let mAdd, mEdit, mDel;
document.addEventListener('DOMContentLoaded', () => {
    mAdd = new bootstrap.Modal(document.getElementById('mAdd'));
    mEdit = new bootstrap.Modal(document.getElementById('mEdit'));
    mDel = new bootstrap.Modal(document.getElementById('mDelete'));
});
function openAdd() { mAdd.show(); }
function openEdit(id, name, email) {
    document.getElementById('fEdit').action = `/users/${id}`;
    document.getElementById('eName').value = name;
    document.getElementById('eEmail').value = email;
    mEdit.show();
}
function openDelete(id, name) {
    document.getElementById('fDelete').action = `/users/${id}`;
    document.getElementById('dName').textContent = name;
    mDel.show();
}
</script>
@endsection
