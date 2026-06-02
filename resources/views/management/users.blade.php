@extends('layouts.app')
@section('content')
<div style="padding: 2rem; max-width: 1280px; margin: 0 auto;">

    @if(session('toast_success'))
    <script>document.addEventListener('DOMContentLoaded',()=>showToast("{{ session('toast_success') }}",'success'));</script>
    @endif
    @if(session('toast_error'))
    <script>document.addEventListener('DOMContentLoaded',()=>showToast("{{ session('toast_error') }}",'error'));</script>
    @endif

    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;">
        <div>
            <h1 class="page-title">User Management</h1>
            <p class="page-sub">Manage all registered platform accounts.</p>
        </div>
        <button onclick="openAddModal()" class="btn-primary-custom" style="display:flex;align-items:center;gap:0.5rem;">
            <i class="fas fa-plus" style="font-size:0.75rem;"></i> Add New User
        </button>
    </div>

    <div class="card-premium" style="overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;">
                    <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.7rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:#64748B;">Name</th>
                    <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.7rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:#64748B;">Email</th>
                    <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.7rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:#64748B;">Joined</th>
                    <th style="padding:0.875rem 1.25rem;text-align:right;font-size:0.7rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:#64748B;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr style="border-bottom:1px solid #F1F5F9;transition:background 0.1s;" onmouseover="this.style.background='#FAFBFF'" onmouseout="this.style.background='transparent'">
                    <td style="padding:1rem 1.25rem;">
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            <div style="width:2.25rem;height:2.25rem;border-radius:50%;background:linear-gradient(135deg,#4F46E5,#818CF8);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.8rem;flex-shrink:0;">
                                {{ substr($user->name,0,1) }}
                            </div>
                            <span style="font-weight:600;color:#0F172A;font-size:0.875rem;">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="padding:1rem 1.25rem;color:#64748B;font-size:0.875rem;">{{ $user->email }}</td>
                    <td style="padding:1rem 1.25rem;color:#94A3B8;font-size:0.8rem;">{{ $user->created_at->format('M d, Y') }}</td>
                    <td style="padding:1rem 1.25rem;text-align:right;">
                        <button onclick="openEditModal({{ $user->id }},'{{ addslashes($user->name) }}','{{ addslashes($user->email) }}')" style="background:rgba(79,70,229,0.08);border:none;color:#4F46E5;font-size:0.75rem;font-weight:600;padding:0.35rem 0.75rem;border-radius:0.375rem;cursor:pointer;margin-right:0.5rem;transition:all 0.15s;" onmouseover="this.style.background='rgba(79,70,229,0.15)'" onmouseout="this.style.background='rgba(79,70,229,0.08)'">
                            <i class="fas fa-pen" style="font-size:0.65rem;margin-right:0.3rem;"></i>Edit
                        </button>
                        <button onclick="openDeleteModal({{ $user->id }},'{{ addslashes($user->name) }}')" style="background:rgba(239,68,68,0.08);border:none;color:#EF4444;font-size:0.75rem;font-weight:600;padding:0.35rem 0.75rem;border-radius:0.375rem;cursor:pointer;transition:all 0.15s;" onmouseover="this.style.background='rgba(239,68,68,0.15)'" onmouseout="this.style.background='rgba(239,68,68,0.08)'">
                            <i class="fas fa-trash" style="font-size:0.65rem;margin-right:0.3rem;"></i>Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding:4rem;text-align:center;color:#94A3B8;">
                        <i class="fas fa-users" style="font-size:2.5rem;display:block;margin-bottom:0.75rem;opacity:0.3;"></i>
                        <div style="font-weight:600;color:#64748B;margin-bottom:0.25rem;">No users found</div>
                        <div style="font-size:0.8rem;">Click "Add New User" to get started.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header-premium">
                <div class="modal-title-premium">Add New User</div>
                <div class="modal-sub-premium">Create a new platform account</div>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body-premium" style="display:flex;flex-direction:column;gap:1rem;">
                    <div>
                        <label class="form-label-premium">Full Name</label>
                        <input type="text" name="name" required class="form-control-premium" placeholder="Enter full name">
                    </div>
                    <div>
                        <label class="form-label-premium">Email Address</label>
                        <input type="email" name="email" required class="form-control-premium" placeholder="Enter email">
                    </div>
                    <div>
                        <label class="form-label-premium">Password</label>
                        <input type="password" name="password" required class="form-control-premium" placeholder="Min. 8 characters">
                    </div>
                </div>
                <div class="modal-footer-premium">
                    <button type="button" class="btn-ghost-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-custom">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header-premium">
                <div class="modal-title-premium">Edit Account</div>
                <div class="modal-sub-premium">Update user credentials</div>
            </div>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body-premium" style="display:flex;flex-direction:column;gap:1rem;">
                    <div>
                        <label class="form-label-premium">Full Name</label>
                        <input type="text" id="edit_name" name="name" required class="form-control-premium">
                    </div>
                    <div>
                        <label class="form-label-premium">Email Address</label>
                        <input type="email" id="edit_email" name="email" required class="form-control-premium">
                    </div>
                    <div>
                        <label class="form-label-premium">New Password <span style="font-weight:400;color:#94A3B8;text-transform:none;letter-spacing:0;">(leave blank to keep current)</span></label>
                        <input type="password" name="password" class="form-control-premium" placeholder="Leave blank to keep current">
                    </div>
                </div>
                <div class="modal-footer-premium">
                    <button type="button" class="btn-ghost-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-custom">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="text-align:center;">
            <div style="padding:2rem 1.5rem 0;">
                <div style="width:3.5rem;height:3.5rem;border-radius:50%;background:#FEE2E2;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                    <i class="fas fa-trash" style="color:#EF4444;font-size:1.1rem;"></i>
                </div>
                <div style="font-size:1.125rem;font-weight:700;color:#0F172A;margin-bottom:0.5rem;">Delete User?</div>
                <p style="font-size:0.875rem;color:#64748B;">Are you sure you want to delete <strong id="deleteTargetName" style="color:#0F172A;"></strong>? This cannot be undone.</p>
            </div>
            <form id="deleteForm" method="POST" style="display:flex;justify-content:center;gap:0.625rem;padding:1rem 1.5rem 1.5rem;">
                @csrf @method('DELETE')
                <button type="button" class="btn-ghost-custom" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn-danger-custom">Delete</button>
            </form>
        </div>
    </div>
</div>

<script>
    let bsAdd, bsEdit, bsDel;
    document.addEventListener('DOMContentLoaded', () => {
        bsAdd = new bootstrap.Modal(document.getElementById('addModal'));
        bsEdit = new bootstrap.Modal(document.getElementById('editModal'));
        bsDel = new bootstrap.Modal(document.getElementById('deleteModal'));
    });
    function openAddModal() { bsAdd.show(); }
    function openEditModal(id, name, email) {
        document.getElementById('editForm').action = `/users/${id}`;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        bsEdit.show();
    }
    function openDeleteModal(id, name) {
        document.getElementById('deleteForm').action = `/users/${id}`;
        document.getElementById('deleteTargetName').innerText = name;
        bsDel.show();
    }
</script>
@endsection
