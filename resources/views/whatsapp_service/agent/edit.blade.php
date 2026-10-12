<x-admindashboard>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/admindashboard') }}">Dashboardadmin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('/admindashboard/bots-r') }}">Bots-r</a></li>
    <li class="breadcrumb-item"><a href="{{ route('/admindashboard/bots-r/', $Bot->id) }}">{{ $Bot->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
  </ol>
</nav>

<div class="container py-3">
  <div class="row justify-content-center">
    <div class="col-xl-10">

      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="fw-bold mb-1">⚙️ Editar Bot: {{ $Bot->name }}</h2>
          <p class="text-muted mb-0">Actualiza los datos del agente, su estado activo y la configuración de Inteligencia Artificial.</p>
        </div>
        <a href="{{ route('/admindashboard/bots-r/', $Bot->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
          <i class="bi bi-arrow-left me-1"></i> Ver Detalles
        </a>
      </div>

      @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
          <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <form action="{{ route('bot-r.update', $Bot->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- ── 1. DATOS BÁSICOS Y ESTADO DEL BOT ── --}}
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
          <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-semibold text-primary">
              <i class="bi bi-info-circle-fill me-2"></i>1. Información General y Estado
            </h5>
          </div>
          <div class="card-body p-4">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Nombre del Bot <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $Bot->name) }}" required />
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-3">
                <label class="form-label fw-semibold">Versión <span class="text-danger">*</span></label>
                <input type="text" name="version" class="form-control @error('version') is-invalid @enderror" 
                       value="{{ old('version', $Bot->version) }}" required />
                @error('version')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-3">
                <label class="form-label fw-semibold">Estado del Bot <span class="text-danger">*</span></label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                  <option value="active" {{ old('status', $Bot->status) == 'active' ? 'selected' : '' }}>🟢 Activo</option>
                  <option value="no-active" {{ old('status', $Bot->status) == 'no-active' ? 'selected' : '' }}>🔴 Inactivo</option>
                </select>
                @error('status')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-12">
                <label class="form-label fw-semibold">Descripción del Bot <span class="text-danger">*</span></label>
                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" 
                       value="{{ old('description', $Bot->description) }}" required />
                @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
        </div>

        {{-- ── 2. CONFIGURACIÓN DEL AGENTE DE IA (LLM) ── --}}
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
          <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-semibold text-success">
              <i class="bi bi-stars me-2"></i>2. Motor de Inteligencia Artificial & Personalidad
            </h5>
            <div class="form-check form-switch mb-0 fs-5">
              <input class="form-check-input" type="checkbox" role="switch" id="ai_enabled" name="ai_enabled" 
                     value="1" {{ old('ai_enabled', $Bot->ai_enabled) ? 'checked' : '' }}>
              <label class="form-check-label fs-6 fw-bold text-dark ms-1" for="ai_enabled">
                Habilitar IA
              </label>
            </div>
          </div>
          
          <div class="card-body p-4">
            <div class="alert alert-info border-0 rounded-3 mb-4 d-flex align-items-center">
              <i class="bi bi-lightbulb-fill fs-4 me-3 text-info"></i>
              <div class="small">
                <strong>Proveedor Activo:</strong> Este agente responde utilizando <strong>Google Gemini ({{ $Bot->ai_model ?: 'gemini-3.5-flash-lite' }})</strong> cuando no hay reglas estáticas que coincidan con el mensaje del lead.
              </div>
            </div>

            <div class="row g-3">
              {{-- Nombre del personaje --}}
              <div class="col-md-6">
                <label class="form-label fw-semibold">Nombre del Agente / Personaje</label>
                <input type="text" name="persona_name" class="form-control @error('persona_name') is-invalid @enderror" 
                       value="{{ old('persona_name', $Bot->persona_name) }}" placeholder="Ej: Sofi, Carlos, Andrea" />
                <div class="form-text">El nombre con el que el bot se presentará a tus clientes.</div>
                @error('persona_name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Rol o cargo --}}
              <div class="col-md-6">
                <label class="form-label fw-semibold">Rol o Cargo en tu Empresa</label>
                <input type="text" name="role" class="form-control @error('role') is-invalid @enderror" 
                       value="{{ old('role', $Bot->role) }}" 
                       placeholder="Ej: Asesora comercial y atención a clientes" />
                <div class="form-text">Qué función cumple dentro del negocio.</div>
                @error('role')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Tono y Creatividad --}}
              <div class="col-md-6">
                <label class="form-label fw-semibold">Tono de Comunicación</label>
                <select name="tone" class="form-select @error('tone') is-invalid @enderror">
                  <option value="cercano" {{ old('tone', $Bot->tone) == 'cercano' ? 'selected' : '' }}>🤝 Cercano y empático (Recomendado para ventas)</option>
                  <option value="formal" {{ old('tone', $Bot->tone) == 'formal' ? 'selected' : '' }}>🎩 Formal y respetuoso (Servicios profesionales/legales)</option>
                  <option value="carismatico" {{ old('tone', $Bot->tone) == 'carismatico' ? 'selected' : '' }}>✨ Carismático y alegre (Tiendas y retail)</option>
                  <option value="tecnico" {{ old('tone', $Bot->tone) == 'tecnico' ? 'selected' : '' }}>🛠️ Técnico y directo (Soporte o B2B)</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Nivel de Creatividad (Temperatura)</label>
                <select name="temperature" class="form-select @error('temperature') is-invalid @enderror">
                  <option value="0.30" {{ old('temperature', $Bot->temperature) == '0.30' ? 'selected' : '' }}>🎯 Preciso y riguroso (0.3 - Menos improvisación)</option>
                  <option value="0.70" {{ old('temperature', $Bot->temperature) == '0.70' || empty($Bot->temperature) ? 'selected' : '' }}>⚖️ Equilibrado (0.7 - Recomendado)</option>
                  <option value="0.90" {{ old('temperature', $Bot->temperature) == '0.90' ? 'selected' : '' }}>💡 Muy creativo y conversacional (0.9)</option>
                </select>
              </div>

              {{-- Base de Conocimiento (Knowledge Base) --}}
              <div class="col-12 mt-4">
                <label class="form-label fw-semibold d-flex justify-content-between align-items-center">
                  <span>📚 Base de Conocimiento del Negocio <span class="badge bg-primary-subtle text-primary ms-1">Clave para la IA</span></span>
                  <span class="small text-muted font-monospace">Lo que sabe tu bot</span>
                </label>
                <textarea name="knowledge_base" rows="7" class="form-control font-monospace small @error('knowledge_base') is-invalid @enderror" 
                          placeholder="Escribe o pega aquí la información de tu empresa:&#10;- Servicios que ofrecen&#10;- Lista de precios o planes&#10;- Horarios de atención&#10;- Métodos de pago y enlaces de compra&#10;- Políticas de envío o devolución">{{ old('knowledge_base', $Bot->knowledge_base) }}</textarea>
                <div class="form-text">
                  La IA usará <strong>exclusivamente</strong> este texto para responder dudas sobre precios, horarios y productos.
                </div>
                @error('knowledge_base')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Historia y trasfondo --}}
              <div class="col-md-6 mt-3">
                <label class="form-label fw-semibold">Historia Propia (Backstory)</label>
                <textarea name="backstory" rows="3" class="form-control small @error('backstory') is-invalid @enderror" 
                          placeholder="Ej: Llevo 2 años en el equipo ayudando a personas a encontrar el producto ideal.">{{ old('backstory', $Bot->backstory) }}</textarea>
                <div class="form-text">Permite que el agente hable de sí mismo de forma coherente si le preguntan.</div>
              </div>

              {{-- Reglas de Estilo para WhatsApp --}}
              <div class="col-md-6 mt-3">
                <label class="form-label fw-semibold">Reglas de Estilo WhatsApp</label>
                <textarea name="style_rules" rows="3" class="form-control small @error('style_rules') is-invalid @enderror" 
                          placeholder="Ej: Respuestas de máximo 2 a 3 líneas. Usa 1 o 2 emojis naturales.">{{ old('style_rules', $Bot->style_rules) }}</textarea>
                <div class="form-text">Controla la longitud del texto para evitar mensajes aburridos o largos.</div>
              </div>

              {{-- Límites y Reglas de Seguridad --}}
              <div class="col-12 mt-3">
                <label class="form-label fw-semibold">Límites y Reglas de Seguridad (Boundaries)</label>
                <textarea name="boundaries" rows="2" class="form-control small @error('boundaries') is-invalid @enderror" 
                          placeholder="Ej: Si preguntan si eres un bot, admite amablemente que eres un asistente virtual.">{{ old('boundaries', $Bot->boundaries) }}</textarea>
              </div>

            </div>
          </div>
        </div>

        {{-- Botones de acción --}}
        <div class="d-flex justify-content-end gap-2 mb-5">
          <a href="{{ route('/admindashboard/bots-r/', $Bot->id) }}" class="btn btn-outline-secondary px-4 py-2">Cancelar</a>
          <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm fw-semibold">
            <i class="bi bi-check2-circle me-1"></i> Guardar Cambios
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

</x-admindashboard>
