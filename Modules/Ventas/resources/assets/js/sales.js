
let total = 0;

let productIndex = 0; // Inicializa el índice para los productos

$('#add-product').on('click', function () {
    // Hacer la petición AJAX para obtener los productos
    $.ajax({
        url: 'products-get', 
        method: 'GET',
        success: function (data) {
            // Crear las opciones del select para los productos
            let productOptions = '<option value="" disabled selected>Seleccione un producto</option>';
            
            // Iterar sobre los productos y agregar las opciones
            data.forEach(product => {
                productOptions += `<option value="${product.id}" data-price="${product.price}">
                    ${product.name} | ${product.brand} | ${product.type}
                </option>`;
            });

            // Generar la nueva fila de producto con el índice correspondiente
            const productRow = `
                <div class="row product-entry" data-index="${productIndex}">
                    <div class="col-md-4">
                        <label>Producto</label>
                        <select name="products[${productIndex}][id]" class="form-select product-select" required>
                            ${productOptions}
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Cantidad</label>
                        <input type="number" name="products[${productIndex}][quantity]" class="form-control quantity-input" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <label>Precio</label>
                        <input type="number" name="products[${productIndex}][price]" class="form-control price-input" step="0.01" readonly>
                    </div>
                    <div class="col-md-2 mt-3">
                        <button type="button" class="btn btn-danger remove-product">Eliminar</button>
                    </div>
                </div>
            `;

            // Agregar la nueva fila al contenedor
            $('#product-section').append(productRow);
            productIndex++;
        },
        error: function (xhr, status, error) {
            // Manejar errores si la petición falla
            console.error('Error al obtener los productos:', error);
        }
    });
});

// Cuando el usuario selecciona un producto, cargar el precio automáticamente
$('#product-section').on('change', '.product-select', function () {
    const selectedOption = $(this).find('option:selected');
    const price = selectedOption.data('price') || 0;
    $(this).closest('.product-entry').find('.price-input').val(price);
});



// Manejar eliminación de producto
$('#product-section').on('click', '.remove-product', function () {
    const row = $(this).closest('.product-entry');
    const price = parseFloat(row.find('.price-input').val()) || 0;
    const quantity = parseInt(row.find('.quantity-input').val()) || 0;
    total -= price * quantity;
    $('#total').val(total.toFixed(2));
    row.remove();
});

// Actualizar precio dinámico al cambiar el producto o la cantidad
$('#product-section').on('change', '.product-select, .quantity-input', function () {
    const row = $(this).closest('.product-entry');
    const price = parseFloat(row.find('.product-select option:selected').data('price')) || 0;
    const quantity = parseInt(row.find('.quantity-input').val()) || 0;
    const totalPrice = price * quantity;

    // Actualizar precio de la fila
    row.find('.price-input').val(totalPrice.toFixed(2));

    // Recalcular el total
    total = 0;
    $('.product-entry').each(function () {
        const rowPrice = parseFloat($(this).find('.price-input').val()) || 0;
        total += rowPrice;
    });
    $('#total').val(total.toFixed(2));
});

document.addEventListener("DOMContentLoaded", function() {
    var successAlert = document.getElementById("success-alert");
    var errorAlert = document.getElementById("error-alert");

    if (successAlert && window.getComputedStyle(successAlert).display !== 'none') {
        setTimeout(function() {
            successAlert.style.display = 'none';
        }, 5000);
    }

    if (errorAlert && window.getComputedStyle(errorAlert).display !== 'none') {
        setTimeout(function() {
            errorAlert.style.display = 'none';
        }, 5000);
    }
});
