import { authService } from '../services/AuthService';
import type { RegisterPayload } from '../types/AuthTypes';
import { AlertComponent } from './ui/AlertComponent';

/**
 * Componente que maneja la lógica de la vista de Registro
 */
export class RegisterComponent {
    private formElement: HTMLFormElement | null;
    private messageContainerId: string = '#messageresponse';

    /**
     * @param formSelector El selector CSS o ID del formulario en el HTML
     * @param messageContainerId Selector opcional del contenedor de alertas
     */
    constructor(formSelector: string, messageContainerId: string = '#messageresponse') {
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
     * Maneja el evento submit del formulario
     */
    private async handleSubmit(event: Event) {
        event.preventDefault(); // Evita la recarga de página por defecto
        
        if (!this.formElement) return;

        // Limpiamos alertas previas
        AlertComponent.render({ container: this.messageContainerId, message: '' }).clear();

        // Limpiamos clases de Bootstrap
        this.formElement.classList.remove('was-validated');

        // Validaciones manuales básicas
        let isValid = true;
        
        const formData = new FormData(this.formElement);
        const name = formData.get('name') as string;
        const email = formData.get('email') as string;
        const password = formData.get('password') as string;
        const password_confirmation = formData.get('password_confirmation') as string;

        // Validar que el formulario cumpla con las validaciones HTML5 requeridas (required, type="email", etc.)
        if (!this.formElement.checkValidity()) {
            isValid = false;
        }

        // Validación específica: las contraseñas deben coincidir
        if (password !== password_confirmation) {
            isValid = false;
            AlertComponent.warning(this.messageContainerId, 'Las contraseñas no coinciden. Por favor verifícalas.');
        }

        if (!isValid) {
            // Mostrar los estilos de validación de Bootstrap
            this.formElement.classList.add('was-validated');
            return; // Detenemos la ejecución si no es válido
        }

        const payload: RegisterPayload = {
            name,
            email,
            password,
            password_confirmation,
        };

        try {
            console.log('Validación exitosa, enviando datos de registro...', payload);

            // Mostrar estado de carga opcional / secundario
            AlertComponent.secondary(this.messageContainerId, 'Procesando registro, por favor espere...');
            
            // Enviamos los datos a la ruta de registro (por defecto /register)
            const response: any = await authService.register(payload);
            
            console.log('Registro exitoso:', response);

            // Evaluamos la respuesta (éxito explícito o respuesta válida)
            if (response && (response.success === true || response.success === undefined || response)) {
                // Renderizar Alerta de Éxito con Bootstrap
                AlertComponent.success(
                    this.messageContainerId, 
                    '<strong>¡Registro exitoso!</strong> Redirigiendo y actualizando la página...'
                );
                
                // Limpiar el formulario
                this.formElement.reset();
                this.formElement.classList.remove('was-validated');

                // Recargar la página tras 1.5 segundos
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
            
        } catch (error: any) {
            console.error('Ocurrió un error en el registro:', error);
            
            // Si Laravel devuelve errores de validación de backend (422), los mostramos en alerta Danger
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                let errorMessages = '<strong>Error de validación:</strong><ul class="mb-0 mt-1 ps-3">';
                for (const key in errors) {
                    errorMessages += `<li>${errors[key].join(', ')}</li>`;
                }
                errorMessages += '</ul>';
                
                AlertComponent.danger(this.messageContainerId, errorMessages);
            } else {
                AlertComponent.danger(
                    this.messageContainerId, 
                    '<strong>Error:</strong> Ocurrió un problema al procesar el registro. Intente nuevamente.'
                );
            }
        }
    }
}
