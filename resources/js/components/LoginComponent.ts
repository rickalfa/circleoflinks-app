import { authService } from '../services/AuthService';
import type { LoginPayload } from '../types/AuthTypes';
import { AlertComponent } from './ui/AlertComponent';

/**
 * Componente que maneja la lógica de la vista de Login
 */
export class LoginComponent {
    private formElement: HTMLFormElement | null;
    private messageContainerId: string;
    private submitButton: HTMLButtonElement | null = null;
    private modalElement: HTMLElement | null = null;
    private originalSubmitHtml: string = '';

    /**
     * @param formSelector El selector CSS o ID del formulario en el HTML (ej: '#formlogin')
     * @param messageContainerId Selector opcional del contenedor de alertas en el modal
     */
    constructor(formSelector: string = '#formlogin', messageContainerId: string = '#messageresponselogin') {
        this.formElement = document.querySelector<HTMLFormElement>(formSelector);
        this.messageContainerId = messageContainerId;

        if (this.formElement) {
            this.submitButton = this.formElement.querySelector<HTMLButtonElement>('button[type="submit"]');
            this.modalElement = this.formElement.closest('.modal');
            if (this.submitButton) {
                this.originalSubmitHtml = this.submitButton.innerHTML;
            }
        }

        this.init();
    }

    /**
     * Inicializa los listeners del componente
     */
    private init(): void {
        if (!this.formElement) return;

        this.formElement.addEventListener('submit', this.handleSubmit.bind(this));

        // Limpiar clase is-invalid en tiempo real al escribir o interactuar
        this.formElement.addEventListener('input', (event: Event) => {
            const target = event.target as HTMLElement;
            if (target && target.classList.contains('is-invalid')) {
                target.classList.remove('is-invalid');
            }
        });

        this.formElement.addEventListener('change', (event: Event) => {
            const target = event.target as HTMLElement;
            if (target && target.classList.contains('is-invalid')) {
                target.classList.remove('is-invalid');
            }
        });
    }

    /**
     * Alterna el estado de carga:
     * - Spinner animado en el botón submit
     * - Bloqueo de todos los botones del modal para evitar clics duplicados
     */
    private setLoadingState(isLoading: boolean): void {
        if (!this.formElement) return;

        const targetContainer = this.modalElement || this.formElement;
        const buttons = targetContainer.querySelectorAll<HTMLButtonElement>('button');

        buttons.forEach(button => {
            button.disabled = isLoading;
        });

        if (this.submitButton) {
            if (isLoading) {
                this.submitButton.innerHTML = `
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    <span>Iniciando sesión...</span>
                `;
            } else {
                this.submitButton.innerHTML = this.originalSubmitHtml || 'Iniciar Sesión';
            }
        }
    }

    /**
     * Limpia mensajes previos y quita clases de error
     */
    private clearErrors(): void {
        if (!this.formElement) return;

        // Limpiar contenedor de alertas
        const container = document.querySelector(this.messageContainerId);
        if (container) {
            container.innerHTML = '';
        }

        // Quitar clases is-invalid de inputs
        const invalidInputs = this.formElement.querySelectorAll<HTMLInputElement>('.is-invalid');
        invalidInputs.forEach(input => {
            input.classList.remove('is-invalid');
        });

        // Ocultar mensaje de Turnstile
        const turnstileError = document.getElementById('turnstile-login-error');
        if (turnstileError) {
            turnstileError.textContent = '';
            turnstileError.style.display = 'none';
        }
    }

    /**
     * Señala un error de campo con estilo Bootstrap (.is-invalid y .invalid-feedback en rojo)
     */
    private showFieldError(fieldName: string, message: string): void {
        if (!this.formElement) return;

        if (fieldName === 'cf-turnstile-response') {
            const turnstileError = document.getElementById('turnstile-login-error');
            if (turnstileError) {
                turnstileError.textContent = message;
                turnstileError.style.display = 'block';
            } else {
                AlertComponent.danger(this.messageContainerId, `<strong>Seguridad:</strong> ${message}`);
            }
            return;
        }

        const input = this.formElement.querySelector<HTMLInputElement>(`[name="${fieldName}"]`);
        if (input) {
            input.classList.add('is-invalid');

            // Buscar contenedor de feedback adyacente en el grupo
            const parent = input.parentElement;
            if (parent) {
                const feedback = parent.querySelector<HTMLElement>('.invalid-feedback');
                if (feedback) {
                    feedback.textContent = message;
                }
            }
        }
    }

    /**
     * Valida campos en el cliente antes de enviar
     */
    private validateClientSide(email: string, password: string, turnstileToken: string): boolean {
        let isValid = true;

        if (!email.trim()) {
            this.showFieldError('email', 'Por favor ingresa tu correo electrónico.');
            isValid = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            this.showFieldError('email', 'Por favor ingresa un correo electrónico válido.');
            isValid = false;
        }

        if (!password) {
            this.showFieldError('password', 'Por favor ingresa tu contraseña.');
            isValid = false;
        }

        if (!turnstileToken) {
            this.showFieldError('cf-turnstile-response', 'Por favor completa la verificación de seguridad anti-bot.');
            isValid = false;
        }

        return isValid;
    }

    /**
     * Reinicia el widget de Turnstile perteneciente al formulario de login
     */
    private resetTurnstile(): void {
        if (!this.formElement) return;
        const turnstileEl = this.formElement.querySelector<HTMLElement>('.cf-turnstile');
        if (turnstileEl && typeof (window as any).turnstile !== 'undefined') {
            try {
                (window as any).turnstile.reset(turnstileEl);
            } catch (e) {
                (window as any).turnstile.reset();
            }
        }
    }

    /**
     * Maneja el evento submit del formulario de Login
     */
    private async handleSubmit(event: Event): Promise<void> {
        event.preventDefault();
        if (!this.formElement) return;

        // Limpiar errores visuales previos
        this.clearErrors();

        const formData = new FormData(this.formElement);
        const email = (formData.get('email') as string) || '';
        const password = (formData.get('password') as string) || '';
        const remember = formData.get('remember') !== null;
        const turnstileToken = (formData.get('cf-turnstile-response') as string) || '';

        // 1. Validación previa en frontend
        const isValid = this.validateClientSide(email, password, turnstileToken);

        if (!isValid) {
            AlertComponent.danger(
                this.messageContainerId,
                '<strong>Campos incorrectos:</strong> Por favor completa todos los campos requeridos.'
            );
            return;
        }

        // 2. Activar spinner y deshabilitar botones
        this.setLoadingState(true);

        // Notificar al usuario mediante AlertComponent
        AlertComponent.secondary(this.messageContainerId, 'Verificando credenciales y seguridad...');

        const payload: LoginPayload = {
            email,
            password,
            remember,
            'cf-turnstile-response': turnstileToken,
        };

        try {
            console.log('Enviando datos de autenticación...', payload);

            // Llamada al backend a través de AuthService
            const response: any = await authService.login(payload);

            console.log('Respuesta de Login:', response);

            if (response && (response.success === true || response.success === undefined || response)) {
                // Cerrar modal de Bootstrap si está abierto
                if (this.modalElement && (window as any).bootstrap) {
                    const modalInstance = (window as any).bootstrap.Modal.getInstance(this.modalElement);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }

                // Alerta flotante de éxito
                AlertComponent.floatingSuccess(
                    '<strong>¡Inicio de sesión exitoso!</strong> Cargando tu cuenta...',
                    3000
                );

                this.formElement.reset();
                this.resetTurnstile();

                // Redirigir respetando el entorno local (XAMPP / subcarpeta)
                const baseUrl = import.meta.env.VITE_API_BASE_URL || '';
                const fallbackUrl = baseUrl ? `${baseUrl.replace(/\/+$/, '')}/admindashboard` : 'admindashboard';
                const targetUrl = response.redirect || fallbackUrl;

                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 1500);
            }

        } catch (error: any) {
            console.error('Error al iniciar sesión:', error);

            // Restaurar botones y spinner
            this.setLoadingState(false);

            // Reiniciar Turnstile para permitir nuevo intento
            this.resetTurnstile();

            // Manejo de errores de validación (422) o credenciales incorrectas (401 / 422)
            if (error.response && (error.response.status === 422 || error.response.status === 401)) {
                const responseData = error.response.data;

                if (responseData.errors) {
                    const errors = responseData.errors;
                    for (const field in errors) {
                        if (Object.prototype.hasOwnProperty.call(errors, field) && errors[field].length > 0) {
                            this.showFieldError(field, errors[field][0]);
                        }
                    }

                    AlertComponent.danger(
                        this.messageContainerId,
                        '<strong>Error de autenticación:</strong> Revisa los campos señalados en rojo.'
                    );
                } else {
                    const message = responseData.message || responseData.messagge || 'Las credenciales ingresadas son incorrectas.';
                    this.showFieldError('password', message);
                    AlertComponent.danger(this.messageContainerId, `<strong>Error de Login:</strong> ${message}`);
                }
            } else {
                AlertComponent.danger(
                    this.messageContainerId,
                    '<strong>Error:</strong> No se pudo conectar con el servidor. Intente nuevamente.'
                );
            }
        }
    }
}

