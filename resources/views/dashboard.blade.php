@extends('layouts.app')
@section('content')
<div style="padding: 2rem; max-width: 1280px; margin: 0 auto;">

    <div style="margin-bottom: 2rem;">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-sub">Welcome back, <strong style="color:#4F46E5;">{{ auth()->user()->name }}</strong>. Here's what's happening.</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-6 col-xl-3">
            <div class="card-premium p-4">
                <div style="display:flex;align-items:center;gap:1rem;">
                    <div style="width:3rem;height:3rem;border-radius:0.75rem;background:rgba(79,70,229,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-users" style="color:#4F46E5;font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div style="font-size:1.75rem;font-weight:800;color:#0F172A;line-height:1;">{{ $totalUsers }}</div>
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;margin-top:0.2rem;">Board Members</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card-premium p-4">
                <div style="display:flex;align-items:center;gap:1rem;">
                    <div style="width:3rem;height:3rem;border-radius:0.75rem;background:rgba(16,185,129,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-file-alt" style="color:#10B981;font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div style="font-size:1.75rem;font-weight:800;color:#0F172A;line-height:1;">{{ $totalNotes }}</div>
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;margin-top:0.2rem;">Total Minutes</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card-premium p-4">
                <div style="display:flex;align-items:center;gap:1rem;">
                    <div style="width:3rem;height:3rem;border-radius:0.75rem;background:rgba(245,158,11,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-bookmark" style="color:#F59E0B;font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div style="font-size:1.75rem;font-weight:800;color:#0F172A;line-height:1;">{{ $myNotesCount }}</div>
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;margin-top:0.2rem;">My Briefings</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card-premium p-4">
                <div style="display:flex;align-items:center;gap:1rem;">
                    <div style="width:3rem;height:3rem;border-radius:0.75rem;background:rgba(236,72,153,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-calendar-check" style="color:#EC4899;font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div style="font-size:1.75rem;font-weight:800;color:#0F172A;line-height:1;">{{ $thisMonthNotes }}</div>
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;margin-top:0.2rem;">This Month</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="card-premium p-4" style="height:380px;display:flex;flex-direction:column;">
                <div style="margin-bottom:1.25rem;">
                    <div style="font-size:1rem;font-weight:700;color:#0F172A;">Meeting Volume</div>
                    <div style="font-size:0.75rem;color:#94A3B8;margin-top:0.2rem;">Sessions documented over time</div>
                </div>
                <div style="flex:1;position:relative;">
                    <canvas id="timelineChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5">
            <div class="card-premium p-4" style="height:380px;display:flex;flex-direction:column;">
                <div style="margin-bottom:1.25rem;">
                    <div style="font-size:1rem;font-weight:700;color:#0F172A;">Distribution</div>
                    <div style="font-size:0.75rem;color:#94A3B8;margin-top:0.2rem;">Members vs. archived minutes</div>
                </div>
                <div style="flex:1;display:flex;align-items:center;justify-content:center;">
                    <div style="width:220px;height:220px;">
                        <canvas id="donutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    new Chart(document.getElementById('timelineChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Sessions',
                data: {!! json_encode($counts) !!},
                borderColor: '#4F46E5',
                backgroundColor: 'rgba(79,70,229,0.06)',
                borderWidth: 2.5,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#4F46E5',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0, color: '#94A3B8', font: { size: 11 } }, grid: { color: '#F1F5F9' }, border: { dash: [4,4] } },
                x: { ticks: { color: '#94A3B8', font: { size: 11 } }, grid: { display: false } }
            }
        }
    });
    new Chart(document.getElementById('donutChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Members', 'Minutes'],
            datasets: [{ data: [{{ $totalUsers }}, {{ $totalNotes }}], backgroundColor: ['#4F46E5', '#818CF8'], borderWidth: 3, borderColor: '#fff', hoverOffset: 4 }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, usePointStyle: true, font: { size: 12, weight: '600' }, color: '#475569', padding: 16 } } },
            cutout: '72%'
        }
    });
});
</script>
@endsection
