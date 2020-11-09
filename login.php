<?php
$action = isset($_GET["action"]) ? $_GET["action"] : "";
if ($action == "logout") {
    session_start();
    $_SESSION["user"] = null;
}
?>
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
        <form action="" id="formLogin" method="post">
            <table>
                <tr>
                    <td>
                        Iniciar sesión
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="email" class="form-control" name="usuario" placeholder="Usuario" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="password" class="form-control" name="pass" placeholder="Contraseña" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="button" onclick="login();" id="btnLogin" class="btn btn-primary btn-block">Login</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="index.php" class="btn btn-block btn-warning">
                            <i class="mr-2"></i> Regresar al menú
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="mb-0">
                            <a href="register.php" class="text-center">Registrar</a>
                        </p>
                    </td>
                </tr>
            </table>
        </form>

    </div>
    <!-- /.login-box -->

    <?php include "includes/js.php"; ?>
    <script>
        function login() {
            $("#btnLogin").html("Cargando");
            $("#btnLogin").attr('disabled', true);
            $.post("ajax/ajaxLogin.php", $("#formLogin").serialize(), function(data) {
                var json = JSON.parse(data);
                Swal.fire({
                    icon: json.icon,
                    title: json.title,
                    text: json.text
                })

                if (json.icon === "success") {
                    setTimeout(function() {
                        window.location.href = "index.php";
                    }, 500);
                }
                //alert(data);
                $("#btnLogin").html("Login");
                $("#btnLogin").attr('disabled', false);
            });
        }
    </script>
</body>

</html>