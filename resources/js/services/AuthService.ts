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

  async login(data: { email: string; password: string; recaptcha: string }): Promise<ApiResponse<User>> {

    /// Obtenemos el CSRF token-api de seguridad para comunicarnos desde en front al back
    await this.ensureCsrf();


    return this.post<User>("/login", {
      email: data.email,
      password: data.password,
      "g-recaptcha-response": data.recaptcha,
    });
  }

  async logout(): Promise<ApiResponse<null>> {
    return this.post<null>("/logout");
  }
}


export const authService = new AuthService();
