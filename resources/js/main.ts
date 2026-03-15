// Importar estilos y dependencias


import { SchemaRenderer } from './components/schemaRenderer.ts';


import '../sass/app.scss';


import './components/anim'

import './bootstrap.ts'

// Ejemplo: importar un componente propio
import './components/login';

import { initRegisterHandler } from "./components/registerHandler";

import {jsonView } from './components/view/jsonview.ts'
import './components/view/accessTokens';

import AuthService from "./services/AuthService";

import { LoginController } from "./components/login.ts";

// Mensaje de verificación
//console.log(' TypeScript + Bootstrap + Sass funcionando correctamente');


document.addEventListener("DOMContentLoaded", () => {

    

  initRegisterHandler();

  new LoginController("login-form");
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

    
    const renderer = new SchemaRenderer();
    renderer.render('schema-viewer');

    jsonView();

  
});
