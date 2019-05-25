<?php

include_once 'Config.php';

$db = Db::getInstance();

class Transferencia {

    private $tableTransferencia;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->tableTransferencia = "transferencia";
    }

    public function getAll() {
        global $db;

        return $db->ejecutar("SELECT 
            t.id as transferencia_id,
            t.fecha as transferencia_fecha,
            t.cedula as transferencia_cedula,
            t.nombre as transferencia_nombre,
            t.monto transferencia_monto,
            t.estatus transferencia_estatus,
            t.cuenta as transferencia_cuenta,
            c.nombre as cuenta_nombre,
            c.cedula as cuenta_cedula,
            t.banco as transferencia_banco,
            b.nombre as banco_nombre 
            FROM transferencia t 
            JOIN cuenta c ON t.cuenta = c.id 
            JOIN banco b on c.banco = b.id 
            WHERE b.estatus = 1 ORDER by fecha
        ")->fetch_all(MYSQLI_ASSOC);
    }
    
    public function formatQueryAll($result) {
        $idTemporalp = -1;
        $idTemporaln = -1;
        $lengthP = 0;
        $lengthN = 0;
        $datos = [  "Realizadas" => [],
                    "Pendientes" => [],
                    "Nose" => []
                 ];

        foreach ($result as $Transfe) {
            $objeto = [
                "transferencia" => [
                    "id" => $Transfe["transferencia_id"],
                    "fecha" => $Transfe["transferencia_fecha"],
                    "cedula" => $Transfe["transferencia_cedula"],
                    "nombre" => $Transfe["transferencia_nombre"],
                    "monto" => $Transfe["transferencia_monto"],
                    "estatus" => $Transfe["transferencia_estatus"],
                    "cuenta" => []
                ],
                "cuenta" => [
                    "id" => $Transfe["transferencia_cuenta"],
                    "nombre" => $Transfe["cuenta_nombre"],
                    "cedula" => $Transfe["cuenta_cedula"],
                    "banco" => []
                ],
                "banco" => [
                    "id" => $Transfe["transferencia_banco"],
                    "nombre" => $Transfe["banco_nombre"],
                ]
            ]; 
            if ($idTemporalp != $Transfe["transferencia_id"]) {
                
                array_push($objeto["cuenta"]["banco"], $objeto["banco"]);
                array_push($objeto["transferencia"]["cuenta"], $objeto["cuenta"]);
                if($Transfe["transferencia_estatus"]==1){
                    array_push($datos["Realizadas"], $objeto["transferencia"]);
                }else if($Transfe["transferencia_estatus"]==2){
                    array_push($datos["Pendientes"], $objeto["transferencia"]);
                }else{
                    array_push($datos["Nose"], $objeto["transferencia"]);
                }
                
                $lengthP++;
            }
            else {
                array_push($objeto["cuenta"]["banco"], $objeto["banco"]);
                array_push($datos[$lengthP - 1]["cuenta"], $objeto["cuenta"]);
            }   
            $idTemporalp = $Transfe["transferencia_id"];
        }

        return $datos;
    }

    public function getCuentas(){
        global $db;

        return $db->ejecutar("SELECT c.*, 
        b.id as banco_id, 
        b.nombre as banco_nombre 
        FROM cuenta c 
        JOIN banco b ON c.banco=b.id 
        ORDER by c.id
        ")->fetch_all(MYSQLI_ASSOC);
    }

    public function formatQuerycuentas($result) {
        $idTemporalb = -1;
        $lengthb = 0;
        $datos = ["bancos"=>[]];

        foreach ($result as $cuenta) {
            $objeto = [
                "bancos" => [
                    "id" => $cuenta["banco_id"],
                    "nombre" => $cuenta["banco_nombre"],
                    "cuentas" => []
                ],
                "cuentas" => [
                    "id" => $cuenta["id"],
                    "nombre" => $cuenta["nombre"],
                    "cedula" => $cuenta["cedula"],
                    "cuenta" => $cuenta["cuenta"],
                    "telefono" => $cuenta["cuenta"],
                    "pago_movil" => $cuenta["pago_movil"],
                ]
            ]; 
            if ($idTemporalb != $cuenta["banco_id"]) {
                array_push($objeto["bancos"]["cuentas"], $objeto["cuentas"]);
                array_push($datos["bancos"], $objeto["bancos"]);
                $lengthb += 1; 
                $idTemporalb = $cuenta["banco_id"];       
            }   else {  
            array_push($datos["bancos"][$idTemporalb - 1]["cuentas"], $objeto["cuentas"]);
            
            }
        }
        return $datos;
    }

    public function insertTransferencia($cedula, $nombre, $monto, $banco, $cuenta, $estatus) {
        global $db;
        $data = array(
            'cedula' => $cedula,
            'nombre' => $nombre,
            'monto' => $monto,
            'banco' => $banco,
            'cuenta' => $cuenta,
            'estatus' => $estatus,
        );
        return $db->insertarRegistro($this->tableTransferencia, $data);
    }

    public function updateTransferencia($id,$cedula, $nombre, $monto, $banco, $cuenta, $estatus) {
        global $db;
        $data = array(
            'cedula' => $cedula,
            'nombre' => $nombre,
            'monto' => $monto,
            'banco' => $banco,
            'cuenta' => $cuenta,
            'estatus' => $estatus,
        );
        return $db->actualizarRegistro($this->tableTransferencia,$id,$data);
    }

}
