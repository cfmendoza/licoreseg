<!-- Modal: Crear nueva categoría -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="createCategoryForm" method="POST" action="{{ route('categories.store') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createCategoryModalLabel">
            <i class="bi bi-tags-fill text-primary"></i> Nueva Categoría
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nombre *</label>
            <input type="text" name="name" class="form-control form-control-sm" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control form-control-sm" rows="2"></textarea>
          </div>
          <div id="categoryError" class="text-danger small d-none"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
