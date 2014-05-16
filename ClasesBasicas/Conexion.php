<?php
/**
 * Archivo para generar la conexion con la base de datos
 * @copyright  Copyright (c) 2010 INFORMATICA MINISTERIO DE SALUD
 * @version    1.0
 * @since      File available since Release 1.0
*/

class Conexion  // se declara una clase para hacer la conexion con la base de datos
{
    protected  $server;    // servidor
    protected $user;  // usuario
    protected $pass;  // clave
    private $con;   // conexion

    // se definen los datos del servidor de base de datos
    //public function Conexion($server='10.106.20.3',$user='root',$pass='root')	{
	public function Conexion($server='localhost',$user='root',$pass='lepaBloski13')	{

        // crea la conexion pasandole el servidor , usuario y clave
        if (!($conect=mysql_connect($server,$user,$pass)))
        {
            echo "Error conectando a la base de datos.";
            exit();
        }        
        $this->con=$conect;
    }

    //// devuelve la conexion
    public function getConexion() {
	return $this->con;
    }

    //// cierra la conexion
    public function Close()  {
        mysql_close($this->con);
    }

}