<?php
require "mysql.php";

session_start();
$inSesion = isset($_SESSION['user']);

if ($inSesion == false) {
    header("Location: index.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "includes/title.php"; ?>
    <?php include "includes/css.php"; ?>
</head>

<body class="hold-transition sidebar-collapse layout-top-nav">
    <div class="wrapper">
        <?php include "includes/navbar.php"; ?>
        <?php include "includes/sidebar.php"; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"> Usuarios</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <h5 class="card-title text-uppercase p-3 bg-info text-white mb-0">
                                    Usuarios
                                </h5>
                                <div class="p-3">
                                    <table width="100%" id="tablaResultados" class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Apellido paterno</th>
                                                <th>Apellido materno</th>
                                                <th>Usuario</th>
                                                <th class="text-right">¿Activado?</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $resultado = selectBD("SELECT * FROM usuario"); //Seleccionar el campo usNombre de la tabla usuarios
                                            if ($resultado) { //Si $resultado != null, significa que si hay resultados del query.
                                                while ($fila = $resultado->fetch_assoc()) { //Cicla cada FILA que retorna la consulta, y se guarda en $fila
                                            ?>
                                                    <tr onclick="editUsuario(<?php echo $fila['idusuario']; ?>);" style="cursor: pointer">
                                                        <td id="nombre_<?php echo $fila['idusuario']; ?>">
                                                            <?php echo $fila['nombre']; ?>
                                                        </td>
                                                        <td id="ape_pat_<?php echo $fila['idusuario']; ?>">
                                                            <?php echo $fila['ape_pat']; ?>
                                                        </td>
                                                        <td id="ape_mat_<?php echo $fila['idusuario']; ?>">
                                                            <?php echo $fila['ape_mat']; ?>
                                                        </td>
                                                        <td id="usuario_<?php echo $fila['idusuario']; ?>">
                                                            <?php echo $fila['usr']; ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                                <input type="checkbox" class="custom-control-input" id="disponible_<?php echo $fila['idusuario']; ?>" name="disponible" <?php echo $fila['usEnabled'] == true ? "checked" : ""; ?>>
                                                                <label class="custom-control-label" for="rol_disponible"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title" id="card_title">Nuevo usuario</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form role="form" id="form_register">
                                        <input type="hidden" name="id_usuario" id="id_usuario" value />
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Nombre</label>
                                                    <input type="text" class="form-control" placeholder="Nombre del usuario" name="nombre" id="nombre">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <!-- textarea -->
                                                <div class="form-group">
                                                    <label>Apellido paterno</label>
                                                    <textarea class="form-control" rows="3" placeholder="Apellido paterno" name="ape_pat" id="ape_pat"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <!-- textarea -->
                                                <div class="form-group">
                                                    <label>Apellido materno</label>
                                                    <textarea class="form-control" rows="3" placeholder="Apellido materno" name="ape_mat" id="ape_mat"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Usuario</label>
                                                    <input type="text" class="form-control" placeholder="Usuario" name="usuario" id="usuario">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="div_password">
                                            <div class="col-sm-12">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Contraseña</label>
                                                    <input type="text" class="form-control" placeholder="Contraseña" name="password" id="password">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="div_password2">
                                            <div class="col-sm-12">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Repetir contraseña</label>
                                                    <input type="text" class="form-control" placeholder="Contraseña" name="password2" id="password2">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row text-right">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                        <input type="checkbox" class="custom-control-input" id="disponible" name="disponible">
                                                        <label class="custom-control-label" for="disponible">¿Activado?</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-body -->


                                <div class="card-footer">
                                    <div id="btn_register">
                                        <button type="button" class="btn btn-success float-right btn-block" id="btnGuardar" onclick="save();">Guardar</button>
                                    </div>
                                    <div id="btn_edit" style="display: none;">
                                        <button type="button" class="btn btn-info float-left btn-block" id="btnCancel" onclick="cancel();">Cancelar</button>
                                        <button type="button" class="btn btn-success float-right btn-block" id="btnEdit" onclick="save();">Editar</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include "includes/rightSidebar.php"; ?>
    <?php include "includes/footer.php"; ?>
    <?php include "includes/js.php"; ?>

    <script>
        $('.js-range-slider').ionRangeSlider({
            min: 0,
            max: 100,
            from: 0,
            type: 'single',
            step: 1,
            postfix: '%',
            prettify: false,
            hasGrid: true
        });

        $(document).ready(function() {
            $('.select2_usuarios_roles').select2();

            //https://datatables.net/reference/option/language
            $('#tablaResultados').DataTable({
                "language": {
                    "lengthMenu": "_MENU_ Registros por página",
                    "zeroRecords": "Sin resultados",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "Sin resultados",
                    "infoFiltered": "(Filtrando por _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });

        function editUsuario(id) {
            var nombre = $("#nombre_" + id).html().trim();
            var apePat = $("#ape_pat_" + id).html().trim();
            var apeMat = $("#ape_mat_" + id).html().trim();
            var usuario = $("#usuario_" + id).html().trim();
            var disponible = document.getElementById("disponible_" + id);

            $("#div_password").hide();
            $("#div_password2").hide();

            $("#card_title").html("Editar usuario");

            $("#id_usuario").val(id);
            $("#nombre").val(nombre);
            $("#ape_pat").val(apePat);
            $("#ape_mat").val(apeMat);
            $("#usuario").val(usuario);
            if (disponible.checked)
                $("#disponible").attr('checked', true);

            $("#btn_register").hide();
            $("#btn_edit").show();
        }

        function cancel() {
            $("#div_password").show();
            $("#div_password2").show();

            $("#card_title").html("Nuevo menú");

            $("#id_usuario").val("");
            $("#nombre").val("");
            $("#ape_pat").val("");
            $("#ape_mat").val("");
            $("#usuario").val("");
            $("#disponible").attr('checked', false);

            $("#btn_register").show();
            $("#btn_edit").hide();
        }

        function save() {
            var nombre = $("#nombre").val();
            var apePat = $("#ape_pat").val();
            var apeMat = $("#ape_mat").val();
            var usuario = $("#usuario").val();
            var telefono = $("#telefono").val();

            if (nombre === '') {
                error("El nombre no puede estar vacío");
                return;
            } else if (apePat === '') {
                error("El apellido paterno no puede estar vacío");
                return;
            } else if (apeMat === '') {
                error("El apellido materno no puede estar vacío");
                return;
            } else if (usuario === '') {
                error("El usuario no puede estar vacío");
                return;
            } else if (telefono === '') {
                error("El teléfono no puede estar vacío");
                return;
            }

            $("#btnGuardar").html("Guardando");
            $("#btnGuardar").attr('disabled', true);
            $.post("ajax/ajaxSaveUsuarios.php", $("#form_register").serialize(), function(data) {
                var json = JSON.parse(data);
                Swal.fire({
                    icon: json.icon,
                    title: json.title,
                    text: json.text
                })

                if (json.icon === "success") {
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                }
                //alert(data);
                $("#btnGuardar").html("Guardar");
                $("#btnGuardar").attr('disabled', false);
            });
        }

        function error(msg) {
            Swal.fire({
                icon: "error",
                title: "¡Oooops!",
                text: msg
            })
        }
    </script>
</body>

</html>