@extends('layouts.template')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-none overflow-hidden">
            <div class="p-6 text-gray-900 mb-5">
                {{ __("Dashboard") }}
            </div>

            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3 class="badge badge-primary">{{ session('counts')['indicateurs'] ?? 0 }}</h3>
                            <p>Indicateurs</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3 class="badge badge-success">{{ session('counts')['structures'] ?? 0 }}</h3>
                            <p>Structures</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-university"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3 class="badge badge-warning">{{ session('counts')['thematiques'] ?? 0 }}</h3>
                            <p>Thématiques</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cog"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3 class="badge badge-info">{{ session('counts')['users'] ?? 0 }}</h3>
                            <p>Utilisateurs</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Graphiques de statistiques --}}
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Statistiques par Catégorie (Barres)</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="barChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Répartition (Camembert)</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Script Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Données communes
    const chartData = {
        labels: ['Indicateurs', 'Structures', 'Thématiques', 'Utilisateurs'],
        counts: [
            {{ session('counts')['indicateurs'] ?? 0 }},
            {{ session('counts')['structures'] ?? 0 }},
            {{ session('counts')['thematiques'] ?? 0 }},
            {{ session('counts')['users'] ?? 0 }}
        ],
        colors: {
            bg: [
                'rgba(54, 162, 235, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(153, 102, 255, 0.7)'
            ],
            border: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(153, 102, 255, 1)'
            ]
        }
    };

    // Diagramme en barres
    const barCtx = document.getElementById('barChart').getContext('2d');
    const barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Nombre',
                data: chartData.counts,
                backgroundColor: chartData.colors.bg,
                borderColor: chartData.colors.border,
                borderWidth: 2,
                borderRadius: 5,
                hoverBackgroundColor: [
                    'rgba(54, 162, 235, 0.9)',
                    'rgba(75, 192, 192, 0.9)',
                    'rgba(255, 159, 64, 0.9)',
                    'rgba(153, 102, 255, 0.9)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: { size: 14 },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 4
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            weight: 'bold'
                        }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            }
        }
    });

    // Diagramme en camembert
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: chartData.labels,
            datasets: [{
                data: chartData.counts,
                backgroundColor: chartData.colors.bg,
                borderColor: chartData.colors.border,
                borderWidth: 2,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        padding: 20,
                        font: {
                            size: 12,
                            weight: 'bold'
                        },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: { size: 14 },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 4,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '0%',
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
</script>

<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: none;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 15px 20px;
    }
    .small-box {
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    .small-box:hover {
        transform: translateY(-5px);
    }
</style>
@endsection
