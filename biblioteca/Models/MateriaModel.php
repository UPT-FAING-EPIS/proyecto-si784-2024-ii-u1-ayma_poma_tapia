<?php
class MateriaModel extends Mysql{
    public $id, $ruc, $nombre, $telefono, $direccion;
    public function __construct()
    {
        parent::__construct();
    }
    public function selectMateria()
    {
        $sql = "SELECT * FROM materia";
        $res = $this->select_all($sql);
        return $res;
    }
    public function insertarMateria(String $nombre)
    {
        $this->nombre = $nombre;
        $query = "INSERT INTO materia(materia) VALUES (?)";
        $data = array($this->nombre);
        $this->insert($query, $data);
        return true;
    }
    public function editMateria(int $id)
    {
        $sql = "SELECT * FROM materia WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }
    public function actualizarMateria(String $nombre, int $id)
    {
        $this->nombre = $nombre;
        $this->id = $id;
        $query = "UPDATE materia SET materia = ? WHERE id = ?";
        $data = array($this->nombre, $this->id);
        $this->update($query, $data);
        return true;
    }
    public function eliminarMateria(int $id)
{
    $this->id = $id;
    $query = "DELETE FROM materia WHERE id=?";
    $data = array($this->id);
    $this->update($query, $data);
    return true;
}

}
?>