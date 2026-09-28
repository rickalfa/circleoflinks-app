<x-guest-layout>
  <div class="container-fluid p-0">
    {{-- Navbar --}}
    <x-navbar-user/>
  </div>

  {{-- ======== SECCIÓN HERO / HOME ======== --}}
  <section id="home" class="container-fluid py-5 bg-light" 
  style="top: 40px; position: relative; min-height: 80vh;">
    <div class="row align-items-center justify-content-center text-center text-md-start">
      <div class="col-12 col-md-6 px-4">
        <h1 class="fw-bold mb-3">
          Circle of Links: la API pública para aprender y probar APIs
        </h1>
        <p class="lead mb-4">
          Aprende, prueba y experimenta con circleoflinks APIs de forma fácil y rápida.
        </p>

        {{-- ======== Mostramos los botones solo si el usuario NO está autenticado ======== --}}
        @guest
          <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#modalRegister">
            Registrarse
          </button>
          <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalLogin">
            Iniciar sesión
          </button>
        @endguest

        @auth
          <a href="{{ url('/profile') }}" class="btn btn-primary me-2">
            Ir a mi perfil
          </a>
          <a href="{{ url('/admindashboard') }}" class="btn btn-outline-secondary">
            Panel de Servicios
          </a>
        @endauth
      </div>

      <div class="col-12 col-md-5 mt-5 mt-md-0 text-center">
        <x-application-logo class="img-fluid" style="max-height: 280px;" />
      </div>
    </div>
  </section>

  {{-- ======== SECCIÓN INFO / CARD ======== --}}
  <section id="about" class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8">
        <div class="card shadow-sm">
          <div class="card-header bg-dark text-light">
            ¿Para quién es Circle of Links?
          </div>
          <div class="card-body bg-body-tertiary">
            <p class="card-text">
              Ideal para desarrolladores, estudiantes y entusiastas de las APIs que desean aprender, practicar y compartir conocimientos.
            </p>
            <footer class="blockquote-footer mt-2">
              Ricardo B. Dev — <cite>Conscientiam Studios</cite>
            </footer>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ======== SECCIÓN API-FEATURES ======== --}}
  <section id="features" class="py-4">
    @include('seccion.api-features')
  </section>

  {{-- ======== MODALES LOGIN & REGISTER ======== --}}
  @include('seccion.modals')

</x-guest-layout>