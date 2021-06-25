<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consulta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiController extends Controller
{


    public function getconsultasomr(Request $request)
    {
        if(empty($request->codigo)){
            return response()->json(['status' => 'Codigo no es valido']);
        }
        $row=Consulta::consultarOMR($request->codigo);
        if(!empty($row)){
        $fechaNacimiento=Carbon::parse($row[14])->format('Y-m-d');
        $fechaSolicitud=Carbon::parse($row[2])->format('Y-m-d');
        $edad = Carbon::parse($fechaNacimiento)->age;
        $data=[
            'idDetalle'=>$row[0],
            'codigoOrdenMedica'=>$row[1],
            'fechaSolicitud'=>$fechaSolicitud,
            'admision'=>$row[3],
            'idUnidadFuncional'=>$row[4],
            'NombreUnidadFuncional'=>$row[5],
            'idEps'=>$row[6],
            'nombreEPS'=>$row[7],
            'idConvenio'=>$row[8],
            'nombreContrato'=>$row[9],
            'idPaciente'=>$row[10],
            'identificacion'=>$row[11],
            'nombre'=>$row[12],
            'sexo'=>$row[13],
            'fechaNacimiento'=>$fechaNacimiento,
            'edad'=>$edad,
            'idProcedimiento'=>$row[15],
            'cups'=>$row[16],
            'nombreProcedimiento'=>$row[17],
            'observacion'=>$row[18],
            'justificacion'=>$row[19],
            'codigoDiagnostico'=>$row[20],
            'nombreDiagnostico'=>$row[21],
            'origen'=>$row[22]
        ];
        return response()->json($data);
        }else{
            return response()->json(['status' => 'El codigo ingresado no es valido']);
        }
    }

    public function getactualizaromr(Request $request){
        if(empty($request->codigo)){
            return response()->json(['status' => 'Codigo no es valido']);
        }
        $validar=Consulta::validarCodigoFormulacion($request->codigo);
        if(!empty($validar)){
            $data=[
                'codigo'=>$request->codigo,
                'fechaCaptura'=>$request->fechaCaptura,
                'urlImagen'=>$request->urlImagen
            ];
            $query=Consulta::insertSQL($data);
            if($query){
                return response()->json(
                    ['status' => 'success',
                    'message'=>'Estudio Registrado Exitosamente'
                    ]);
            }else{
                return response()->json(
                    [   'status' => 'error',
                        'message'=>'No se registro la información'
                    ]);
            }

        }else{
            return response()->json([
                'status' => 'error',
                'message'=>'No hay información con el codigo ingresado'
            ]);
        }

    }

    public function getlecturaomr(Request $request){
        if(empty($request->codigo)){
            return response()->json(['status' => 'Codigo no es valido']);
        }
        $validar=Consulta::validarCodigoOculusRx($request->codigo);
        if(!empty($validar)){
            $data=[
                'codigo'=>$request->codigo,
                'tecnica'=>$request->tecnica,
                'hallazgos'=>$request->hallazgos,
                'conclusion'=>$request->conclusion,
                'fecha'=>$request->fecha,
                'identificacion'=>$request->identificacionRadiologo,
                'tipo'=>1
            ];
            $query=Consulta::updateSQL($data);
            if($query){
                return response()->json(
                    ['status' => 'success',
                    'message'=>'Estudio Registrado Exitosamente'
                    ]);
            }else{
                return response()->json(
                    ['status' => 'error',
                    'message'=>'No se registro la información'
                    ]);
            }

        }else{
            return response()->json([
                'status' => 'error',
                'message'=>'No hay información con el codigo ingresado'
            ]);
        }

    }

    public function getrechazos(Request $request){
        if(empty($request->codigo)){
            return response()->json(['status' => 'Codigo no es valido']);
        }
        $validar=Consulta::validarCodigoOculusRx($request->codigo);
        if(!empty($validar)){
            $data=[
                'codigo'=>$request->codigo,
                'motivo'=>$request->motivo,
                'observaciones'=>$request->observaciones,
                'fechaRechazo'=>$request->fechaRechazo,
                'fechaLectura'=>$request->fechaLectura,
                'identificacion'=>$request->identificacionRadiologo,
                'tipo'=>2
            ];
            $query=Consulta::updateSQL($data);
            if($query){
                return response()->json(
                    ['status' => 'success',
                    'message'=>'Estudio Registrado Exitosamente'
                    ]);
            }else{
                return response()->json(
                    ['status' => 'error',
                    'message'=>'No se registro la información'
                    ]);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'message'=>'No hay información con el codigo ingresado'
            ]);
        }

    }
}
