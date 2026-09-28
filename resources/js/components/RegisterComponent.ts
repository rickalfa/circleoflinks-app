import { authService } from '../services/AuthService';
import type { RegisterPayload } from '../types/AuthTypes';
import { AlertComponent } from './ui/AlertComponent';

/**
 * Componente que maneja la lógica de la vista de Registro
 */
export class RegisterComponent {
    private formElement: HTMLFormElement | null;
    private messageContainerId: string;
    private submitButton: HTMLButtonElement | null = null;
    private modalElement: HTMLElement | null = null;
    private originalSubmitHtml: string = '';

    /**
     * @param formSelector El selector CSS o ID del formulario en el HTML
     * @param messageContainerId Selector del contenedor de alertas (ej: '#messageresponse')
     */
    constructor(formSelector: string = '#formregister', messageContainerId: string = '#messageresponse') {
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

        // Limpieza de estilos de error en tiempo real al escribir o interactuar
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
                    <span>Registrando...</span>
                `;
            } else {
                this.submitButton.innerHTML = this.originalSubmitHtml || 'Registrarse';
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
        const turnstileError = document.getElementById('turnstile-error');
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
            const turnstileError = document.getElementById('turnstile-error');
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
     * Valida campos en el cliente antes de disparar la petición HTTP
     */
    private validateClientSide(
        name: string,
        email: string,
        password: string,
        passwordConfirmation: string,
        termsAccepted: boolean,
        turnstileToken: string
    ): boolean {
        let isValid = true;

        if (!name.trim()) {
            this.showFieldError('name', 'Por favor ingresa tu nombre completo.');
            isValid = false;
        }

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
        } else if (password.length < 8) {
            this.showFieldError('password', 'La contraseña debe tener al menos 8 caracteres.');
            isValid = false;
        }

        if (!passwordConfirmation) {
            this.showFieldError('password_confirmation', 'Por favor confirma tu contraseña.');
            isValid = false;
        } else if (password !== passwordConfirmation) {
            this.showFieldError('password_confirmation', 'Las contraseñas no coinciden.');
            isValid = false;
        }

        if (!termsAccepted) {
            this.showFieldError('remember', 'Debes aceptar los términos y condiciones para continuar.');
            isValid = false;
        }

        if (!turnstileToken) {
            this.showFieldError('cf-turnstile-response', 'Por favor completa la verificación de seguridad anti-bot.');
            isValid = false;
        }

        return isValid;
    }

    /**
     * Reinicia el widget de Turnstile perteneciente a este formulario
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
     * Maneja el evento submit del formulario
     */
    private async handleSubmit(event: Event): Promise<void> {
        event.preventDefault();
        if (!this.formElement) return;

        // Limpiar errores visuales previos
        this.clearErrors();

        const formData = new FormData(this.formElement);
        const name = (formData.get('name') as string) || '';
        const email = (formData.get('email') as string) || '';
        const password = (formData.get('password') as string) || '';
        const passwordConfirmation = (formData.get('password_confirmation') as string) || '';
        const termsAccepted = formData.get('remember') !== null;
        const turnstileToken = (formData.get('cf-turnstile-response') as string) || '';

        // 1. Validación previa en frontend
        const isValid = this.validateClientSide(
            name,
            email,
            password,
            passwordConfirmation,
            termsAccepted,
            turnstileToken
        );

        if (!isValid) {
            AlertComponent.danger(
                this.messageContainerId,
                '<strong>Campos incorrectos:</strong> Por favor corrige los errores señalados en rojo.'
            );
            return;
        }

        // 2. Activar spinner de carga y deshabilitar todos los botones
        this.setLoadingState(true);

        // Notificar en el contenedor de mensajes
        AlertComponent.secondary(this.messageContainerId, 'Creando tu cuenta y validando información...');

        const payload: RegisterPayload = {
            name,
            email,
            password,
            password_confirmation: passwordConfirmation,
            'cf-turnstile-response': turnstileToken,
        };

        try {
            console.log('Enviando datos de registro...', payload);

            // Llamada asíncrona mediante Axios con authService
            const response: any = await authService.register(payload);

            console.log('Respuesta de registro:', response);

            if (response && (response.success === true || response.success === undefined || response.user)) {
                // Cerrar modal de Bootstrap si está presente
                if (this.modalElement && (window as any).bootstrap) {
                    const modalInstance = (window as any).bootstrap.Modal.getInstance(this.modalElement);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }

                // Alerta flotante de éxito
                AlertComponent.floatingSuccess(
                    '<strong>¡Registro exitoso!</strong> Sesión iniciada, redirigiendo...',
                    3000
                );

                this.formElement.reset();
                this.resetTurnstile();

                // Resolver URL de redirección: prioridad a la URL enviada por Laravel que respeta XAMPP/puertos/host local
                const baseUrl = import.meta.env.VITE_API_BASE_URL || '';
                const fallbackUrl = baseUrl ? `${baseUrl.replace(/\/+$/, '')}/admindashboard` : 'admindashboard';
                const targetUrl = response.redirect || fallbackUrl;

                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 1500);
            }

        } catch (error: any) {
            console.error('Ocurrió un error en el registro:', error);

            // Restaurar botones y quitar spinner
            this.setLoadingState(false);

            // Reiniciar Turnstile para permitir nuevo intento
            this.resetTurnstile();

            // Manejo de errores de validación HTTP 422 desde Laravel / Axios
            if (error.response && error.response.status === 422) {
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
                        '<strong>Error de validación:</strong> Por favor corrige los campos señalados en rojo.'
                    );
                } else {
                    const msg = responseData.message || responseData.massage || 'Ocurrió un error de validación.';
                    AlertComponent.danger(
                        this.messageContainerId,
                        `<strong>Error de Registro:</strong> ${msg}`
                    );
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
