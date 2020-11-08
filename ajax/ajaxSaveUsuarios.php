<?php

    session_start();
    $user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $inSesion = isset($user) && isset($user->nombre);

    if (!$inSesion) {
        error("Necesitas iniciar sesión.");
        exit();
    }

    require "../mysql.php";

    $nombre = isset($_POST["nombre"]) ? $_POST['nombre'] : null;
    $apePat = isset($_POST["ape_pat"]) ? $_POST['ape_pat'] : null;
    $apeMat = isset($_POST["ape_mat"]) ? $_POST['ape_mat'] : null;
    $usuario = isset($_POST["usuario"]) ? $_POST['usuario'] : null;
    $pass = isset($_POST["pass"]) != null ? $_POST["pass"] : "";
    $pass2 = isset($_POST["pass2"]) != null ? $_POST["pass2"] : "";
    $activado = isset($_POST["disponible"]) ? ($_POST['disponible'] != "off" && $_POST['disponible'] != "off" ? true : false) : false;
    $idUsuario = isset($_POST["id_usuario"]) ? $_POST['id_usuario'] : null;//Si se recibe un id_usuario, significa que será editado

    //Editar usuario
    if ($idUsuario > 0) {
        if (updateDB("UPDATE usuario SET nombre='" . $nombre . "', ape_pat='" . $apePat . "', ape_mat='" . $apeMat . "', usr='" . $usuario . "', usEnabled='" . $activado . "' WHERE idusuario='" . $idUsuario . "'")){
            success("¡Usuario " . $nombre . " editado!");
        } else {
            error("Hubo un error al editar el usuario.");
        }

        exit();
    }

    $resultado = selectBD("SELECT idusuario FROM usuario WHERE usr = '" . $usuario . "'");//Seleccionar el campo usNombre de la tabla usuarios
    if ($resultado){//Si $resultado != null, significa que si hay resultados del query.
        error("El usuario " . $usuario . " ya está registrado.");
        exit();
    }


    if (insertDB("INSERT INTO usuario (nombre, ape_pat, ape_mat, usr, pwd, usEnabled) VALUES('" . $nombre . "','" . $apePat . "', '" . $apeMat . "', '" . $usuario . "', '" . md5($pass) . "', " . ($activado ? "1" : "0") . ")")){
        success("¡Usuario " . $nombre . " registrado!");
    } else {
        error("Hubo un error al registrar el usuario.");
    }

    function error($msg)  {
        echo '{"icon":"error","text":"' . $msg . '","title":"¡Ops!"}';
    }

    function success($msg)  {
        echo '{"icon": "success", "title": "¡Éxito!", "text": "' . $msg . '"}';
    }
