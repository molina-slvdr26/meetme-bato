@extends('layouts.app')

@section('content')
<div class="container py-2" style="max-width: 1200px; padding-bottom: 6rem !important;">
    
    @if(session('toast_success'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        <div class="toast show align-items-center border-0 shadow rounded-4 bg-white" role="alert">
            <div class="d-flex p-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success me-3" style="width: 2.5rem; height: 2.5rem;">
                    <strong>✓</strong>
                </div>
                <div class="me-auto fw-semibold text-secondary d-flex align-items-center">{{ session('toast_success') }}</div>
                <button type="button" class="btn-close m-auto shadow-none" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-5">
        <div>
            <h1 class="h2 fw-bold text-dark mb-1">Meeting Records</h1>
            <p class="text-muted small mb-0">Manage corporate session minutes, tracking indices, and target workflow actions.</p>
        </div>
        <button onclick="openAddMinutesModal()" class="btn btn-primary fw-bold px-4 py-2.5 rounded-3 shadow-sm text-sm border-0" style="background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);">
            + New Meeting Document
        </button>
    </div>

    <div class="row g-4">
        @forelse($notes as $note)
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-2 h-100 bg-white">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                            <div style="max-width: 75%;">
                                <span class="badge bg-light text-primary border border-primary border-opacity-10 mb-1 fw-bold text-uppercase" style="font-size: 9px; letter-spacing: 0.05em;">Minutes Log</span>
                                <h5 class="fw-bold text-dark text-truncate mb-0">{{ $note->subject ?? 'Untitled Meeting' }}</h5>
                            </div>
                            <div class="text-end">
                                <span class="d-block fw-bold text-dark small">{{ \Carbon\Carbon::parse($note->meeting_date)->format('M d, Y') }}</span>
                                <span class="text-muted text-uppercase fw-semibold" style="font-size: 10px;">{{ \Carbon\Carbon::parse($note->meeting_time)->format('h:i A') }}</span>
                            </div>
                        </div>

                        <div class="row g-2 mb-3 text-muted small">
                            <div class="col-6"><strong>📍 Location:</strong> <span class="text-dark">{{ $note->place ?? 'N/A' }}</span></div>
                            <div class="col-6"><strong>✍️ Writer:</strong> <span class="text-dark">{{ $note->minutes_taken_by ?? 'N/A' }}</span></div>
                            <div class="col-12 text-truncate"><strong>👥 Attendees:</strong> <span class="text-dark">{{ $note->attendees ?? 'None' }}</span></div>
                        </div>

                        <div class="bg-light rounded-3 p-3 mb-3">
                            <h6 class="fw-bold text-secondary small text-uppercase mb-1" style="letter-spacing: 0.05em;">Discussion Notes</h6>
                            <p class="text-muted small mb-0 text-break" style="white-space: pre-line; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.6;">{{ $note->meeting_notes }}</p>
                        </div>

                        @if($note->action_items && count(json_decode($note->action_items, true)) > 0)
                        <div class="mb-4">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill fw-bold" style="font-size: 10px;">
                                📋 {{ count(json_decode($note->action_items, true)) }} Action Items Generated
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-3 border-top border-light">
                        <button onclick="openEditMinutesModal({{ $note->id }}, {{ json_encode($note) }})" class="btn btn-link text-decoration-none text-primary p-0 fw-bold text-uppercase tracking-wider" style="font-size: 11px;">Modify</button>
                        <button onclick="openDeleteMinutesModal({{ $note->id }})" class="btn btn-link text-decoration-none text-danger p-0 fw-bold text-uppercase tracking-wider" style="font-size: 11px;">Purge</button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 bg-white shadow-sm rounded-4 p-5 text-center text-muted border-dashed">
                <div class="card-body py-5">
                    <span class="fs-1 d-block mb-3">📁</span>
                    <h5 class="fw-bold text-dark">Boardroom Archives Empty</h5>
                    <p class="small text-muted mb-0">No meeting documents have been written. Click "New Meeting Document" to initialize corporate log recording parameters.</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>

<div class="modal fade" id="addMinutesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 p-3">
            <div class="modal-body">
                <h4 class="fw-bold text-dark mb-1">Draft New Meeting Document</h4>
                <p class="text-uppercase tracking-wider text-muted mb-4" style="font-size: 11px; font-weight: 700;">Corporate Minutes File Configuration</p>
                
                <form action="{{ route('notes.store') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Meeting Subject</label>
                            <input type="text" name="subject" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Location / Place</label>
                            <input type="text" name="place" class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Date</label>
                            <input type="date" name="meeting_date" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Time</label>
                            <input type="time" name="meeting_time" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Minutes Taken By</label>
                            <input type="text" name="minutes_taken_by" class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Agenda Parameters</label>
                            <textarea name="agenda" rows="3" class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none" placeholder="Target agenda parameters to discuss..."></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Committee Attendees</label>
                            <textarea name="attendees" rows="3" class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none" placeholder="John Doe, Jane Smith, etc."></textarea>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Meeting Notes / Transcripts</label>
                        <textarea name="meeting_notes" rows="6" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none" placeholder="Write comprehensive minutes here..."></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light text-secondary fw-semibold px-4 py-2 rounded-3 text-sm shadow-none" data-bs-dismiss="modal">Cancel Document</button>
                        <button type="submit" class="btn btn-primary fw-semibold px-4 py-2 rounded-3 text-sm border-0 shadow-sm" style="background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);">Archive Minutes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editMinutesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 p-3">
            <div class="modal-body">
                <h4 class="fw-bold text-dark mb-1">Modify Document Vault Entry</h4>
                <p class="text-uppercase tracking-wider text-muted mb-4" style="font-size: 11px; font-weight: 700;">Update meeting variables safely</p>
                
                <form id="editMinutesForm" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Meeting Subject</label>
                            <input type="text" id="edit_subject" name="subject" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Location / Place</label>
                            <input type="text" id="edit_place" name="place" class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Date</label>
                            <input type="date" id="edit_meeting_date" name="meeting_date" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Time</label>
                            <input type="time" id="edit_meeting_time" name="meeting_time" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Minutes Taken By</label>
                            <input type="text" id="edit_minutes_taken_by" name="minutes_taken_by" class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Agenda Parameters</label>
                            <textarea id="edit_agenda" name="agenda" rows="3" class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none"></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Committee Attendees</label>
                            <textarea id="edit_attendees" name="attendees" rows="3" class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none"></textarea>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px;">Meeting Notes / Transcripts</label>
                        <textarea id="edit_meeting_notes" name="meeting_notes" rows="6" required class="form-control bg-light border-0 py-2.5 rounded-3 text-sm shadow-none"></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light text-secondary fw-semibold px-4 py-2 rounded-3 text-sm shadow-none" data-bs-dismiss="modal">Cancel Modification</button>
                        <button type="submit" class="btn btn-primary fw-semibold px-4 py-2 rounded-3 text-sm border-0 shadow-sm" style="background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);">Update Archive</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteMinutesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4 p-3">
            <div class="modal-body text-center">
                <h4 class="fw-bold text-dark mb-2">Purge Minutes?</h4>
                <p class="text-muted small mb-4">Are you absolutely sure you want to delete this document trace? Recovery operations are not possible.</p>
                
                <form id="deleteMinutesForm" method="POST" class="d-flex justify-content-center gap-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-light text-secondary fw-semibold px-4 py-2 rounded-3 text-sm shadow-none" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger fw-semibold px-4 py-2 rounded-3 text-sm border-0 shadow-sm">Purge Note</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1.25rem !important; }
    .bg-light { background-color: #f8fafc !important; }
    .tracking-wider { letter-spacing: 0.05em !important; }
    .border-dashed { border: 2px dashed #e2e8f0 !important; background: transparent !important; }
    .form-control:focus, .form-textarea:focus { background-color: #fff !important; border: 1px solid #1d4ed8 !important; }
</style>

<script>
    let addModal, editModal, deleteModal;

    document.addEventListener("DOMContentLoaded", function () {
        addModal = new bootstrap.Modal(document.getElementById('addMinutesModal'));
        editModal = new bootstrap.Modal(document.getElementById('editMinutesModal'));
        deleteModal = new bootstrap.Modal(document.getElementById('deleteMinutesModal'));
        
        // Auto fade success messages cleanly
        setTimeout(() => {
            const toastEl = document.querySelector('.toast');
            if(toastEl) { toastEl.classList.remove('show'); setTimeout(() => toastEl.remove(), 300); }
        }, 4000);
    });

    function openAddMinutesModal() { addModal.show(); }

    function openEditMinutesModal(id, data) {
        document.getElementById('editMinutesForm').action = `/notes/${id}`;
        document.getElementById('edit_subject').value = data.subject || '';
        document.getElementById('edit_place').value = data.place || '';
        document.getElementById('edit_meeting_date').value = data.meeting_date || '';
        document.getElementById('edit_meeting_time').value = data.meeting_time ? data.meeting_time.substring(0,5) : '';
        document.getElementById('edit_minutes_taken_by').value = data.minutes_taken_by || '';
        document.getElementById('edit_agenda').value = data.agenda || '';
        document.getElementById('edit_attendees').value = data.attendees || '';
        document.getElementById('edit_meeting_notes').value = data.meeting_notes || '';
        editModal.show();
    }

    function openDeleteMinutesModal(id) {
        document.getElementById('deleteMinutesForm').action = `/notes/${id}`;
        deleteModal.show();
    }
</script>
@endsection