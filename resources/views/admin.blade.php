@extends('layouts.admin_layout')

@section('content')
<div class="mb-4">
    <p class="text-muted mb-1 fw-bold" style="font-size: 0.7rem; letter-spacing: 1.5px; text-transform: uppercase;">Descripción General</p>
    <h2 class="fw-bold mb-1" style="letter-spacing: -0.5px;">Dashboard</h2>
    <p class="text-muted" style="font-size: 0.9rem;">Supervise el rendimiento, las ganancias y el registro desde un único espacio de trabajo.</p>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card card-blue">
            <div class="card-gradient"></div>
            <div>
                <div class="icon-box"><i class="bi bi-currency-dollar"></i></div>
                <div class="stat-label">Ganancia Neta</div>
                <div class="stat-value">${{ number_format($netProfit, 2) }}</div>
                <div class="stat-sub"><span class="badge-up">Bruto: ${{ number_format($totalRevenue, 2) }}</span></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card card-green">
            <div class="card-gradient"></div>
            <div>
                <div class="icon-box"><i class="bi bi-droplet-half"></i></div>
                <div class="stat-label">Lavadas Totales</div>
                <div class="stat-value">{{ $totalWashes }}</div>
                <div class="stat-sub">Hoy: {{ $todayWashes }} lavados</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card card-yellow">
            <div class="card-gradient"></div>
            <div>
                <div class="icon-box"><i class="bi bi-people"></i></div>
                <div class="stat-label">Lavadores Activos</div>
                <div class="stat-value">{{ $washersRanking->count() }}</div>
                <div class="stat-sub">Pago total: ${{ number_format($totalInvested, 2) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card card-red">
            <div class="card-gradient"></div>
            <div>
                <div class="icon-box"><i class="bi bi-clock-history"></i></div>
                <div class="stat-label">En Proceso</div>
                <div class="stat-value">{{ $pendingCount }}</div>
                <div class="stat-sub" style="color: var(--accent-rose);">Pendientes de terminar</div>
            </div>
        </div>
    </div>
</div>

<!-- Chart + Ranking -->
<div class="row g-4 mb-4">
    <!-- Chart -->
    <div class="col-lg-8">
        <div class="panel d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="panel-title mb-0"><i class="bi bi-graph-up"></i> Rendimiento Mensual</h5>
                <span class="text-muted" style="font-size: 0.8rem;">Últimos 6 meses</span>
            </div>
            <div style="height: 280px; position: relative;">
                <canvas id="washesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Ranking -->
    <div class="col-lg-4">
        <div class="panel">
            <h5 class="panel-title"><i class="bi bi-trophy"></i> Ranking Lavadores</h5>
            <div>
                @forelse($washersRanking as $index => $washer)
                <div class="ranking-item">
                    <div class="rank-number">{{ $index + 1 }}</div>
                    <div class="rank-info">
                        <h6 class="mb-0">{{ $washer->name }}</h6>
                        <small>Comisión: {{ $washer->commission_rate }}%</small>
                    </div>
                    <div class="rank-count">{{ $washer->washes_count }}</div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="bi bi-emoji-neutral fs-1 text-muted"></i>
                    <p class="text-muted mt-2">No hay lavadores registrados</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Recent Records Table -->
<div class="row">
    <div class="col-12">
        <div class="panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="panel-title mb-0"><i class="bi bi-list-ul"></i> Registros Recientes</h5>
                <span class="text-muted" style="font-size: 0.8rem;">Últimos 15 registros</span>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Vehículo</th>
                            <th>Placa</th>
                            <th>Lavador</th>
                            <th>Estado</th>
                            <th>Método Pago</th>
                            <th>Cobrado</th>
                            <th>Comisión</th>
                            <th>Foto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentWashes as $wash)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(99,102,241,0.1); display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-car-front" style="color: var(--accent-indigo);"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold" style="font-size: 0.88rem;">{{ $wash->vehicle_type }}</div>
                                            <small class="text-muted">{{ $wash->color ?? 'Sin color' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-bold" style="font-family: monospace;">{{ $wash->plate_number }}</td>
                                <td><span class="badge-status badge-progress">{{ $wash->washer->name ?? 'N/A' }}</span></td>
                                <td>
                                    @if($wash->status === 'completed')
                                        <span class="badge-status badge-completed"><i class="bi bi-check-circle me-1"></i>Completado</span>
                                    @elseif($wash->status === 'in_progress')
                                        <span class="badge-status badge-progress"><i class="bi bi-arrow-repeat me-1"></i>En proceso</span>
                                    @else
                                        <span class="badge-status badge-pending"><i class="bi bi-clock me-1"></i>Pendiente</span>
                                    @endif
                                </td>
                                <td><span class="badge" style="background: rgba(100,116,139,0.1); color: #94a3b8; border: 1px solid rgba(100,116,139,0.2);">{{ $wash->payment_method }}</span></td>
                                <td class="fw-bold" style="color: var(--accent-green);">${{ number_format($wash->price, 2) }}</td>
                                <td style="color: var(--accent-yellow);">${{ number_format($wash->washer_payment, 2) }}</td>
                                <td>
                                    @if($wash->photo_path)
                                        <a href="/storage/{{ $wash->photo_path }}" target="_blank" class="btn btn-sm btn-outline-info" style="border-radius: 8px; font-size: 0.75rem;">
                                            <i class="bi bi-image"></i>
                                        </a>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.destroyWash', $wash) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este registro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="background: rgba(239,68,68,0.1); color: var(--accent-red); border-radius: 8px; font-size: 0.75rem; border: none;">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2" style="opacity: 0.5;"></i>
                                    No se han registrado lavados aún.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('washesChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 280);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($monthLabels),
            datasets: [{
                label: 'Lavados',
                data: @json($monthlyData),
                backgroundColor: gradient,
                borderColor: '#6366f1',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
                barThickness: 40,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#f1f5f9',
                    bodyColor: '#94a3b8',
                    borderColor: '#334155',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' lavados';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#64748b',
                        font: { size: 11 },
                        stepSize: 1
                    },
                    grid: {
                        color: 'rgba(51, 65, 85, 0.3)',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#64748b',
                        font: { size: 11, weight: '500' }
                    },
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endpush
