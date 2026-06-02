@extends('layouts.app')
@section('content')
<div class="page-wrap">

    {{-- Header --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;">
        <div>
            <h1 class="page-title">Meeting Notes</h1>
            <p class="page-desc">Manage corporate session minutes, agendas, and action items.</p>
        </div>
        <button onclick="openAdd()" class="btn-p btn-primary-p btn-block-mobile">
            <i class="fas fa-plus" style="font-size:0.7rem;"></i> New Meeting Note
        </button>
    </div>

    {{-- Notes Grid --}}
    <div class="row g-3">
        @forelse($meetingNotes as $note)
        <div class="col-12 col-lg-6 col-xl-6">
            <div class="card-p card-p-hover" style="height:100%;display:flex;flex-direction:column;">
                {{-- Card Header --}}
                <div style="padding:1.25rem 1.25rem 0;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:0.75rem;">
                        <div style="flex:1;min-width:0;">
                            <span class="badge-p badge-primary" style="margin-bottom:0.5rem;">Minutes Log</span>
                            <div style="font-size:0.9375rem;font-weight:700;color:var(--t1);letter-spacing:-0.01em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $note->subject ?? 'Untitled Meeting' }}
                            </div>
                        </div>
                        <div style="text-align:right;flex-shrink:0;">
                            <div style="font-size:0.8125rem;font-weight:700;color:var(--t2);">{{ \Carbon\Carbon::parse($note->meeting_date)->format('M d, Y') }}</div>
                            <div style="font-size:0.6875rem;color:var(--t4);font-weight:500;margin-top:1px;">{{ \Carbon\Carbon::parse($note->meeting_time)->format('h:i A') }}</div>
                        </div>
                    </div>
                </div>

                {{-- Divider --}}
                <div style="height:1px;background:var(--border-light);margin:1rem 1.25rem;"></div>

                {{-- Meta --}}
                <div style="padding:0 1.25rem;flex:1;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem 1rem;margin-bottom:1rem;">
                        <div style="font-size:0.75rem;color:var(--t3);">
                            <span style="font-weight:600;color:var(--t2);display:block;font-size:0.6875rem;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.125rem;">Location</span>
                            {{ $note->place ?? '—' }}
                        </div>
                        <div style="font-size:0.75rem;color:var(--t3);">
                            <span style="font-weight:600;color:var(--t2);display:block;font-size:0.6875rem;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.125rem;">Written By</span>
                            {{ $note->minutes_taken_by ?? '—' }}
                        </div>
                        <div style="font-size:0.75rem;color:var(--t3);grid-column:span 2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            <span style="font-weight:600;color:var(--t2);display:block;font-size:0.6875rem;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.125rem;">Attendees</span>
                            {{ $note->attendees ?? 'Not specified' }}
                        </div>
                    </div>

                    <div style="background:var(--surface-2);border-radius:8px;padding:0.875rem;border:1px solid var(--border-light);">
                        <div style="font-size:0.625rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--t4);margin-bottom:0.5rem;">Discussion Notes</div>
                        <p style="font-size:0.75rem;color:var(--t3);margin:0;line-height:1.7;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">{{ $note->meeting_notes }}</p>
                    </div>

                    @if($note->action_items)
                        @php $items = is_array($note->action_items) ? $note->action_items : json_decode($note->action_items, true); @endphp
                        @if($items && count($items) > 0)
                        <div style="margin-top:0.75rem;">
                            <span class="badge-p badge-success">
                                <i class="fas fa-check-circle" style="margin-right:0.3rem;font-size:0.6rem;"></i>
                                {{ count($items) }} Action {{ Str::plural('Item', count($items)) }}
                            </span>
                        </div>
                        @endif
                    @endif
                </div>

                {{-- Card Footer --}}
                <div style="padding:0.875rem 1.25rem;border-top:1px solid var(--border-light);margin-top:1rem;display:flex;justify-content:flex-end;gap:0.5rem;">
                    <button class="chip-btn chip-edit" onclick="openEdit({{ $note->id }}, {{ json_encode($note) }})">
                        <i class="fas fa-pen" style="font-size:0.6rem;"></i> Edit
                    </button>
                    <button class="chip-btn chip-delete" onclick="openDelete({{ $note->id }})">
                        <i class="fas fa-trash" style="font-size:0.6rem;"></i> Delete
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card-p empty-state">
                <div class="empty-icon"><i class="fas fa-folder-open"></i></div>
                <div class="empty-title">No meeting notes yet</div>
                <div class="empty-desc">Start documenting your sessions by clicking "New Meeting Note".</div>
            </div>
        </div>
        @endforelse
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="mAdd" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-premium-head">
                <div class="modal-premium-title">New Meeting Note</div>
                <div class="modal-premium-sub">Document a new session</div>
            </div>
            <form action="{{ route('notes.store') }}" method="POST">
                @csrf
                <div class="modal-premium-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="lbl-p">Meeting Subject <span style="color:var(--danger);">*</span></label>
                            <input type="text" name="subject" required class="inp-p" placeholder="e.g. Q2 Strategy Review">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="lbl-p">Location</label>
                            <input type="text" name="place" class="inp-p" placeholder="e.g. Conference Room A">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="lbl-p">Date <span style="color:var(--danger);">*</span></label>
                            <input type="date" name="meeting_date" required class="inp-p">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="lbl-p">Time <span style="color:var(--danger);">*</span></label>
                            <input type="time" name="meeting_time" required class="inp-p">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="lbl-p">Minutes Taken By</label>
                            <input type="text" name="minutes_taken_by" class="inp-p" placeholder="Recorder's name">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="lbl-p">Agenda</label>
                            <textarea name="agenda" rows="3" class="inp-p" style="resize:vertical;" placeholder="Topics to be discussed..."></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="lbl-p">Attendees</label>
                            <textarea name="attendees" rows="3" class="inp-p" style="resize:vertical;" placeholder="John Doe, Jane Smith..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="lbl-p">Meeting Notes <span style="color:var(--danger);">*</span></label>
                            <textarea name="meeting_notes" rows="5" required class="inp-p" style="resize:vertical;" placeholder="Write comprehensive meeting minutes here..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-premium-foot">
                    <button type="button" class="btn-p btn-ghost-p" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-p btn-primary-p">Save Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="mEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-premium-head">
                <div class="modal-premium-title">Edit Meeting Note</div>
                <div class="modal-premium-sub">Update session details</div>
            </div>
            <form id="fEdit" method="POST">
                @csrf @method('PUT')
                <div class="modal-premium-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="lbl-p">Meeting Subject</label>
                            <input type="text" id="eSubject" name="subject" required class="inp-p">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="lbl-p">Location</label>
                            <input type="text" id="ePlace" name="place" class="inp-p">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="lbl-p">Date</label>
                            <input type="date" id="eDate" name="meeting_date" required class="inp-p">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="lbl-p">Time</label>
                            <input type="time" id="eTime" name="meeting_time" required class="inp-p">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="lbl-p">Minutes Taken By</label>
                            <input type="text" id="eBy" name="minutes_taken_by" class="inp-p">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="lbl-p">Agenda</label>
                            <textarea id="eAgenda" name="agenda" rows="3" class="inp-p" style="resize:vertical;"></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="lbl-p">Attendees</label>
                            <textarea id="eAttendees" name="attendees" rows="3" class="inp-p" style="resize:vertical;"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="lbl-p">Meeting Notes</label>
                            <textarea id="eNotes" name="meeting_notes" rows="5" required class="inp-p" style="resize:vertical;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-premium-foot">
                    <button type="button" class="btn-p btn-ghost-p" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-p btn-primary-p">Update Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="mDelete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:380px;">
        <div class="modal-content" style="text-align:center;">
            <div style="padding:2rem 1.5rem 0;">
                <div style="width:52px;height:52px;border-radius:14px;background:rgba(239,68,68,0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 1.125rem;">
                    <i class="fas fa-file-circle-xmark" style="color:#DC2626;font-size:1.25rem;"></i>
                </div>
                <div style="font-size:1.0625rem;font-weight:700;color:var(--t1);margin-bottom:0.5rem;">Delete Note?</div>
                <p style="font-size:0.8125rem;color:var(--t3);line-height:1.6;">This meeting note will be permanently deleted and cannot be recovered.</p>
            </div>
            <form id="fDelete" method="POST" style="display:flex;justify-content:center;gap:0.5rem;padding:1.25rem 1.5rem 1.5rem;">
                @csrf @method('DELETE')
                <button type="button" class="btn-p btn-ghost-p" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn-p btn-danger-p">Delete Note</button>
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
function openEdit(id, d) {
    document.getElementById('fEdit').action = `/meeting-notes/${id}`;
    document.getElementById('eSubject').value = d.subject || '';
    document.getElementById('ePlace').value = d.place || '';
    document.getElementById('eDate').value = d.meeting_date || '';
    document.getElementById('eTime').value = d.meeting_time ? d.meeting_time.substring(0,5) : '';
    document.getElementById('eBy').value = d.minutes_taken_by || '';
    document.getElementById('eAgenda').value = d.agenda || '';
    document.getElementById('eAttendees').value = d.attendees || '';
    document.getElementById('eNotes').value = d.meeting_notes || '';
    mEdit.show();
}
function openDelete(id) {
    document.getElementById('fDelete').action = `/meeting-notes/${id}`;
    mDel.show();
}
</script>
@endsection
