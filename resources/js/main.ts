// Importar estilos y dependencias
import '../sass/app.scss';


import './components/anim'

import './bootstrap.ts'

// Ejemplo: importar un componente propio
import './components/login';

import { initRegisterHandler } from "./components/registerHandler";


import AuthService from "./services/AuthService";



// Mensaje de verificación
//console.log(' TypeScript + Bootstrap + Sass funcionando correctamente');


document.addEventListener("DOMContentLoaded", () => {

    

  initRegisterHandler();

 /// const authService = new AuthService();
 /// const form = document.getElementById("formRegister") as HTMLFormElement | null;

 /// if (form) {
 ///   form.addEventListener("submit", async (e) => {
 ///     e.preventDefault();

 ///     const formData = new FormData(form);
 ///     const data = Object.fromEntries(formData.entries());

 ///     try {
 ///       const response = await authService.register(data as any);
 ///       console.log(" Usuario registrado:", response);
 ///     } catch (err) {
 ///       console.error("Error:", err);
 ///     }
 ///   });
 /// }



  
});