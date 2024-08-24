<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>Assets/css/styles.css" id="theme-stylesheet">

    <style>
        body, html {
            height: 100%;
            
        }

        body {
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background: url("Assets/videos/Aurora.mp4");
            background-repeat: no-repeat;
            background-size: cover;
        }

        video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        

        p, h3{
            color: white;
        }

        #layoutAuthentication_content{
            width: 100%;
        }

        .card-header {
            background-color: black;
        }

        .card-body {
            background-color: black;
        }

        .custom-btn {
            background-color: black;
            color: white;
        }

        .custom-btn:hover {
            background-color: white;
            color: black;
        }

        .custom-container {
            margin-left: -100px;
            margin-right: auto;
            max-width: 700px;
        }
        #background-video {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
        }
    </style>

</head>

<body>

<video src="Assets/videos/Aurora.mp4" autoplay loop muted></video>

    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
        <?php if (isset($_GET['msg'])) { ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Alerta',
                text: 'Usuario o contraseña incorrecta',
                timer: 3000,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                allowClose: false,
                showCancelButton: false,
                showCloseButton: false
            });
        });
    </script>
<?php } ?>



            <main>
                <div class="container custom-container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-10">
                            <div class="card border-0 rounded-lg mt-5 sb-sidenav-dark">
                                <div class="card-body">
                                    <img class="img-thumbnail" src="<?php echo base_url(); ?>Assets/images/fondo.webp">
                                    <br><br>
                                    <form action="<?php echo base_url(); ?>Usuarios/login" method="post" autocomplete="off">
                                        <div class="form-group">
                                            <center><h6>Usuario</h6></center>
                                            <br>
                                            <input id="usuario" class="form-control" type="text" name="usuario" placeholder="Usuario">
                                        </div>
                                        <div class="form-group">
                                            <center><h6>Contraseña</h6></center>
                                            <br>
                                            <input id="clave" class="form-control" type="password" name="clave" placeholder="Contraseña">
                                        </div>
                                        <br>
                                        <button class="btn btn-primary btn-block custom-btn" type="submit">Iniciar Sesion</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>Assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>Assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>Assets/js/scripts.js"></script>
    <script>
        $(document).ready(function() {
            $('#errorPass').toast('show');
        });
    </script>
</body>

</html>
