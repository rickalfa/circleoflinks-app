// Importa Bootstrap
import * as bootstrap from '../../node_modules/bootstrap/js/index.esm.js';
(window as any).bootstrap = bootstrap;

// Si tienes Alpine.js, lo inicializamos aquí
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Importa los componentes TypeScript
import { RegisterComponent } from './components/RegisterComponent';
import { LoginComponent } from './components/LoginComponent';
import { AlertComponent } from './components/ui/AlertComponent';
import { LeadUnreadStatus } from './components/LeadUnreadStatus';
import { LeadsTableComponent, initLeadsTable } from './components/view/leadsTable';

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

    // Inicializar el formulario de login si está presente en el DOM
    const loginForm = document.getElementById('formlogin');
    if (loginForm) {
        new LoginComponent('#formlogin', '#messageresponselogin');
    }

    // Inicializar el componente de Tabla de Leads (TypeScript)
    if (document.getElementById('leads-table-root')) {
        initLeadsTable();
    } else if (document.getElementById('leads-list-container')) {
        // Fallback legacy si otra vista usa #leads-list-container
        new LeadUnreadStatus();
    }
});

export {
    RegisterComponent,
    LoginComponent,
    AlertComponent,
    LeadUnreadStatus,
    LeadsTableComponent,
    initLeadsTable,
};
