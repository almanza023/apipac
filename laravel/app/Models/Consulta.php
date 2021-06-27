<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{

    public static function consultarOMR($codigo)
    {
        $conn=Conexion::conectar();
        $sql="SELECT f.Autonumerico,codigo,fecha,f.rips,p.ccocod,f.servicio, r.Eps as ideps, e.Nombre as NombreEPS, c.Autonumerico as IdConvenio, r.ContratoE as NombreConvenio,Paciente IdPaciente,Paciente IdentificacionPaciente, u.NombreCompleto as NombrePaciente,
        u.sexo, u.FECHA_NACIMIENTO as fechaNacimiento ,'' EdadPaciente,Codigo Cups, Medicamento NombreRX,Dosificasion ObservacionOrden,'' JustificacionOrden,  d.DX as CodigoDiagnostico, d.DESCRIPCION as NombreDiagnostico, 'HC' Origen
        FROM            Formulacion f,  procencos  p, Usuarios u, RipsG r, EPSSI e, CONTRATOSIN c, Diagnosticoscie10 d, DXRips dxr
        WHERE u.AfCodigo=Paciente and r.Rips=f.Rips and e.codigoEps=r.Eps and c.NumeroC=r.ContratoE and d.DX=dxr.DXP and dxr.rips=f.rips  and   (F.Tipo =3)
        and f.servicio = p.cconom and f.rips>0 and f.servicio<>'Consulta Externa' and f.Rips>0 and u.AfCodigo=Paciente and dxr.Servicio=f.servicio  and f.Autonumerico='$codigo'
        ORDER BY f.Autonumerico DESC";
        $stmt = sqlsrv_query( $conn, $sql );
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC);
        return $row;

    }

    public static function actualizarOMR($codigo)
    {
        $conn=Conexion::conectar();
        $sql="SELECT f.Autonumerico,codigo,fecha,f.rips,p.ccocod,f.servicio, r.Eps as ideps, e.Nombre as NombreEPS, c.Autonumerico as IdConvenio, r.ContratoE as NombreConvenio,Paciente IdPaciente,Paciente IdentificacionPaciente, u.NombreCompleto as NombrePaciente,
        u.sexo, u.FECHA_NACIMIENTO as fechaNacimiento ,'' EdadPaciente,Codigo Cups, Medicamento NombreRX,Dosificasion ObservacionOrden,'' JustificacionOrden,  d.DX as CodigoDiagnostico, d.DESCRIPCION as NombreDiagnostico, 'HC' Origen
        FROM            Formulacion f,  procencos  p, Usuarios u, RipsG r, EPSSI e, CONTRATOSIN c, Diagnosticoscie10 d, DXRips dxr

        WHERE u.AfCodigo=Paciente and r.Rips=f.Rips and e.codigoEps=r.Eps and c.NumeroC=r.ContratoE and d.DX=dxr.DXP and dxr.rips=f.rips  and   (F.Tipo =3)
        and f.servicio = p.cconom and f.rips>0 and f.servicio<>'Consulta Externa' and f.Rips>0 and u.AfCodigo=Paciente and dxr.Servicio=f.servicio  and f.Autonumerico='$codigo'

        ORDER BY f.Autonumerico DESC";
        $stmt = sqlsrv_query( $conn, $sql );
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC);
        return $row;

    }

    public static function validarCodigoFormulacion($codigo)
    {
        $conn=Conexion::conectar();
        $sql="SELECT Autonumerico FROM Formulacion  where Autonumerico=$codigo";
        $stmt = sqlsrv_query( $conn, $sql );
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC);
        return $row;

    }

    public static function validarCodigoOculusRx($codigo)
    {
        $conn=Conexion::conectar();
        $sql="SELECT codigo FROM oculusrx  where codigo=$codigo";
        $stmt = sqlsrv_query( $conn, $sql );
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC);
        return $row;

    }

    public static function insertSQL($data)
    {
        $conn=Conexion::conectar();
        $codigo=$data['codigo'];
        $fecha=$data['fechaCaptura'];
        $url=$data['urlImagen'];
        $sql="INSERT INTO oculusrx (codigo, FechaCapturaRadiografia, UrlImagenRadiografia) VALUES ('$codigo', '$fecha', '$url')";
        $stmt = sqlsrv_query( $conn, $sql );
        return $stmt;

    }

    public static function updateSQL($data)
    {
        $conn=Conexion::conectar();
        $codigo=$data['codigo'];
        $tipo=$data['tipo'];
        $identificacion=$data['identificacion'];


        if($tipo==1){
        $tecnica=$data['tecnica'];
        $hallazgos=$data['hallazgos'];
        $conclusion=$data['conclusion'];
        $fecha=$data['fecha'];
        $sql="UPDATE oculusrx SET tecnicadelestudio='$tecnica', hallazgosdelestudio='$hallazgos', conclusiondelestudio='$conclusion', fechalectura='$fecha',
        identificacionlectura='$identificacion' where codigo='$codigo' ";
        }
        if($tipo==2){
        $motivo=$data['motivo'];
        $observaciones=$data['observaciones'];
        $fechaRechazo=$data['fechaRechazo'];
        $fechaLectura=$data['fechaLectura'];
            $sql="UPDATE oculusrx SET fecharechazo='$fechaRechazo', motivorechazo='$motivo', observaciones='$observaciones',
            fechalectura='$fechaLectura', identificacionrechazo='$identificacion' where codigo='$codigo' ";
        }
        $stmt = sqlsrv_query( $conn, $sql );
        return $sql;

    }



}
