<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Configuración Inicial de Servicio
        </h2>
    </x-slot>

    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="text-center mb-4">
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold mb-2">
                        <i class="bi bi-gift-fill me-1"></i> Plan Gratuito: Conversaciones de Servicio
                    </span>
                    <h2 class="fw-bold text-gray-800 dark:text-white mt-2">Bienvenido a Circle of Links</h2>
                    <p class="text-muted dark:text-gray-300">Configura tu proyecto y tu número de WhatsApp para comenzar a recibir leads y automatizar conversaciones.</p>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger shadow-sm border-0 rounded-3 mb-3">{{ session('error') }}</div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning shadow-sm border-0 rounded-3 mb-3">{{ session('warning') }}</div>
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
                                    <input type="text" class="form-control @error('company_industry') is-invalid @enderror" id="company_industry" name="company_industry" value="{{ old('company_industry') }}" placeholder="Ej: E-commerce, Servicios...">
                                    @error('company_industry') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="company_tax_id" class="form-label dark:text-gray-200">ID Fiscal (Opcional)</label>
                                    <input type="text" class="form-control @error('company_tax_id') is-invalid @enderror" id="company_tax_id" name="company_tax_id" value="{{ old('company_tax_id') }}" placeholder="RUT / CUIT / RFC">
                                    @error('company_tax_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <hr class="my-4 dark:border-gray-600">

                            <!-- PASO 2: Datos del Proyecto y WhatsApp -->
                            <h5 class="mb-3 text-primary fw-bold"><i class="bi bi-whatsapp me-2 text-success"></i>2. Proyecto y Conversaciones de Servicio</h5>
                            <p class="small text-muted dark:text-gray-300 mb-3">Tu proyecto alojará los bots, leads recibidos e historial de conversaciones de WhatsApp.</p>

                            <div class="mb-3">
                                <label for="project_name" class="form-label dark:text-gray-200">Nombre del Proyecto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('project_name') is-invalid @enderror" id="project_name" name="project_name" value="{{ old('project_name') }}" required placeholder="Ej: Ventas y Atención al Cliente">
                                @error('project_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="project_description" class="form-label dark:text-gray-200">Descripción del Servicio</label>
                                <textarea class="form-control @error('project_description') is-invalid @enderror" id="project_description" name="project_description" rows="2" placeholder="¿Qué objetivo principal tendrá la atención automatizada?">{{ old('project_description') }}</textarea>
                                @error('project_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="project_phone" class="form-label dark:text-gray-200 fw-semibold">
                                    <i class="bi bi-telephone-fill text-success me-1"></i> Número de Celular para Conversaciones <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="bi bi-phone"></i></span>
                                    <input type="text" class="form-control @error('project_phone') is-invalid @enderror" id="project_phone" name="project_phone" value="{{ old('project_phone') }}" required placeholder="Ej: +56912345678 o 56912345678">
                                </div>
                                <div class="form-text text-muted dark:text-gray-400 mt-1">
                                    <i class="bi bi-info-circle me-1"></i> Este es el número con el que conectarás el servicio de WhatsApp para recibir y responder a tus prospectos.
                                </div>
                                @error('project_phone') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="d-grid mt-4 gap-2">
                                <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold shadow-sm">
                                    <i class="bi bi-check-circle-fill me-2"></i> Activar Servicio y Entrar
                                </button>
                            </div>
                        </form>

                        <!-- Opción de saltar el Onboarding (Usuario Tipo B) -->
                        <div class="text-center pt-3 border-top mt-4 dark:border-gray-700">
                            <form method="POST" action="{{ route('onboarding.skip') }}">
                                @csrf
                                <button type="submit" class="btn btn-link text-secondary text-decoration-none small py-1" style="font-size: 0.9rem;">
                                    <i class="bi bi-arrow-right-circle me-1"></i> <strong>Saltar configuración por ahora</strong> (Ingresar sin proyecto activo)
                                </button>
                            </form>
                            <p class="text-muted small mb-0 mt-1" style="font-size: 0.8rem;">
                                Si saltas este paso, entrarás como usuario no suscrito (Tipo B) y podrás configurar tu número más tarde desde el menú lateral.
                            </p>
                        </div>

                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <p class="small text-muted dark:text-gray-400">
                        Servicio <strong>Conversaciones de Servicio</strong> incluido sin costo.<br> 
                        Hasta 100 respuestas automáticas y 60 conversaciones al mes.
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
