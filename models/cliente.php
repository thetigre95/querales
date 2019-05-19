<?php

include_once 'Config.php';

$db = Db::getInstance();

class cliente {

    public function __construct() {
    
    }

    public function getAll() {
        global $db;

        return $db->ejecutar("SELECT * FROM $db->tableCliente")->fetch_all(MYSQLI_ASSOC);
    }

    public function getcliente($ci){
        global $db;

        return $db->ejecutar("SELECT *
        FROM $db->tableCliente 
        WHERE cedula = $ci
        ")->fetch_assoc();
    }

    public function insertcliente($cedula, $nombres, $apellidos, $direccion) {
        global $db;
        $data = array(
            'cedula' => $cedula,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'direccion' => $direccion,
            'estatus' => 1,
        );
        return $db->insertarRegistro($db->tableCliente, $data);
    }

}
