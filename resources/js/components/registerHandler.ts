import AuthService from "../services/AuthService";

export function initRegisterHandler(): void {
  const authService = new AuthService();
  const form = document.getElementById("formRegister") as HTMLFormElement | null;
  const messageBox = document.getElementById("messageresponse") as HTMLElement | null;

  if (!form) return;

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    if (messageBox) messageBox.innerHTML = "";

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

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
      const errorMsg =
        error.response?.data?.message ||
        error.response?.data?.errors
          ? Object.values(error.response.data.errors).flat().join("<br>")
          : " Error inesperado al registrar. Intenta nuevamente.";

      if (messageBox)
        messageBox.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            ${errorMsg}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>`;
    }
  });
}
