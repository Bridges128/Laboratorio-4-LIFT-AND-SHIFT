<?php
// models/ContactoModel.php

class ContactoModel {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function guardarContacto($nombre) {
        try {
            $sql = "INSERT INTO contactos (nombre) VALUES (:nombre)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':nombre' => $nombre]);
        } catch (PDOException $e) {
            // En producción es mejor guardar esto en un log en vez de lanzarlo al usuario
            return false; 
        }
    }
}
