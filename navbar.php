<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container">

        <a class="navbar-brand" href="#">EGO SALON</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link <?=$active=="sistema" ? 'active' : '' ?>" href="/ego/sistema.php">Atención</a>
                </li>

                <?php
                if ($_SESSION['id'] == 1) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link <?=$active=="pagar" ? 'active' : '' ?>" href="/ego/modules/pagar/pagar.php">Pagar</a>
                    </li>

                    <!--<li class="nav-item">
                        <a class="nav-link" href="/ego/modules/servicios/servicios_productos.php">Servicios y Productos</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/ego/modules/dashboard/dashboard.php">Dashboard</a>
                    </li>-->
                <?php
                }
                ?>
            </ul>

            <ul class="navbar-nav">

                <li class="nav-item">
                    <span class="nav-link">👤 <?php echo $_SESSION['nombre']; ?></span>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-danger" href="/ego/logout.php">Cerrar sesión</a>
                </li>

            </ul>

        </div>

    </div>

</nav>