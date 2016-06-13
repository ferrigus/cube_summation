<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use App\Matriz;

class CubesumController extends Controller
{
	var $matriz;
    
    public function  __construct(){
        $this->matriz=new Matriz();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$matrizope = array();
		$operaciones = array();
		$matriziniciada = array();
		$mostrarsuma = 0;
		$mostrardatos = array();

		$validator = Validator::make($request->all(), [
			'casosprueba'=>'required|numeric|min:1|max:50', // 1 <= T <= 50
		]);

		//RESTRICCIONES
		if (!$validator->fails()) {
			for($i=1;$i<=$request->get('casosprueba');$i++){
				$matriziniciada = array();
				$mostrarsuma = 0;
				//$mostrardatos = array();
				$matrizope=explode(" ",$request->get('matrizope'.$i.''));
				$request['cantidadmatrizope'.$i.'']=count($matrizope);
				
				if(count($matrizope)==2){
					$request['ultimobloque'.$i.'']=$matrizope[0];
					$request['numoperaciones'.$i.'']=$matrizope[1];
				}

				$validator = Validator::make($request->all(), [
					'cantidadmatrizope'.$i.''=>'required|numeric|min:2|max:2', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
					'ultimobloque'.$i.''=>'required|numeric|min:1|max:100', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
					'numoperaciones'.$i.''=>'required|numeric|min:1|max:1000', // 1 <= M <= 1000 -- NÚMERO DE OPERACIONES (UPDATE & QUERY)
				]);

				if ($validator->fails()) {
					$errors = $validator->errors();
					return response()->json([
						'success' => false,
						'message' => $errors
					], 422);
				}else{
					$matriziniciada = $this->matriz->inicializarMatriz($request['ultimobloque'.$i.'']);
				}

				for($j=1;$j<=$matrizope[1];$j++){
					$operacion=explode(" ",$request->get('operacion'.$i."-".$j.''));
					$request['cantidadoperacion'.$i."-".$j.'']=count($operacion);
					if(strtoupper($operacion[0])=='UPDATE'){
						if(count($operacion)==5){
							$request['x'.$i."-".$j.'']=$operacion[1];
							$request['y'.$i."-".$j.'']=$operacion[2];
							$request['z'.$i."-".$j.'']=$operacion[3];
							$request['w'.$i."-".$j.'']=$operacion[4];
						}
						//dd($request['x'.$i."-".$j.'']);
						$validator = Validator::make($request->all(), [
							'cantidadoperacion'.$i."-".$j.''=>'required|numeric|min:5|max:5', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
							'x'.$i."-".$j.''=>' required|numeric|min:1|max:'.$request['ultimobloque'.$i.''].'', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
							'y'.$i."-".$j.''=>' required|numeric|min:1|max:'.$request['ultimobloque'.$i.''].'', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
							'z'.$i."-".$j.''=>' required|numeric|min:1|max:'.$request['ultimobloque'.$i.''].'', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
							'w'.$i."-".$j.''=>' required|numeric|min:'.pow(-10, 9).'|max:'.pow(10, 9).'', // -10^9 <= W <= 10^9 -- VALOR PARA CADA BLOQUE
						]);

						if ($validator->fails()) {
							$errors = $validator->errors();
							return response()->json([
								'success' => false,
								'message' => $errors
							], 422);
						}else{
							$updatebloque=$this->matriz->updateBloque(
								$request['x'.$i."-".$j.''],
								$request['y'.$i."-".$j.''],
								$request['z'.$i."-".$j.''],
								$request['w'.$i."-".$j.'']
							);
						}
						
					}elseif(strtoupper($operacion[0])=='QUERY'){
						if(count($operacion)==7){
							$request['x1'.$i."-".$j.'']=$operacion[1];
							$request['y1'.$i."-".$j.'']=$operacion[2];
							$request['z1'.$i."-".$j.'']=$operacion[3];
							$request['x2'.$i."-".$j.'']=$operacion[4];
							$request['y2'.$i."-".$j.'']=$operacion[5];
							$request['z2'.$i."-".$j.'']=$operacion[6];
						}
						

						$validator = Validator::make($request->all(), [
							'cantidadoperacion'.$i."-".$j.''=>'required|numeric|size:7', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
							'x1'.$i."-".$j.''=>' required|numeric|between:1,'.$request['x2'.$i."-".$j.''].'|max:'.$request['ultimobloque'.$i.''].'', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
							'y1'.$i."-".$j.''=>' required|numeric|between:1,'.$request['y2'.$i."-".$j.''].'|max:'.$request['ultimobloque'.$i.''].'', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
							'z1'.$i."-".$j.''=>' required|numeric|between:1,'.$request['z2'.$i."-".$j.''].'|max:'.$request['ultimobloque'.$i.''].'', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
							'x2'.$i."-".$j.''=>' required|numeric|min:'.$request['x1'.$i."-".$j.''].'|max:'.$request['ultimobloque'.$i.''].'', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
							'y2'.$i."-".$j.''=>' required|numeric|min:'.$request['y1'.$i."-".$j.''].'|max:'.$request['ultimobloque'.$i.''].'', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
							'z2'.$i."-".$j.''=>' required|numeric|min:'.$request['z1'.$i."-".$j.''].'|max:'.$request['ultimobloque'.$i.''].'', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
						]);

						if ($validator->fails()) {
							$errors = $validator->errors();
							return response()->json([
								'success' => false,
								'message' => $errors
							], 422);
						}else{
							$mostrarsuma=$this->matriz->sumatoria(
								$request['x1'.$i."-".$j.''],
								$request['y1'.$i."-".$j.''],
								$request['z1'.$i."-".$j.''],
								$request['x2'.$i."-".$j.''],
								$request['y2'.$i."-".$j.''],
								$request['z2'.$i."-".$j.'']
							);
							array_push($mostrardatos,$mostrarsuma);
						}


					}else{
							$errors = $validator->errors();
							return response()->json([
								'success' => false,
								'message' => "El campo debe empezar con UPDATE o QUERY"
							], 422);
					}
				}
				
			}


		}else{
			$errors = $validator->errors();
            return response()->json([
                'success' => false,
                'message' => $errors
            ], 422);
		}

		return response()->json([
			'success' => true,
			'data' => $mostrardatos
		], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
