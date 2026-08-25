import { authService } from '../services/AuthService';
import type { RegisterPayload } from '../types/AuthTypes';

/**
 * Componente que maneja la lógica de la vista de Registro
 */
class RegisterComponent {
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

        // Limpiamos mensajes previos y aplicamos clases de Bootstrap
        this.formElement.classList.remove('was-validated');

        // Validaciones manuales básicas
        let isValid = true;
        
        const formData = new FormData(this.formElement);
        const name = formData.get('name') as string;
        const email = formData.get('email') as string;
        const password = formData.get('password') as string;
        const password_confirmation = formData.get('password_confirmation') as string;
        const terms = formData.get('remember'); // checkbox

        // Validar que el formulario cumpla con las validaciones HTML5 requeridas (required, type="email", etc.)
        if (!this.formElement.checkValidity()) {
            isValid = false;
        }

        // Validación específica: las contraseñas deben coincidir
        if (password !== password_confirmation) {
            isValid = false;
            alert("Las contraseñas no coinciden");
            // Aquí puedes también manipular el DOM para mostrar el error en el input
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
            
            // Enviamos los datos a la ruta de registro (por defecto /register)
            const response = await authService.register(payload);
            
            console.log('Registro exitoso:', response);
            alert('¡Registro exitoso!');
            
            // Como Laravel típicamente autentica y requiere redirección tras el registro:
            window.location.href = '/dashboard'; // O la ruta a la que quieras redirigir tras registrar
            
        } catch (error: any) {
            console.error('Ocurrió un error en el registro:', error);
            
            // Si Laravel devuelve errores de validación (422), podemos mostrarlos
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                let errorMessages = 'Por favor corrige los siguientes errores:\n';
                for (const key in errors) {
                    errorMessages += `- ${errors[key].join(', ')}\n`;
                }
                alert(errorMessages);
            } else {
                alert('Hubo un error al registrar. Revisa la consola o intenta nuevamente.');
            }
        }
    }
}
