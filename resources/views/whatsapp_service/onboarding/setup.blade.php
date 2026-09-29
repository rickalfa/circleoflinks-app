<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Configuración Inicial
        </h2>
    </x-slot>

    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-gray-800 dark:text-white">Bienvenido a Circle of Links</h2>
                    <p class="text-muted dark:text-gray-300">Antes de comenzar, necesitamos configurar tu espacio de trabajo.</p>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card shadow-sm border-0 rounded-4 dark:bg-gray-800">
                    <div class="card-body p-4 p-md-5">
                        <form method="POST" action="{{ route('onboarding.store') }}">
                            @csrf

                            <!-- PASO 1: Datos de la Empresa -->
                            <h5 class="mb-3 text-primary fw-bold"><i class="bi bi-building me-2"></i>1. Datos de tu Empresa</h5>
                            
                            <div class="mb-3">
                                <label for="company_name" class="form-label dark:text-gray-200">Nombre de la Empresa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name') }}" required placeholder="Ej: Mi Negocio S.A.">
                                @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="company_industry" class="form-label dark:text-gray-200">Sector / Industria</label>
                                    <input type="text" class="form-control @error('company_industry') is-invalid @enderror" id="company_industry" name="company_industry" value="{{ old('company_industry') }}" placeholder="Ej: E-commerce, Salud...">
                                    @error('company_industry') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="company_tax_id" class="form-label dark:text-gray-200">ID Fiscal (Opcional)</label>
                                    <input type="text" class="form-control @error('company_tax_id') is-invalid @enderror" id="company_tax_id" name="company_tax_id" value="{{ old('company_tax_id') }}" placeholder="RUT / CUIT / RFC">
                                    @error('company_tax_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <hr class="my-4 dark:border-gray-600">

                            <!-- PASO 2: Datos del Proyecto -->
                            <h5 class="mb-3 text-primary fw-bold"><i class="bi bi-folder me-2"></i>2. Tu Primer Proyecto</h5>
                            <p class="small text-muted dark:text-gray-300 mb-3">Un proyecto contiene todos tus bots, leads y configuraciones de WhatsApp.</p>

                            <div class="mb-3">
                                <label for="project_name" class="form-label dark:text-gray-200">Nombre del Proyecto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('project_name') is-invalid @enderror" id="project_name" name="project_name" value="{{ old('project_name') }}" required placeholder="Ej: Atención al Cliente - Ventas">
                                @error('project_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="project_description" class="form-label dark:text-gray-200">Descripción</label>
                                <textarea class="form-control @error('project_description') is-invalid @enderror" id="project_description" name="project_description" rows="2" placeholder="¿Qué objetivo tiene este bot?">{{ old('project_description') }}</textarea>
                                @error('project_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="project_phone" class="form-label dark:text-gray-200">Teléfono de Contacto (Opcional)</label>
                                <input type="text" class="form-control @error('project_phone') is-invalid @enderror" id="project_phone" name="project_phone" value="{{ old('project_phone') }}" placeholder="+123456789">
                                <div class="form-text text-muted dark:text-gray-400"><i class="bi bi-info-circle me-1"></i>En el plan gratuito usarás nuestro número compartido, pero puedes dejar el tuyo como referencia.</div>
                                @error('project_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold">
                                    Crear y Entrar al Dashboard <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <p class="small text-muted dark:text-gray-400">
                        Al continuar, iniciarás con el <strong>Plan Gratuito</strong>.<br> 
                        Tendrás hasta 100 lógicas de bots y 60 conversaciones al mes sin ningún costo.
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
