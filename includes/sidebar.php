<?php

$user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
$search = isset($_GET['search']) ? $_GET['search'] : null;

$inSesion = isset($user) && isset($user->nombre);
?>
<style>
    .item-hijo {
        padding-left: 30px;
    }
</style>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="SortBook" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SortBook</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/avatar.png" class="img-circle elevation-2" alt="<?php echo $user->nombre; ?>">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $inSesion ? $user->nombre : "¡Regístrate!"; ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php
                if ($inSesion && $user->isAdmin) { ?>
                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-cog text-blue"></i>
                            <p>
                                Administración
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: block;">
                            <li class="nav-item">
                                <a href="indexUsuarios.php" class="nav-link item-hijo">
                                    <i class="nav-icon fa fa-users text-success"></i>
                                    <p>
                                        Usuarios
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                ?>

                <li class="nav-item">
                    <a href="login.php?action=logout" class="nav-link">
                        <i class="nav-icon far fa-circle text-danger"></i>
                        <p>
                            Salir
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>