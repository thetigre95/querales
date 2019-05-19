<?php

/* Clase encargada de gestionar las conexiones a la base de datos */
Class Db {

    private $servidor = 'localhost';
    private $cliente = 'root';
    private $password = '';
    private $base_datos = 'querales';
    private $mysqli;

    static $_instance;

    public $tableTransferencia, $tableCliente, $tableBanco, $tableCuenta;
    /*La función construct es privada para evitar que el objeto pueda ser creado mediante new*/
    private function __construct() {
        $this->tableTransferencia = "transferencia";
        $this->tableCliente = "cliente";
        $this->tableBanco = "banco";
        $this->tableCuenta = "cuenta";
        $this->conectar();
    }

    /*Evitamos el clonaje del objeto. Patrón Singleton*/
    private function __clone() {}

    /*Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar desde fuera de la clase para instanciar el objeto, y así, poder utilizar sus métodos*/
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /*Realiza la conexión a la base de datos.*/
    private function conectar() {
        $this->mysqli = new mysqli($this->servidor, $this->cliente, $this->password, $this->base_datos);
        if ($this->mysqli->connect_error) {
            die("Conexión falló: " . $this->mysqli->connect_error);
        }
        $this->mysqli->set_charset("utf8");
    }

    /*Método para ejecutar una sentencia sql*/
    public function ejecutar($sql) {
        return $this->mysqli->query($sql);
    }

    /*Método para construir una sentencia INSERT sql*/
    public function insertarRegistro($tabla, $arrayValores) {
        $sql = "INSERT INTO $tabla " . $this->buildInsertColumnsValues($arrayValores);
        if ($this->ejecutar($sql)) {
            return $this->lastID();
        }
        return -1;
    }

    /*Función auxiliar para generar los valores por insertar para ser concatenados*/
    private function buildInsertColumnsValues($assocArray) {
        if (!isset($assocArray) || count($assocArray) == 0) {
            throw new Exception("Arreglo de valores a insertar no está inicializado o está vacío");
        }
        $delimiter = "";
        $fields = ""; // Columnas
        $values = ""; // Valores de cada columna
        foreach ($assocArray as $key => $value) {
            $fields .= $delimiter . $key;
            if (is_string($value)) {
                $values .= $delimiter . "'$value'";
            } else {
                $values .= $delimiter . $value;
            }
            $delimiter = ", ";
        }
        return "($fields) VALUES ($values)";
    }

    /*Devuelve el último id autoincrementado registrado por un INSERT*/
    public function lastID() {
        return $this->mysqli->insert_id;
    }

    /*Método para construir una sentencia INSERT sql de múltiples registros*/
    public function insertarMultiple($tabla, $arrayValores) {
        $sql = "INSERT INTO $tabla " . $this->buildInsertColumnsValuesMultiple($arrayValores);
        return $this->ejecutar($sql);
    }

    private function buildInsertColumnsValuesMultiple($arrayMultiple) {
        if (!isset($arrayMultiple) || count($arrayMultiple) == 0) {
            throw new Exception("Arreglo de valores a insertar no está inicializado o está vacío");
        }
        $delimiter = "";
        $fields = ""; // Columnas
        $values = ""; // Valores de cada columna
        foreach ($arrayMultiple[0] as $key => $value) {
            $fields .= $delimiter . $key;
            $delimiter = ", ";
        }
        $delimiter = "(";
        foreach ($arrayMultiple as $assocArray) {
            foreach ($assocArray as $key => $value) {
                if (is_string($value)) {
                    $values .= $delimiter . "'$value'";
                } else {
                    $values .= $delimiter . $value;
                }
                $delimiter = ", ";
            }
            $values .= ")";
            $delimiter = ", (";
        }
        return "($fields) VALUES $values";
    }

    /*Método para construir una sentencia UPDATE sql*/
    public function actualizarRegistro($tabla, $id, $arrayValores) {
        $sql = "UPDATE $tabla SET " . $this->buildUpdateFields($arrayValores) . " WHERE id = $id";
        return $this->ejecutar($sql); // Retorna TRUE si es exitoso, FALSE en caso contrario
    }

    /*Función auxiliar para generar los valores por actualizar para ser concatenados*/
    private function buildUpdateFields($assocArray) {
        if (!isset($assocArray) || count($assocArray) == 0) {
            throw new Exception("Arreglo de valores a actualizar no está inicializado o está vacío");
        }
        $str = "";
        $delimiter = "";
        foreach ($assocArray as $key => $value) {
            if (is_string($value)) {
                $str .= $delimiter . "$key = '$value'";
            } else {
                $str .= $delimiter . "$key = $value";
            }
            $delimiter = ", ";
        }
        return $str;
    }

}
?>