<?php

namespace App\Repos;
use App\Db\Conn;
use PDO;

class EmpresaRepo{
    private $db;
    public function __construct() {
        $this->db = Conn::getInstance();
    }

    public function getAll(string $search = '') {

        $sql = "SELECT * FROM empresa WHERE deleted_at IS NULL";
        $params = [];
        if(!empty($search)){
            if(is_numeric($search)) {
                $sql .= " AND id_empresa LIKE :search"; ;
                $params[':search'] = "%$search%";
            } else {
                $sql .= " AND razon_social LIKE :search";
                $params[':search'] = "%$search%";
            }
        }
        $sql .= " ORDER BY fecha_creacion DESC ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM empresa WHERE id_empresa = :id AND deleted_at IS NULL");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data) {
        $stmt = $this->db->prepare("INSERT INTO empresa (rif, razon_social, direccion, telefono) VALUES (:rif, :razon_social, :direccion, :telefono)");
        return $stmt->execute([
            ':rif' => $data['rif'],
            ':razon_social' => $data['razon_social'],
            ':direccion' => $data['direccion'],
            ':telefono' => $data['telefono']
        ]);
         
    }

    public function update(int $id, array $data) {
        $stmt = $this->db->prepare("UPDATE empresa SET rif = :rif, razon_social = :razon_social, direccion = :direccion, telefono = :telefono WHERE id_empresa = :id AND deleted_at IS NULL");
        return $stmt->execute([
            ':rif' => $data['rif'],
            ':razon_social' => $data['razon_social'],
            ':direccion' => $data['direccion'],
            ':telefono' => $data['telefono'],
            ':id' => $id
        ]);
    }

    public function delete(int $id) {
        $stmt = $this->db->prepare("UPDATE empresa SET deleted_at = NOW() WHERE id_empresa = :id AND deleted_at IS NULL");
        return $stmt->execute([':id' => $id]);
    }

    public function rifExists(string $rif, ?int $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM empresa WHERE rif = :rif AND deleted_at IS NULL";
        $params = [':rif' => $rif];
        if($excludeId !== null) {
            $sql .= " AND id_empresa != :id";
            $params[':id'] = $excludeId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }



}