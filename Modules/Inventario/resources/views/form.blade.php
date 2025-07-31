@php
    $isEdit = isset($product);
@endphp
@push('scripts')
<script src="{{ asset('js/inventories.js') }}"></script>
@endpush

{{-- Fila combinada: Datos Generales y Clasificación --}}
<div class="row mb-4">
    {{-- Datos Generales --}}
    <div class="col-md-6">
        <div class="p-3 border rounded" style="border-radius: 10px;">
            <h6 class="text-secondary mb-3 border-bottom pb-1">📝 Datos Generales</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Nombre del producto *</label>
                    <input type="text" class="form-control form-control-sm" name="name" 
                           value="{{ old('name', $isEdit ? $product->name : '') }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Tipo</label>
                    <input type="text" class="form-control form-control-sm" name="type" 
                           value="{{ old('type', $isEdit ? $product->type : '') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <input type="text" class="form-control form-control-sm" name="description" 
                           value="{{ old('description', $isEdit ? $product->description : '') }}" required>
                </div>
            </div>
        </div>
    </div>

    {{-- Clasificación --}}
    <div class="col-md-6">
        <div class="p-3 border rounded" style="border-radius: 10px;">
            <h6 class="text-secondary mb-3 border-bottom pb-1">📂 Clasificación</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Categoría</label>
                    <div class="input-group input-group-sm">
                        <select id="categorySelect" name="category_id" class="form-select form-select-sm">
                            <option disabled selected>Seleccione una categoría</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $isEdit ? $product->category_id : '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <a href="#" class="btn btn-outline-primary rounded-end" title="Crear nueva categoría"
                           data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                            <i class="bi bi-plus-circle"></i>
                        </a>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Marca</label>
                    <input type="text" class="form-control form-control-sm" name="brand" 
                           value="{{ old('brand', $isEdit ? $product->brand : '') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Presentación</label>
                    <input type="text" class="form-control form-control-sm" name="presentation" 
                           value="{{ old('presentation', $isEdit ? $product->presentation : '') }}">
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Contenido y Código --}}
<div class="mb-4 p-3 border rounded" style="border-radius: 10px;">
    <h6 class="text-secondary mb-3 border-bottom pb-1">🔖 Contenido y Código</h6>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Contenido (ml)</label>
            <input type="number" class="form-control form-control-sm" name="content"
                   value="{{ old('content', $isEdit ? $product->content : '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Código de Barras</label>
            <input type="text" class="form-control form-control-sm" name="barcode"
                   value="{{ old('barcode', $isEdit ? $product->barcode : '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Fecha de Vencimiento</label>
            <input type="date" class="form-control form-control-sm" name="expiration_date"
                   value="{{ old('expiration_date', $isEdit && $product->expiration_date ? $product->expiration_date->format('Y-m-d') : '') }}">
        </div>
    </div>
</div>

{{-- Precios y Stock --}}
<div class="mb-4 p-3 border rounded" style="border-radius: 10px;">
    <h6 class="text-secondary mb-3 border-bottom pb-1">💰 Precios y Stock</h6>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Precio de Compra</label>
            <input type="number" step="0.01" class="form-control form-control-sm" name="price_purchase"
                   value="{{ old('price_purchase', $isEdit ? $product->price_purchase : '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Precio de Venta</label>
            <input type="number" step="0.01" class="form-control form-control-sm" name="price_sale"
                   value="{{ old('price_sale', $isEdit ? $product->price_sale : '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Stock</label>
            <input type="number" class="form-control form-control-sm" name="stock"
                   value="{{ old('stock', $isEdit ? $product->stock : '') }}">
        </div>
    </div>
</div>

{{-- Imagen --}}
<div class="mb-4 p-3 border rounded" style="border-radius: 10px;">
    <h6 class="text-secondary mb-3 border-bottom pb-1">🖼️ Imagen</h6>
    <div class="row g-3">
        <div class="col-md-4">
            <input type="file" class="form-control form-control-sm" name="image">
            @if ($isEdit && $product->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-thumbnail" width="100">
                </div>
            @endif
        </div>
    </div>
</div>

