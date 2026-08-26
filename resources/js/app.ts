// Importa Bootstrap
import '../../node_modules/bootstrap/js/index.esm.js';

// Si tienes Alpine.js, lo inicializamos aquí
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Importa los componentes TypeScript
import { RegisterComponent } from './components/RegisterComponent';
import { AlertComponent } from './components/ui/AlertComponent';

// Exportar globalmente para componentes o scripts legacy si se requiere
(window as any).AlertComponent = AlertComponent;

/**
 * Punto de Entrada Principal (Main) de la Aplicación Frontend
 */
document.addEventListener('DOMContentLoaded', () => {
    console.log('Aplicación TypeScript iniciada correctamente.');

    // Inicializar el formulario de registro si está presente en el DOM
    const registerForm = document.getElementById('formregister');
    if (registerForm) {
        new RegisterComponent('#formregister', '#messageresponse');
    }
});

export { RegisterComponent, AlertComponent };
