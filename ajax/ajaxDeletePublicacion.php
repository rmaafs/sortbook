<?php
require "../mysql.php";
include "../Usuario.php";

session_start();
$user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
$inSesion = isset($user) && isset($user->nombre);

if ($inSesion == false) {
    error("Inicia sesión para poder eliminar publicaciones.");
    exit();
}

$idConsulta = isset($_POST['idConsulta']) ? $_POST['idConsulta'] : null;
$condicionExtra = "";
if (!$user->isAdmin) {
    $condicionExtra = " AND id_usuario = " . $user->idUser;
}

if (deleteDB("DELETE FROM consulta WHERE idconsulta='" . $idConsulta . "' " . $condicionExtra)) {
    success("Eliminado correctamente");
} else {
    error("No se pudo eliminar. ¿Tienes permisos?");
}


function error($msg)
{
    echo '{"icon":"error","text":"' . $msg . '","title":"¡Ops!"}';
}

function success($msg)
{
    echo '{"icon": "success", "title": "¡Éxito!", "text": "' . $msg . '"}';
}
