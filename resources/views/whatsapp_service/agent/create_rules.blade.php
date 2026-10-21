<x-admindashboard>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/admindashboard') }}">Dashboardadmin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('/admindashboard/bots-r') }}">Bots-r</a></li>
    <li class="breadcrumb-item active" aria-current="page">Crear Bot Normal (Reglas)</li>
  </ol>
</nav>

<div class="container py-3">
  <div class="row justify-content-center">
    <div class="col-xl-9 col-lg-10">

      {{-- ── Encabezado Principal ── --}}
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
          <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 rounded-pill">
              <i class="bi bi-diagram-3-fill me-1"></i> Motor de Reglas
            </span>
            <span class="badge bg-light text-secondary border px-2 py-1 rounded-pill">
              Gratis & Premium
            </span>
          </div>
          <h2 class="fw-bold mb-1">🤖 Crear Bot Normal (Reglas Lógicas)</h2>
          <p class="text-muted mb-0">Configura un agente estructurado con respuestas automáticas detonadas por palabras clave exactas.</p>
        </div>
        <a href="{{ route('/admindashboard/bots-r') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm">
          <i class="bi bi-arrow-left me-1"></i> Volver a Bots
        </a>
      </div>

      @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
          <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      {{-- ── Explicación de Funcionamiento ── --}}
      <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px; background: linear-gradient(135deg, rgba(13, 110, 253, 0.05) 0%, rgba(13, 110, 253, 0.01) 100%);">
        <div class="card-body p-4">
          <div class="d-flex align-items-start gap-3">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
              <i class="bi bi-lightning-charge-fill fs-5"></i>
            </div>
            <div>
              <h5 class="fw-bold text-dark mb-1">¿Cómo funciona un Bot Normal?</h5>
              <p class="text-muted small mb-2">
                Este tipo de bot opera con reglas deterministas tipo <em>"Si el cliente escribe <strong>[palabra clave]</strong>, responder con <strong>[mensaje]</strong>"</em>. Es 100% predecible, seguro y no requiere modelos de lenguaje.
              </p>
              <div class="d-flex flex-wrap gap-2 pt-1">
                <span class="badge bg-white text-dark border small py-1 px-2">
                  <i class="bi bi-check2 text-success me-1"></i> Respuestas instantáneas
                </span>
                <span class="badge bg-white text-dark border small py-1 px-2">
                  <i class="bi bi-check2 text-success me-1"></i> Menús de opciones numéricas
                </span>
                <span class="badge bg-white text-dark border small py-1 px-2">
                  <i class="bi bi-check2 text-success me-1"></i> Preguntas frecuentes fijas
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- ── Formulario de Creación ── --}}
      <form action="{{ route('bot.store') }}" method="POST">
        @csrf

        {{-- Deshabilitar IA explícitamente para bot normal --}}
        <input type="hidden" name="ai_enabled" value="0">

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px;">
          <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-semibold text-primary">
              <i class="bi bi-card-checklist me-2"></i>Información del Bot
            </h5>
            <span class="text-muted small">Paso 1 de 2</span>
          </div>

          <div class="card-body p-4">
            <div class="row g-4">
              <div class="col-md-8">
                <label class="form-label fw-semibold">
                  Nombre del Bot <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light text-muted border-end-0">
                    <i class="bi bi-robot"></i>
                  </span>
                  <input type="text" 
                         name="name" 
                         class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" 
                         value="{{ old('name') }}" 
                         placeholder="Ej: Bot Menú Principal WhatsApp" 
                         required 
                         autofocus />
                </div>
                <div class="form-text">Nombre descriptivo para identificarlo en tu panel.</div>
                @error('name')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-4">
                <label class="form-label fw-semibold">
                  Versión <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light text-muted border-end-0">
                    <i class="bi bi-tag"></i>
                  </span>
                  <input type="text" 
                         name="version" 
                         class="form-control border-start-0 ps-0 @error('version') is-invalid @enderror" 
                         value="{{ old('version', '1.0') }}" 
                         placeholder="1.0" 
                         required />
                </div>
                <div class="form-text">Ejemplo: 1.0, 2.1</div>
                @error('version')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-12">
                <label class="form-label fw-semibold">
                  Descripción del Bot <span class="text-danger">*</span>
                </label>
                <textarea name="description" 
                          rows="3"
                          class="form-control @error('description') is-invalid @enderror" 
                          placeholder="Ej: Bot con menú de opciones para orientar clientes sobre precios, ubicación y horarios de atención." 
                          required>{{ old('description') }}</textarea>
                <div class="form-text">Resume el objetivo o ámbito de atención de este bot.</div>
                @error('description')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="card-footer bg-light p-4 d-flex flex-wrap align-items-center justify-content-between gap-3 border-top">
            <div class="text-muted small">
              <i class="bi bi-info-circle me-1"></i> Al guardar, serás redirigido para configurar las <strong>palabras clave y respuestas</strong>.
            </div>
            <div class="d-flex align-items-center gap-2">
              <a href="{{ route('/admindashboard/bots-r') }}" class="btn btn-outline-secondary px-3">
                Cancelar
              </a>
              <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                Guardar y Crear Reglas <i class="bi bi-arrow-right ms-1"></i>
              </button>
            </div>
          </div>
        </div>
      </form>

      {{-- ── Banner Opcional: ¿Buscas Inteligencia Artificial? ── --}}
      <div class="card border border-warning-subtle shadow-sm mb-4" style="border-radius: 14px; background: rgba(255, 193, 7, 0.04);">
        <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
          <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
              <i class="bi bi-stars fs-5"></i>
            </div>
            <div>
              <h6 class="fw-bold mb-1">¿Necesitas que tu bot hable con fluidez usando IA?</h6>
              <p class="text-muted small mb-0">
                Los <strong>Bots con MLL (Inteligencia Artificial)</strong> entienden preguntas complejas, aprenden de tu negocio y responden como un asesor humano.
              </p>
            </div>
          </div>
          <a href="{{ route('bot.create.mll') }}" class="btn btn-outline-warning text-dark fw-semibold btn-sm px-3 rounded-pill">
            Ver Bot con IA (MLL) <i class="bi bi-chevron-right ms-1"></i>
          </a>
        </div>
      </div>

    </div>
  </div>
</div>

</x-admindashboard>
