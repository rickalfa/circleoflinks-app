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
  }): Promise<ApiResponse<User>>{

    const response = await this.post<responselaravel>("/register", data);
  
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

  async login(data: { email: string; password: string }): Promise<ApiResponse<User>> {
    return this.post<User>("/login", data);
  }

  async logout(): Promise<ApiResponse<null>> {
    return this.post<null>("/logout");
  }
}
