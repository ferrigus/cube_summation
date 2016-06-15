<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Curl;

class CubeSumProcessController extends Controller
{
    /**
     * Muestra el formulario para enviar al servicio de suma del cubo.
     *
     * @param  int  $id
     * @return Response
     */
    public function index()
    {
        //return view('index');
		return view('index', array('records' => null, 'errors' => null));
    }

	public function store(Request $request)
    {
		$arreglo=$request->all();
		$i=0;
		foreach ($arreglo as $key => $valor) {
			$campos[$i]=$valor;
			$i++;
		}
		$campos=explode("\r\n",$campos[0]);
		//dd($campos);
		$response = Curl::to('http://10.0.3.97/cubesum/public/cubesummation')
        ->withData($campos)
		->withOption('FAILONERROR', false)
		//->enableDebug('/var/www/html/cubesum/logFile.txt')
		->asJson(true)
		->withContentType('application/json')
        ->post();

		if($response['success']){
			$records=$response['data'];
			//dd($records);
			$errores=null;
		}else{
			$records=null;
			$errors=$response['message'];
			$i=0;
			foreach ($errors as $key1 => $valor1) {
				$errores[$i]=$valor1[0];
				$i++;
			}
		}
		return view('index', array('records' => $records, 'errors' => $errores))->with('old',$request->input('texto'));
    }
}
