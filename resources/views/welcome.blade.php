<x-guest-layout>
  <div class="container-fluid p-0">
    {{-- Navbar --}}
    <x-navbar-user/>
  </div>

  {{-- ======== SECCIÓN HERO / HOME ======== --}}
  <section id="home" class="container-fluid py-5 bg-light" 
  style="top: 40px; position: relative;
         height:100vh;
  ">
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
  <section id="about" class="container " >
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8">
        <div class="card shadow-sm" style="margin-top: 100px;">
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


 


 {{-- ======== SECCIÓN API-FETURES ======== --}}
 <section id="features">

  @include('seccion.api-features')
 
 </section>

 

    <div class="row">
        <div class="col-lg-12 p-3">
          <div class="d-flex justify-content-center">
            <div class="row">

               


                  <div class="col-lg-12"> 
                  
              
                   
                  <div class="container my-5">

                    

                        <div class="row">
                            <div class="col" >
                              <div class="p-2 m-1 borders border-rounded border-2">
                                <h3> Ejemplo de peticion Get</h3>

                              </div>
                              

                            </div>                                                  
                        </div>

                        <div class="row"><!-- Peticion ejemplo get -->
                              <div class="col ">
                                      <label for="basic-url" class="form-label">Peticion <span class="badge bg-success fs-6">Get</span></label>
                                      <hr></br>
                                      <label for="basic-url" class="form-label">URL : </label>
                                      <div class="input-group mb-3">
                                        <i class="bi bi-link px-1" style="font-size: 2rem;"></i>
                                        <span class="input-group-text" id="basic-addon3">{{env('VITE_API_BASE_URL')}}/api/v1/empresa/</span>
                                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" value="2" disabled>
                                      </div>

                              </div>

                              <div class="row justify-content-center g-1 " >

                              <!-- Info de la respuesta -->
                              <div class="col-lg-5" >

                                <div class="row align-items-center bg-warning" style="height: 60vh;">

                                  <div class="col">

                                      <div class="card shadow-sm border-0">
                                      <div class="card-body">

                                        <h4 class="fw-bold mb-3">
                                          Estructura de Respuesta JSON
                                        </h4>

                                        <p class="text-muted">
                                          Respuesta exitosa de la API cuando la solicitud se procesa correctamente.
                                        </p>

                                        <p class="mb-2">
                                          Status HTTP:
                                          <span class="badge bg-success fs-6">200 OK</span>
                                        </p>

                                        <p class="mb-4 text-muted">
                                          Ejemplo de respuesta generada por la API.
                                        </p>

                                      </div>

                          
                                    </div>

                                  </div>
                                  
                                  


                                </div>
                              
                              </div>

                              <!-- Visualizador JSON -->
                              <div class="col-lg-7">

                                <div class="card shadow-sm border-0">

                                  <div class="card-header bg-light d-flex justify-content-between">

                                    <span class="fw-semibold">
                                      Response
                                    </span>

                                    <span class="badge bg-info">
                                      application/json
                                    </span>

                                  </div>

                                  <div class="card-body p-1">

                                    <h5 class="card-title">  <i class="bi bi-filetype-json" style="font-size: 1.4rem;"> </i> Formato respuesta
                                      </h5>
                                    
                                    
                                      <div id="box-json" class="boxjson m-4"></div>



                                

                                  </div>

                                </div>

                              </div>
                      </div>
                  

                    </div>

                 
                  </div>

</div>


             </div> {{--  END ROW --}}
           
              
        

            </div>

        </div>
    </div>
     


  </section>


   <section>

    <div class="container my-5">
    <h2 class="text-center mb-4">Modelo de Datos: Circle Of Links</h2>
    <div id="schema-viewer"></div>
    </div>

   </section>


  {{-- ======== MODALES LOGIN & REGISTER ======== --}}
  @include('seccion.modals') {{-- mueve tus modales a un parcial para mantener limpio --}}


</x-guest-layout>
