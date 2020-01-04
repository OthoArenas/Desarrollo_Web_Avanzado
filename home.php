<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header("location: index.php");
} else {
    $username = $_SESSION['user_id'];
}

?>
<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Práctica Desarrollo Web Avanzado">
        <meta name="author" content="Othoniel E. Salazar Arenas">
        <title>Desarrollo Web Avanzado</title>
        <!-- Carga de CSS para Bootstrap -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <!-- Carga de estilos personalizados -->
        <link href="css/style.css" rel="stylesheet">
    </head>
    <!-- Bienvenida a usuario -->
    <div class="container justify-content-center align-items-center mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="site-wrapper">
                <div class="site-wrapper-inner">
                    <div class="cover-container">
                        <div class="masthead clearfix">
                            <div class="inner">
</div>
                        </div>
                        <div class="container">
                            <h1 class="cover-heading text-center mb-5">Bienvenid@ <?php echo $username; ?></h1>
                            <div class="row text-center justify-content-center">
                                <form action="functions/functions.php" name="logout-form" method="post">
                                    <button class="btn btn-lg text-left btn-light logout-btn" type="submit" name="logout-btn">Cerrar Sesión</button>
                                </form>
                            </div>
                        </div>
                        <div class="mastfoot">
                            <div class="inner">
</div>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <footer class="text-center" style="font-size: 12px;">
                    <p class="mt-5 text-muted mb-1">© 2020&nbsp;Othoniel E. Salazar Arenas</p>
                    <p class="mt-1 mb-3 text-muted">Computación en el Servidor Web</p>
                </footer>
            </div>
        </div>
    </div>
    <!-- Script para acción de modales en pantalla -->
    <script>
    $(function() {
        $('[data-toggle="popover"]').popover();
    })
</script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
