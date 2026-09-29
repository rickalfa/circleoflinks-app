export class LeadUnreadStatus {
    private intervalId: number | null = null;
    private apiUrl: string;

    constructor(apiUrl: string = '/chat-api/unread-status') {
        this.apiUrl = apiUrl;
        this.init();
    }

    public init() {
        // Ejecutar inmediatamente
        this.fetchUnreadStatus();
        
        // Configurar polling cada 15 segundos para no saturar los logs
        this.intervalId = window.setInterval(() => {
            this.fetchUnreadStatus();
        }, 15000);
    }

    private async fetchUnreadStatus() {
        try {
            const response = await fetch(this.apiUrl, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const result = await response.json();
                if (result.success && result.data) {
                    this.updateUI(result.data);
                }
            }
        } catch (error) {
            console.error('[LeadUnreadStatus] Error fetching unread status:', error);
        }
    }

    private updateUI(leads: Array<{ id: number, has_unread_messages: boolean }>) {
        leads.forEach(lead => {
            const badge = document.querySelector(`.unread-badge[data-lead-id="${lead.id}"]`) as HTMLElement;
            if (badge) {
                badge.style.display = lead.has_unread_messages ? 'inline-block' : 'none';
            }
        });
    }

    public destroy() {
        if (this.intervalId) {
            clearInterval(this.intervalId);
        }
    }
}
