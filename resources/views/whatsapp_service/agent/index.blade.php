<x-admindashboard>

<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold mb-0">🤖 Bots del Servicio de WhatsApp</h3>
            <p class="text-muted small mb-0">Administra los agentes virtuales, respuestas automáticas y configuración de IA.</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            @php
                $userPlan = auth()->user()->plan ?? 'free';
                $isPremium = auth()->user()->canUseAiBots();
            @endphp
            <span class="badge {{ $isPremium ? 'bg-success' : 'bg-primary' }} p-2">
                <i class="bi {{ $isPremium ? 'bi-gem' : 'bi-shield-check' }} me-1"></i>
                Plan: {{ strtoupper($userPlan) }}
            </span>
            <span class="badge bg-secondary p-2">
                Bots: {{ $currentBotCount ?? $Bots->total() }} / {{ config("plans.{$userPlan}.max_bots") === -1 ? '∞' : config("plans.{$userPlan}.max_bots") }}
            </span>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row align-items-center mb-3">
        <div class="col-md-6 mb-2 mb-md-0">
            @if($canCreateMore)
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <a href="{{ route('bot.create.rules') }}" class="btn btn-primary shadow-sm" role="button">
                        <i class="bi bi-robot me-1"></i> Crear Bot Normal
                    </a>
                    <a href="{{ route('bot.create.mll') }}" class="btn btn-outline-success shadow-sm" role="button">
                        <i class="bi bi-stars me-1 text-warning"></i> Crear Bot MLL (IA)
                        @if(!$canUseAi)
                            <span class="badge bg-warning text-dark ms-1" style="font-size: 0.65rem;">
                                <i class="bi bi-lock-fill"></i> PRO
                            </span>
                        @endif
                    </a>
                </div>
            @else
                <button class="btn btn-secondary disabled" title="Has alcanzado el límite de bots de tu plan">
                    <i class="bi bi-lock-fill me-1"></i> Límite de Bots Alcanzado
                </button>
                <small class="text-warning d-block mt-1">Has alcanzado el límite máximo de bots permitidos para el plan {{ ucfirst($userPlan) }}.</small>
            @endif
        </div>

        <div class="col-md-6 d-flex justify-content-md-end">
            <div class="btn-group" role="group">
                <a href="{{ route('/admindashboard/bots-r') }}" class="btn btn-outline-primary active">Todos</a>
                <a href="{{ route('bot.actives') }}" class="btn btn-outline-primary">Solo Activos</a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th scope="col" style="width: 50px;">#</th>
                        <th scope="col">Nombre del Bot</th>
                        <th scope="col">Tipo de Motor</th>
                        <th scope="col">Versión</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Descripción</th>
                        <th scope="col" class="text-end pe-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = ($Bots->currentPage() - 1) * $Bots->perPage() + 1;
                    @endphp

                    @forelse ($Bots as $Bot)
                        <tr>
                            <th scope="row">{{ $count++ }}</th>
                            <td class="fw-semibold">
                                <i class="bi bi-robot text-warning me-1 fs-5"></i>
                                {{ $Bot->name }}
                            </td>
                            <td>
                                @if($Bot->ai_enabled)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                        <i class="bi bi-stars me-1"></i>IA (LLM)
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-light border border-secondary-subtle">
                                        <i class="bi bi-cpu me-1"></i>Reglas
                                    </span>
                                @endif
                            </td>
                            <td><span class="badge bg-dark border text-light">{{ $Bot->version }}</span></td>
                            <td>
                                @if($Bot->status === 'active')
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-truncate" style="max-width: 250px;">
                                {{ $Bot->description }}
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('/admindashboard/bots-r/', $Bot->id) }}" class="btn btn-sm btn-outline-info me-1" title="Ver Detalles">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('bot.edit', $Bot->id) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                No hay bots registrados en este proyecto.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-3">
        {{ $Bots->links('pagination::bootstrap-5') }}
    </div>
</div>

</x-admindashboard>
