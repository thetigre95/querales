<?php
    session_start();

    include_once 'models/Encuesta.php';
    $objEncuesta = new Encuesta();
    
    $objeto = [];
    if (isset($_SESSION["id_empresa"])) {
        $result = $objEncuesta->getEstructuraRespuestasPorEmpresa($_SESSION["id_empresa"]);
        $objeto = $objEncuesta->formatQueryResultEstructuraToObject($result);
        //session_destroy();
    } else {
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="colorlib.com">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Asimet - Encuesta</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="assets/fonts/material-icon/css/material-design-iconic-font.min.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <!-- Main css -->
    <link rel="stylesheet" href="assets/css/style.css">

    <script src="assets/js/chartjs/Chart.min.js"></script>
</head>

<body>

    <div class="main">

        <div class="container">
            <div class="signup-content">
                <div class="signup-desc">
                    <div class="signup-desc-content">
                        <h2><span>Asimet </span>Asesorías</h2>
                        <p class="title">Mis Resultados</p>
                        <p class="desc" id="desc">
                            
                        </p>
                        <img src="assets/images/signup-img.jpg" alt="" class="signup-img">

                    </div>
                </div>
                <div class="signup-form-conent">
                    <form method="POST" id="signup-form" class="signup-form" enctype="multipart/form-data">

                        <canvas id="grafico"></canvas>

                        <div class="row">
                            <div class="col-xs-6 text-right">
                                <label for="promedioGeneral">Promedio General:</label>
                            </div>
                            <div class="col-xs-6 no-padding text-left">
                                <input class="form-control input-en-linea" type="text" name="promedioGeneral"
                                    id="promedioGeneral" required />
                            </div>
                            <div class="col-xs-6 text-right">
                                <label for="porcentaje">Porcentaje:</label>
                            </div>
                            <div class="col-xs-6 no-padding text-left">
                                <input class="form-control input-en-linea" type="text" name="porcentaje" id="porcentaje"
                                    required />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- JS -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="assets/vendor/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="assets/vendor/jquery-steps/jquery.steps.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="views/js/resultados.js"></script>

    <script>
        inicializarObjetoRespuestas(JSON.parse('<?= json_encode($objeto) ?>'));
        guardarDatosEmpresa('<?= $_SESSION["nombre_representante"] ?>', '<?= $_SESSION["nombre_empresa"] ?>', '<?= $_SESSION["email"] ?>', '<?= $_SESSION["telefono"] ?>');
    </script>

</body>

</html>