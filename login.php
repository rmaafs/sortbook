
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
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="../../index2.html">Sort<b>Book</b></a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Inicia sesión</p>

                    <form action="" id="formLogin" method="post">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" name="usuario" placeholder="Usuario" value="">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="pass" placeholder="Contraseña" value="">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember" name="recordar">
                                    <label for="remember">
                                        Recordar
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="button" onclick="login();" id="btnLogin" class="btn btn-primary btn-block">Login</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <div class="social-auth-links text-center mb-3">
                        <a href="#" class="btn btn-block btn-primary">
                            <i class="fab fa-facebook mr-2"></i> Iniciar usando Facebook
                        </a>
                        <a href="#" class="btn btn-block btn-danger">
                            <i class="fab fa-google-plus mr-2"></i> Iniciar usando Google+
                        </a>
                        <a href="index.php" class="btn btn-block btn-warning">
                            <i class="mr-2"></i> Regresar al menú
                        </a>
                    </div>
                    <!-- /.social-auth-links -->

                    <p class="mb-0">
                        <a href="register.php" class="text-center">Registrar</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->

        <?php include "includes/js.php"; ?>
        <script>
            function login() {
                $("#btnLogin").html("Cargando");
                $("#btnLogin").attr('disabled', true);
                $.post("ajax/ajaxLogin.php", $("#formLogin").serialize(), function (data) {
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
