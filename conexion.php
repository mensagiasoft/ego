<?php

$host = "localhost";
$user = "juanvil2_admin";
$pass = "Siniestro07!";
$db = "juanvil2_ego_salon";

/*$host = "localhost";
$user = "root";
$pass = "";
$db = "ego_salon";*/

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>