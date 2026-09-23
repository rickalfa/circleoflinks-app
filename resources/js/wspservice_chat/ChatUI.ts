import type { ChatMessage } from './interfaces';

export class ChatUI {
    private chatContainer: HTMLElement;
    private inputField: HTMLInputElement;
    private sendButton: HTMLButtonElement;
    private btnTakeControl: HTMLButtonElement;
    private btnReleaseControl: HTMLButtonElement;
    private statusText: HTMLElement;

    constructor() {
        this.chatContainer = document.getElementById('chat-messages-container') as HTMLElement;
        this.inputField = document.getElementById('chat-input-text') as HTMLInputElement;
        this.sendButton = document.getElementById('chat-btn-send') as HTMLButtonElement;
        this.btnTakeControl = document.getElementById('btn-take-control') as HTMLButtonElement;
        this.btnReleaseControl = document.getElementById('btn-release-control') as HTMLButtonElement;
        this.statusText = document.getElementById('chat-status-text') as HTMLElement;
    }

    public renderMessages(messages: ChatMessage[]) {
        this.chatContainer.innerHTML = ''; // Limpiar
        
        if (messages.length === 0) {
            this.chatContainer.innerHTML = '<div class="text-center text-muted mt-3"><small>No hay mensajes aún.</small></div>';
            return;
        }

        messages.forEach(msg => {
            this.appendMessage(msg);
        });
        this.scrollToBottom();
    }

    public appendMessage(msg: ChatMessage) {
        const isUser = msg.sender_type === 'user';
        const justifyClass = isUser ? 'justify-content-start' : 'justify-content-end';
        const bgClass = isUser ? 'bg-success text-white' : 'bg-secondary text-white';
        
        const row = document.createElement('div');
        row.className = `row ${justifyClass} mb-2`;

        const col = document.createElement('div');
        col.className = 'col-8 col-md-6';

        const bubble = document.createElement('div');
        bubble.className = `d-inline-flex rounded-pill p-2 ${bgClass}`;
        
        const textWrapper = document.createElement('div');
        textWrapper.className = 'p-1';
        textWrapper.innerText = msg.content;

        const timeWrapper = document.createElement('div');
        timeWrapper.className = 'd-flex align-items-end ms-2';
        const timeSmall = document.createElement('small');
        timeSmall.style.fontSize = '0.7em';
        timeSmall.innerText = msg.sent_at ? new Date(msg.sent_at).toLocaleTimeString() : '';
        
        timeWrapper.appendChild(timeSmall);
        bubble.appendChild(textWrapper);
        bubble.appendChild(timeWrapper);
        col.appendChild(bubble);
        row.appendChild(col);

        this.chatContainer.appendChild(row);
        this.scrollToBottom();
    }

    public scrollToBottom() {
        this.chatContainer.scrollTop = this.chatContainer.scrollHeight;
    }

    public updateStatus(status: 'bot_active' | 'human_active' | 'closed') {
        if (status === 'bot_active') {
            this.btnTakeControl.style.display = 'block';
            this.btnReleaseControl.style.display = 'none';
            this.inputField.disabled = true;
            this.sendButton.disabled = true;
            this.statusText.innerText = 'El Bot está respondiendo...';
        } else {
            this.btnTakeControl.style.display = 'none';
            this.btnReleaseControl.style.display = 'block';
            this.inputField.disabled = false;
            this.sendButton.disabled = false;
            this.statusText.innerText = 'Tú tienes el control (Humano)';
        }
    }

    public bindSendEvent(callback: (text: string) => void) {
        this.sendButton.addEventListener('click', () => {
            const text = this.inputField.value.trim();
            if (text) {
                callback(text);
                this.inputField.value = ''; // Limpiar input después de enviar
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
