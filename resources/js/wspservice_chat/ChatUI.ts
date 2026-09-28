import type { ChatMessage, Lead } from './interfaces';

export class ChatUI {
    private chatContainer: HTMLElement;
    private inputField: HTMLInputElement;
    private sendButton: HTMLButtonElement;
    private btnTakeControl: HTMLButtonElement;
    private btnReleaseControl: HTMLButtonElement;
    private statusText: HTMLElement;
    private statusBadge: HTMLElement | null;
    private leadName: HTMLElement | null;
    private leadPhone: HTMLElement | null;
    private leadAvatar: HTMLImageElement | null;

    constructor() {
        this.chatContainer = document.getElementById('chat-messages-container') as HTMLElement;
        this.inputField = document.getElementById('chat-input-text') as HTMLInputElement;
        this.sendButton = document.getElementById('chat-btn-send') as HTMLButtonElement;
        this.btnTakeControl = document.getElementById('btn-take-control') as HTMLButtonElement;
        this.btnReleaseControl = document.getElementById('btn-release-control') as HTMLButtonElement;
        this.statusText = document.getElementById('chat-status-text') as HTMLElement;
        this.statusBadge = document.getElementById('chat-status-badge');
        this.leadName = document.getElementById('chat-lead-name');
        this.leadPhone = document.getElementById('chat-lead-phone');
        this.leadAvatar = document.getElementById('chat-lead-avatar') as HTMLImageElement;
    }

    public setLeadInfo(lead: Partial<Lead>) {
        if (this.leadName && lead.name) {
            this.leadName.innerText = lead.name;
        }
        if (this.leadPhone && lead.phone_number) {
            this.leadPhone.innerHTML = `<i class="bi bi-whatsapp text-success me-1"></i>+${lead.phone_number}`;
        }
        if (this.leadAvatar) {
            const avatarUrl = lead.avatar_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(lead.name || 'Lead')}&background=0D8ABC&color=fff`;
            this.leadAvatar.src = avatarUrl;
        }
    }

    public renderMessages(messages: ChatMessage[]) {
        this.chatContainer.innerHTML = '';
        
        if (messages.length === 0) {
            this.chatContainer.innerHTML = '<div class="text-center text-muted my-auto"><small>No hay mensajes en esta conversación aún.</small></div>';
            return;
        }

        messages.forEach(msg => {
            this.appendMessage(msg);
        });
        this.scrollToBottom();
    }

    public appendMessage(msg: ChatMessage) {
        const isUser = msg.sender_type === 'user';
        const isBot = msg.sender_type === 'agent';
        
        const row = document.createElement('div');
        row.className = `d-flex ${isUser ? 'justify-content-start' : 'justify-content-end'} mb-2 w-100`;

        const bubble = document.createElement('div');
        const bubbleTypeClass = isUser ? 'bubble-user' : (isBot ? 'bubble-bot' : 'bubble-admin');
        bubble.className = `chat-bubble ${bubbleTypeClass}`;

        // Etiqueta del remitente
        const senderTag = document.createElement('div');
        senderTag.className = 'bubble-sender';
        if (isUser) {
            senderTag.className += ' text-muted';
            senderTag.innerText = 'Cliente';
        } else if (isBot) {
            senderTag.className += ' text-primary';
            senderTag.innerHTML = '<i class="bi bi-robot me-1"></i>Bot Automático';
        } else {
            senderTag.className += ' text-success';
            senderTag.innerHTML = '<i class="bi bi-person-fill me-1"></i>Operador (Tú)';
        }

        const textWrapper = document.createElement('div');
        textWrapper.className = 'bubble-content';
        textWrapper.innerText = msg.content;

        const footerWrapper = document.createElement('div');
        footerWrapper.className = 'bubble-footer';
        
        const timeSmall = document.createElement('span');
        timeSmall.innerText = msg.sent_at ? new Date(msg.sent_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '';
        footerWrapper.appendChild(timeSmall);

        if (!isUser) {
            const checkIcon = document.createElement('i');
            checkIcon.className = 'bi bi-check-all text-primary ms-1';
            footerWrapper.appendChild(checkIcon);
        }

        bubble.appendChild(senderTag);
        bubble.appendChild(textWrapper);
        bubble.appendChild(footerWrapper);
        row.appendChild(bubble);

        this.chatContainer.appendChild(row);
        this.scrollToBottom();
    }

    public scrollToBottom() {
        this.chatContainer.scrollTop = this.chatContainer.scrollHeight;
    }

    public updateStatus(status: 'bot_active' | 'human_active' | 'closed') {
        if (status === 'bot_active') {
            this.btnTakeControl.style.display = 'inline-flex';
            this.btnReleaseControl.style.display = 'none';
            this.inputField.disabled = true;
            this.sendButton.disabled = true;
            this.inputField.placeholder = 'Modo Bot: Toma el control para escribir...';
            this.statusText.innerText = 'Bot respondiendo automáticamente';
            if (this.statusBadge) {
                this.statusBadge.className = 'badge bg-warning text-dark';
                this.statusBadge.innerHTML = '<i class="bi bi-robot me-1"></i> Bot Activo';
            }
        } else if (status === 'human_active') {
            this.btnTakeControl.style.display = 'none';
            this.btnReleaseControl.style.display = 'inline-flex';
            this.inputField.disabled = false;
            this.sendButton.disabled = false;
            this.inputField.placeholder = 'Escribe un mensaje como operador...';
            this.statusText.innerText = 'Modo Humano en Vivo';
            if (this.statusBadge) {
                this.statusBadge.className = 'badge bg-success';
                this.statusBadge.innerHTML = '<i class="bi bi-person-fill me-1"></i> Agente en Vivo';
            }
        } else {
            this.btnTakeControl.style.display = 'none';
            this.btnReleaseControl.style.display = 'none';
            this.inputField.disabled = true;
            this.sendButton.disabled = true;
            this.inputField.placeholder = 'Conversación cerrada';
            this.statusText.innerText = 'Conversación cerrada';
            if (this.statusBadge) {
                this.statusBadge.className = 'badge bg-secondary';
                this.statusBadge.innerHTML = '<i class="bi bi-x-circle me-1"></i> Cerrado';
            }
        }
    }

    public bindSendEvent(callback: (text: string) => void) {
        this.sendButton.addEventListener('click', () => {
            const text = this.inputField.value.trim();
            if (text) {
                callback(text);
                this.inputField.value = '';
            }
        });

        this.inputField.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.sendButton.click();
            }
        });
    }

    public bindTakeControlEvent(callback: () => void) {
        this.btnTakeControl.addEventListener('click', () => {
            callback();
        });
    }

    public bindReleaseControlEvent(callback: () => void) {
        this.btnReleaseControl.addEventListener('click', () => {
            callback();
        });
    }
}

