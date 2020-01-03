<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Práctica Desarrollo Web Avanzado">
    <meta name="author" content="Othoniel E. Salazar Arenas">
    <title>Signin Template for Bootstrap</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
</head>

<div class="container justify-content-center align-items-center">
    <div class="row justify-content-center align-items-center">
        <div class="site-wrapper">
            <div class="site-wrapper-inner">
                <div class="cover-container">
                    <div class="masthead clearfix">
                        <div class="inner">
                        </div>
                    </div>
                    <div class="inner cover">
                        <h1 class="cover-heading text-center mb-5">Bienvenid@ &lt;?php echo $username; ?&gt;</h1>
                        <p class="lead text-center"> <a href="#" class="btn btn-lg text-left btn-light logout-btn">Cerrar Sesión</a> </p>
                    </div>
                    <div class="mastfoot">
                        <div class="inner">
                        </div>
                    </div>
                </div>
            </div>
            <footer class="text-center">
                <p class="mt-5 mb-3 text-muted">© 2020&nbsp;Othoniel E. Salazar Arenas</p>
                <p class="mt-1 mb-3 text-muted">Computación en el Servidor Web</p>
            </footer>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('[data-toggle="popover"]').popover();
    })
</script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>