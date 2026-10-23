<x-admindashboard>

<div class="container-fluid py-2 leads-table-wrapper" data-bs-theme="dark">
    <div class="row">
        <div class="col-lg-12">

            <!-- Componente de Vista TypeScript: Tabla de Leads -->
            <div id="leads-table-root"
                 data-endpoint="{{ route('chat-api.leads') }}"
                 data-contacts-url="{{ route('/admindashboard/contacts') }}">

                <div class="card leads-card shadow-lg">
                    <!-- Header -->
                    <div class="card-header bg-body-tertiary py-3 px-4 d-flex flex-wrap gap-3 align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center leads-header-icon">
                                <i class="bi bi-whatsapp fs-5"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 text-white">Leads</h5>
                                <div class="muted-xs">Prospectos que escribieron a tu número de WhatsApp</div>
                            </div>
                            <!-- Resumen de Leads que solicitan atención humana -->
                            <span id="waiting-summary" class="badge rounded-pill text-bg-danger ms-2 d-none">
                                <i class="bi bi-person-raised-hand me-1"></i><span></span>
                            </span>
                        </div>

                        <!-- Selector de cantidad de registros (5 o 10) -->
                        <div class="d-flex align-items-center gap-2">
                            <label for="page-size" class="muted-xs mb-0">Mostrar</label>
                            <select id="page-size" class="form-select form-select-sm bg-dark text-light border-secondary" style="width: auto;">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                            </select>
                            <span class="muted-xs">registros</span>
                        </div>
                    </div>

                    <!-- Tabla de 3 Columnas: Lead | Contacto en plataforma | Estado de atención -->
                    <div class="table-responsive-lg">
                        <table class="table leads-table">
                            <thead>
                                <tr>
                                    <th scope="col" class="ps-4" style="width: 34%;">Lead</th>
                                    <th scope="col" style="width: 30%;">Contacto en plataforma</th>
                                    <th scope="col" class="pe-4">Estado de atención</th>
                                </tr>
                            </thead>
                            <tbody id="leads-tbody">
                                <tr>
                                    <td colspan="3" class="text-center py-4">
                                        <div class="spinner-border text-success spinner-border-sm me-2" role="status"></div>
                                        <span class="muted-xs">Cargando leads...</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer: Información de registros + Botones de Paginación -->
                    <div class="card-footer bg-body-tertiary py-3 px-4 d-flex flex-wrap gap-2 align-items-center justify-content-between">
                        <div id="page-info" class="muted-xs">Mostrando 0 de 0 leads</div>
                        <nav aria-label="Paginación de leads">
                            <ul id="pagination" class="pagination pagination-sm mb-0"></ul>
                        </nav>
                    </div>
                </div>

                <!-- Leyenda de estados -->
                <div class="card border-0 shadow-sm mt-3 leads-legend-card">
                    <div class="card-body py-2 px-4 d-flex flex-wrap gap-3 align-items-center small">
                        <strong class="me-1 text-white">Estados:</strong>
                        <span class="status-pill text-bg-danger"><i class="bi bi-person-raised-hand"></i>Solicita humano</span>
                        <span class="status-pill text-bg-warning"><i class="bi bi-headset"></i>Atendido por humano</span>
                        <span class="status-pill text-bg-success"><i class="bi bi-robot"></i>Atendido por bot</span>
                        <span class="status-pill text-bg-secondary"><i class="bi bi-check2-circle"></i>Cerrada</span>
                        <span class="status-pill bg-body-secondary text-body-secondary"><i class="bi bi-dash-circle"></i>Sin conversación</span>
                    </div>
                </div>

            </div>

        </div>

        <!-- Modal Live Chat -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" data-bs-theme="light">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content overflow-hidden border-0 shadow-lg">
                    <div class="modal-body p-0">
                        @include('components.chat-leads', ['Lead' => new \App\Models\WhatsappApi\Lead()])
                    </div>
                    <div class="modal-footer bg-light py-2">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-1"></i> Cerrar Chat
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</x-admindashboard>