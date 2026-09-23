<div id="wspservice-chat-wrapper" data-lead-id="{{ $Lead->id }}" class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Chat en Vivo</h5>
        <button id="btn-take-control" class="btn btn-warning btn-sm" style="display:none;">
            Tomar Control (Silenciar Bot)
        </button>
        <button id="btn-release-control" class="btn btn-info btn-sm text-white" style="display:none;">
            Devolver control al Bot
        </button>
    </div>

    <!-- Contenedor donde ChatUI.ts inyectará las burbujas -->
    <div class="card-body">
        <div id="chat-messages-container" class="box-message" style="overflow-y: scroll; height: 400px; display: flex; flex-direction: column;">
            <div class="text-center text-muted mt-3">
                <small>Cargando mensajes...</small>
            </div>
        </div>
    </div>

    <!-- Inputs del formulario -->
    <div class="card-footer bg-light">
        <div class="d-flex flex-row">
            <input type="text" id="chat-input-text" class="form-control" placeholder="Escribe un mensaje..." disabled>
            <button id="chat-btn-send" class="btn btn-primary ms-2" disabled>Enviar</button>
        </div>
        <small id="chat-status-text" class="text-muted mt-1 d-block text-end">Conectando...</small>
    </div>
</div>

<!-- En desarrollo usamos Vite, podemos incluir el script aquí si configuramos vite.config.mjs -->
@vite('resources/js/wspservice_chat/index.ts')