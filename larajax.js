class Larajax {

    constructor({
        data = false,
        idTable = '#table',
        columns = false,
        actionsButtons = false
    }) {

        this.columns = columns;
        this.idTable = idTable;
        this.route = data.route;
        this.model = data.model;
        this.csrf = data.csrf;
        this.actionsButtons = actionsButtons;
        this.renderDataTable();
        return this.table

    }
    renderDataTable() {
        this.table = ($(this.idTable).DataTable({

            ajax: this.dataAjax(),
            columns: this.columnsTable(),
            columnDefs: this.renderColumsDef(),
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando la página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            },
            rowReorder: {
                dataSrc: 'id'
            }
        }));
    }

    dataAjax() {
        if (this.route) {
            return {
                url: this.route,
                dataSrc: '',
                type: "POST",
                dataType: 'json',
                data: {
                    'accion': 'GET_Asociados',
                    'csrf': 'csrf',
                }
            }
        } else {
            return false;
        }
    }
    columnsTable() {
        if (!this.columns) {
            return false;
        }
        let columnas = this.columns
        if (this.actionsButtons) {
            columnas.push({ data: 'id', title: 'Acciones' });
        }
        return columnas;
    }
    renderColumsDef() {
        let columnDefs = [
            {
                "targets": [0, -1],
                'className': 'text-center',
            },
            {
                "targets": [1],
                "render": (data, type, row) => {
                    return `<a href="${this.route}/${row['id']}">${data}</a>`;
                }
            }
        ];

        if (this.actionsButtons) {
            columnDefs.push(this.renderActionsButtons(this.actionsButtons));
        }
        return columnDefs;


    }

    renderActionsButtons({

        view = false,
        print = false,
        edit = false,
        destroy = false,
        menuType = 'default',
        customButton = false,
        customButtonLink = false,
    }) {

        return {
            targets: [-1],
            className: "d-print-none acciones",

            render: (data, type, row, meta) => {
                // crear variable denominacion y cargarle el valor de la columna 1, tener en cuenta que row tiene key con nombre y no sabemos los nombres
                // por eso tenemos que cambiar los key nombrados a key numerico

                let fila = Object.values(row);

                let buttons = "";
                if (menuType == 'default') {
                    buttons += view ? `<a type="button" class="btn btn-primary btn-sm me-2" href="${this.route}/${data}" >Ver</a>` : '';
                    buttons += print ? `<button type="button" class="btn btn-primary btn-sm btn-print me-2" id=${data} subject="${fila[1]}">Imprimir</button>` : '';
                    buttons += edit ? `<button type="button" class="btn btn-primary btn-sm btn-edit me-2" id=${data} subject="${fila[1]}" >Editar</button>` : '';
                    //buttons += destroy ? `<button type="button" class="btn btn-primary btn-sm btn-destroy me-2" id=${data} ${this.model}="${fila[1]}" onclick="destroy_record('${fila[0]}','${fila[1]}')">Eliminar</button>` : '';
                    buttons += destroy ? `<button type="button" class="btn btn-primary btn-sm btn-destroy me-2" id=${data} subject="${fila[1]}" >Eliminar</button>` : '';


                    if (customButton) {
                        customButton.forEach((element) => {
                            buttons += `<button type="button" class="btn btn btn-primary btn-sm btn-${element.action} me-2" id="${data}" ${this.model}="${fila[1]}"><i class="${element.icon} me-2"></i>${element.action}</button>`;
                        });

                    }
                    if (customButtonLink) {
                        customButtonLink.forEach((element) => {
                            buttons += `<a href="${element.url}/${data}" type="button" class="btn btn btn-primary btn-sm  me-2" id="${data}" ${this.model}="${fila[1]}"><i class="${element.icon} me-2"></i>${element.action}</a>`;
                        });

                    }
                }

                if (menuType == 'dropdown') {
                    buttons = "";
                    customButton = `<li><hr class="dropdown-divider"></li>`;
                    if (customButtonLink) {
                        let icon = "";

                        customButtonLink.forEach((element) => {
                            if (element.icon) {
                                icon = `<i class="${element.icon} me-2"></i>`;
                            }
                            customButton += `<li><a href="${element.url}/${data}"  class="dropdown-item" id="${data}" ${this.model}="${fila[1]}">${icon}${element.action}</a><li>`;
                        });

                    }
                    buttons += view ? `<li><a href="${this.route}/${data}" class="dropdown-item" id=${data}>Ver</a></li>` : '';
                    buttons += print ? `<li><button class="dropdown-item btn-print" id=${data} ${this.model}="${fila[1]}" onclick="print_record('Hola mundo')" >Imprimir</button></li>` : '';
                    buttons += edit ? `<li><button class="dropdown-item btn-edit" id=${data} ${this.model}="${fila[1]}" onclick="edit_record('Hola mundo')">Editar</button></li>` : '';
                    buttons += destroy ? `<li><button class="dropdown-item btn-destroy" id=${data} ${this.model}="${fila[1]}" onclick="destroy_record('Hola mundo')">Eliminar</button></li>` : '';


                    let dropdown = `
                   <div class="btn-group dropdown-center">
                        <button type="button" class="btn btn-sm btn-secondary ">Opciones</button>
                        <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            ${buttons}
                            
                            ${customButton}
                        </ul>
                   </div>`
                    return dropdown;
                }
                return buttons;
            },
        };
    }

    getTable() {
        return this.table;
    }
    getRoute() {
        return this.route;
    }

}

function edit_record(rowData, table, fila) {

    for (prop in rowData) {
        $("#" + prop).val(rowData[prop]);
    }
    $('#modal').modal('show');
    $('.modal-title').text('Editar (' + fila.attr('id')+') ' + fila.attr('subject') );
    accion = 'actualizar';
    method = 'PUT';
    // url = model.route + '/' + data['id'];
    // activate_button_on_input_change();
}
function destroy_record(dataAjax, table,fila) {


    Swal.fire({

        title: "eliminar "+ dataAjax.subject,
        text: "¿Está seguro de eliminar a: (" + fila.attr('id')+') ' + fila.attr('subject')  + "?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar",
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: dataAjax.route + "/"+fila.attr('id'),
                type: "DELETE",
                data: {
                    _token: dataAjax.token,
                },
                success: function (respuesta) {
                    swal_message_response(respuesta) ? table.ajax.reload() : null;

                },
                error: function (error) {
                    console.log(error);
                }
            });


        }
    });

}
function store_record(dataAjax, formData, table) {
    
    Swal.fire({
        title: accion  +' '+ dataAjax.subject,
        html: "¿esta seguro de "+ accion + ' el registro?',
        icon: "question",
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: "Guardar",
        cancelButtonText: "Cancelar",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return $.ajax({
                url: dataAjax.route,
                type: "POST",
                data: formData,
                success: function (respuesta) {
                    swal_message_response(respuesta) ? table.ajax.reload() : null;
                },
                error: function (error) {
                    console.log(error);
                }
            });
        },
       

    });
    
}

function swal_message_response(respuesta) {
    if (respuesta["success"] == true) {
        Swal.fire({
            icon: "success",
            title: respuesta["title"],
            html: respuesta["message"],
            showConfirmButton: true,
        });
        $("#modal").modal("hide");

        return true;
    } else if (respuesta["success"] == false) {
        Swal.fire({
            icon: "error",
            title: respuesta["title"],
            html: respuesta["message"],
            showConfirmButton: true,
        });

        return false;
    } else {
        Swal.fire({
            icon: "error",
            title: "Hubo un error sin definir",
            html: respuesta,
            showConfirmButton: true,
        });

        return false;
    }
}

function no_send_form(idform = "#form") {
    $(idform).submit(function (e) {
        e.preventDefault();
    });
}