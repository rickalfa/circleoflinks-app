export interface RegisterPayload {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
}

export interface UserResponse {
    user?: {
        id: number;
        name: string;
        email: string;
    };
    token?: string;
    message?: string;
}
