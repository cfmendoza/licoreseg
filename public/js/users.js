$(document).ready(function () {
  // Delegamos el evento por si hay múltiples formularios
  $(document).on('submit', '.edit-user-form', function (e) {
    e.preventDefault();

    const form = $(this);
    const userId = form.data('id');
    const formData = form.serialize();

    $.ajax({
      url: '/usuarios/' + userId,
      type: 'POST', // Laravel espera POST + override
      data: formData,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'X-HTTP-Method-Override': 'PUT' // Simula PUT
      },
      success: function (response) {
        // Cierra modal si existe
        const modal = form.closest('.modal');
        if (modal.length > 0) {
          const bsModal = bootstrap.Modal.getInstance(modal[0]);
          if (bsModal) bsModal.hide();
        }

        Swal.fire({
          icon: 'success',
          title: 'Usuario actualizado',
          text: 'Los datos del usuario fueron actualizados correctamente',
          timer: 2000,
          showConfirmButton: false
        });

        // Si hay tabla, recargarla. Si no, redirigir a lista.
        if ($('#tabla-usuarios').length > 0) {
          $('#tabla-usuarios').load(location.href + ' #tabla-usuarios > *');
        } else {
          // Redirigir después de unos segundos si es vista completa
          setTimeout(() => {
            window.location.href = '/usuarios';
          }, 2000);
        }
      },
      error: function (xhr) {
        let mensaje = 'Ocurrió un error al actualizar el usuario.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
          mensaje = xhr.responseJSON.message;
        }
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: mensaje
        });
      }
    });
  });


  $(document).on('click', '.btn-delete-user', function (e) {
    e.preventDefault();

    const userId = $(this).data('id');

    Swal.fire({
      title: '¿Eliminar usuario?',
      text: 'Esta acción no se puede deshacer.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar',
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `/usuarios/${userId}`,
          type: 'POST',
          data: {
            _method: 'DELETE',
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function () {
            Swal.fire({
              icon: 'success',
              title: 'Usuario eliminado',
              showConfirmButton: false,
              timer: 1500
            });

            // Recargar solo la tabla
            $('#tabla-usuarios').load(location.href + ' #tabla-usuarios > *');
          },
          error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'No se pudo eliminar el usuario.'
            });
          }
        });
      }
    });
  });


});
