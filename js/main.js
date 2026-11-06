var usuariosAsociados = [
  { id: 'uriel', nombre: 'Uriel Pérez' },
  { id: 'mateo', nombre: 'Mateo García' }
];

function seleccionarUsuario(id) {
  var usuario = usuariosAsociados.find(function (item) {
    return item.id === id;
  });

  if (!usuario) return;

  localStorage.setItem('usuarioActivoId', usuario.id);
  $('#userRoleLabel').text(usuario.nombre);
  $('#activeUser').text('Padre de familia (' + usuario.nombre + ')');
}

$(function () {
  var usuarioGuardado = localStorage.getItem('usuarioActivoId') || usuariosAsociados[0].id;
  seleccionarUsuario(usuarioGuardado);

  $('[data-user-id]').on('click', function (e) {
    e.preventDefault();
    seleccionarUsuario($(this).data('user-id'));
  });
});

// Cambiar de rol (RF1.1)
function iniciarSesion(e) {
  e.preventDefault();
  window.location.href = 'index.html';
}

// Ver código de Proyecto (RF3.1, RF3.2)
function verCodigo(titulo, codigo) {
  $('#tituloModalCodigo').html('<i class="fas fa-code mr-2"></i> Prototipo: ' + titulo);
  $('#contenidoCodigo').text(codigo);
  $('#modalCodigo').modal('show');
}

// Descarga Interactiva de Recibos en PDF (RF4.1, RF4.2)
function descargarRecibo(folio, concepto, monto, fecha) {
  var reciboWindow = window.open('', '_blank');
  reciboWindow.document.write(`
    <html>
    <head>
      <title>Recibo ${folio} - Punk Reception</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
      <style>body { padding: 40px; font-family: sans-serif; }</style>
    </head>
    <body>
      <div class="card border-dark">
        <div class="card-header bg-dark text-white d-flex justify-content-between">
          <h4>PUNK RECEPTION - COMPROBANTE DE PAGO</h4>
          <h4>Folio: ${folio}</h4>
        </div>
        <div class="card-body">
          <p><strong>Academia de Robótica Punk Reception</strong></p>
          <p><strong>Alumno:</strong> Uriel Pérez </p>
          <p><strong>Concepto:</strong> ${concepto}</p>
          <p><strong>Fecha de Pago:</strong> ${fecha}</p>
          <p><strong>Monto Pagado:</strong> ${monto}</p>
          <hr>
          <p class="text-success"><strong>Estatus: PAGADO Y COMPROBADO</strong></p>
          <button class="btn btn-primary no-print" onclick="window.print()">Imprimir o Guardar en PDF</button>
        </div>
      </div>
    </body>
    </html>
  `);
}
