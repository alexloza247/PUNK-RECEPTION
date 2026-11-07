$(function () {
  var formLogin = document.getElementById('formLogin');
  if (formLogin) {
    formLogin.addEventListener('submit', function () {
      document.getElementById('loginUsuario').value = document.getElementById('loginEmail').value;
      document.getElementById('loginContrasena').value = document.getElementById('loginPassword').value;
    });
  }
});

// Descarga Interactiva de Recibos en PDF (RF4.1, RF4.2)
function descargarRecibo(folio, concepto, monto, fecha) {
  var elementoNombreAlumno = document.getElementById('userRoleLabel');
  var nombreAlumno = elementoNombreAlumno ? elementoNombreAlumno.textContent.trim() : 'Alumno';
  var nombreAlumnoSeguro = nombreAlumno.replace(/[&<>"']/g, function (caracter) {
    return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[caracter];
  });
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
          <p><strong>Alumno:</strong> ${nombreAlumnoSeguro}</p>
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
