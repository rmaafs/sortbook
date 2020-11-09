<!DOCTYPE html>
<html>

<head>
    <?php include "includes/title.php"; ?>
    <?php include "includes/css.php"; ?>

    <style>
        body {
            align-items: center;
            display: flex;
            background: #e9ecef;
            height: 100vh;
            justify-content: center;
        }

        .tarjeta {
            background: #fff;
            padding: 20px;
            text-align: center;
        }

        .tarjeta td {
            padding: 14px;
        }
    </style>
</head>

<body>

    <div class="tarjeta">
        <form action="" id="formRegister" method="post">
            <table>
                <tr>
                    <td>
                        Registrar
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control" id="ape_pat" name="ape_pat" placeholder="Apellido paterno">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control" id="ape_mat" name="ape_mat" placeholder="Apellido materno">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="password" class="form-control" id="pass" name="pass" placeholder="Contraseña">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Repetir contraseña">
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="button" onclick="register();" id="btnRegister" class="btn btn-success btn-block">Registrar</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="login.php" class="text-center">Ya tengo una cuenta</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>


    <?php include "includes/js.php"; ?>
    <script>
        function register() {
            var nombre = $("#nombre").val();
            var apePat = $("#ape_pat").val();
            var apeMat = $("#ape_mat").val();
            var usuario = $("#usuario").val();
            var pass = $("#pass").val();
            var pass2 = $("#pass2").val();

            if (nombre === "") {
                error("El nombre no puede estar vacío");
                return;
            } else if (nombre.includes("<") || nombre.includes("script") || nombre.includes("</")) {
                error("El nombre no puede tener carácteres extraños.");
                return;
            } else if (apePat === "") {
                error("El apellido paterno no puede estar vacío");
                return;
            } else if (apeMat === "") {
                error("El apellido materno no puede estar vacío");
                return;
            } else if (usuario === "") {
                error("El usuario no puede estar vacío");
                return;
            } else if (pass === "") {
                error("La contraseña no puede estar vacía");
                return;
            } else if (pass !== pass2) {
                error("Las contraseñas no coinciden");
                return;
            }

            $("#btnRegister").html("Cargando");
            $("#btnRegister").attr('disabled', true);
            $.post("ajax/ajaxRegister.php", $("#formRegister").serialize(), function(data) {
                var json = JSON.parse(data);
                Swal.fire({
                    icon: json.icon,
                    title: json.title,
                    text: json.text
                })

                if (json.icon === "success") {
                    setTimeout(function() {
                        window.location.href = "login.php";
                    }, 500);
                }

                $("#btnRegister").html("Registrar");
                $("#btnRegister").attr('disabled', false);
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