<!-- Modal Crear Cliente -->
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="modalClienteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="customer-form">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalClienteLabel">Nuevo Cliente</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label for="cliente_nombre" class="form-label">Nombre</label>
            <input type="text" id="cliente_nombre" name="nombre" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="cliente_telefono" class="form-label">Teléfono</label>
            <input type="text" id="cliente_telefono" name="telefono" class="form-control">
          </div>

          <div class="mb-3">
            <label for="cliente_direccion" class="form-label">Dirección</label>
            <input type="text" id="cliente_direccion" name="direccion" class="form-control">
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Guardar
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
