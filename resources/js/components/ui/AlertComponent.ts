/**
 * Componente UI Reutilizable para alertas de Bootstrap 5
 * Desarrollado bajo principios OOP y SOLID.
 */

export type AlertType = 'success' | 'danger' | 'warning' | 'info' | 'primary' | 'secondary' | 'light' | 'dark';

export interface AlertOptions {
    container: string | HTMLElement; // Selector CSS (ej: '#messageresponse') o elemento HTML objetivo
    message: string;                // Texto o contenido HTML del mensaje
    type?: AlertType;              // Tipo de alerta Bootstrap ('success', 'danger', 'secondary', etc.)
    dismissible?: boolean;         // Si incluye botón de cierre 'x' (default: true)
    autoCloseMs?: number;          // Tiempo en milisegundos para autocerrar la alerta (opcional)
    icon?: string;                 // Clase de icono personalizado (ej: 'bi bi-star-fill')
}

export class AlertComponent {
    private containerElement: HTMLElement | null = null;
    private alertElement: HTMLDivElement | null = null;

    constructor(options?: AlertOptions) {
        if (options) {
            this.show(options);
        }
    }

    /**
     * Establece el contenedor donde se inyectará la alerta.
     */
    private setContainer(container: string | HTMLElement): void {
        if (typeof container === 'string') {
            this.containerElement = document.querySelector<HTMLElement>(container);
        } else {
            this.containerElement = container;
        }
    }

    /**
     * Renderiza y muestra la alerta Bootstrap dentro del contenedor.
     */
    public show(options: AlertOptions): HTMLDivElement | null {
        if (options.container) {
            this.setContainer(options.container);
        }

        if (!this.containerElement) {
            console.warn(`[AlertComponent] Contenedor no encontrado en el DOM:`, options.container);
            return null;
        }

        const type: AlertType = options.type || 'info';
        const dismissible: boolean = options.dismissible !== undefined ? options.dismissible : true;
        const iconHtml: string = options.icon 
            ? `<i class="${options.icon} me-2"></i>` 
            : this.getDefaultIcon(type);

        // Crear la estructura de la alerta usando clases nativas de Bootstrap 5
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} ${dismissible ? 'alert-dismissible' : ''} fade show d-flex align-items-center my-2`;
        alertDiv.setAttribute('role', 'alert');

        alertDiv.innerHTML = `
            <div class="d-flex align-items-center flex-grow-1">
                ${iconHtml}
                <div>${options.message}</div>
            </div>
            ${dismissible ? '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' : ''}
        `;

        // Limpiar alertas anteriores del contenedor e inyectar la nueva
        this.containerElement.innerHTML = '';
        this.containerElement.appendChild(alertDiv);
        this.alertElement = alertDiv;

        // Programar auto-cierre si se configuró autoCloseMs
        if (options.autoCloseMs && options.autoCloseMs > 0) {
            setTimeout(() => {
                this.close();
            }, options.autoCloseMs);
        }

        return alertDiv;
    }

    /**
     * Cierra y remueve la alerta del DOM con animación suave.
     */
    public close(): void {
        if (this.alertElement && this.alertElement.parentElement) {
            this.alertElement.classList.remove('show');
            setTimeout(() => {
                this.alertElement?.remove();
                this.alertElement = null;
            }, 150);
        }
    }

    /**
     * Limpia el contenido HTML del contenedor.
     */
    public clear(): void {
        if (this.containerElement) {
            this.containerElement.innerHTML = '';
        }
    }

    /**
     * Método estático genérico para renderizar una alerta de forma directa.
     */
    public static render(options: AlertOptions): AlertComponent {
        return new AlertComponent(options);
    }

    /**
     * Método estático para alertas de Éxito ('success')
     */
    public static success(container: string | HTMLElement, message: string, autoCloseMs?: number): AlertComponent {
        return AlertComponent.render({ container, message, type: 'success', autoCloseMs });
    }

    /**
     * Método estático para alertas de Error ('danger')
     */
    public static danger(container: string | HTMLElement, message: string, autoCloseMs?: number): AlertComponent {
        return AlertComponent.render({ container, message, type: 'danger', autoCloseMs });
    }

    /**
     * Método estático para alertas de Advertencia ('warning')
     */
    public static warning(container: string | HTMLElement, message: string, autoCloseMs?: number): AlertComponent {
        return AlertComponent.render({ container, message, type: 'warning', autoCloseMs });
    }

    /**
     * Método estático para alertas Informativas ('info')
     */
    public static info(container: string | HTMLElement, message: string, autoCloseMs?: number): AlertComponent {
        return AlertComponent.render({ container, message, type: 'info', autoCloseMs });
    }

    /**
     * Método estático para alertas Secundarias ('secondary')
     */
    public static secondary(container: string | HTMLElement, message: string, autoCloseMs?: number): AlertComponent {
        return AlertComponent.render({ container, message, type: 'secondary', autoCloseMs });
    }

    /**
     * Devuelve el icono SVG/Bootstrap predeterminado según el tipo de alerta.
     */
    private getDefaultIcon(type: AlertType): string {
        switch (type) {
            case 'success':
                return '<i class="bi bi-check-circle-fill me-2 fs-5"></i>';
            case 'danger':
                return '<i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>';
            case 'warning':
                return '<i class="bi bi-exclamation-diamond-fill me-2 fs-5"></i>';
            case 'info':
            case 'primary':
                return '<i class="bi bi-info-circle-fill me-2 fs-5"></i>';
            case 'secondary':
                return '<i class="bi bi-bell-fill me-2 fs-5"></i>';
            default:
                return '';
        }
    }
}
