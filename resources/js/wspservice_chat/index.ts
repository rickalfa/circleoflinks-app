import { ChatManager } from './ChatManager';

// Instanciamos el ChatManager SOLO UNA VEZ para toda la aplicación.
// Esto evita duplicar los event listeners (botones) cuando abrimos y cerramos el modal repetidas veces.
const chatManager = new ChatManager();

// Escuchar cuando el Modal de Bootstrap se abre para inyectar el chat
document.addEventListener('InitLiveChat', (e: Event) => {
    const customEvent = e as CustomEvent;
    const leadId = customEvent.detail.leadId;
    
    console.log(`[Vite TS] Abriendo Live Chat para el Lead ID: ${leadId}`);
    chatManager.openChat(leadId);
});

// Escuchar cuando el Modal de Bootstrap se cierra
document.addEventListener('DestroyLiveChat', () => {
    console.log('[Vite TS] Destruyendo Live Chat (deteniendo polling)');
    chatManager.closeChat();
});
