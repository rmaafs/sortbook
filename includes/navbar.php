<?php
    include "Usuario.php";
    if(!isset($_SESSION)) {
        session_start();
    }
    

    $user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $search = isset($_GET['search']) ? $_GET['search'] : null;

    $inSesion = isset($user) && isset($user->nombre);
?>
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="/" class="navbar-brand">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Sort<b>Book</b></span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Publicaciones</a>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            <form class="form-inline ml-0 ml-md-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Buscar" aria-label="Buscar" name="search" value="<?php echo $search; ?>">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <?php
                if ($inSesion) { ?>
            <li class="nav-item col-md-12">
                <a class="nav-link" href="login.php">Hola <?php echo $user->nombre; ?></a>
            </li>
            <?php } else { ?>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Iniciar sesión</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="register.php">Registrarse</a>
            </li>
            <?php } ?>

        </ul>
    </div>
</nav>