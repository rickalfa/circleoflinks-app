<x-guest-layout>
  <div class="container-fluid p-0">
    {{-- Navbar --}}
    <x-navbar-user/>
  </div>

  {{-- ======== SECCIÓN HERO / HOME ======== --}}
  <section id="home" class="container-fluid py-5 bg-light" style="top: 40px; position: relative;">
    <div class="row align-items-center justify-content-center text-center text-md-start">
      <div class="col-12 col-md-6 px-4">
        <h1 class="fw-bold mb-3">
          Circle of Links: la API pública para aprender y probar APIs
        </h1>
        <p class="lead mb-4">
          Aprende, prueba y experimenta con circleoflinks APIs de forma fácil y rápida.
        </p>

          {{-- ======== Mostramos los botones solo si el usuario NO esta autentiado ======== --}}
        @guest
          <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#modalRegister">
            Registrarse
          </button>
          <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalLogin">
            Iniciar sesión
          </button>

        @endguest
   

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
    <h2 class="text-center mb-4 ">Documentación API</h2>

        <p class="text-center text-muted fs-5">
      
      visita nuestra documentacion para aprender mas sobre la API y hacer request. 

        <a class="link-info link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover " href="{{ route('l5-swagger.default.api')}}" >API V1 Doc</a>
         
    </p>


      <div class="container mt-4">
      <div class="card border-start border-4 border-primary shadow-sm">
          <div class="card-body">
              <h5 class="card-title d-flex align-items-center">
                  <i class="bi bi-link-45deg me-2 text-primary"></i>
                  Base URL de la API (Swagger)
              </h5>
              <p class="card-text text-muted small">
                  Esta es la URL base configurada para todas las peticiones en este entorno.
              </p>
              
              <div class="env-display bg-dark text-light p-3 rounded-3 position-relative">
                  <span class="badge bg-secondary position-absolute top-0 end-0 m-2">.env</span>
                  <code class="text-info">VITE_API_BASE_URL</code>
                  <span class="text-white-50">=</span>
                  <span class="url-text">https://circleoflinks.cloud/api/v1</span>
                  
                  <button class="btn btn-sm btn-outline-light ms-3 btn-copy" onclick="copyUrl()">
                      <i class="bi bi-clipboard"></i>
                  </button>
              </div>

              <div class="mt-3">
                  <span class="badge bg-success-subtle text-success border border-success-subtle">
                      <i class="bi bi-check-circle-fill me-1"></i> Estado: Activo
                  </span>
                  <span class="ms-2 text-secondary small">
                      <i class="bi bi-info-circle me-1"></i> Utilizado por L5-Swagger
                  </span>
              </div>
          </div>
      </div>


</div>


    <div class="row">
        <div class="col-lg-12 p-3">
          <div class="d-flex justify-content-center">
            <div class="row">

                  <div class="d-flex justify-content-center">
                    <div class="bg-dark text-white p-2 fs-4 rounded" >
                    <p> 
                    <span>Estructura general de Respuesta Json exitosa ( status: <span class="text-success">  200 </span>)  de la API.   </br> En la la key "Data" es donde 
                    van los datos de la respeusta a la peticion </p> 

                                      
                              <nav class="navbar bg-body-tertiary">
                          <form class="container-fluid">
                          
                              <div class="mb-3">
                                  <label for="basic-url" class="form-label text-dark">peticion <span class="text-success">GET </span></label>
                                  <div class="input-group">
                                    <i class="bi bi-link-45deg me-2 text-primary"></i>
                                    <span class="input-group-text" id="basic-addon3">{{ env('L5_SWAGGER_CONST_HOST') }}/api/v1/empresa/</span>
                                    <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4" placeholder="2" readonly>
                                  </div>
                                  <div class="form-text" id="basic-addon4">ejemplo de url request.</div>
                                </div>
                          </form>
                        </nav>
                   </div>

                </div>
             
                <div id="box-json" class="boxjson m-4">

                  </div>

              </div>

            </div>

        </div>
    </div>
     


  </section>



 
 {{-- ======== SECCIÓN API-FETURES ======== --}}
   @include('seccion.api-features')
 

   <section>

    <div class="container my-5">
    <h2 class="text-center mb-4">Modelo de Datos: Circle Of Links</h2>
    <div id="schema-viewer"></div>
    </div>

   </section>


  {{-- ======== MODALES LOGIN & REGISTER ======== --}}
  @include('seccion.modals') {{-- mueve tus modales a un parcial para mantener limpio --}}


</x-guest-layout>
