<x-guest-layout>
  <div class="container-fluid p-0">
    {{-- Navbar --}}
    <x-navbar-user/>
  </div>

  {{-- ======== SECCIÓN HERO / HOME ======== --}}
  <section id="home" class="container-fluid py-5 bg-light">
    <div class="row align-items-center justify-content-center text-center text-md-start">
      <div class="col-12 col-md-6 px-4">
        <h1 class="fw-bold mb-3">
          Circle of Links: la API pública para aprender y probar APIs
        </h1>
        <p class="lead mb-4">
          Aprende, prueba y experimenta con APIs de forma fácil y rápida.
        </p>
        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
          Registrarse
        </button>
        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop01">
          Iniciar sesión
        </button>
      </div>

      <div class="col-12 col-md-5 mt-5 mt-md-0">
        <x-application-logo class="img-fluid" />
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


  {{-- ======== SECCIÓN API DOC ======== --}}
  <section id="apidoc" class="container py-5">
    <h2 class="text-center mb-4">Documentación API</h2>
    <p class="text-center text-muted">
      
      visita nuestra documentacion para aprender mas sobre la API y hacer request 

      Documentacion con Swagger  <a class="link-info link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover " href="{{ route('l5-swagger.default.api')}}" >API V1 Doc</a>
         
    </p>
  </section>



 
 {{-- ======== SECCIÓN API-FETURES ======== --}}
   @include('seccion.api-features')
 

  {{-- ======== MODALES LOGIN & REGISTER ======== --}}
  @include('seccion.modals') {{-- mueve tus modales a un parcial para mantener limpio --}}


</x-guest-layout>
