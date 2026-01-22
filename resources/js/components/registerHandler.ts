import AuthService from "../services/AuthService";

export function initRegisterHandler(): void {
  const authService = new AuthService();
  const form = document.getElementById("formRegister") as HTMLFormElement | null;
  const messageBox = document.getElementById("messageresponse") as HTMLElement | null;

  if (!form) return;

  form.addEventListener("submit", async (e) => 
    {
              e.preventDefault();
              if (messageBox) messageBox.innerHTML = "";

              const formData = new FormData(form);
              const data = Object.fromEntries(formData.entries());

              console.log(" datos del formulario ");
              console.log(formData.entries());
              console.log(data);


              try {
                const response = await authService.register(data as any);

                if (response.success) {
                  if (messageBox)
                    messageBox.innerHTML = `
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Registro exitoso. Bienvenido <strong>${response.data?.name}</strong>.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>`;
                  form.reset();


                }
              } catch (error: any) {
         console.error("Detalle del error:", error.response?.data);

      let errorMsg = "Error inesperado al registrar.";

      // Verificamos si hay errores de validación específicos (el objeto 'errors')
      if (error.response?.data?.errors) {
        const errors = error.response.data.errors;
        errorMsg = Object.values(errors).flat().join("<br>");
      } 
      // Si no hay objeto 'errors', usamos el mensaje general
      else if (error.response?.data?.message) {
        errorMsg = error.response.data.message;
      }

      if (messageBox) {
        messageBox.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i> ${errorMsg}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>`;
      }
                
                
                  }
    }
 );
}
