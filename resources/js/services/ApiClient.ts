import axios, { AxiosInstance, AxiosResponse } from 'axios';

/**
 * Clase abstracta ApiClient
 * 
 * Centraliza la configuración de Axios. Al ser abstracta, no se puede instanciar 
 * directamente, obligando a que otros servicios hereden de ella. Esta es una excelente
 * práctica de Programación Orientada a Objetos (OOP) para estructurar peticiones HTTP.
 */
export abstract class ApiClient {
    protected readonly http: AxiosInstance;

    constructor(baseURL: string = '/api',import.meta.env.VITE_API_BASE_URL || '/api') {
        // Inicializamos la instancia de axios con configuración base
        this.http = axios.create({
            baseURL,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        });

        this.initializeRequestInterceptor();
        this.initializeResponseInterceptor();
    }

    /**
     * Interceptor de peticiones.
     * Útil para adjuntar tokens (Bearer) de forma automática antes de que salga la petición.
     */
    private initializeRequestInterceptor() {
        this.http.interceptors.request.use(
            (config) => {
                // Ej: config.headers['Authorization'] = `Bearer ${token}`;
                // Nota: Laravel y Axios ya manejan el CSRF automáticamente si las cookies existen.
                return config;
            },
            (error) => Promise.reject(error)
        );
    }

    /**
     * Interceptor de respuestas.
     * Útil para el manejo global de errores (ej. redirigir al login si retorna 401).
     */
    private initializeResponseInterceptor() {
        this.http.interceptors.response.use(
            (response: AxiosResponse) => response,
            (error) => {
                // Manejo de errores global
                console.error('API Error Detectado en ApiClient:', error?.response?.data || error.message);
                return Promise.reject(error);
            }
        );
    }
}
