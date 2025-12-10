<table>

    <tr> <td><strong>Nueva solicitud registrada </strong></td></tr>
    <tr><td>No. Solicitud: {{ $solicitud->no_solicitud }}</td></tr>
    <tr><td>Nombre: {{ $solicitud->nombre }} {{ $solicitud->apellido }}</td></tr>
    <tr><td>CUI: {{ $solicitud->cui }}</td></tr>
    <tr><td>Teléfono: {{  $solicitud->telefono }}</td></tr>
    <tr><td>Correo: {{ $solicitud->email }}</td></tr>
    <tr><td>Estado: {{ $solicitud->estado->nombre ?? 'Pendiente' }}</td></tr>

    <tr><td><br> Por favor darle seguimiento</td></tr>
</table>