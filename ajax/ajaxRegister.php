<?php
    require "../mysql.php";

    $nombre = isset($_POST["nombre"]) != null ? $_POST["nombre"] : "";
    $apePat = isset($_POST["ape_pat"]) != null ? $_POST["ape_pat"] : "";
    $apeMat = isset($_POST["ape_mat"]) != null ? $_POST["ape_mat"] : "";
    $usuario = isset($_POST["usuario"]) != null ? $_POST["usuario"] : "";
    $pass = isset($_POST["pass"]) != null ? $_POST["pass"] : "";
    $pass2 = isset($_POST["pass2"]) != null ? $_POST["pass2"] : "";
    if ($nombre == "") {
        error("El nombre no puede estar vacío");
        return;
    } else if ($apePat == "") {
        error("El apellido paterno no puede estar vacío");
        return;
    } else if ($apeMat == "") {
        error("El apellido materno no puede estar vacío");
        return;
    } else if ($usuario == "") {
        error("El usuario no puede estar vacío");
        return;
    } else if ($pass == "") {
        error("La contraseña no puede estar vacía");
        return;
    } else if ($pass != $pass2) {
        error("Las contraseñas no coinciden");
        return;
    }

    //Verificamos si el correo ya está registrado
    $resultado = selectBD("SELECT idusuario FROM usuario WHERE usr = '" . $usuario . "'");//Seleccionar el campo usNombre de la tabla usuarios
    if ($resultado){//Si $resultado != null, significa que si hay resultados del query.
        $fila = $resultado -> fetch_assoc();
        error("Este usuario ya ha sido registrado");
        return;
    }

    if (insertDB("INSERT INTO usuario (nombre, ape_pat, ape_mat, usr, pwd) VALUES('" . $nombre . "','" . $apePat . "', '" . $apeMat . "', '" . $usuario . "', '" . md5($pass) . "')")){
        success("Bienvenid@ " . $nombre);
    } else {
        error("No se ha podido registrar.");
    }
    

    function error($msg)  {
        echo '{"icon":"error","text":"' . $msg . '","title":"¡Ops!"}';
    }

    function success($msg)  {
        echo '{"icon": "success", "title": "¡Éxito!", "text": "' . $msg . '"}';
    }
?>