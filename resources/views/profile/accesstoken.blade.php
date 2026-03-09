<x-guest-layout>

  <div class="container-fluid">

  <!-- HEADER PROFILE -->
  <div class="row">
    <div class="col h-25 d-inline-block">
      <div style="height:70px;">
        <x-profile.dashboardprofile/>
      </div>
    </div>
  </div>


  <div class="row">

    <!-- SIDEBAR -->
    <div class="col-lg-3">
      <x-profile.sidebarprofile/>
    </div>


    <!-- MAIN CONTENT -->
    <div class="col-lg-9">

      <div class="py-4">

        <section style="background-color:#eee;">
          <div class="container py-4">

            <!-- BREADCRUMB -->
            <div class="row">
              <div class="col">

                <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">

                  <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                      <a href="{{ url('/') }}">Home</a>
                    </li>

                    <li class="breadcrumb-item">
                      <a href="#">User</a>
                    </li>

                    <li class="breadcrumb-item active">
                      Access API
                    </li>
                  </ol>

                </nav>

              </div>
            </div>


            @php
              $userm = Auth::user();
            @endphp


            <!-- EMAIL VERIFIED CHECK -->

            @if ($userm->hasVerifiedEmail())

            <div class="card shadow-sm mb-4">

              <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                  <div>
                    <h4 class="mb-1">API Tokens</h4>
                    <p class="text-muted mb-0">
                      Create and manage access tokens for the API.
                    </p>
                  </div>

                  <div>

                    <!-- BOTON CREAR TOKEN -->

                    <button 
                      class="btn btn-primary"
                      data-bs-toggle="modal"
                      data-bs-target="#createTokenModal">

                      Crear API Token

                    </button>

                  </div>

                </div>

              </div>

            </div>


            <!-- LISTA DE TOKENS -->

            <div class="card shadow-sm">

              <div class="card-body">

                <h5 class="mb-3">Tus API Keys</h5>

                <table class="table table-striped">

                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Token</th>
                      <th>Creado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>

                  <tbody>

                    @foreach ($tokens ?? [] as $token)

                    <tr>

                      <td>{{ $token->name }}</td>

                      <td>
                        <code>{{ $token->token }}</code>
                      </td>

                      <td>
                        {{ $token->created_at }}
                      </td>

                      <td>

                        <form method="POST" action="{{ route('api.tokens.delete',$token->id) }}">
                          @csrf
                          @method('DELETE')

                          <button class="btn btn-sm btn-danger">
                            Revocar
                          </button>

                        </form>

                      </td>

                    </tr>

                    @endforeach

                  </tbody>

                </table>

              </div>

            </div>


            @else

            <!-- EMAIL NO VERIFICADO -->

            <div class="p-2">
              <span class="badge rounded-pill text-bg-danger">
                Danger Email no Verificado
              </span>
            </div>

            <div class="alert alert-danger alert-dismissible fade show">

              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

              <strong>Danger!</strong> Email no verificado.

              <a href="{{ url('verify-email') }}">
                Verificar email
              </a>

            </div>

            @endif

          </div>
        </section>

      </div>

    </div>

  </div>

</div>


</x-guest-layout>
