<?php
    require "../mysql.php";
    include "../Usuario.php";

    session_start();
    $user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $inSesion = isset($user) && isset($user->nombre);

    if ($inSesion == false) {
        error("Inicia sesión para poder registrar comentarios.");
        exit();
    }

    $idConsulta = isset($_POST['idConsulta']) ? $_POST['idConsulta'] : null;
    $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : null;

    if (insertDB("INSERT INTO respuesta (respuesta, id_consulta, id_usuario) VALUES('" . $comentario . "','" . $idConsulta . "', '" . $user->idUser . "')")){
        success("Comentario registrado");
    } else {
        error("No se ha podido registrar el comentario.");
    }

    function error($msg)  {
        echo '{"icon":"error","text":"' . $msg . '","title":"¡Ops!"}';
    }

    function success($msg)  {
        echo '{"icon": "success", "title": "¡Éxito!", "text": "' . $msg . '"}';
    }
