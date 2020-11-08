<?php
    require "../mysql.php";
    include "../Usuario.php";

    session_start();
    $user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $inSesion = isset($user) && isset($user->nombre);

    if ($inSesion == false) {
        error("Inicia sesión para poder registrar publicaciones.");
        exit();
    }

    $tema = isset($_POST["tema"]) != null ? $_POST["tema"] : "";
    $consulta = isset($_POST["consulta"]) != null ? $_POST["consulta"] : "";
    $idConsulta = isset($_POST["id_publicacion"]) != null ? $_POST["id_publicacion"] : "";

    //Si se editará la publicación....
    if ($idConsulta > 0) {
        if (updateDB("UPDATE consulta SET titulo='" . $tema . "', descripcion='" . $idConsulta . "' WHERE idconsulta='" . $idConsulta . "'")){
            success("Publicación editada!");
        } else {
            error("Hubo un error al editar la publicación.");
        }

        exit();
    }

    if (insertDB("INSERT INTO consulta (titulo, descripcion, id_usuario) VALUES('" . $tema . "','" . $consulta . "', '" . $user->idUser . "')")){
        success("Publicación registrada");
    } else {
        error("No se ha podido registrar la publicación.");
    }

    function error($msg)  {
        echo '{"icon":"error","text":"' . $msg . '","title":"¡Ops!"}';
    }

    function success($msg)  {
        echo '{"icon": "success", "title": "¡Éxito!", "text": "' . $msg . '"}';
    }
?>