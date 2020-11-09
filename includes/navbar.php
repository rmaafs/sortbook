<?php
include "Usuario.php";
if (!isset($_SESSION)) {
    session_start();
}


$user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
$search = isset($_GET['search']) ? $_GET['search'] : null;

$inSesion = isset($user) && isset($user->nombre);
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Sort<b>Book</b></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Publicaciones</a>
            </li>

            <?php
            if ($inSesion && $user->isAdmin) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Administración
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="indexUsuarios.php">Usuarios</a>
                    </div>
                </li>
            <?php
            }
            ?>
        </ul>

        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" placeholder="Buscar" aria-label="Buscar" name="search" value="<?php echo $search; ?>">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>

        <ul class="navbar-nav mr-auto">
            <?php
            if ($inSesion) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Hola <?php echo $user->nombre; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php?action=logout">Salir</a>
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