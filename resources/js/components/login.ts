import { authService } from "../services/AuthService";

export class LoginController {
    private form: HTMLFormElement | null;
    private submitBtn: HTMLButtonElement | null;
    private messageContainer: HTMLElement | null;

    constructor(formId: string) {
        this.form = document.getElementById(formId) as HTMLFormElement;
        this.submitBtn = this.form?.querySelector('button[type="submit"]') as HTMLButtonElement;
        // Seleccionamos el contenedor de mensajes que pusiste en el HTML
        this.messageContainer = document.getElementById("messageresponselogin");

        if (!this.form) return;

        this.init();
    }

    private init(): void {
        this.form?.addEventListener("submit", async (e: Event) => {
            e.preventDefault();
            this.clearMessage(); // Limpiar errores previos al intentar de nuevo
            await this.handleLogin();
        });
    }

    private async handleLogin(): Promise<void> {
        if (!this.form) return;

        const formData = new FormData(this.form);
        const email = formData.get("email") as string;
        const password = formData.get("password") as string;

        this.setLoading(true);

        try {
            const response = await authService.login({ email, password });

            if (response.success) {
                this.showMessage("¡Éxito! Redirigiendo...", "success");
                // Pequeña pausa para que el usuario vea el mensaje de éxito
                setTimeout(() => window.location.reload(), 2000);
            }
        } catch (error: any) {
            let errorMsg = "Ocurrió un error inesperado.";
            
            // Manejar errores de Laravel (422 o 401)
            if (error.response) {
                const data = error.response.data;
                // Si hay errores de validación específicos (email, password)
                if (data.errors) {
                    errorMsg = Object.values(data.errors).flat().join("<br>");
                } else {
                    errorMsg = data.message || "Credenciales incorrectas.";
                }
            }
            
            this.showMessage(errorMsg, "danger");
        } finally {
            this.setLoading(false);
        }
    }

    private showMessage(message: string, type: 'danger' | 'success'): void {
        if (!this.messageContainer) return;

        // Inyectamos un alert de Bootstrap
        this.messageContainer.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="bi bi-${type === 'danger' ? 'exclamation-triangle' : 'check-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    }

    private clearMessage(): void {
        if (this.messageContainer) this.messageContainer.innerHTML = "";
    }

    private setLoading(isLoading: boolean): void {
        if (!this.submitBtn) return;
        this.submitBtn.disabled = isLoading;
        this.submitBtn.innerHTML = isLoading 
            ? `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Entrando...`
            : `<i class="bi bi-box-arrow-in-right me-1"></i> Entrar`;
    }
}