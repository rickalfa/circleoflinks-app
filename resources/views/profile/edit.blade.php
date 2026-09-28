<x-guest-layout>
    

    <div class="container-fluid profile-container pb-5">
      
      <!-- Componente dashboardprofile -->
      <div class="row">
        <div class="col h-25 d-inline-block">
          <div style="height: 70px; left: 20px">
           <x-profile.dashboardprofile/>
          </div>
        </div>
      </div>

      <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-2 col-md-12">
          <x-profile.sidebarprofile/>
        </div>
   
        <!-- Contenido Principal -->
        <div class="col-lg-10 col-md-12">
          <div id="main">
             <div class="py-4">
                <section>
                    <div class="container">
                      
                      <!-- Breadcrumb -->
                      <div class="row mb-4">
                        <div class="col">
                          <nav aria-label="breadcrumb" class="modern-breadcrumb">
                            <ol class="breadcrumb mb-0">
                              <li class="breadcrumb-item"><a href="{{ url('/')}}"><i class="bi bi-house-door-fill me-1"></i> Home</a></li>
                              <li class="breadcrumb-item"><a href="#">User</a></li>
                              <li class="breadcrumb-item active fw-bold" aria-current="page">User Profile</li>
                            </ol>
                          </nav>
                        </div>
                      </div>

                      @php
                        $userm = Auth::user();
                      @endphp

                      <!-- Verificación de Email -->
                      @if ($userm && $userm->hasVerifiedEmail())
                         <!-- <div class="alert alert-success modern-alert">
                            <i class="bi bi-check-circle-fill me-2 fs-5"></i> Email verificado correctamente.
                         </div> -->
                      @else
                        @if ($userm)
                        <div class="alert alert-danger modern-alert alert-dismissible fade show mb-4">
                          <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                          <div>
                            <strong>¡Atención!</strong> Tu correo electrónico no ha sido verificado. 
                            <a href="{{ url('verify-email') }}" class="alert-link text-decoration-underline">Verificar correo electrónico</a>.
                          </div>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                      @endif
                      
                      <div class="row">
                        <!-- Tarjeta de Perfil Izquierda -->
                        <div class="col-lg-4 mb-4">
                          <div class="card profile-card h-100">
                            <div class="card-body text-center p-4">
                              <div class="profile-avatar-wrapper mb-3 mt-2">
                                <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=0D8ABC&color=fff' }}" alt="avatar" class="profile-avatar">
                              </div>
                              <h4 class="mb-1 fw-bold text-dark">{{ $user->name }}</h4>
                              <p class="text-muted mb-2"><i class="bi bi-briefcase-fill me-1"></i> Full Stack Developer</p>
                              <p class="text-muted mb-4"><i class="bi bi-geo-alt-fill me-1"></i> Bay Area, San Francisco, CA</p>
                              
                              <div class="d-flex justify-content-center gap-2 mb-2">
                                <button type="button" class="btn btn-primary px-4 rounded-pill shadow-sm"><i class="bi bi-person-check-fill me-1"></i> Follow</button>
                                <button type="button" class="btn btn-outline-primary px-4 rounded-pill"><i class="bi bi-chat-dots-fill me-1"></i> Message</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Detalles del Perfil Derecha -->
                        <div class="col-lg-8 mb-4">
                          <div class="card profile-card h-100">
                            <div class="card-body p-4">
                              <h5 class="card-title fw-bold mb-4 text-dark"><i class="bi bi-person-vcard me-2 text-primary"></i> Información de Contacto</h5>
                              
                              <div class="info-row row align-items-center">
                                <div class="col-sm-4 info-label">
                                  <i class="bi bi-person-fill"></i> Full Name
                                </div>
                                <div class="col-sm-8 info-value">
                                  {{ $user->name }}
                                </div>
                              </div>
                              <hr class="text-muted opacity-25 my-2">
                              
                              <div class="info-row row align-items-center">
                                <div class="col-sm-4 info-label">
                                  <i class="bi bi-envelope-fill"></i> Email
                                </div>
                                <div class="col-sm-8 info-value">
                                  {{ $user->email }}
                                </div>
                              </div>
                              <hr class="text-muted opacity-25 my-2">
                              
                              <div class="info-row row align-items-center">
                                <div class="col-sm-4 info-label">
                                  <i class="bi bi-telephone-fill"></i> Phone
                                </div>
                                <div class="col-sm-8 info-value">
                                  (097) 234-5678
                                </div>
                              </div>
                              <hr class="text-muted opacity-25 my-2">
                              
                              <div class="info-row row align-items-center">
                                <div class="col-sm-4 info-label">
                                  <i class="bi bi-phone-fill"></i> Mobile
                                </div>
                                <div class="col-sm-8 info-value">
                                  (098) 765-4321
                                </div>
                              </div>
                              <hr class="text-muted opacity-25 my-2">
                              
                              <div class="info-row row align-items-center">
                                <div class="col-sm-4 info-label">
                                  <i class="bi bi-house-door-fill"></i> Address
                                </div>
                                <div class="col-sm-8 info-value">
                                  {{ $user->address ?? 'Not provided' }}
                                </div>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                        
                      </div> <!-- End Row Profile -->

                    </div>
                  </section>
             </div>
          </div>
        </div>

      </div>
    </div>
</x-guest-layout>
