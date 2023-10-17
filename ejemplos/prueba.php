<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Bonito con Bootstrap 3</title>
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilo para el encabezado */
        .dashboard-header {
            background-color: #293737;
            color: #fff;
            padding: 20px;
        }

        /* Estilo para el panel de control */
        .dashboard-panel {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        /* Estilo para los botones de acción */
        .action-button {
            background-color: #337ab7;
            color: #fff;
        }

        /* Estilo para las tarjetas o cuadros de resumen */
        .dashboard-card {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dashboard-header">
            <h1>Panel de Control Bonito</h1>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="dashboard-panel">
                    <h2>Resumen</h2>
                    <p>Información general de tu panel de control.</p>
                    <button class="btn action-button">Ver Detalles</button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-panel">
                    <h2>Estadísticas</h2>
                    <p>Gráficos y estadísticas importantes.</p>
                    <button class="btn action-button">Ver Estadísticas</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h3>Tarjeta de Resumen 1</h3>
                    <p>Contenido de la tarjeta de resumen.</p>
                </div>
                <div class="dashboard-card">
                    <h3>Tarjeta de Resumen 2</h3>
                    <p>Contenido de la tarjeta de resumen.</p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
</body>
</html>
