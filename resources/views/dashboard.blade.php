@extends('layouts.app')
@section('content')
<div class="page-wrap">

    {{-- Header --}}
    <div style="margin-bottom:2rem;display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:1rem;">
        <div>
            <div style="font-size:0.6875rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--primary);margin-bottom:0.375rem;">Welcome back</div>
            <h1 class="page-title">{{ auth()->user()->name }}</h1>
            <p class="page-desc">Here's what's happening with your workspace today.</p>
        </div>
        <div style="font-size:0.75rem;color:var(--t3);font-weight:500;text-align:right;">
            <div style="font-size:1rem;font-weight:700;color:var(--t2);">{{ now()->format('l') }}</div>
            <div>{{ now()->format('F d, Y') }}</div>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="card-p card-p-hover" style="padding:1.25rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                    <div style="font-size:0.6875rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--t3);">Board Members</div>
                    <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,rgba(99,102,241,0.12),rgba(139,92,246,0.12));display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-users" style="color:var(--primary);font-size:0.875rem;"></i>
                    </div>
                </div>
                <div style="font-size:2rem;font-weight:800;letter-spacing:-0.03em;color:var(--t1);line-height:1;">{{ $totalUsers }}</div>
                <div style="font-size:0.75rem;color:var(--t4);margin-top:0.25rem;">Total registered users</div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card-p card-p-hover" style="padding:1.25rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                    <div style="font-size:0.6875rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--t3);">Total Minutes</div>
                    <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,rgba(16,185,129,0.12),rgba(5,150,105,0.12));display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-file-lines" style="color:var(--success);font-size:0.875rem;"></i>
                    </div>
                </div>
                <div style="font-size:2rem;font-weight:800;letter-spacing:-0.03em;color:var(--t1);line-height:1;">{{ $totalNotes }}</div>
                <div style="font-size:0.75rem;color:var(--t4);margin-top:0.25rem;">Meeting notes archived</div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card-p card-p-hover" style="padding:1.25rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                    <div style="font-size:0.6875rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--t3);">My Briefings</div>
                    <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,rgba(245,158,11,0.12),rgba(217,119,6,0.12));display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-bookmark" style="color:var(--warning);font-size:0.875rem;"></i>
                    </div>
                </div>
                <div style="font-size:2rem;font-weight:800;letter-spacing:-0.03em;color:var(--t1);line-height:1;">{{ $myNotesCount }}</div>
                <div style="font-size:0.75rem;color:var(--t4);margin-top:0.25rem;">Notes authored by you</div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card-p card-p-hover" style="padding:1.25rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                    <div style="font-size:0.6875rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--t3);">This Month</div>
                    <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,rgba(236,72,153,0.12),rgba(219,39,119,0.12));display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-calendar-check" style="color:#EC4899;font-size:0.875rem;"></i>
                    </div>
                </div>
                <div style="font-size:2rem;font-weight:800;letter-spacing:-0.03em;color:var(--t1);line-height:1;">{{ $thisMonthNotes }}</div>
                <div style="font-size:0.75rem;color:var(--t4);margin-top:0.25rem;">{{ now()->format('F') }} sessions</div>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="row g-3">
        <div class="col-12 col-lg-8">
            <div class="card-p" style="padding:1.5rem;height:360px;display:flex;flex-direction:column;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1.25rem;">
                    <div>
                        <div style="font-size:0.875rem;font-weight:700;color:var(--t1);letter-spacing:-0.01em;">Session Volume</div>
                        <div style="font-size:0.75rem;color:var(--t3);margin-top:0.125rem;">Meeting notes documented over time</div>
                    </div>
                    <span class="badge-p badge-primary">Last 6 months</span>
                </div>
                <div style="flex:1;position:relative;"><canvas id="lineChart"></canvas></div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card-p" style="padding:1.5rem;height:360px;display:flex;flex-direction:column;">
                <div style="margin-bottom:1.25rem;">
                    <div style="font-size:0.875rem;font-weight:700;color:var(--t1);letter-spacing:-0.01em;">Distribution</div>
                    <div style="font-size:0.75rem;color:var(--t3);margin-top:0.125rem;">Members vs. archived minutes</div>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:1rem;">
                    <div style="width:180px;height:180px;"><canvas id="donutChart"></canvas></div>
                    <div style="display:flex;gap:1.25rem;">
                        <div style="display:flex;align-items:center;gap:0.4rem;font-size:0.75rem;font-weight:600;color:var(--t2);">
                            <span style="width:8px;height:8px;border-radius:2px;background:var(--primary);flex-shrink:0;"></span>Members
                        </div>
                        <div style="display:flex;align-items:center;gap:0.4rem;font-size:0.75rem;font-weight:600;color:var(--t2);">
                            <span style="width:8px;height:8px;border-radius:2px;background:#A5B4FC;flex-shrink:0;"></span>Minutes
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const gridColor = '#F3F4F6';
    const tickColor = '#9CA3AF';
    const font = { family: 'Inter', size: 11, weight: '500' };

    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Sessions',
                data: {!! json_encode($counts) !!},
                borderColor: '#6366F1',
                backgroundColor: 'rgba(99,102,241,0.06)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#6366F1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { backgroundColor: '#111827', titleFont: { ...font, weight: '700' }, bodyFont: font, padding: 10, cornerRadius: 8, displayColors: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0, color: tickColor, font }, grid: { color: gridColor }, border: { display: false, dash: [4,4] } },
                x: { ticks: { color: tickColor, font }, grid: { display: false }, border: { display: false } }
            }
        }
    });

    new Chart(document.getElementById('donutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Members', 'Minutes'],
            datasets: [{ data: [{{ $totalUsers }}, {{ $totalNotes }}], backgroundColor: ['#6366F1', '#A5B4FC'], borderWidth: 0, hoverOffset: 4 }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { backgroundColor: '#111827', titleFont: { ...font, weight: '700' }, bodyFont: font, padding: 10, cornerRadius: 8 } },
            cutout: '74%'
        }
    });
});
</script>
@endsection
