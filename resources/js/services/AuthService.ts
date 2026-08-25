import { ApiClient } from './ApiClient';
import type { RegisterPayload, UserResponse } from '../types/AuthTypes';

/**
 * Servicio encargado de la autenticación.
 * Hereda de ApiClient para reutilizar la configuración de Axios.
 */
export class AuthService extends ApiClient {
    
    constructor() {
        // Inicializa ApiClient apuntando a la ruta base de Vite para que funcione en subcarpetas (XAMPP)
        super(import.meta.env.VITE_API_BASE_URL || '/'); 
    }

    /**
     * Envía los datos de registro al backend.
     * @param data Payload con name, email, password
     */
    public async register(data: RegisterPayload): Promise<UserResponse> {
        // This.http está disponible porque AuthService hereda de ApiClient
        const response = await this.http.post<UserResponse>('register', data);
        return response.data;
    }
}

// Exportamos una única instancia (Singleton) para usarla a lo largo de la app
export const authService = new AuthService();
