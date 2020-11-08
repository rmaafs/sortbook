<?php

    require "../mysql.php";
    include "../Usuario.php";

    $usuario = isset($_POST["usuario"]) != null ? $_POST["usuario"] : "";
    $pass = isset($_POST["pass"]) != null ? $_POST["pass"] : "";

    $resultado = selectBD('SELECT * FROM usuario WHERE usr = "' . $usuario . '" AND pwd = "' . md5($pass) . '"');//Seleccionar el campo usNombre de la tabla usuarios
    if ($resultado){//Si $resultado != null, significa que si hay resultados del query.
        $fila = $resultado -> fetch_assoc();//Obtenemos los resultados de LA PRIMERA FILA y lo ponemos en $fila.

        $usuario = new Usuario();
        $usuario->idUser = $fila['idusuario'];
        $usuario->nombre = $fila['nombre'];
        $usuario->apellidoPaterno = $fila['ape_pat'];
        $usuario->apellidoMaterno = $fila['ape_mat'];
        $usuario->usuario = $fila['usr'];
        $usuario->isAdmin = $fila['usAdmin'];

        session_start();
        $_SESSION["user"] = serialize($usuario);

        echo '{"icon": "success", "title": "¡Éxito!", "text": "¡Bienvenido ' . $fila['nombre'] . '!"}';
    } else {
        echo '{"icon":"error","text":"Este usuario no está registrado o la contraseña es incorrecta.","title":"¡Ops!"}';
    }
    exit();