<x-admindashboard>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/admindashboard') }}">Dashboardadmin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('/admindashboard/bots-r') }}">Bots-r</a></li>
    <li class="breadcrumb-item active" aria-current="page">Crear Bot con IA (MLL)</li>
  </ol>
</nav>

<div class="container py-3">
  <div class="row justify-content-center">
    <div class="col-xl-10 col-lg-11">

      {{-- ── Encabezado Principal ── --}}
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
          <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge bg-warning text-dark border border-warning px-2.5 py-1 rounded-pill fw-semibold">
              <i class="bi bi-stars me-1"></i> Modelo de Lenguaje (MLL / LLM)
            </span>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
              ⭐ Exclusivo Premium
            </span>
          </div>
          <h2 class="fw-bold mb-1">✨ Crear Bot con Inteligencia Artificial (MLL)</h2>
          <p class="text-muted mb-0">Agente conversacional impulsado por LLM. Comprende contexto, habla con naturalidad y responde con la base de conocimiento de tu negocio.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
          <a href="{{ route('bot.create.rules') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm">
            <i class="bi bi-robot me-1"></i> Crear Bot Normal
          </a>
          <a href="{{ route('/admindashboard/bots-r') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver a Bots
          </a>
        </div>
      </div>

      @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
          <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if (!$canUseAi)
        {{-- ── BLOQUE DE RESTRICCIÓN PARA PLAN GRATUITO ── --}}
        <div class="card border-0 shadow-lg mb-5 overflow-hidden" style="border-radius: 16px; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #fff;">
          <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4">
              <div class="col-lg-8">
                <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-3" style="letter-spacing: 0.5px;">
                  <i class="bi bi-lock-fill me-1"></i> Funcionalidad Bloqueada en Plan Free
                </span>
                <h3 class="fw-bold text-white mb-2">Desbloquea Bots con Inteligencia Artificial (MLL)</h3>
                <p class="text-white-50 mb-4" style="line-height: 1.6;">
                  Tu cuenta se encuentra en el <strong>Plan Gratuito</strong>. Los Bots impulsados por Modelos de Lenguaje (MLL) utilizan inteligencia artificial generativa avanzada para entender a tus clientes de manera humana, recordar el contexto de la charla y responder 24/7 sin reglas rígidas.
                </p>

                <div class="row g-3 mb-4">
                  <div class="col-sm-6">
                    <div class="d-flex align-items-start gap-2 text-white-50">
                      <i class="bi bi-check-circle-fill text-warning fs-5"></i>
                      <span class="small text-white">Comprensión de lenguaje natural sin palabras clave exactas.</span>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="d-flex align-items-start gap-2 text-white-50">
                      <i class="bi bi-check-circle-fill text-warning fs-5"></i>
                      <span class="small text-white">Base de conocimiento de tu catálogo, precios y preguntas frecuentes.</span>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="d-flex align-items-start gap-2 text-white-50">
                      <i class="bi bi-check-circle-fill text-warning fs-5"></i>
                      <span class="small text-white">Personalidad a medida: Tono comercial, empático o formal.</span>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="d-flex align-items-start gap-2 text-white-50">
                      <i class="bi bi-check-circle-fill text-warning fs-5"></i>
                      <span class="small text-white">Límites éticos y derivación inteligente a asesores humanos.</span>
                    </div>
                  </div>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-3">
                  <a href="{{ route('project.settings') }}" class="btn btn-warning fw-bold px-4 py-2.5 rounded-pill shadow">
                    <i class="bi bi-gem me-1.5"></i> Actualizar a Plan Premium
                  </a>
                  <a href="{{ route('bot.create.rules') }}" class="btn btn-outline-light px-4 py-2.5 rounded-pill">
                    <i class="bi bi-robot me-1.5"></i> Continuar con Bot Normal (Gratis)
                  </a>
                </div>
              </div>

              <div class="col-lg-4 text-center d-none d-lg-block">
                <div class="p-4 rounded-4" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                  <div class="display-3 text-warning mb-2">
                    <i class="bi bi-robot"></i>
                  </div>
                  <div class="fw-semibold text-white mb-1">Asistente Virtual con MLL</div>
                  <div class="small text-white-50">Respuestas fluidas e inteligentes en tu WhatsApp oficial</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Vista previa deshabilitada del formulario para que el usuario conozca lo que incluye --}}
        <div class="text-center mb-3">
          <span class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.5px;">
            <i class="bi bi-eye me-1"></i> Vista previa de configuración (Modo Solo Lectura)
          </span>
        </div>
      @endif

      {{-- ── FORMULARIO DE CREACIÓN DE BOT MLL ── --}}
      <form action="{{ route('bot.store') }}" method="POST">
        @csrf

        {{-- Habilitar IA explícitamente para bot MLL --}}
        <input type="hidden" name="ai_enabled" value="1">

        <fieldset {{ $canUseAi ? '' : 'disabled' }} style="{{ $canUseAi ? '' : 'opacity: 0.55; filter: grayscale(20%); pointer-events: none;' }}">

          {{-- ── 1. Información Básica ── --}}
          <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px;">
            <div class="card-header bg-white border-bottom py-3">
              <h5 class="mb-0 fw-semibold text-primary">
                <i class="bi bi-info-circle-fill me-2"></i>1. Información General del Bot
              </h5>
            </div>
            <div class="card-body p-4">
              <div class="row g-4">
                <div class="col-md-8">
                  <label class="form-label fw-semibold">Nombre del Bot <span class="text-danger">*</span></label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                         value="{{ old('name') }}" placeholder="Ej: Agente Virtual Inteligente WhatsApp" required />
                  <div class="form-text">Nombre interno con el que identificarás este bot en tus métricas y reportes.</div>
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-4">
                  <label class="form-label fw-semibold">Versión <span class="text-danger">*</span></label>
                  <input type="text" name="version" class="form-control @error('version') is-invalid @enderror" 
                         value="{{ old('version', '1.0') }}" placeholder="1.0" required />
                  <div class="form-text">Versión del modelo de atención.</div>
                  @error('version')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-12">
                  <label class="form-label fw-semibold">Descripción del Bot <span class="text-danger">*</span></label>
                  <textarea name="description" rows="2" class="form-control @error('description') is-invalid @enderror" 
                            placeholder="Ej: Agente de IA para responder consultas de clientes, asesorar en productos y agendar reuniones." required>{{ old('description') }}</textarea>
                  @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          {{-- ── 2. Identidad y Personalidad del Agente ── --}}
          <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px;">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
              <h5 class="mb-0 fw-semibold text-success">
                <i class="bi bi-person-badge-fill me-2"></i>2. Identidad y Personalidad del Agente
              </h5>
              <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                Motor LLM Activo
              </span>
            </div>
            <div class="card-body p-4">
              <div class="row g-4">
                {{-- Nombre del personaje --}}
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Nombre del Agente / Personaje</label>
                  <input type="text" name="persona_name" class="form-control @error('persona_name') is-invalid @enderror" 
                         value="{{ old('persona_name', 'Sofi') }}" placeholder="Ej: Sofi, Carlos, Camila" />
                  <div class="form-text">El nombre con el que la IA se presentará ante los usuarios en WhatsApp.</div>
                  @error('persona_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Rol o cargo --}}
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Rol o Cargo en tu Empresa</label>
                  <input type="text" name="role" class="form-control @error('role') is-invalid @enderror" 
                         value="{{ old('role', 'Asesora comercial y de atención a clientes') }}" 
                         placeholder="Ej: Asesora comercial, Especialista en Soporte" />
                  <div class="form-text">Qué papel cumple dentro de la organización.</div>
                  @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Tono de comunicación --}}
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Tono de Comunicación</label>
                  <select name="tone" class="form-select @error('tone') is-invalid @enderror">
                    <option value="cercano" {{ old('tone', 'cercano') == 'cercano' ? 'selected' : '' }}>🤝 Cercano y empático (Recomendado para ventas)</option>
                    <option value="formal" {{ old('tone') == 'formal' ? 'selected' : '' }}>🎩 Formal y respetuoso (Servicios profesionales/legales)</option>
                    <option value="carismatico" {{ old('tone') == 'carismatico' ? 'selected' : '' }}>✨ Carismático y alegre (Tiendas y retail)</option>
                    <option value="tecnico" {{ old('tone') == 'tecnico' ? 'selected' : '' }}>🛠️ Técnico y directo (Soporte o B2B)</option>
                  </select>
                  <div class="form-text">Define la calidez y el estilo de lenguaje del bot.</div>
                </div>

                {{-- Nivel de Creatividad (Temperatura) --}}
                <div class="col-md-6">
                  <label class="form-label fw-semibold d-flex justify-content-between align-items-center">
                    <span>Nivel de Creatividad (Temperatura)</span>
                    <span class="badge bg-primary text-white" id="temp-badge">0.7 (Equilibrado)</span>
                  </label>
                  <input type="range" class="form-range" min="0" max="1" step="0.1" 
                         id="temperature-slider" name="temperature" 
                         value="{{ old('temperature', '0.7') }}"
                         oninput="updateTemperatureLabel(this.value)">
                  <div class="d-flex justify-content-between small text-muted">
                    <span>0.0 (Preciso / Fijo)</span>
                    <span>0.7 (Recomendado)</span>
                    <span>1.0 (Muy Creativo)</span>
                  </div>
                </div>

                {{-- Personalidad y Actitud --}}
                <div class="col-12">
                  <label class="form-label fw-semibold">Personalidad y Actitud Detallada</label>
                  <textarea name="personality" rows="3" class="form-control @error('personality') is-invalid @enderror" 
                            placeholder="Ej: Eres muy amable, paciente, entusiasta por ayudar. Siempre saludas con calidez, usas emojis con moderación y demuestras interés genuino por resolver las dudas del cliente.">{{ old('personality') }}</textarea>
                  <div class="form-text">Describe los rasgos de personalidad para que el modelo adopte la actitud exacta que deseas.</div>
                  @error('personality')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Historia de Fondo / Backstory --}}
                <div class="col-12">
                  <label class="form-label fw-semibold">Historia de Fondo (Backstory)</label>
                  <textarea name="backstory" rows="2" class="form-control @error('backstory') is-invalid @enderror" 
                            placeholder="Ej: Llevas más de 3 años asesorando clientes en nuestra empresa, conoces a la perfección todos los servicios y te apasiona conectar a las personas con la mejor solución.">{{ old('backstory') }}</textarea>
                  <div class="form-text">Aporta contexto al modelo sobre su trayectoria y experiencia imaginaria.</div>
                  @error('backstory')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          {{-- ── 3. Base de Conocimiento y Restricciones ── --}}
          <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px;">
            <div class="card-header bg-white border-bottom py-3">
              <h5 class="mb-0 fw-semibold text-dark">
                <i class="bi bi-journal-text me-2"></i>3. Base de Conocimiento & Reglas de Comportamiento
              </h5>
            </div>
            <div class="card-body p-4">
              <div class="row g-4">
                {{-- Base de Conocimiento --}}
                <div class="col-12">
                  <label class="form-label fw-semibold">
                    Base de Conocimiento de tu Negocio
                    <span class="badge bg-light text-primary border ms-1">Fundamental</span>
                  </label>
                  <textarea name="knowledge_base" rows="5" class="form-control font-monospace @error('knowledge_base') is-invalid @enderror" 
                            style="font-size: 0.88rem;"
                            placeholder="- Horario de atención: Lunes a Viernes de 9:00 a 18:00 hrs.
- Dirección: Av. Providencia 1234, Oficina 501, Santiago.
- Planes de Suscripción: Plan Básico ($15.000/mes), Plan Pro ($35.000/mes).
- Métodos de pago: Transferencia bancaria, tarjetas de crédito/débito vía Webpay.
- Envíos: Despachamos a todo el país en 48 a 72 horas hábiles.">{{ old('knowledge_base') }}</textarea>
                  <div class="form-text">
                    Información verificada que el bot consultará para responder. Puedes incluir preguntas frecuentes, productos, políticas de reembolso y enlaces de interés.
                  </div>
                  @error('knowledge_base')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Reglas de Estilo --}}
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Reglas de Estilo</label>
                  <textarea name="style_rules" rows="3" class="form-control @error('style_rules') is-invalid @enderror" 
                            placeholder="- Responde en máximo 3 oraciones por mensaje.
- Usa máximo 2 emojis por mensaje.
- No uses tecnicismos complicados.
- Separa las ideas en párrafos cortos para facilitar la lectura en móvil.">{{ old('style_rules') }}</textarea>
                  <div class="form-text">Cómo debe formatear sus respuestas el bot en WhatsApp.</div>
                  @error('style_rules')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Límites y Qué NO hacer --}}
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Límites y Qué NO Hacer (Guardrails)</label>
                  <textarea name="boundaries" rows="3" class="form-control @error('boundaries') is-invalid @enderror" 
                            placeholder="- Nunca inventes precios o descuentos que no figuren en la base de conocimiento.
- Si el cliente solicita hablar con un humano o está molesto, pídele su número y derívalo amablemente.
- No opines sobre política, religión o temas ajenos al negocio.">{{ old('boundaries') }}</textarea>
                  <div class="form-text">Límites de seguridad estrictos que la IA respetará en todo momento.</div>
                  @error('boundaries')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            @if($canUseAi)
              <div class="card-footer bg-light p-4 d-flex flex-wrap align-items-center justify-content-between gap-3 border-top">
                <div class="text-muted small">
                  <i class="bi bi-stars text-warning me-1"></i> Este bot utilizará el motor de IA generativa para responder autónomamente a tus leads.
                </div>
                <div class="d-flex align-items-center gap-2">
                  <a href="{{ route('/admindashboard/bots-r') }}" class="btn btn-outline-secondary px-3">
                    Cancelar
                  </a>
                  <button type="submit" class="btn btn-success px-4 fw-semibold shadow-sm">
                    <i class="bi bi-rocket-takeoff-fill me-1.5"></i> Crear Bot MLL y Activar
                  </button>
                </div>
              </div>
            @endif
          </div>

        </fieldset>
      </form>

    </div>
  </div>
</div>

<script>
  function updateTemperatureLabel(val) {
    const badge = document.getElementById('temp-badge');
    if (!badge) return;
    
    let text = val;
    if (val <= 0.3) {
      text += ' (Preciso / Foco)';
    } else if (val <= 0.7) {
      text += ' (Equilibrado)';
    } else {
      text += ' (Creativo / Variado)';
    }
    badge.innerText = text;
  }
</script>

</x-admindashboard>
