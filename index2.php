<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.4/css/dataTables.dataTables.css">
<link href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.dataTables.css" rel="stylesheet">

<body>

    <div class="container">
        <table id="table" class="tasble dissplay" style="width:100%">
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>email</th>
                    <th>phone</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

        </table>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.4/js/dataTables.js"></script>
    <script src="dataTables.rowReorder.js"></script>
    <script src="rowReorder.dataTables.js"></script>



    <script>
        $(document).ready(function() {

            new DataTable('#table', {
                ajax: {
                    url: 'user.php',
                    dataSrc: '',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        'accion': 'GET_Asociados',
                        'csrf': 'csrf',
                    }
                },

                columns: [{
                        data: 'id',
                        title: 'id'
                    },
                    {
                        data: 'name',
                        title: 'name'
                    },
                    {
                        data: 'email',
                        title: 'email'
                    },
                    {
                        data: 'phone',
                        title: 'phone'
                    }
                    

                ],
                rowReorder: {
                    dataSrc: 'id'
                }
            });
        });
    </script>
</body>

</html>