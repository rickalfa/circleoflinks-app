import { ChatApi } from './ChatApi';
import { ChatUI } from './ChatUI';
import type { Conversation } from './interfaces';

export class ChatManager {
    private api: ChatApi;
    private ui: ChatUI;
    private leadId: number;
    private currentConversation: Conversation | null = null;
    private phoneNumber: string = '';
    private pollingInterval: number | null = null;

    constructor(leadId: number) {
        this.leadId = leadId;
        this.api = new ChatApi();
        this.ui = new ChatUI();
        
        this.ui.bindSendEvent(this.handleSend.bind(this));
        this.ui.bindTakeControlEvent(this.handleTakeControl.bind(this));
        this.ui.bindReleaseControlEvent(this.handleReleaseControl.bind(this));
        
        this.init();
    }

    private async init() {
        await this.loadChat();
        // Iniciar polling cada 5 segundos para recibir nuevos mensajes
        this.pollingInterval = window.setInterval(() => this.loadChat(false), 5000);
    }

    private async loadChat(initialLoad: boolean = true) {
        const data = await this.api.getConversation(this.leadId);
        if (data && data.conversation) {
            
            const newMessagesCount = data.conversation.messages.length;
            const oldMessagesCount = this.currentConversation?.messages.length || 0;

            this.currentConversation = data.conversation;
            this.phoneNumber = data.phone;
            
            // Si es la carga inicial, o si hay mensajes nuevos, re-renderizar
            if (initialLoad || newMessagesCount > oldMessagesCount) {
                this.ui.renderMessages(this.currentConversation.messages);
            }

            this.ui.updateStatus(this.currentConversation.status);
        }
    }

    private async handleSend(text: string) {
        if (!this.currentConversation) return;
        
        const newMsg = await this.api.sendMessage(this.currentConversation.id, this.phoneNumber, text);
        if (newMsg) {
            // Añadirlo al DOM inmediatamente y a nuestro arreglo de estado
            this.currentConversation.messages.push(newMsg);
            this.ui.appendMessage(newMsg);
        }
    }

    private async handleTakeControl() {
        if (!this.currentConversation) return;
        
        const success = await this.api.takeControl(this.currentConversation.id, 'human_active');
        if (success) {
            this.currentConversation.status = 'human_active';
            this.ui.updateStatus('human_active');
        }
    }

    private async handleReleaseControl() {
        if (!this.currentConversation) return;
        
        const success = await this.api.takeControl(this.currentConversation.id, 'bot_active');
        if (success) {
            this.currentConversation.status = 'bot_active';
            this.ui.updateStatus('bot_active');
        }
    }

    // Método para limpiar el polling si se cierra el modal (para no gastar recursos)
    public destroy() {
        if (this.pollingInterval) {
            window.clearInterval(this.pollingInterval);
        }
    }
}
