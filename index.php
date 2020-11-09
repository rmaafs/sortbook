<?php
require "mysql.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "includes/title.php"; ?>
    <?php include "includes/css.php"; ?>

    <style>
        .card-header,
        .card-footer {
            background-color: white;
        }

        .btn-eliminar,
        .btn-editar {
            color: red;
            cursor: pointer;
        }
    </style>
</head>

<body class="hold-transition sidebar-collapse layout-top-nav">
    <div class="wrapper">
        <?php include "includes/navbar.php"; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <div class="content" style="background-color: #ececec;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="" id="formPublicacion" onsubmit="return false;">
                                        <h2>Nueva publicación</h2>
                                        <input type="hidden" id="id_publicacion" name="id_publicacion" value="" />

                                        <small>Tema</small>
                                        <input type="text" class="form-control" name="tema" id="tema" placeholder="Tema/título de la publicación">

                                        <small>Consulta</small>
                                        <textarea class="form-control" name="consulta" id="consulta" cols="30" rows="10" placeholder="Texto de la consulta"></textarea>

                                        <div class="col-md-12 text-center">
                                            <button class="btn btn-success btn-rounded waves-effect waves-light mt-2 text-white" id="btnPublicar" onclick="savePublicacion();">Publicar</button>
                                            <button class="btn btn-danger btn-rounded waves-effect waves-light mt-2 text-white" id="btnEdicion" onclick="cancelarEdicion();" style="display: none;">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <?php
                        //Obtenemos resultados
                        $resultado = selectBD("SELECT CONCAT(u.nombre, ' ', u.ape_pat, ' ', u.ape_mat) as nombre, u.idusuario, c.idconsulta, c.titulo, c.descripcion, c.fecha_hora, (SELECT COUNT(r.idrespuesta) FROM respuesta r WHERE r.id_consulta = c.idconsulta) as respuestas FROM consulta c LEFT JOIN usuario u ON u.idusuario = c.id_usuario WHERE c.titulo LIKE '%" . $search . "%' OR c.descripcion LIKE '%" . $search . "%' ORDER BY c.fecha_hora DESC"); //Seleccionar el campo usNombre de la tabla usuarios
                        if ($resultado) { //Si $resultado != null, significa que si hay resultados del query.
                            while ($fila = $resultado->fetch_assoc()) { //Cicla cada FILA que retorna la consulta, y se guarda en $fila
                                $tienePermisos = isset($user) && ($user->isAdmin || $fila['idusuario'] == $user->idUser);
                        ?>
                                <div class="col-md-6 col-lg-4" id="publicacion_<?php echo $fila['idconsulta']; ?>">
                                    <div class="card">
                                        <div class="card-header">
                                            <?php
                                            if ($tienePermisos) { ?>
                                                <i class="fas fa-times btn-eliminar" onclick="eliminarPublicacion(<?php echo $fila['idconsulta']; ?>);"></i>
                                                <i class="fas fa-pen btn-editar" onclick="editarPublicacion(<?php echo $fila['idconsulta']; ?>);"></i>
                                            <?php
                                            }
                                            ?>
                                            <img src="dist/img/AdminLTELogo.png" class="rounded-circle" width="30"> <?php echo $fila['nombre']; ?>
                                        </div>
                                        <div class="card-body">
                                            <h3 class="mt-3" id="titulo_<?php echo $fila['idconsulta']; ?>"><?php echo $fila['titulo']; ?></h3>
                                            <p class="mt-3 font-light" id="descripcion_<?php echo $fila['idconsulta']; ?>"><?php echo $fila['descripcion']; ?></p>
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex no-block align-items-center mb-3">
                                                <div>
                                                    <a href="javascript:openModal(<?php echo $fila['idconsulta']; ?>)" class="link"><i class="far fa-comment"></i> <?php echo $fila['respuestas']; ?></a>
                                                </div>
                                                <span class="text-muted ml-3"><i class="fas fa-calendar"></i> <?php echo $fila['fecha_hora']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>

                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- MODAL Formulario de mostrar Historial -->
        <div class="button btn btn-primary btn-outline" style="display:none;" data-toggle="modal" data-target="#divFormModal1" id="btnModal"></div>
        <div class="modal fade" id="divFormModal1" tabindex="-1" role="dialog" aria-labelledby="modalLabel1">
            <div class="modal-dialog" role="document" style="max-width: 1000px;">
                <div class="modal-content">
                    <div class="modal-header bg-inverse">
                        <h4 class="modal-title text-white" id="modalLabelTitle1"><span id="spanTitle"></span></h4>
                        <i class="fas fa-times" onclick="$('#btnModal').click()" style="cursor: pointer;"></i>
                    </div>
                    <div class="modal-body" id="formModal">


                    </div>
                </div>
            </div>
        </div>

        <?php include "includes/footer.php"; ?>
    </div>
    <!-- ./wrapper -->

    <?php include "includes/js.php"; ?>

    <script>
        function eliminarPublicacion(idConsulta) {
            $("#publicacion_" + idConsulta).hide();
            $.post("ajax/ajaxDeletePublicacion.php", {
                idConsulta: idConsulta
            }, function(data) {
                var json = JSON.parse(data);
                Swal.fire({
                    icon: json.icon,
                    title: json.title,
                    text: json.text
                })

                if (json.icon === "success") {
                    $("#publicacion_" + idConsulta).remove();
                }
            });
        }

        function editarPublicacion(idConsulta) {
            $("#tema").val($("#titulo_" + idConsulta).html());
            $("#consulta").html($("#descripcion_" + idConsulta).html());
            $("#id_publicacion").val(idConsulta);
            $("#btnEdicion").show();
        }

        function cancelarEdicion() {
            $("#btnEdicion").hide();
            $("#id_publicacion").val("");
            $("#tema").val("");
            $("#consulta").html("");
        }

        function openModal(idConsulta) {
            $('#formModal').html("Cargando...");
            $('#spanTitle').html("");
            $('#btnModal').click();

            $.ajax({
                url: 'ajax/ajaxViewComentarios.php',
                type: 'POST',
                data: {
                    idConsulta: idConsulta
                },
                success: function(data) {
                    $('#spanTitle').html("Comentarios");
                    $('#formModal').html(data);
                }
            });
        }

        function savePublicacion() {
            var tema = $("#tema").val();
            var consulta = $("#consulta").val();

            if (tema === "") {
                error("El tema no puede estar vacío");
                return;
            } else if (consulta === "") {
                error("La consulta no puede estar vacía");
                return;
            }


            $("#btnPublicar").html("Cargando");
            $("#btnPublicar").attr('disabled', true);
            $.post("ajax/ajaxSavePublicacion.php", $("#formPublicacion").serialize(), function(data) {
                var json = JSON.parse(data);
                Swal.fire({
                    icon: json.icon,
                    title: json.title,
                    text: json.text
                })

                if (json.icon === "success") {
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                }
                //alert(data);
                $("#btnPublicar").html("Publicar");
                $("#btnPublicar").attr('disabled', false);
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