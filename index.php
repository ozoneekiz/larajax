<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.dataTables.css" rel="stylesheet">

<body>

    <div class="container">
        <table id="table" class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>nombre completos</th>
                    <th>email</th>
                    <th>telefono</th>
                    <th>acciones</th>

                </tr>
            <tbody></tbody>
            </thead>

        </table>
        <!-- <table id="table2" class="table table-striped ">


            <thead>
                <tr role="row">
                    <th>id</th>
                    <th>nombre completos</th>
                    <th>email</th>
                    <th>telefono</th>
                    <th>acciones</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>pedro herrera</td>
                    <td>jhon@gmail.com</td>
                    <td>1234567890</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>jhon@gmail.com</td>
                    <td>1234567890</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>jhon@gmail.com</td>
                    <td>1234567890</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>jhon@gmail.com</td>
                    <td>1234567890</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>jhon@gmail.com</td>
                    <td>1234567890</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>jhon@gmail.com</td>
                    <td>1234567890</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>>Jane Doe</td>
                    <td>jane@gmail.com</td>
                    <td>1234567890</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>>Jane Doe</td>
                    <td>jane@gmail.com</td>
                    <td>1234567890</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>>Jane Doe</td>
                    <td>jane@gmail.com</td>
                    <td>1234567890</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>>Jane Doe</td>
                    <td>jane@gmail.com</td>
                    <td>1234567890</td>
                </tr>
            </tbody>
            <tfoot></tfoot>
        </table> -->
        //modal edicion
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar registro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form">
                            <input type="hidden" name="id" id="id">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Telefono</label>
                                <input type="number" class="form-control" id="phone" name="phone" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-store">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.0.4/js/dataTables.js"></script>
    <script src="dataTables.rowReorder.js"></script>
    <script src="rowReorder.dataTables.js"></script>


    <script src="larajax.js"></script>
    <script>
        $(document).ready(function() {
            dataAjax = {
                subject: 'Usuario',
                route: 'user.php',
                csrf: '56465sda56sad4',
            }

            table = new Larajax({
                data: dataAjax,
                idTable: '#table',
                columns: [{
                        data: 'id',
                        title: "id"
                    },
                    {
                        data: 'name',
                        title: "nombre"
                    },
                    {
                        data: function(data) {
                            //retornar mail con in badge
                            return `<div class="badge text-bg-success">${data.email}</div>`;
                        },
                        title: "email"
                    },
                    {
                        data: 'phone',
                        title: "telefono"
                    },

                ],
                actionsButtons: {
                    //menuType: 'dropdown',
                    edit: true,
                    destroy: true,
                    /*  customButtonLink: [{
                         action : 'custom action',
                         url: 'https://www.google.com',
                         icon: 'fa-solid fa-download',
                         
                     }] */
                }
            });
            ///edit
            $('#table').on('click', '.btn-edit', function() {

                let rowData = ($(this).parents('tr').hasClass('child')) ?
                    table.row($(this).parents().prev('tr')).data() :
                    table.row($(this).parents('tr')).data();
                edit_record(rowData, table, $(this));

            });
            //print
            $('#table').on('click', '.btn-print', function() {
                print_record('id', dataAjax, table);
            });

            /// destroy
            $('#table').on('click', '.btn-destroy', function() {
                destroy_record(dataAjax, table, $(this));
            });

            // store
            $(document).on('click', '.btn-store', function() {

                no_send_form();

                let form = document.getElementById('form');
                if (!form.checkValidity()) {
                    return;
                }
                let formData = $('#form').serialize();
                
                store_record(dataAjax, formData, table);

            });

        });
    </script>
</body>

</html>