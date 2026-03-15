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

                   <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#createtoken">
                      Crear Token
                    </button>

                  </div>

                </div>

              </div>

            </div>


            <!-- LISTA DE TOKENS -->

            <div class="card shadow-sm" id="access-token-manager">

              <div class="card-body">

                <div id="tokens-message" class="alert alert-info d-none" role="status" aria-live="polite"></div>

                <h5 class="mb-3">Tus API Keys</h5>

                <div class="table-responsive">

                  <table class="table table-hover mb-0">

                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Creado</th>
                        <th>Último uso</th>
                        <th>Habilidades</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>

                    <tbody id="tokens-table-body">
     @if(isset($tokens))
            @forelse($tokens as $token)

            <tr data-token-id="{{ $token->id }}">
              <td>{{ $token->name }}</td>
              <td>{{ $token->created_at }}</td>
               <td>{{ optional($token->last_used_at)->format('Y-m-d H:i') ?? 'Nunca' }}</td>
              <td>{{ implode(",", $token->abilities) }}</td>
             

              <td>
                @if(!empty($token->plain_text_token))
                  <button type="button" class="btn btn-sm btn-outline-primary view-token" data-view-id="{{ $token->id }}">
                    Ver token
                  </button>
                @else
                  <span class="text-muted small">No disponible</span>
                @endif

                <form method="POST" action="{{ route('api.tokens.delete',$token->id) }}" class="d-inline-block">
                  @csrf
                  @method('DELETE')

                  <button type="submit" class="btn btn-sm btn-outline-danger revoke-token" data-revoke-id="{{ $token->id }}">
                    Revocar
                  </button>

                </form>
              </td>

            </tr>

            @empty

            <tr>
              <td colspan="4" class="text-center text-muted">
                No tienes API Tokens creados
              </td>
            </tr>

            @endforelse

            @endif

                    </tbody>

                  </table>

                </div>

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


<div class="modal fade" id="createtoken"
     data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="modalRegisterLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalRegisterLabel">
          <i class="bi bi-key m-2"></i> Crear API-Token
        </h5>
        <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
            <form id="create-token-form" method="POST" action="{{ route('api.tokens.create') }}">

            @csrf

            <div class="mb-3">

            <label class="form-label">Nombre del Token</label>

            <input 
            type="text"
            name="name"
            class="form-control"
            placeholder="ej: servidor-production"
            required>

            </div>

            <button type="submit" class="btn btn-primary">
            Crear API Token
            </button>

            </form>


      </div>
    </div>
  </div>
</div>


</x-guest-layout>
