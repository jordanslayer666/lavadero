@extends('layouts.host_layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold mb-1" style="letter-spacing: -0.5px;">Panel de Recepción</h2>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">Gestión de ingresos y asignación de lavadores</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#addVehicleModal">
            <i class="bi bi-plus-lg me-1"></i> Recibir Vehículo
        </button>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-5">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="icon-box icon-blue"><i class="bi bi-car-front"></i></div>
            <div class="stat-info">
                <h6>VEHÍCULOS HOY</h6>
                <h3>{{ $todayWashes }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="icon-box icon-lightblue"><i class="bi bi-people-fill"></i></div>
            <div class="stat-info">
                <h6>LAVADORES</h6>
                <h3>{{ count($washers) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="icon-box icon-green"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-info">
                <h6>CAJA DEL DÍA</h6>
                <h3>${{ number_format($todayRevenue, 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="icon-box icon-purple"><i class="bi bi-check-circle-fill"></i></div>
            <div class="stat-info">
                <h6>TERMINADOS HOY</h6>
                <h3>{{ $todayCompleted }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Vehicles In Progress Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="panel">
            <div class="panel-header">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-arrow-repeat text-primary me-2"></i>Vehículos en Proceso
                    @if($inProgressWashes->count() > 0)
                        <span class="badge rounded-pill ms-2" style="background: var(--primary-light); color: var(--primary); font-size: 0.75rem;">{{ $inProgressWashes->count() }}</span>
                    @endif
                </h5>
            </div>
            <div class="panel-body">
                @if($inProgressWashes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Vehículo</th>
                                <th>Placa</th>
                                <th>Color</th>
                                <th>Lavador</th>
                                <th>Precio</th>
                                <th>Método Pago</th>
                                <th>Hora de ingreso</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inProgressWashes as $wash)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 36px; height: 36px; border-radius: 10px; background: var(--primary-light); display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-car-front" style="color: var(--primary);"></i>
                                        </div>
                                        <span class="fw-bold">{{ $wash->vehicle_type }}</span>
                                    </div>
                                </td>
                                <td><span class="fw-bold" style="font-family: monospace;">{{ $wash->plate_number }}</span></td>
                                <td>{{ $wash->color ?? '—' }}</td>
                                <td><span class="badge-status badge-progress">{{ $wash->washer->name ?? 'N/A' }}</span></td>
                                <td class="fw-bold" style="color: var(--success);">${{ number_format($wash->price, 2) }}</td>
                                <td><span class="badge" style="background: rgba(100,116,139,0.1); color: #475569; border: 1px solid rgba(100,116,139,0.2);">{{ $wash->payment_method }}</span></td>
                                <td class="text-muted">{{ $wash->created_at->format('h:i A') }}</td>
                                <td>
                                    <form action="{{ route('reception.updateStatus', $wash) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="btn btn-sm" style="background: var(--success-light); color: var(--success); border-radius: 8px; font-weight: 600; font-size: 0.78rem; border: none;">
                                            <i class="bi bi-check2-circle me-1"></i> Completar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <div style="width: 80px; height: 80px; border-radius: 20px; background: var(--warning-light); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <i class="bi bi-cone-striped fs-1" style="color: var(--warning);"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Sin vehículos en proceso</h5>
                    <p class="text-muted mb-4">Registra un vehículo para comenzar a trabajar.</p>
                    <button class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#addVehicleModal">
                        <i class="bi bi-plus-lg me-1"></i> Registrar Vehículo
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal para Agregar Vehículo -->
<div class="modal fade" id="addVehicleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-car-front-fill text-primary me-2"></i> Recepción de Vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/reception" method="POST" enctype="multipart/form-data" id="vehicleForm">
                @csrf
                <div class="modal-body">
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" style="border-radius: 10px;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Error:</strong> {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Tipo de Vehículo</label>
                            <select name="vehicle_type" class="form-select" required id="vehicleType">
                                <option value="">Seleccione...</option>
                                <option value="Carro">🚗 Carro</option>
                                <option value="Camioneta">🚙 Camioneta</option>
                                <option value="Camión">🚛 Camión</option>
                                <option value="Moto">🏍️ Moto</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Lavador Asignado</label>
                            <select name="washer_id" class="form-select" required id="washerId">
                                <option value="">Seleccione lavador...</option>
                                @foreach($washers as $washer)
                                    <option value="{{ $washer->id }}">{{ $washer->name }} ({{ $washer->commission_rate }}%)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small">Placa</label>
                            <input type="text" name="plate_number" class="form-control" placeholder="Ej. ABC-123" required id="plateNumber" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small">Color</label>
                            <input type="text" name="color" class="form-control" placeholder="Rojo, Azul..." id="vehicleColor">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small">Precio ($)</label>
                            <input type="number" step="0.01" min="0" name="price" class="form-control" placeholder="0.00" required id="washPrice">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small">Método Pago</label>
                            <select name="payment_method" class="form-select" required>
                                <option value="Efectivo">💵 Efectivo</option>
                                <option value="Tarjeta">💳 Tarjeta</option>
                                <option value="Transferencia">🏦 Transf.</option>
                                <option value="Yape/Plin">📱 Yape/Plin</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Observaciones / Detalles</label>
                        <textarea name="details" class="form-control" rows="2" placeholder="Ej: Rayón puerta trasera derecha..." id="vehicleDetails"></textarea>
                    </div>

                    <div>
                        <label class="form-label fw-bold text-muted small">Evidencia Fotográfica (Opcional)</label>
                        <div class="border rounded p-4 text-center" style="border-style: dashed !important; border-color: var(--border-color) !important; background: #f8fafc; border-radius: 12px !important;">
                            <input type="file" name="photo" class="d-none" id="photoInput" accept="image/*">
                            <label for="photoInput" class="btn btn-outline-primary btn-sm mb-2" style="border-radius: 8px;">
                                <i class="bi bi-camera me-1"></i> Seleccionar Imagen
                            </label>
                            <p class="text-muted small mb-0">JPG, PNG — Máx 5MB</p>
                            <div id="previewContainer" class="d-none mt-3">
                                <img id="photoPreview" src="" alt="Vista previa" class="img-thumbnail" style="max-height: 150px; border-radius: 12px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 10px;">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px;">
                        <i class="bi bi-check2-circle me-1"></i> Confirmar Ingreso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Vista previa de imagen
        $('#photoInput').change(function() {
            const file = this.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    alert('La imagen no debe superar 5MB.');
                    this.value = '';
                    return;
                }
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#photoPreview').attr('src', event.target.result);
                    $('#previewContainer').removeClass('d-none');
                }
                reader.readAsDataURL(file);
            }
        });

        // Mostrar modal si hay errores de validación
        @if($errors->any())
            new bootstrap.Modal(document.getElementById('addVehicleModal')).show();
        @endif

        // Uppercase placa
        $('#plateNumber').on('input', function() {
            this.value = this.value.toUpperCase();
        });
    });
</script>
@endpush
