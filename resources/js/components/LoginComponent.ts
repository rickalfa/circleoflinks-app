import { authService } from '../services/AuthService';
import type { LoginPayload } from '../types/AuthTypes';
import { AlertComponent } from './ui/AlertComponent';

/**
 * Componente que maneja la lógica de la vista de Login
 */
export class LoginComponent {
    private formElement: HTMLFormElement | null;
    private messageContainerId: string = '#messageresponselogin';

    /**
     * @param formSelector El selector CSS o ID del formulario en el HTML (ej: '#formlogin')
     * @param messageContainerId Selector opcional del contenedor de alertas en el modal
     */
    constructor(formSelector: string = '#formlogin', messageContainerId: string = '#messageresponselogin') {
        this.formElement = document.querySelector<HTMLFormElement>(formSelector);
        this.messageContainerId = messageContainerId;
        this.init();
    }

    /**
     * Inicializa los listeners del componente
     */
    private init() {
        if (this.formElement) {
            this.formElement.addEventListener('submit', this.handleSubmit.bind(this));
        }
    }

    /**
     * Maneja el evento submit del formulario de Login
     */
    private async handleSubmit(event: Event) {
        event.preventDefault(); // Evita la recarga inmediata por defecto

        if (!this.formElement) return;

        // Limpiar estilos de validaciones previas
        this.formElement.classList.remove('was-validated');

        // Validar que los campos requeridos de HTML5 (email, password) estén correctos
        if (!this.formElement.checkValidity()) {
            this.formElement.classList.add('was-validated');
            AlertComponent.danger(this.messageContainerId, 'Por favor completa todos los campos requeridos.');
            return;
        }

        const formData = new FormData(this.formElement);
        const email = formData.get('email') as string;
        const password = formData.get('password') as string;
        const remember = formData.get('remember') ? true : false;

        const payload: LoginPayload = {
            email,
            password,
            remember
        };

        try {
            console.log('Enviando datos de autenticación...', payload);

            // Alerta secundaria indicando progreso
            AlertComponent.secondary(this.messageContainerId, 'Verificando credenciales...');

            // Llamada al backend a través de AuthService
            const response: any = await authService.login(payload);

            console.log('Respuesta de Login:', response);

            // Si la respuesta es exitosa
            if (response && (response.success === true || response.success === undefined || response)) {
                
                // Cierre del modal de Bootstrap si está abierto
                const modalElement = document.getElementById('staticBackdrop01');
                if (modalElement && (window as any).bootstrap) {
                    const modalInstance = (window as any).bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }

                // 🌟 Muestra Alerta Flotante con animación desde la esquina superior derecha hacia el centro
                AlertComponent.floatingSuccess(
                    '<strong>¡Inicio de sesión exitoso!</strong> Cargando tu cuenta...',
                    3000
                );

                // Limpieza del formulario
                this.formElement.reset();

                // Recargar la página tras 1.5 segundos para que se refleje la sesión activa
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }

        } catch (error: any) {
            console.error('Error al iniciar sesión:', error);

            // Si el backend devuelve 422 o 401 (Credenciales inválidas)
            if (error.response && (error.response.status === 422 || error.response.status === 401)) {
                const message = error.response.data.message || 'Las credenciales ingresadas son incorrectas.';
                AlertComponent.danger(this.messageContainerId, `<strong>Error de Login:</strong> ${message}`);
            } else {
                AlertComponent.danger(
                    this.messageContainerId, 
                    '<strong>Error:</strong> No se pudo conectar con el servidor. Intente nuevamente.'
                );
            }
        }
    }
}
