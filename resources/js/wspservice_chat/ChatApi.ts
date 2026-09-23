import axios from 'axios';
import type { Conversation, ChatMessage } from './interfaces';

export class ChatApi {
    private csrfToken: string;

    constructor() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        this.csrfToken = meta ? meta.getAttribute('content') || '' : '';
        
        // Configuramos axios por defecto
        axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    }

    public async getConversation(leadId: number): Promise<{ conversation: Conversation, phone: string } | null> {
        try {
            const response = await axios.get(`/chat-api/conversation/lead/${leadId}`);
            if (response.data && response.data.conversation) {
                // El phone está en contact o lead (dependiendo del backend), ajustemos asumiendo lead.phone_number
                return {
                    conversation: response.data.conversation,
                    phone: response.data.lead?.phone_number || ''
                };
            }
            return null;
        } catch (error) {
            console.error('Error al cargar la conversación:', error);
            return null;
        }
    }

    public async sendMessage(conversationId: number, phone: string, message: string): Promise<ChatMessage | null> {
        try {
            const response = await axios.post('/chat-api/send', {
                conversation_id: conversationId,
                phone: phone,
                message: message
            });
            if (response.data && response.data.success) {
                return response.data.message as ChatMessage;
            }
            return null;
        } catch (error) {
            console.error('Error al enviar mensaje:', error);
            return null;
        }
    }

    public async takeControl(conversationId: number): Promise<boolean> {
        try {
            const response = await axios.post('/chat-api/take-control', {
                conversation_id: conversationId
            });
            return response.data?.success || false;
        } catch (error) {
            console.error('Error al tomar el control:', error);
            return false;
        }
    }
}
