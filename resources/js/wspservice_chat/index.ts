import { ChatManager } from './ChatManager';

let currentChatManager: ChatManager | null = null;

// Escuchar cuando el Modal de Bootstrap se abre para inyectar el chat
document.addEventListener('InitLiveChat', (e: Event) => {
    const customEvent = e as CustomEvent;
    const leadId = customEvent.detail.leadId;
    
    console.log(`[Vite TS] Inicializando Live Chat para el Lead ID: ${leadId}`);
    
    // Destruir instancia previa si por algún motivo quedó colgada
    if (currentChatManager) {
        currentChatManager.destroy();
    }

    // Instanciar el orquestador
    currentChatManager = new ChatManager(leadId);
});

// Escuchar cuando el Modal de Bootstrap se cierra
document.addEventListener('DestroyLiveChat', () => {
    console.log('[Vite TS] Destruyendo Live Chat (deteniendo polling)');
    if (currentChatManager) {
        currentChatManager.destroy();
        currentChatManager = null;
    }
});
