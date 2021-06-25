<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conexion
{
    public static function  conectar(){

        $serverName = '192.168.1.4\SQLEXPRESS'; //serverName\instanceName
        $database = 'IPSSALUDSOCIAL';
        $usuario='sa'; //serverName\instanceName
        $password='12345'; //serverName\instanceName

        $connectionInfo = array( "Database"=>$database, "UID"=>$usuario, "PWD"=>$password,  'CharacterSet' => 'UTF-8');
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        if( $conn ) {
            return $conn;
        }else {
			return 'error';
		}
    }




}
