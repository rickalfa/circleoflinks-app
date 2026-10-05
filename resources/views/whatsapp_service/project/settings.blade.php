<x-admindashboard>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">

            {{-- Encabezado --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="fw-bold mb-1 text-dark">
                        <i class="bi bi-sliders text-primary me-2"></i>Configuración del Proyecto
                    </h3>
                    <p class="text-muted mb-0 small">
                        Gestiona los detalles de tu proyecto y el número de WhatsApp asociado a las <strong>Conversaciones de Servicio</strong>.
                    </p>
                </div>
                <div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold">
                        <i class="bi bi-check-circle-fill me-1"></i> Servicio Activo
                    </span>
                </div>
            </div>

            {{-- Mensajes de estado --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Tarjeta Principal de Configuración --}}
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">

                    <form method="POST" action="{{ route('project.settings.update') }}">
                        @csrf
                        @method('PUT')

                        {{-- Sección: Empresa --}}
                        <div class="mb-4">
                            <h5 class="fw-bold text-dark mb-3">
                                <i class="bi bi-building text-secondary me-2"></i>Datos de la Empresa
                            </h5>
                            <div class="mb-3">
                                <label for="company_name" class="form-label fw-semibold text-secondary">Nombre de la Empresa</label>
                                <input type="text" class="form-control rounded-3 @error('company_name') is-invalid @enderror" 
                                       id="company_name" name="company_name" 
                                       value="{{ old('company_name', $company->name ?? '') }}" 
                                       placeholder="Ej: Mi Empresa S.A.">
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        {{-- Sección: Proyecto y Celular --}}
                        <div class="mb-4">
                            <h5 class="fw-bold text-dark mb-3">
                                <i class="bi bi-whatsapp text-success me-2"></i>Servicio de Conversaciones WhatsApp
                            </h5>

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold text-secondary">
                                    Nombre del Proyecto <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" 
                                       id="name" name="name" 
                                       value="{{ old('name', $project->name) }}" required 
                                       placeholder="Ej: Chatbot Principal">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold text-secondary">Descripción</label>
                                <textarea class="form-control rounded-3 @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="2" 
                                          placeholder="Propósito del bot...">{{ old('description', $project->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label fw-semibold text-dark">
                                    <i class="bi bi-telephone-fill text-success me-1"></i> Número de Celular Receptor <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="bi bi-phone"></i></span>
                                    <input type="text" class="form-control rounded-end-3 @error('phone_number') is-invalid @enderror" 
                                           id="phone_number" name="phone_number" 
                                           value="{{ old('phone_number', $project->phone_number) }}" required 
                                           placeholder="Ej: +56912345678">
                                </div>
                                <div class="form-text text-muted mt-2 small">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Este número es el identificador con el que el Webhook de WhatsApp asocia las conversaciones y los leads directamente a tu cuenta.
                                </div>
                                @error('phone_number')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Botón Guardar --}}
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm">
                                <i class="bi bi-save-fill me-2"></i>Guardar Cambios
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            {{-- Tarjeta de Plan y Límites --}}
            <div class="card border-0 shadow-sm rounded-4 bg-light">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">Plan Actual: Conversaciones de Servicio</h6>
                            <p class="text-muted small mb-0">Plan Gratuito con hasta 60 leads únicos al mes y 100 respuestas lógicas del bot.</p>
                        </div>
                        <span class="badge bg-primary px-3 py-2 rounded-pill">Gratuito</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</x-admindashboard>
