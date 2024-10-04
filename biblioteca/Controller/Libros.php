<?php
class Libros extends Controllers {
    public function __construct() {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url());
        }
        parent::__construct();
    }

    public function libros() {
        $libro = $this->model->selectLibro();
        $materias = $this->model->selectMateria();
        $editorial = $this->model->selectEditorial();
        $autor = $this->model->selectAutor();
        $data = ['libros' => $libro, 'materias' => $materias, 'editoriales' => $editorial, 'autores' => $autor];
        $this->views->getView($this, "listar", $data);
    }

    public function registrar() {
        $titulo = htmlspecialchars($_POST['titulo']);
        $cantidad = intval($_POST['cantidad']);
        $autor = htmlspecialchars($_POST['autor']);
        $editorial = htmlspecialchars($_POST['editorial']);
        $anio_edicion = intval($_POST['anio_edicion']);
        $materia = htmlspecialchars($_POST['materia']);
        $num_pagina = intval($_POST['num_pagina']);
        $descripcion = htmlspecialchars($_POST['descripcion']);

        $img = $_FILES['imagen'];
        $imgName = $img['name'];
        $nombreTemp = $img['tmp_name'];

        // Validar y sanitizar el nombre del archivo
        if (!empty($imgName)) {
            $imgNameSeguro = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($imgName, PATHINFO_FILENAME));
            $imgNameSeguro = uniqid() . '-' . $imgNameSeguro . '.' . pathinfo($imgName, PATHINFO_EXTENSION); // Generar nombre único

            // Verificar el tipo de archivo permitido
            $tipoArchivo = mime_content_type($nombreTemp);
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];

            if (!in_array($tipoArchivo, $tiposPermitidos)) {
                die('Tipo de archivo no permitido.');
            }

            // Definir la ruta de destino
            $destino = "Assets/images/libros/" . $imgNameSeguro;

            // Insertar libro en la base de datos con la imagen
            $insert = $this->model->insertarLibro($titulo, $cantidad, $autor, $editorial, $anio_edicion, $materia, $num_pagina, $descripcion, $imgNameSeguro);
            
            if ($insert) {
                if (!move_uploaded_file($nombreTemp, $destino)) {
                    die('Error al subir el archivo.');
                }
            }
        } else {
            // Insertar libro con imagen por defecto
            $insert = $this->model->insertarLibro($titulo, $cantidad, $autor, $editorial, $anio_edicion, $materia, $num_pagina, $descripcion, "default-avatar.png");
        }

        header("location: " . base_url() . "libros");
        die();
    }

    public function editar() {
        $id = intval($_GET['id']); // Sanitizar ID
        $materias = $this->model->selectMateria();
        $editorial = $this->model->selectEditorial();
        $autor = $this->model->selectAutor();
        $libro = $this->model->editLibro($id);
        $data = ['materias' => $materias, 'editoriales' => $editorial, 'autores' => $autor, 'libro' => $libro];
        if ($data == 0) {
            $this->libros();
        } else {
            $this->views->getView($this, "editar", $data);
        }
    }

    public function modificar() {
        $id = intval($_POST['id']); // Sanitizar ID
        $titulo = htmlspecialchars($_POST['titulo']);
        $cantidad = intval($_POST['cantidad']);
        $autor = htmlspecialchars($_POST['autor']);
        $editorial = htmlspecialchars($_POST['editorial']);
        $anio_edicion = intval($_POST['anio_edicion']);
        $materia = htmlspecialchars($_POST['materia']);
        $num_pagina = intval($_POST['num_pagina']);
        $descripcion = htmlspecialchars($_POST['descripcion']);
    
        $img = $_FILES['imagen'];
        $imgName = $img['name'];
        $nombreTemp = $img['tmp_name'];
    
        // Obtener la imagen antigua
        $imgAntigua = $_POST['foto'];
    
        if (empty($imgName)) {
            // Si no se subió una nueva imagen, se mantiene la imagen antigua
            $actualizar = $this->model->actualizarLibro($titulo, $cantidad, $autor, $editorial, $anio_edicion, $materia, $num_pagina, $descripcion, $imgAntigua, $id);
        } else {
            // Sanitizar el nombre del archivo
            $imgNameSeguro = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($imgName, PATHINFO_FILENAME));
            $imgNameSeguro = uniqid() . '-' . $imgNameSeguro . '.' . strtolower(pathinfo($imgName, PATHINFO_EXTENSION)); // Generar nombre único y normalizar extensión
    
            // Verificar el tipo de archivo permitido
            $tipoArchivo = mime_content_type($nombreTemp);
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
    
            if (!in_array($tipoArchivo, $tiposPermitidos)) {
                die('Tipo de archivo no permitido.');
            }
    
            // Definir la ruta de destino
            $destino = "Assets/images/libros/" . $imgNameSeguro;
    
            // Actualizar libro en la base de datos con la nueva imagen
            $actualizar = $this->model->actualizarLibro($titulo, $cantidad, $autor, $editorial, $anio_edicion, $materia, $num_pagina, $descripcion, $imgNameSeguro, $id);
    
            if ($actualizar) {
                // Subir nueva imagen
                if (!move_uploaded_file($nombreTemp, $destino)) {
                    error_log("Error al subir el archivo: " . $imgName);
                    die('Ocurrió un error al procesar tu solicitud.');
                }
    
                // Eliminar la imagen antigua solo si no es la imagen por defecto
                if ($imgAntigua !== "default-avatar.png") {
                    $this->eliminarImagen($imgAntigua);
                }
            }
        }
    
        header("location: " . base_url() . "libros");
        die();
    }
    
    private function eliminarImagen($nombreImagen) {
        // Sanitizar el nombre de la imagen antigua
        $imgAntiguaSanitizado = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($nombreImagen, PATHINFO_FILENAME));
        $imgAntiguaSanitizado .= '.' . strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION)); // Agregar extensión
    
        // Definir la ruta completa
        $filePath = "Assets/images/libros/" . $imgAntiguaSanitizado;
    
        // Verificar si el archivo existe
        if (file_exists($filePath)) {
            unlink($filePath);
        } else {
            error_log("Intento de eliminar archivo no encontrado: " . $filePath);
        }
    }

    public function eliminar() {
        $id = intval($_POST['id']); // Sanitizar ID
        $this->model->estadoLibro(0, $id);
        header("location: " . base_url() . "libros");
        die();
    }

    public function reingresar() {
        $id = intval($_POST['id']); // Sanitizar ID
        $this->model->estadoLibro(1, $id);
        header("location: " . base_url() . "libros");
        die();
    }

    public function pdf() {
        $libros = $this->model->selectLibro();
        require_once 'Libraries/pdf/fpdf.php';
        $pdf = new FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetTitle("libros");
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(196, 5, "Libros", 1, 1, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(11, 5, utf8_decode('N°'), 1, 0, 'L');
        $pdf->Cell(100, 5, utf8_decode('Titulo'), 1, 0, 'L');
        $pdf->Cell(70, 5, utf8_decode('Autor'), 1, 0, 'L');
        $pdf->Cell(15, 5, 'Cant.', 1, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $contador = 1;
        foreach ($libros as $row) {
            $pdf->Cell(11, 5, $contador, 1, 0, 'L');
            $pdf->Cell(100, 5, utf8_decode($row['titulo']), 1, 0, 'L');
            $pdf->Cell(70, 5, utf8_decode($row['autor']), 1, 0, 'L');
            $pdf->Cell(15, 5, $row['cantidad'], 1, 1, 'L');
            $contador++;
        }
        $pdf->Output();
    }
}
