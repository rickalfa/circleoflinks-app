import { ApiClient } from './ApiClient';
import { RegisterPayload, UserResponse } from '../types/AuthTypes';

/**
 * Servicio encargado de la autenticación.
 * Hereda de ApiClient para reutilizar la configuración de Axios.
 */
export class AuthService extends ApiClient {
    
    constructor() {
        // Inicializa ApiClient apuntando a la ruta raíz para endpoints web (ej. /register)
        // o a '/api' si el registro pasa por la API de Laravel
        super('/'); 
    }

    /**
     * Envía los datos de registro al backend.
     * @param data Payload con name, email, password
     */
    public async register(data: RegisterPayload): Promise<UserResponse> {
        // This.http está disponible porque AuthService hereda de ApiClient
        const response = await this.http.post<UserResponse>('/register', data);
        return response.data;
    }
}

// Exportamos una única instancia (Singleton) para usarla a lo largo de la app
export const authService = new AuthService();
