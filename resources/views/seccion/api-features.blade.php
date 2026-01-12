<section id="api-features" class="container py-5">
  <h2 class="text-center mb-4">Características principales de la API Circle of Links</h2>
  <p class="text-center text-muted mb-5">
    Una API relacional pensada para que desarrolladores, estudiantes y empresas aprendan a construir y consumir sistemas reales con modelos conectados.
  </p>

  <div class="accordion accordion-flush" id="apiAccordion">
    {{-- 1. Modelo relacional educativo --}}
    <div class="accordion-item">
      <h2 class="accordion-header" id="featureOneHeader">
        <button class="accordion-button collapsed" type="button"
                data-bs-toggle="collapse" data-bs-target="#featureOne"
               aria-expanded="false" aria-controls="featureOne">
           Modelo relacional educativo
        </button>
      </h2>
      <div id="featureOne" class="accordion-collapse collapse"
           aria-labelledby="featureOneHeader" data-bs-parent="#apiAccordion">
        <div class="accordion-body">
          La API implementa un modelo relacional real con entidades como 
          <code>empresa</code>, <code>proyectos</code>, <code>oferta_laborals</code>, 
          <code>user_app</code> y <code>user_perfil</code>.  
          Esta estructura permite comprender cómo se conectan usuarios, proyectos 
          y ofertas laborales, siendo ideal para aprender relaciones 
          <strong>one-to-many</strong> y <strong>many-to-many</strong>.
        </div>
      </div>
    </div>

    {{-- 2. Creación de proyectos y ofertas laborales --}}
    <div class="accordion-item">
      <h2 class="accordion-header" id="featureTwoHeader">
        <button class="accordion-button collapsed" type="button"
                data-bs-toggle="collapse" data-bs-target="#featureTwo"
                aria-expanded="false" aria-controls="featureTwo">
           Sistema de proyectos y ofertas laborales
        </button>
      </h2>
      <div id="featureTwo" class="accordion-collapse collapse"
           aria-labelledby="featureTwoHeader" data-bs-parent="#apiAccordion">
        <div class="accordion-body">
          Las empresas registradas pueden crear <code>proyectos</code> y publicar 
          <code>oferta_laborals</code>.  
          Los usuarios (<code>user_app</code>) pueden postularse, establecer contacto 
          o usar estas entidades como base para sus propios desarrollos.  
          Es una API lista para experimentar con CRUDs completos, autenticación y 
          relaciones empresariales.
        </div>
      </div>
    </div>

    {{-- 3. Enfoque de aprendizaje y colaboración --}}
    <div class="accordion-item">
      <h2 class="accordion-header" id="featureThreeHeader">
        <button class="accordion-button collapsed" type="button"
                data-bs-toggle="collapse" data-bs-target="#featureThree"
                aria-expanded="false" aria-controls="featureThree">
           Enfoque práctico para aprender y colaborar
        </button>
      </h2>
      <div id="featureThree" class="accordion-collapse collapse"
           aria-labelledby="featureThreeHeader" data-bs-parent="#apiAccordion">
        <div class="accordion-body">
          Circle of Links fue diseñada como una herramienta educativa para practicar 
          el consumo de APIs REST.  
          Puedes conectarla desde aplicaciones web, móviles o de escritorio y 
          experimentar con endpoints reales.  
          Ideal para practicar con <strong>autenticación Laravel Sanctum</strong>, 
          <strong>relaciones Eloquent</strong> y <strong>consumo con Axios/Fetch</strong>.
        </div>
      </div>
    </div>
  </div>
</section>