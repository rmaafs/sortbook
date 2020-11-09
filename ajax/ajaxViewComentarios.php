<?php
require "../mysql.php";
include "../Usuario.php";

if (!isset($_SESSION)) {
    session_start();
}

$user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;

$idConsulta = isset($_POST['idConsulta']) ? $_POST['idConsulta'] : null;
?>
<div class="card-body scrollable ps-container ps-theme-default ps-active-y" data-ps-id="39251eef-7f89-1afc-cf25-bf38e6bb29d9">
    <div class="steamline mt-0">
        <?php
        //Obtenemos resultados
        $resultado = selectBD("SELECT CONCAT(u.nombre, ' ', u.ape_pat, ' ', u.ape_mat) as nombre, r.respuesta, r.fecha_hora, u.idusuario, idrespuesta FROM respuesta r LEFT JOIN usuario u ON u.idusuario = r.id_usuario WHERE r.id_consulta = " . $idConsulta);
        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                $tienePermisos = isset($user) && ($user->isAdmin || $fila['idusuario'] == $user->idUser);
        ?>
                <div>
                    <div>
                        <?php
                        if ($tienePermisos) { ?>
                            <i class="fas fa-times btn-eliminar" onclick="eliminarComentario(<?php echo $fila['idrespuesta']; ?>);"></i>
                        <?php
                        }
                        ?>
                        <a href="javascript:void(0)" class="link text-dark"><?php echo $fila['nombre']; ?></a>
                        <span class="sl-date"><?php echo $fila['fecha_hora']; ?></span>
                        <p class="mt-1 font-light"><?php echo $fila['respuesta']; ?></p>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>
<div class="card-footer">
    <div class="row">
        <div class="col-9">
            <div class="input-field mt-0 mb-0">
                <textarea id="comentario" placeholder="Escribe tu comentario" class="form-control border-0"></textarea>
            </div>
        </div>
        <div class="col-3">
            <a id="btnComentario" class="btn-circle btn-lg btn-success btn text-white" href="javascript:sendComentario()"><i class="fas fa-paper-plane"></i></a>
        </div>
    </div>
</div>
<script>
    function sendComentario() {
        var comentario = $("#comentario").val();

        if (comentario === "") {
            error("El comentario no puede estar vacío");
            return;
        }

        $("#btnComentario").attr('disabled', true);
        $.post("ajax/ajaxSaveComentario.php", {
            idConsulta: <?php echo $idConsulta; ?>,
            comentario: comentario
        }, function(data) {
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
            $("#btnComentario").attr('disabled', false);
        });
    }

    function eliminarComentario(idComentario) {
        $("#comentario_" + idComentario).hide();
        $.post("ajax/ajaxDeleteComentario.php", {
            idComentario: idComentario
        }, function(data) {
            var json = JSON.parse(data);
            Swal.fire({
                icon: json.icon,
                title: json.title,
                text: json.text
            })

            if (json.icon === "success") {
                location.reload();
            }
        });
    }
</script>