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
                    <p class="login-box-msg">Registrate</p>

                    <form action="" id="formRegister" method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="ape_pat" name="ape_pat" placeholder="Apellido paterno">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="ape_mat" name="ape_mat" placeholder="Apellido materno">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="pass" name="pass" placeholder="Contraseña">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Repetir contraseña">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-12" style="padding-bottom: 20px;">
                                <button type="button" onclick="register();" id="btnRegister" class="btn btn-success btn-block">Registrar</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <div class="social-auth-links text-center mb-3">
                        <a href="#" class="btn btn-block btn-primary">
                            <i class="fab fa-facebook mr-2"></i> Registrar usando Facebook
                        </a>
                        <a href="#" class="btn btn-block btn-danger">
                            <i class="fab fa-google-plus mr-2"></i> Registrar usando Google+
                        </a>
                    </div>
                    <!-- /.social-auth-links -->
                    <p class="mb-0 text-center">
                        <a href="login.php" class="text-center">Ya tengo una cuenta</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->

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
                $.post("ajax/ajaxRegister.php", $("#formRegister").serialize(), function (data) {
                    var json = JSON.parse(data);
                    Swal.fire({
                        icon: json.icon,
                        title: json.title,
                        text: json.text
                    })

                    if (json.icon === "success") {
                        setTimeout(function () {
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