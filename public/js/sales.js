let total = 0;
let productIndex = 0;

$(document).ready(function () {
    // Cargar clientes
    $.ajax({
        url: 'clients-get',
        method: 'GET',
        success: function (clientes) {
            let options = '<option value="" disabled selected>Seleccione un cliente</option>';
            clientes.forEach(cliente => {
                options += `<option value="${cliente.id}">${cliente.name} - (${cliente.city ?? 'Sin Telefono'})</option>`;
            });
            $('#cliente_id').html(options);
        },
        error: function () {
            $('#cliente_id').html('<option value="" disabled>Error al cargar clientes</option>');
        }
    });
});

$('#add-product').on('click', function () {
    $.ajax({
        url: 'products-get',
        method: 'GET',
        success: function (data) {
            let productOptions = '<option value="" disabled selected>Seleccione un producto</option>';
            data.forEach(product => {
                productOptions += `<option value="${product.id}" 
                    data-price-sale="${product.price_sale}" 
                    data-stock="${product.stock}">
                    ${product.name} | ${product.description} | ${product.presentation}
                </option>`;
            });

            const productRow = `
                <div class="row product-entry" data-index="${productIndex}">
                    <div class="col-md-3">
                        <label>Producto</label>
                        <select name="products[${productIndex}][id]" class="form-select product-select" required>
                            ${productOptions}
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Cantidad</label>
                        <input type="number" name="products[${productIndex}][quantity]" class="form-control quantity-input" min="1" value="1" required>
                    </div>
                    <div class="col-md-2">
                        <label>Precio Unitario</label>
                        <input type="number" name="products[${productIndex}][price_unit]" class="form-control price-unit-input" step="0.01" readonly>
                    </div>
                    <div class="col-md-2">
                        <label>Subtotal</label>
                        <input type="number" name="products[${productIndex}][subtotal]" class="form-control subtotal-input" step="0.01" readonly>
                    </div>
                    <div class="col-md-2 mt-3">
                        <button type="button" class="btn btn-danger remove-product">Eliminar</button>
                    </div>
                </div>
            `;

            $('#product-section').append(productRow);
            productIndex++;
        },
        error: function () {
            console.error('Error al obtener los productos');
        }
    });
});

// Evento para eliminar productos
$('#product-section').on('click', '.remove-product', function () {
    $(this).closest('.product-entry').remove();
});

// Evento para actualizar precio y subtotal al seleccionar un producto
$('#product-section').on('change', '.product-select', function () {
    const selected = $(this).find('option:selected');
    const row = $(this).closest('.product-entry');
    const price = parseFloat(selected.data('price-sale')) || 0;
    const stock = parseInt(selected.data('stock')) || 0;

    row.find('.price-unit-input').val(price.toFixed(2));
    row.find('.quantity-input').attr('max', stock).val(1);
    row.find('.subtotal-input').val((1 * price).toFixed(2));
});

// Evento para validar la cantidad y calcular el subtotal
$('#product-section').on('input', '.quantity-input', function () {
    const quantityInput = $(this);
    const row = quantityInput.closest('.product-entry');
    const productSelect = row.find('.product-select option:selected');

    const maxStock = parseInt(productSelect.data('stock')) || 0;
    const quantity = parseInt(quantityInput.val()) || 0;
    const price = parseFloat(row.find('.price-unit-input').val()) || 0;

    if (quantity > maxStock) {
    Swal.fire({
        icon: 'warning',
        title: 'Stock insuficiente',
        text: `Solo hay ${maxStock} unidades disponibles en stock.`,
        confirmButtonText: 'Entendido'
    }).then(() => {
        quantityInput.val(1);
        row.find('.subtotal-input').val((1 * price).toFixed(2));
    });
} else {
    row.find('.subtotal-input').val((quantity * price).toFixed(2));
}

});

// Calcular precio y subtotal automáticamente
$('#product-section').on('change', '.product-select, .quantity-input', function () {
    const row = $(this).closest('.product-entry');
    const selectedOption = row.find('.product-select option:selected');
    const price = parseFloat(selectedOption.data('price-sale')) || 0;
    const quantity = parseInt(row.find('.quantity-input').val()) || 0;
    const subtotal = price * quantity;

    row.find('.price-unit-input').val(price.toFixed(2));
    row.find('.subtotal-input').val(subtotal.toFixed(2));

    calcularTotal();
});

// Eliminar producto
$('#product-section').on('click', '.remove-product', function () {
    $(this).closest('.product-entry').remove();
    calcularTotal();
});

// Recalcular total
function calcularTotal() {
    total = 0;
    $('.product-entry').each(function () {
        const subtotal = parseFloat($(this).find('.subtotal-input').val()) || 0;
        total += subtotal;
    });
    $('#total').val(total.toFixed(2));
}

// Ocultar alertas después de 5 segundos
document.addEventListener("DOMContentLoaded", function() {
    setTimeout(function () {
        $('#success-alert').fadeOut();
        $('#error-alert').fadeOut();
    }, 5000);
});

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('customer-form');

    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            try {
                const response = await fetch('/customers', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Cliente registrado!',
                        text: result.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Opcional: cerrar modal y limpiar formulario
                    const modal = bootstrap.Modal.getInstance(document.getElementById('customerModal'));
                    modal.hide();
                    form.reset();

                    // Puedes también agregar el nuevo cliente al <select> si deseas
                    const clienteSelect = document.getElementById('cliente_id');
                    const option = document.createElement('option');
                    option.value = result.data.id;
                    option.text = result.data.name;
                    option.selected = true;
                    clienteSelect.appendChild(option);
                }

            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo registrar el cliente.'
                });
            }
        });
    }
});

