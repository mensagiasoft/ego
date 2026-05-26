<?php

session_start();
include("conexion.php");

$usuario = $_POST['usuario'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM usuarios 
        WHERE usuario='$usuario' 
        AND password='$password'
        AND estado = '1'";

$resultado = $conn->query($sql);

if($resultado->num_rows > 0){

    $fila = $resultado->fetch_assoc();

    $_SESSION['id'] = $fila['id'];
    $_SESSION['usuario'] = $fila['usuario'];
    $_SESSION['nombre'] = $fila['nombre'];

    header("Location: sistema.php");

}else{

    header("Location: index.php?error=1");

}

?>