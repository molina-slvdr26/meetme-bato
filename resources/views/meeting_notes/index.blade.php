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
            <h1 class="page-title">Meeting Notes</h1>
            <p class="page-sub">Manage corporate session minutes and records.</p>
        </div>
        <button onclick="openAddModal()" class="btn-primary-custom" style="display:flex;align-items:center;gap:0.5rem;">
            <i class="fas fa-plus" style="font-size:0.75rem;"></i> New Meeting Note
        </button>
    </div>

    <div class="row g-4">
        @forelse($meetingNotes as $note)
        <div class="col-12 col-lg-6">
            <div class="card-premium p-4 h-100" style="display:flex;flex-direction:column;justify-content:space-between;">
                <div>
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;padding-bottom:1rem;margin-bottom:1rem;border-bottom:1px solid #F1F5F9;">
                        <div style="flex:1;min-width:0;padding-right:1rem;">
                            <span style="font-size:0.65rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#4F46E5;background:rgba(79,70,229,0.08);padding:0.2rem 0.6rem;border-radius:99px;display:inline-block;margin-bottom:0.5rem;">Minutes Log</span>
                            <div style="font-size:1rem;font-weight:700;color:#0F172A;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $note->subject ?? 'Untitled Meeting' }}</div>
                        </div>
                        <div style="text-align:right;flex-shrink:0;">
                            <div style="font-size:0.875rem;font-weight:600;color:#0F172A;">{{ \Carbon\Carbon::parse($note->meeting_date)->format('M d, Y') }}</div>
                            <div style="font-size:0.75rem;color:#94A3B8;font-weight:500;">{{ \Carbon\Carbon::parse($note->meeting_time)->format('h:i A') }}</div>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;margin-bottom:1rem;">
                        <div style="font-size:0.8rem;color:#64748B;"><span style="color:#94A3B8;">📍</span> <strong style="color:#374151;">Location:</strong> {{ $note->place ?? 'N/A' }}</div>
                        <div style="font-size:0.8rem;color:#64748B;"><span style="color:#94A3B8;">✍️</span> <strong style="color:#374151;">Writer:</strong> {{ $note->minutes_taken_by ?? 'N/A' }}</div>
                        <div style="font-size:0.8rem;color:#64748B;grid-column:span 2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><span style="color:#94A3B8;">👥</span> <strong style="color:#374151;">Attendees:</strong> {{ $note->attendees ?? 'None' }}</div>
                    </div>

                    <div style="background:#F8FAFC;border-radius:0.625rem;padding:0.875rem;margin-bottom:1rem;">
                        <div style="font-size:0.65rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#94A3B8;margin-bottom:0.5rem;">Discussion Notes</div>
                        <p style="font-size:0.8rem;color:#64748B;margin:0;line-height:1.6;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">{{ $note->meeting_notes }}</p>
                    </div>

                    @if($note->action_items && count(json_decode($note->action_items, true) ?? []) > 0)
                    <span style="font-size:0.7rem;font-weight:600;color:#4F46E5;background:rgba(79,70,229,0.08);padding:0.25rem 0.75rem;border-radius:99px;display:inline-block;">
                        📋 {{ count(json_decode($note->action_items, true)) }} Action Items
                    </span>
                    @endif
                </div>

                <div style="display:flex;justify-content:flex-end;gap:0.75rem;padding-top:1rem;margin-top:1rem;border-top:1px solid #F1F5F9;">
                    <button onclick="openEditModal({{ $note->id }}, {{ json_encode($note) }})" style="background:rgba(79,70,229,0.08);border:none;color:#4F46E5;font-size:0.75rem;font-weight:600;padding:0.4rem 0.875rem;border-radius:0.375rem;cursor:pointer;display:flex;align-items:center;gap:0.4rem;transition:background 0.15s;" onmouseover="this.style.background='rgba(79,70,229,0.15)'" onmouseout="this.style.background='rgba(79,70,229,0.08)'">
                        <i class="fas fa-pen" style="font-size:0.65rem;"></i> Edit
                    </button>
                    <button onclick="openDeleteModal({{ $note->id }})" style="background:rgba(239,68,68,0.08);border:none;color:#EF4444;font-size:0.75rem;font-weight:600;padding:0.4rem 0.875rem;border-radius:0.375rem;cursor:pointer;display:flex;align-items:center;gap:0.4rem;transition:background 0.15s;" onmouseover="this.style.background='rgba(239,68,68,0.15)'" onmouseout="this.style.background='rgba(239,68,68,0.08)'">
                        <i class="fas fa-trash" style="font-size:0.65rem;"></i> Delete
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card-premium p-5" style="text-align:center;">
                <i class="fas fa-file-alt" style="font-size:3rem;color:#E2E8F0;margin-bottom:1rem;display:block;"></i>
                <div style="font-size:1rem;font-weight:700;color:#64748B;margin-bottom:0.5rem;">No meeting notes yet</div>
                <div style="font-size:0.875rem;color:#94A3B8;">Click "New Meeting Note" to start documenting sessions.</div>
            </div>
        </div>
        @endforelse
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header-premium">
                <div class="modal-title-premium">New Meeting Note</div>
                <div class="modal-sub-premium">Document a new session</div>
            </div>
            <form action="{{ route('notes.store') }}" method="POST">
                @csrf
                <div class="modal-body-premium">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label-premium">Meeting Subject</label>
                            <input type="text" name="subject" required class="form-control-premium" placeholder="e.g. Q2 Strategy Review">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-premium">Location / Place</label>
                            <input type="text" name="place" class="form-control-premium" placeholder="e.g. Board Room 3">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label-premium">Date</label>
                            <input type="date" name="meeting_date" required class="form-control-premium">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label-premium">Time</label>
                            <input type="time" name="meeting_time" required class="form-control-premium">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-premium">Minutes Taken By</label>
                            <input type="text" name="minutes_taken_by" class="form-control-premium" placeholder="Name of recorder">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-premium">Agenda</label>
                            <textarea name="agenda" rows="3" class="form-control-premium" placeholder="Topics to discuss..."></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-premium">Attendees</label>
                            <textarea name="attendees" rows="3" class="form-control-premium" placeholder="John Doe, Jane Smith..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label-premium">Meeting Notes</label>
                            <textarea name="meeting_notes" rows="5" required class="form-control-premium" placeholder="Write comprehensive minutes here..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-premium">
                    <button type="button" class="btn-ghost-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-custom">Save Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header-premium">
                <div class="modal-title-premium">Edit Meeting Note</div>
                <div class="modal-sub-premium">Update session details</div>
            </div>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body-premium">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label-premium">Meeting Subject</label>
                            <input type="text" id="e_subject" name="subject" required class="form-control-premium">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-premium">Location / Place</label>
                            <input type="text" id="e_place" name="place" class="form-control-premium">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label-premium">Date</label>
                            <input type="date" id="e_date" name="meeting_date" required class="form-control-premium">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label-premium">Time</label>
                            <input type="time" id="e_time" name="meeting_time" required class="form-control-premium">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-premium">Minutes Taken By</label>
                            <input type="text" id="e_by" name="minutes_taken_by" class="form-control-premium">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-premium">Agenda</label>
                            <textarea id="e_agenda" name="agenda" rows="3" class="form-control-premium"></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-premium">Attendees</label>
                            <textarea id="e_attendees" name="attendees" rows="3" class="form-control-premium"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label-premium">Meeting Notes</label>
                            <textarea id="e_notes" name="meeting_notes" rows="5" required class="form-control-premium"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-premium">
                    <button type="button" class="btn-ghost-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-custom">Update Note</button>
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
                <div style="font-size:1.125rem;font-weight:700;color:#0F172A;margin-bottom:0.5rem;">Delete Note?</div>
                <p style="font-size:0.875rem;color:#64748B;">This meeting note will be permanently deleted and cannot be recovered.</p>
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
    function openEditModal(id, d) {
        document.getElementById('editForm').action = `/meeting-notes/${id}`;
        document.getElementById('e_subject').value = d.subject || '';
        document.getElementById('e_place').value = d.place || '';
        document.getElementById('e_date').value = d.meeting_date || '';
        document.getElementById('e_time').value = d.meeting_time ? d.meeting_time.substring(0,5) : '';
        document.getElementById('e_by').value = d.minutes_taken_by || '';
        document.getElementById('e_agenda').value = d.agenda || '';
        document.getElementById('e_attendees').value = d.attendees || '';
        document.getElementById('e_notes').value = d.meeting_notes || '';
        bsEdit.show();
    }
    function openDeleteModal(id) {
        document.getElementById('deleteForm').action = `/meeting-notes/${id}`;
        bsDel.show();
    }
</script>
@endsection
