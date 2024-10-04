<?php
class Autor extends Controllers {
    public function __construct() {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url());
        }
        parent::__construct();
    }

    public function autor() {
        $data = $this->model->selectAutor();         
        $this->views->getView($this, "listar", $data);
    }

    public function registrar() {
        $autor = htmlspecialchars($_POST['nombre']);
        $img = $_FILES['imagen'];
        $nombre = $img['name'];
        $nombreTemp = $img['tmp_name'];

        if (empty($nombre)) {
            // Si no se sube una imagen, usar imagen por defecto
            $insert = $this->model->insertarAutor($autor, "default-avatar.png");
        } else {
            // Sanitizar el nombre del archivo
            $nombreSeguro = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($nombre, PATHINFO_FILENAME));
            $fecha = md5(date("Y-m-d h:i:s")) . "_" . $nombreSeguro . '.' . pathinfo($nombre, PATHINFO_EXTENSION); // Generar nombre único

            $destino = "Assets/images/autor/" . $fecha;

            // Insertar autor en la base de datos
            $insert = $this->model->insertarAutor($autor, $fecha);
            if ($insert) {
                // Verificar el tipo de archivo permitido
                $tipoArchivo = mime_content_type($nombreTemp);
                $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];

                if (in_array($tipoArchivo, $tiposPermitidos)) {
                    move_uploaded_file($nombreTemp, $destino);
                } else {
                    die('Tipo de archivo no permitido.');
                }
            }
        }
        
        header("location: " . base_url() . "autor");
        die();
    }

    public function editar() {
        $id = intval($_GET['id']); // Sanitizar ID
        $data = $this->model->editAutor($id);
        if ($data == 0) {
            $this->autor();
        } else {
            $this->views->getView($this, "editar", $data);
        }
    }

    public function modificar() {
        $id = intval($_POST['id']); // Sanitizar ID
        $nombre = htmlspecialchars($_POST['nombre']);
        $img = $_FILES['imagen'];
        $imgName = $img['name'];
        $imgTmp = $img['tmp_name'];

        if (empty($imgName)) {
            // Si no se sube una nueva imagen, se mantiene la imagen antigua
            $imgAntigua = htmlspecialchars($_POST['foto']);
            $actualizar = $this->model->actualizarAutor($nombre, $imgAntigua, $id);
        } else {
            // Sanitizar el nombre del archivo
            $nombreSeguro = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($imgName, PATHINFO_FILENAME));
            $fecha = md5(date("Y-m-d h:i:s")) . "_" . $nombreSeguro . '.' . pathinfo($imgName, PATHINFO_EXTENSION); // Generar nombre único

            $destino = "Assets/images/autor/" . $fecha;
            $actualizar = $this->model->actualizarAutor($nombre, $fecha, $id);
            
            if ($actualizar) {
                // Verificar el tipo de archivo permitido
                $tipoArchivo = mime_content_type($imgTmp);
                $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];

                if (in_array($tipoArchivo, $tiposPermitidos)) {
                    move_uploaded_file($imgTmp, $destino);
                    $imgAntigua = htmlspecialchars($_POST['foto']);
                    if ($imgAntigua != "default-avatar.png") {
                        $this->eliminarImagen($imgAntigua);
                    }
                } else {
                    die('Tipo de archivo no permitido.');
                }
            }
        }
        
        header("location: " . base_url() . "autor");
        die();
    }

    private function eliminarImagen($nombreImagen) {
        // Sanitizar el nombre de la imagen antigua
        $imgAntiguaSanitizado = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($nombreImagen, PATHINFO_FILENAME));
        $imgAntiguaSanitizado .= '.' . strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION)); // Agregar extensión

        // Definir la ruta completa
        $filePath = "Assets/images/autor/" . $imgAntiguaSanitizado;

        // Verificar si el archivo existe
        if (file_exists($filePath)) {
            unlink($filePath);
        } else {
            error_log("Intento de eliminar archivo no encontrado: " . $filePath);
        }
    }

    public function eliminar() {
        $id = intval($_POST['id']); // Sanitizar ID
        $this->model->estadoAutor(0, $id);
        header("location: " . base_url() . "autor");
        die();
    }

    public function reingresar() {
        $id = intval($_POST['id']); // Sanitizar ID
        $this->model->estadoAutor(1, $id);
        header("location: " . base_url() . "autor");
        die();
    }
}
