<?php

abstract class ConexDBMySQL {

    protected $servidor;
    protected $base;
    protected $conexion;

    public function __construct($servidor, $base, $loginDB, $passwordDB) {
        $this->servidor = $servidor;
        $this->base = $base;
        try {
            $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''); //formato de codificación de caracteres
            
            $dsn = "mysql:dbname=" . $this->base . ";host=" . $this->servidor;
            $this->conexion = new PDO($dsn, $loginDB, $passwordDB,$options);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } catch (Exception $exc) {
            echo "Error de conexión" . $exc->getMessage();
        }
    }

    public function cierreDB() {
        ;
    }

}

?>