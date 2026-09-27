<div id="wspservice-chat-wrapper" data-lead-id="{{ $Lead->id }}" class="chat-leads-wrapper card shadow-sm border-0">
    <!-- Header enriquecido con información del Lead y Handover -->
    <div class="chat-header card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <div class="position-relative me-3">
                <img id="chat-lead-avatar" 
                     src="https://ui-avatars.com/api/?name=Lead&background=0D8ABC&color=fff" 
                     alt="Lead Avatar" 
                     class="chat-avatar shadow-sm">
            </div>
            <div>
                <div class="d-flex align-items-center gap-2">
                    <h6 id="chat-lead-name" class="chat-lead-name">Cargando contacto...</h6>
                    <span id="chat-status-badge" class="badge bg-secondary">
                        <i class="bi bi-clock me-1"></i> Conectando...
                    </span>
                </div>
                <small id="chat-lead-phone" class="chat-lead-phone d-block">
                    <i class="bi bi-telephone-fill me-1"></i> --
                </small>
            </div>
        </div>

        <!-- Botones de Handover (Tomar / Devolver Control) -->
        <div class="d-flex align-items-center gap-2">
            <button id="btn-take-control" class="btn btn-warning btn-sm fw-semibold shadow-sm" style="display: none;">
                <i class="bi bi-person-fill-lock me-1"></i> Silenciar Bot
            </button>
            <button id="btn-release-control" class="btn btn-info btn-sm text-white fw-semibold shadow-sm" style="display: none;">
                <i class="bi bi-robot me-1"></i> Devolver Control al Bot
            </button>
        </div>
    </div>

    <!-- Contenedor donde ChatUI.ts inyectará las burbujas -->
    <div class="chat-body card-body p-3">
        <div id="chat-messages-container" class="chat-messages-container box-message">
            <div class="text-center text-muted my-auto">
                <div class="spinner-border text-primary spinner-border-sm me-2" role="status"></div>
                <small>Cargando mensajes...</small>
            </div>
        </div>
    </div>

    <!-- Inputs del formulario -->
    <div class="chat-footer card-footer">
        <div class="d-flex flex-row align-items-center">
            <input type="text" id="chat-input-text" class="form-control chat-input me-2" placeholder="Escribe un mensaje como operador..." disabled>
            <button id="chat-btn-send" class="btn btn-primary chat-btn-send px-3 d-flex align-items-center gap-1" disabled>
                <span>Enviar</span>
                <i class="bi bi-send-fill"></i>
            </button>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-1">
            <small class="text-muted fst-italic" style="font-size: 0.75rem;">
                <i class="bi bi-shield-check text-success"></i> WhatsApp Cloud API Omnicanal
            </small>
            <small id="chat-status-text" class="text-muted" style="font-size: 0.75rem;">Conectando...</small>
        </div>
    </div>
</div>

<!-- En desarrollo usamos Vite, podemos incluir el script aquí si configuramos vite.config.mjs -->
@vite('resources/js/wspservice_chat/index.ts')