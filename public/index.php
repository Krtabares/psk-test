<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de empresas - CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-light bg-light">
    <div class="container">
        <span class="navbar-brand">Gestion de Empresas</span>
    </div>
</nav>
<div class="container">
    <div class="card p-4 mb-4">
        <div class="row g-3 align-input-group" >
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="search" class="form-control" placeholder="Buscar por RIF o Razón Social">
                    <button class="btn btn-primary" id="searchBtn">Buscar</button>
                </div>

            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end gap-2">
                    <button class="btn btn-success" 
                    data-bs-toggle="modal" 
                    data-bs-target="#empresaModal"
                    id="addEmpresaBtn" 
                    onclick="clearModal()">Agregar Empresa</button>
                    <button class="btn btn-secondary" id="exportJsonBtn">Exportar JSON</button>
                    <button class="btn btn-secondary" id="exportPdfBtn">Exportar PDF</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="empresasTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>RIF</th>
                        <th>Razón Social</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="empresasTableBody">
                    <!-- Aquí se cargarán las empresas -->
                </tbody>
            </table>

        </div>
    </div>
</div>

<div class="modal" id="empresaModal" tabindex="-1" aria-labelledby="empresaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="empresaForm">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="empresaModalLabel">Agregar/Editar Empresa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <input type="hidden" id="empresaId">
                    <div class="mb-3">
                        <label for="rif" class="form-label">RIF</label>
                        <input type="text" class="form-control" id="rif" required>
                    </div>
                    <div class="mb-3">
                        <label for="razon_social" class="form-label">Razón Social</label>
                        <input type="text" class="form-control" id="razon_social" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" required>
                    </div>
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="saveEmpresaBtn">Guardar</button>
            </div>
        </div>
          </form>
    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.1/sweetalert.min.js" ></script>
<script>
$(document).ready(function() {

    loadEmpresas();

    $('#searchBtn').click(function() {
        const search = $('#search').val();
        loadEmpresas(search);
    });

    $('#exportJsonBtn').click(function() {
        const search = $('#search').val();
        window.location.href = `http://localhost/empresas/public/api/empresas_export_json.php?search=${encodeURIComponent(search)}`;
    });

    $('#exportPdfBtn').click(function() {
        const search = $('#search').val();
        window.location.href = `http://localhost/empresas/public/api/empresas_report_pdf.php?search=${encodeURIComponent(search)}`;
    });

    $('#empresaForm').on('submit', function(e) {
        e.preventDefault();
        saveEmpresa();
    });

    // Aquí irán los handlers para editar y eliminar empresas
});

    function loadEmpresas(search = '') {
        $.get('http://localhost/empresas/public/api/empresas_list.php', { search }, function(data) {
            let html = '';
            if(data.length === 0) {
                html = '<tr><td colspan="6" class="text-center">No se encontraron empresas</td></tr>';
                $('#empresasTableBody').html(html);
                return;
            }else{
                const tbody = $('#empresasTableBody');
                tbody.empty();
                data.forEach(e => {
                    tbody.append(`
                        <tr>
                            <td>${e.id_empresa}</td>
                            <td>${e.rif}</td>
                            <td>${e.razon_social}</td>
                            <td>${e.direccion}</td>
                            <td>${e.telefono}</td>
                            <td>
                                <button class="btn btn-sm btn-primary edit-btn" data-id="${e.id_empresa}" onclick="editEmpresa(${e.id_empresa})">Editar</button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${e.id_empresa}" onclick="deleteEmpresa(${e.id_empresa})">Eliminar</button>
                            </td>
                        </tr>
                    `);
                });
            }
        });
    }

    function clearModal() {
        $('#empresaId').val('');
        $('#rif').val('');
        $('#razon_social').val('');
        $('#direccion').val('');
        $('#telefono').val('');
    }

    function saveEmpresa() {
        const id = $('#empresaId').val();
        const data = {
            rif: $('#rif').val(),
            razon_social: $('#razon_social').val(),
            direccion: $('#direccion').val(),
            telefono: $('#telefono').val()
        };
        let url = 'http://localhost/empresas/public/api/empresas_create.php';
        let method = 'POST';

        if(id) {
            url = `http://localhost/empresas/public/api/empresas_update.php?id=${id}`;
            method = 'PUT';
        } 
        
        $.ajax({
            type: method,
            url: url,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response) {
                swal('Éxito', 'Empresa guardada correctamente', 'success');
                $('#empresaModal').modal('hide');
                loadEmpresas();
            },
            error: handleError
        });


        
    }

    function editEmpresa(id) {
        $.get(`http://localhost/empresas/public/api/empresas_get.php?id=${id}`, function(data) {
            $('#empresaId').val(data.id_empresa);
            $('#rif').val(data.rif);
            $('#razon_social').val(data.razon_social);
            $('#direccion').val(data.direccion);
            $('#telefono').val(data.telefono);
            $('#empresaModal').modal('show');
        });
    }

    function deleteEmpresa(id) {
        swal({
            title: "¿Estás seguro?",
            text: "Una vez eliminado, no podrás recuperar esta empresa",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'DELETE',
                    url: `http://localhost/empresas/public/api/empresas_delete.php?id=${id}`,
                    success: function(response) {
                        swal('Éxito', 'Empresa eliminada correctamente', 'success');
                        loadEmpresas();
                    },
                    error: handleError
                });
            }
        });
    }

    function handleError(xhr){
        const errMsg = xhr.responseJSON && xhr.responseJSON.errors ? xhr.responseJSON.errors.join('\n') : 'Error desconocido';
        swal('Error', errMsg, 'error');
    }
</script>
</html>