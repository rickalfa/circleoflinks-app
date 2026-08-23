import { authService } from '../services/AuthService';
import { RegisterPayload } from '../types/AuthTypes';

/**
 * Componente que maneja la lógica de la vista de Registro
 */
export class RegisterComponent {
    private formElement: HTMLFormElement | null;

    /**
     * @param formSelector El selector CSS o ID del formulario en el HTML
     */
    constructor(formSelector: string) {
        this.formElement = document.querySelector<HTMLFormElement>(formSelector);
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

        // Extraer los datos de los inputs
        const formData = new FormData(this.formElement);
        const payload: RegisterPayload = {
            name: formData.get('name') as string,
            email: formData.get('email') as string,
            password: formData.get('password') as string,
            password_confirmation: formData.get('password_confirmation') as string,
        };

        try {
            console.log('Enviando datos de registro...', payload);
            
            // Llamamos a nuestro servicio que hereda de ApiClient
            const response = await authService.register(payload);
            
            console.log('Registro exitoso:', response);
            alert('¡Registro exitoso!');
            
            // Opcional: Redirigir al usuario
            // window.location.href = '/home';
        } catch (error) {
            console.error('Ocurrió un error en el registro:', error);
            alert('Hubo un error al registrar. Revisa la consola o los datos ingresados.');
        }
    }
}
