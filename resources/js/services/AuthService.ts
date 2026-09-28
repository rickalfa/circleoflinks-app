import { ApiClient } from './ApiClient';
import type { RegisterPayload, LoginPayload, UserResponse } from '../types/AuthTypes';

/**
 * Servicio encargado de la autenticación.
 * Hereda de ApiClient para reutilizar la configuración de Axios.
 */
export class AuthService extends ApiClient {
    constructor() {
        super(import.meta.env.VITE_API_BASE_URL || '/');
    }

    /**
     * Envía los datos de registro al backend.
     * @param data Payload con name, email, password, etc.
     */
    public async register(data: RegisterPayload | any): Promise<UserResponse> {
        const response = await this.http.post<UserResponse>('register', data);
        return response.data;
    }

    /**
     * Envía los datos de inicio de sesión al backend.
     * @param data Payload con email, password, token, etc.
     */
    public async login(data: LoginPayload | any): Promise<UserResponse> {
        const response = await this.http.post<UserResponse>('login', data);
        return response.data;
    }

    /**
     * Cierra la sesión activa.
     */
    public async logout(): Promise<any> {
        const response = await this.http.post('logout');
        return response.data;
    }
}

// Instancia singleton para uso modular
export const authService = new AuthService();

// Export default para compatibilidad con código existente
export default AuthService;
