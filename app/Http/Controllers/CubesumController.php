<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CubeSumPostRequest;
use Validator;
use App\Matriz;
class CubesumController extends Controller
{
	var $array_input;
	var $campos;
	var $matriz;
	var $postrquest;
	var $rules;
	var $messages;


	public function  __construct(){
		$this->array_input=array();
		$this->campos=array();
		$this->matriz=new Matriz();
		$this->postrquest=new CubeSumPostRequest();
		$this->rules=array();
		$this->messages=array();
	}
	public function showCubeSum(Request $request)
	{
		$this->array_input=$request->all();
		$i=0;
		foreach ($this->array_input as $key => $valor) {
			$this->campos[$i]=$valor;
			$i++;
		}
		if(count($this->campos)==0){
			return response()->json([
				'success' => false,
				'message' => "Error. Ninguna informacion fue suministrada."
			], 422);
		}else{
			$this->rules=$this->postrquest->rules(0, $this->campos);
			$this->messages=$this->postrquest->messages(0, $this->campos);
			$validator = Validator::make($this->campos, $this->rules, $this->messages);
		}
		//RESTRICCIONES
		if (!$validator->fails()) {
			for($i=1;$i<=$this->campos[0];$i++){
				$mostrarsuma = 0;
				//$mostrardatos = array();
				//$matrizope=explode(" ",$request->get('matrizope'.$i.''));
				//$matrizope=explode(" ",$this->campos[$i]);
				//dd($this->campos[$i]);
				$this->rules=$this->postrquest->rules(1, $this->campos);
				//dd($this->rules);
				$this->messages=$this->postrquest->messages(1, $this->campos);
				$validator = Validator::make($this->campos, $this->rules, $this->messages);
				//$request['cantidadmatrizope'.$i.'']=count($matrizope);

				/*if(count($matrizope)==2){
					$request['ultimobloque'.$i.'']=$matrizope[0];
					$request['numoperaciones'.$i.'']=$matrizope[1];
				}
				$validator = Validator::make($request->all(), [
					'cantidadmatrizope'.$i.''=>'required|numeric|min:2|max:2', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
					'ultimobloque'.$i.''=>'required|numeric|min:1|max:100', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
					'numoperaciones'.$i.''=>'required|numeric|min:1|max:1000', // 1 <= M <= 1000 -- NÚMERO DE OPERACIONES (UPDATE & QUERY)
				]);*/
				if ($validator->fails()) {
					$errors = $validator->errors();
					return response()->json([
						'success' => false,
						'message' => $errors
					], 422);
				}else{
					$this->matriz->inicializarMatriz($request['ultimobloque'.$i.'']); //INICIALIZO LA MATRIZ
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
}