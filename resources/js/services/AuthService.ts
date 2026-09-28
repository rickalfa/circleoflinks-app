<<<<<<< HEAD
import ApiService, { ApiResponse } from "../core/ApiService";

interface User {
  id: number;
  name: string;
  email: string;
}
interface responselaravel{

  success: boolean;
  data: {
    user: User;
  };
}



export default class AuthService extends ApiService {
  constructor() {
    super(); // baseURL relativa (Laravel)
  }

  async register(data: {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
    "g-recaptcha-response"?: string;
  }): Promise<ApiResponse<User>>{

    /// Obtenemos el CSRF token-api de seguridad para comunicarnos desde en front al back
    await this.ensureCsrf();


    const response = await this.post<responselaravel>("/api/v1/register", data);
  
  return {
    success: response.success,
    data: response.data?.data.user
  };
  
   //const user = res.data?.user;
   // {
   //  success: res.success,
   //  data: user
   //}

  }

  async login(data: { email: string; password: string; token: string }): Promise<ApiResponse<User>> {

    /// Obtenemos el CSRF token-api de seguridad para comunicarnos desde en front al back
    await this.ensureCsrf();


    return this.post<User>("/login", {
      email: data.email,
      password: data.password,
      "_token": data.token,
    });
  }

  async logout(): Promise<ApiResponse<null>> {
    return this.post<null>("/logout");
  }
}


=======
import { ApiClient } from './ApiClient';
import type { RegisterPayload, LoginPayload, UserResponse } from '../types/AuthTypes';

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
        const response = await this.http.post<UserResponse>('register', data);
        return response.data;
    }

    /**
     * Envía los datos de inicio de sesión al backend.
     * @param data Payload con email, password, remember
     */
    public async login(data: LoginPayload): Promise<UserResponse> {
        const response = await this.http.post<UserResponse>('login', data);
        return response.data;
    }
}

// Exportamos una única instancia (Singleton) para usarla a lo largo de la app
>>>>>>> origin/chatbotwsp
export const authService = new AuthService();
