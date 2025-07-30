<div>
    <style>
        .dt-buttons {
            display: none !important;
        }
    </style>
    <div class="card-content collapse show">
        <div wire:ignore class="card-body card-dashboard">
            <div class="col-md-6 col-sm-12 col-12">
                <a href="javascript:exportTabla('excel')" class="btn-lg btn-default text-success mx-1 shadow">
                    <i class="far fa-file-excel"></i>
                </a>
                <a href="javascript:exportTabla('pdf')" class="btn-lg btn-default text-danger mx-1 shadow">
                    <i class="far fa-file-pdf"></i>
                </a>
                <a href="#" data-toggle="modal" data-target="#rechazarReportes" id="btn_rechazo"
                    class="btn-lg btn-default mx-1 shadow d-none">
                </a>
                <a href="#" data-toggle="modal" data-target="#verReportes" id="btn_ver"
                    class="btn-lg btn-default mx-1 shadow d-none">
                </a>
            </div>
            <table class="table table-striped  tabla_reportes d-none" style="width:100%;">
                <thead>
                    <tr>
                        <th style="text-align: center">Fecha</th>
                        <th style="text-align: center">Reportado por</th>
                        <th style="text-align: center">Matriz de Impacto</th>
                        <th style="text-align: center">Area del reporte</th>
                        <th style="text-align: center">Zona</th>
                        <th style="text-align: center">Prioridad</th>
                        <th style="text-align: center">Estado</th>
                        <th style="text-align: center">Consecutivo</th>
                        <th style="text-align: center">Acción</th>
                    </tr>
                </thead>
                <tbody id="content_tabla_reportes">
                </tbody>
                <div class="margin_20 loading_p">
                    <div class="centrar_todo w_100px">
                        <i class="la la-spinner spinner" style="font-size:30px;"></i>
                    </div>
                </div>
            </table>
        </div>
    </div>

    @push('js')
        <script>
            $(document).ready(function() {
                console.log('entro');
                Livewire.dispatch('cargarReportes');
                console.log('paso');
            });

            Livewire.on('cargarReportesTabla', data => {
                console.log('llego');
                cargarTabla(data);
            });

            function cargarTabla(data) {
                $('.tabla_reportes').DataTable().destroy(); // destruir la tabla existente
                $('.tabla_reportes').addClass('d-none'); // ocultamos la tabla
                $('.loading_p').removeClass('d-none'); // mostramos el loading
                $('#content_tabla_reportes').html(''); // limpiar el contenido de la tabla
                llenarTabla(data).then(() => {
                    $('.tabla_reportes').DataTable({
                        language: {
                            "decimal": "",
                            "emptyTable": "No hay información",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                            "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                            "lengthMenu": "Mostrar _MENU_ Entradas",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscar:",
                            "zeroRecords": "Sin resultados encontrados",
                            "paginate": {
                                "first": "Primero",
                                "last": "Último",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            }
                        },
                        dom: 'Bfrtip',
                        buttons: [{
                                extend: 'excelHtml5',
                                autoFilter: true,
                                title: 'Reportes',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                                },
                            },
                            {
                                extend: 'pdfHtml5',
                                autoFilter: true,
                                title: 'Reportes',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                                },
                            }
                        ]
                    });
                    $('.tabla_reportes').removeClass('d-none'); // mostrar la tabla
                    $('.loading_p').addClass('d-none');
                });
            }

            function llenarTabla(data) {
                data = JSON.parse(data);
                return new Promise((resolve) => {
                    let body = $('#content_tabla_reportes');
                    for (let index = 0; index < data.length; index++) {
                        const item = data[index];
                        let prioridadBadge = item.prioridad == 'ALTA' ? 'badge-danger' : item.prioridad ==
                            'MEDIA' ?
                            'badge-warning' : 'badge-success';
                        let estadoBadge, estadoText;

                        switch (item.estado) {
                            case 1:
                                estadoBadge = 'badge-info';
                                estadoText = 'PENDIENTE';
                                break;
                            case 2:
                                estadoBadge = 'badge-warning';
                                estadoText = 'EN PROCESO';
                                break;
                            case 3:
                                estadoBadge = 'badge-success';
                                estadoText = 'FINALIZADO';
                                break;
                            case 4:
                                estadoBadge = 'badge-danger';
                                estadoText = 'RECHAZADO';
                                break;
                            case 5:
                                estadoBadge = 'bg-secondary';
                                estadoText = 'POR ACEPTACION';
                                break;
                            case 6:
                                estadoBadge = 'badge-dark';
                                estadoText = 'SEGUIMIENTO';
                                break;
                            default:
                                estadoBadge = 'badge-primary';
                                estadoText = 'RE-ABIERTO';
                        }

                        body.append(`<tr>
            <td class="text-center">${new Date(item.created_at).toLocaleDateString()}</td>
            <td class="text-center">${item.ReportadoPor}</td>
            <td class="text-center">${item.impacto_names}</td>
            <td class="text-center">${item.area}</td>
            <td class="text-center">${item.zona}</td>
            <td class="text-center"><span class="badge ${prioridadBadge}">${item.prioridad}</span></td>
            <td class="text-center"><span class="badge ${estadoBadge}">${estadoText}</span></td>
            <td class="text-center">${item.consecutivo}</td>
            <td class="text-center">
                <a href="#" class="btn btn-xs btn-default text-primary mx-1 shadow" onclick="editar(${item.id})">
                    <i class="far fa-eye"></i>
                </a>
                ${(item.estado == 1 && item.userRole == 'JefeArea') ? `<a href="#" class="btn btn-xs btn-default text-danger mx-1 shadow" onclick="rechazar(${item.id})"><i class="fas fa-times-circle"></i></a>` : ''}
            </td>
        </tr>`);
                    }
                    resolve(body);
                });
            }


            function exportTabla(tipo) {
                if (tipo == 'excel') {
                    $('.buttons-excel').click();
                } else {
                    $('.buttons-pdf').click();
                }
            }

            function rechazar(id) {
                $('#btn_rechazo').click();
                Livewire.dispatch('Rechazo', {
                    id: id
                });
            }

            function editar(id) {
                $('#btn_ver ').click();
                Livewire.dispatch('info', {
                    id: id
                });
            }
        </script>
    @endpush
</div>
