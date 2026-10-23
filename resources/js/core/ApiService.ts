import axios, { AxiosInstance, AxiosRequestConfig, AxiosResponse, formToJSON } from "axios";

export interface ApiResponse<T> {
  success: boolean;
  message?: string;
  data?: T;
}

export default class ApiService {
  protected api: AxiosInstance;

  constructor(resourcePath: string = "/") {

    // 1. Obtenemos la URL base del .env o usamos el origen actual del navegador como fallback,
    // normalizando las barras para evitar '//' (ej. '.../public//chat-api') en subdirectorios XAMPP.
    const rawBase = (import.meta.env.VITE_API_BASE_URL || window.location.origin).replace(/\/+$/, "");
    const cleanPath = resourcePath && resourcePath !== "/"
      ? "/" + resourcePath.replace(/^\/+|\/+$/g, "")
      : "";

    this.api = axios.create({
      baseURL: `${rawBase}${cleanPath}`,
      headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
      withCredentials: true,

      responseType: 'json'

    });

    this.api.interceptors.request.use((config) => {

    const token = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content;
    
    if (token) {
      config.headers["X-CSRF-TOKEN"] = token;
    }
    
    return config;
  }, (error) => {
    return Promise.reject(error);
  });

  // interceptor de respuesta existente...
  this.api.interceptors.response.use(
    (response) => response,
    (error) => {
      // Si recibes un 419, significa que el token expiró
      if (error.response?.status === 419) {
        alert("La sesión ha expirado. Por favor, recarga la página.");
      }
      return Promise.reject(error);
    }

    
  );

    // Interceptor para manejar errores globalmente
    this.api.interceptors.response.use(
      (response) => response,
      (error) => {
        console.error(" Error en la solicitud:", error.response || error);
        return Promise.reject(error);
      }
    );
  }

  protected async get<T>(url: string, config?: AxiosRequestConfig): Promise<ApiResponse<T>> {
    const response: AxiosResponse<T> = await this.api.get(url, config);
    return { success: true, data: response.data };
  }

  protected async post<T>(
    url: string,
    data?: any,
    config?: AxiosRequestConfig
  ): Promise<ApiResponse<T>> {
    const response: AxiosResponse<T> = await this.api.post(url, data, config);

    const rest = response.data;

    const respojson = JSON.stringify(rest);

    console.log("apiService : "+ respojson);

    return { success: true, data: response.data };
  }

  protected async put<T>(
    url: string,
    data?: any,
    config?: AxiosRequestConfig
  ): Promise<ApiResponse<T>> {
    const response: AxiosResponse<T> = await this.api.put(url, data, config);
    return { success: true, data: response.data };
  }

  protected async delete<T>(url: string, config?: AxiosRequestConfig): Promise<ApiResponse<T>> {
    const response: AxiosResponse<T> = await this.api.delete(url, config);
    return { success: true, data: response.data };
  }

  protected async ensureCsrf(){

    await this.api.get('/sanctum/csrf-cookie');


  }

}
