<?php
session_start();

/* Si ya hay sesión activa redirige al sistema */
if (isset($_SESSION['usuario'])) {
    header("Location: sistema.php");
    exit();
}

$error = "";

if (isset($_GET['error'])) {
    $error = "El usuario o la contraseña son incorrectas";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Ego Salon</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

    <div class="container login-container d-flex justify-content-center align-items-center">

        <div class="card shadow p-4" style="max-width:420px; width:100%;">

            <div class="text-center mb-3">

                <div class="logo-container">
                    <img src="assets/logo1.png" class="logo">
                </div>

            </div>

            <h4 class="text-center mb-4">Iniciar Sesión</h4>

            <?php if ($error != "") { ?>

                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>

            <?php } ?>

            <form action="login.php" method="POST">

                <div class="mb-3">
                    <label class="form-label">Usuario</label>
                    <input type="text" name="usuario" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        Iniciar Sesión
                    </button>
                </div>

            </form>

        </div>

    </div>

</body>

</html>