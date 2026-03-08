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

                  <div class="d-flex justify-content-center">
                    <div class="bg-dark text-white p-2 fs-4 rounded" >
                    <p> 
                 </br> En la la key "Data" es donde 
                    van los datos de la respuesta a la peticion </p> 

                                      
                    <nav class="navbar bg-body-tertiary">
                          <div class="form-text px-3" id="basic-addon4">ejemplo de url request.</div>
                                  <form class="container-fluid">
                      
                                      <div class="mb-3">
                                          <label for="basic-url" class="form-label text-dark">peticion <span class="text-success">GET </span></label>
                                          <div class="input-group">
                                            <i class="bi bi-link-45deg me-2 text-primary"></i>
                                            <span class="input-group-text" id="basic-addon3">{{ env('L5_SWAGGER_CONST_HOST') }}/api/v1/empresa/</span>
                                            <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4" placeholder="2" readonly>
                                          </div>
                                          
                                        </div>
                                  </form>
                                  
                            </div>
                    </nav>

                  </div>


                  <div class="col-lg-12"> 

              
                    <div class="d-flex justify-content-center">


                         {{-- ======== Box de vizualizacion de Json======== --}}          
             
                         <div class="card" style="width: 18rem;">

                           <div class="card-body">
                            <blockquote class="blockquote fs-2">
                                      <span>Estructura general de Respuesta Json exitosa ( status: <span class="text-success">  200 </span>)  de la API. 
                                <p>ejemplo de respuesta :</p>
                              </blockquote>

                              </div>

                         </div>
                            <div id="box-json" class="boxjson m-4">

                     
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
