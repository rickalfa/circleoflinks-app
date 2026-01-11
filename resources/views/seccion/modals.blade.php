{{-- ===================================== --}}
{{--  MODAL: REGISTER                     --}}
{{-- ===================================== --}}
<div class="modal fade" id="modalRegister"
     data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="modalRegisterLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalRegisterLabel">
          <i class="bi bi-person-plus me-2"></i> Crear cuenta
        </h5>
        <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div id="messageresponse" class="mb-2"></div>

        <form id="formRegister" class="needs-validation" novalidate>
          @csrf

          <div class="mb-3">
            <label for="name" class="form-label">Nombre completo</label>
            <input type="text" class="form-control" id="name"
                   placeholder="Tu nombre" name="name" required>
            <div class="invalid-feedback">Por favor ingresa tu nombre.</div>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email"
                   placeholder="ejemplo@correo.com" name="email" required>
            <div class="invalid-feedback">Por favor ingresa un correo válido.</div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="password"
                     placeholder="••••••••" name="password" required minlength="6">
              <div class="invalid-feedback">Mínimo 6 caracteres.</div>
            </div>

            <div class="col-md-6 mb-3">
              <label for="password_confirmation" class="form-label">Confirmar</label>
              <input type="password" class="form-control" id="password_confirmation"
                     placeholder="Repite la contraseña"
                     name="password_confirmation" required>
              <div class="invalid-feedback">Debe coincidir con la contraseña.</div>
            </div>
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="terms" required>
            <label class="form-check-label" for="terms">
              Acepto los <a href="#" class="link-primary">términos y condiciones</a>.
            </label>
            <div class="invalid-feedback">Debes aceptar los términos.</div>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-send me-1"></i> Registrarme
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- ===================================== --}}
{{--  MODAL: LOGIN                        --}}
{{-- ===================================== --}}
<div class="modal fade" id="modalLogin"
     data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-secondary text-white">
        <h5 class="modal-title" id="modalLoginLabel">
          <i class="bi bi-box-arrow-in-right me-2"></i> Iniciar sesión
        </h5>
        <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div id="messageresponselogin" class="mb-2"></div>

        <form id="formLogin" method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
          @csrf

          <div class="mb-3">
            <label for="loginEmail" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="loginEmail"
                   placeholder="ejemplo@correo.com" name="email" required>
            <div class="invalid-feedback">Por favor ingresa tu correo.</div>
          </div>

          <div class="mb-3">
            <label for="loginPassword" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="loginPassword"
                   placeholder="••••••••" name="password" required>
            <div class="invalid-feedback">Por favor ingresa tu contraseña.</div>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-secondary">
              <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
