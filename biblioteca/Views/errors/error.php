<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Página no encontrada</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Estilos generales */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Contenedor del fondo de imagen */
        .background-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .background-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(5px); /* Ajusta el valor de desenfoque según tus preferencias */
        }

        /* Contenedor del error */
        .error-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative; /* Agregado */
            z-index: 1; /* Agregado - Coloca el contenido por encima de la imagen de fondo */
        }

        /* Contenido del error */
        .error-content {
            text-align: center;
            padding: 20px;
        }

        .error-content h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .error-content p {
            font-size: 18px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .error-content .home-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            font-size: 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .error-content .home-link:hover {
            background-color: #555;
        }

        .error-content .error-icon {
            font-size: 100px;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="background-container">
        <img src="https://chaospin.com/wp-content/uploads/2021/01/aurora-aksnes-photos-for-new-album.jpg" alt="Background Image">
    </div>

    <div class="error-container">
        <div class="error-content">
            <i class="fas fa-exclamation-triangle error-icon"></i>
            <h1>Error 404</h1>
            <p>Lo sentimos, la página que estás buscando no pudo ser encontrada.</p>
            <a href="<?php echo base_url(); ?>admin/listar" class="home-link">Volver a la página de inicio</a>
        </div>
    </div>
</body>

</html>
