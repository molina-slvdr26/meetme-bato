@extends('layouts.app')

@section('content')
<div class="container py-2" style="max-width: 1200px;">
    
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="h2 fw-bold text-dark mb-1">Strategy Intelligence</h1>
            <p class="text-muted small mb-0">Welcome back, <span class="fw-bold text-primary">{{ auth()->user()->name }}</span>. Review latest boardroom indexes below.</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-2 bg-white">
                <div class="card-body d-flex align-items-center gap-3 p-2">
                    <div class="fs-3 bg-slate bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 3.5rem; height: 3.5rem; color: #1e293b; background-color: #f1f5f9;">
                        👥
                    </div>
                    <div>
                        <h3 class="fw-bold text-dark mb-0 fs-3">{{ $totalUsers }}</h3>
                        <p class="text-muted uppercase-tracking mb-0">Board Members</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-2 bg-white">
                <div class="card-body d-flex align-items-center gap-3 p-2">
                    <div class="fs-3 bg-amber bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 3.5rem; height: 3.5rem; color: #E67E5A; background-color: rgba(230, 126, 90, 0.08);">
                        📁
                    </div>
                    <div>
                        <h3 class="fw-bold text-dark mb-0 fs-3">{{ $totalNotes }}</h3>
                        <p class="text-muted uppercase-tracking mb-0">Total Minutes</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-2 bg-white">
                <div class="card-body d-flex align-items-center gap-3 p-2">
                    <div class="fs-3 bg-primary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 3.5rem; height: 3.5rem; color: #1d4ed8; background-color: rgba(29, 78, 216, 0.06);">
                        ⚖️
                    </div>
                    <div>
                        <h3 class="fw-bold text-dark mb-0 fs-3">{{ $myNotesCount }}</h3>
                        <p class="text-muted uppercase-tracking mb-0">My Briefings</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-2 bg-white">
                <div class="card-body d-flex align-items-center gap-3 p-2">
                    <div class="fs-3 bg-success bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 3.5rem; height: 3.5rem; color: #10b981; background-color: rgba(16, 185, 129, 0.06);">
                        📅
                    </div>
                    <div>
                        <h3 class="fw-bold text-dark mb-0 fs-3">{{ $thisMonthNotes }}</h3>
                        <p class="text-muted uppercase-tracking mb-0">This Month</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-5 p-4 d-flex flex-column justify-content-between layout-chart-card" style="min-height: 400px;">
                <div class="mb-3">
                    <h5 class="fw-bold text-dark mb-1">Briefing Volume Velocity</h5>
                    <p class="text-muted text-uppercase tracking-wider mb-0" style="font-size: 10px; font-weight: 700; color: #94a3b8 !important;">Chronological strategy session cadence analytics</p>
                </div>
                <div class="position-relative flex-grow-1 w-100" style="height: 280px;">
                    <canvas id="dashboardTimelineChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-5 p-4 d-flex flex-column justify-content-between layout-chart-card" style="min-height: 400px;">
                <div class="mb-3">
                    <h5 class="fw-bold text-dark mb-1">Resource Index Densities</h5>
                    <p class="text-muted text-uppercase tracking-wider mb-0" style="font-size: 10px; font-weight: 700; color: #94a3b8 !important;">Proportional ratio between members and log data matrices</p>
                </div>
                <div class="position-relative flex-grow-1 w-100 d-flex align-items-center justify-content-center" style="height: 260px;">
                    <div style="width: 200px; height: 200px; max-width: 100%; max-height: 100%;">
                        <canvas id="dashboardComparisonChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .rounded-5 { border-radius: 1.5rem !important; }
    .tracking-wider { letter-spacing: 0.05em !important; }
    .layout-chart-card { background-color: #ffffff; border: 1px solid rgba(0,0,0,0.01) !important; }
    .uppercase-tracking {
        font-size: 10px;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.05em;
        color: #64748b;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
       
        const ctxTimeline = document.getElementById('dashboardTimelineChart').getContext('2d');
        new Chart(ctxTimeline, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Sessions Documented',
                    data: {!! json_encode($counts) !!},
                    borderColor: '#1d4ed8', 
                    backgroundColor: 'rgba(29, 78, 216, 0.04)',
                    borderWidth: 2.5,
                    tension: 0.3, 
                    fill: true,
                    pointBackgroundColor: '#1d4ed8',
                    pointHoverBackgroundColor: '#1e40af',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 15,
                        bottom: 0,
                        left: 5,
                        right: 15
                    }
                },
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grace: '10%',
                        ticks: { 
                            stepSize: 1, 
                            precision: 0,
                            color: '#94a3b8', 
                            font: { size: 11, weight: '500' } 
                        },
                        grid: { color: '#f1f5f9' },
                        border: { dash: [5, 5] }
                    },
                    x: {
                        ticks: { 
                            color: '#94a3b8', 
                            font: { size: 11, weight: '500' } 
                        },
                        grid: { display: false }
                    }
                }
            }
        });

        
        const ctxCompare = document.getElementById('dashboardComparisonChart').getContext('2d');
        new Chart(ctxCompare, {
            type: 'doughnut',
            data: {
                labels: ['Committee Personnel', 'Minutes Archived'],
                datasets: [{
                    data: [{{ $totalUsers }}, {{ $totalNotes }}],
                    backgroundColor: ['#0f172a', '#E67E5A'], 
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            usePointStyle: true,
                            font: { size: 11, weight: '600' },
                            color: '#475569',
                            padding: 15
                        }
                    }
                },
                cutout: '76%'
            }
        });
    });
</script>
@endsection