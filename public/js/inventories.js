document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.dataset.id;

            Swal.fire({
                title: '¿Eliminar producto?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });
    });
});




$(document).ready(function () {
    $('#createCategoryForm').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const url = form.attr('action');
        const data = form.serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Cerrar modal, limpiar formulario
                    $('#createCategoryModal').modal('hide');
                    form[0].reset();
                    $('#categoryError').addClass('d-none').html('');

                    // 👉 Agregar nueva categoría al select y seleccionarla
                    $('#categorySelect').append(
                        new Option(response.category.name, response.category.id, true, true)
                    ).trigger('change');
                }
            },
            error: function (xhr) {
                let msg = 'Error al crear la categoría.';
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    const errores = xhr.responseJSON.errors;
                    msg = Object.values(errores).flat().join('<br>');
                } else if (xhr.responseJSON?.message) {
                    msg = xhr.responseJSON.message;
                }

                $('#categoryError').removeClass('d-none').html(msg);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: msg
                });
            }
        });
    });
});


