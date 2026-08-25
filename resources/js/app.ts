// Importa Bootstrap
import '../../node_modules/bootstrap/js/index.esm.js';

// Si tienes Alpine.js, lo inicializamos aquí
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Importa código JS existente (temporalmente hasta que se migre a TS)
import './clientrequest.js';

// Importa los componentes TypeScript
import { RegisterComponent } from './components/RegisterComponent';

/**
 * Punto de Entrada Principal (Main) de la Aplicación Frontend
 */
document.addEventListener('DOMContentLoaded', () => {
    console.log('Aplicación TypeScript iniciada correctamente.');

    // Aquí instanciamos o registramos los componentes si detectamos su HTML
    
    // Si la vista actual tiene un formulario de registro (con id #form-registro), 
    // lo conectamos a nuestro componente.
    const registerForm = document.getElementById('formregister');
    if (registerForm) {
        new RegisterComponent('#formregister');
    }

    // Aquí agregarías más lógica de arranque para otros componentes, Vue, o Alpine.js
});
