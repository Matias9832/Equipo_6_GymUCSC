<!-- Modal: Crear Tenant -->
<div class="modal fade" id="crearTenantModal" tabindex="-1" aria-labelledby="crearTenantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('tenants.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="background-color: #1B1725; color: white;">
                    <h5 class="modal-title">Crear Nuevo Tenant</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="subdominio">Subdominio</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="subdominio" name="subdominio"
                                   placeholder="ej: deportes1" required>
                            <span class="input-group-text">.ugym.local</span>
                        </div>
                        <small class="form-text text-muted">
                            Dominio completo: <strong>subdominio.ugym.local</strong>
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary-custom">Crear</button>
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
