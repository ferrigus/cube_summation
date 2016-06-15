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
	var $camposaux;
	var $camposaux2;
	var $matriz;
	var $postrquest;
	var $rules;
	var $messages;
	var $matrizope;
	var $operaciones;
	var $operacionesold;
	var $suma;
	var $mostrardatos;

	public function  __construct(){
		$this->array_input=array();
		$this->campos=array();
		$this->camposaux=array();
		$this->camposaux2=array();
		$this->matriz=new Matriz();
		$this->postrquest=new CubeSumPostRequest();
		$this->rules=array();
		$this->messages=array();
		$this->matrizope=array();
		$this->operaciones=array();
		$this->operacionesold=0;
		$this->suma=0;
		$this->mostrardatos=array();
	}
	public function showCubeSum(Request $request)
	{
		$this->array_input=$request->all();
		$i=0;
		$x = $y = $z = $x1 = $x2 = $y1 = $y2 = $z1 = $z2 = 0;
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

				if(count($this->campos)>1){

					if (array_key_exists($this->operacionesold+$i,$this->campos)){
						$this->matrizope=explode(" ",$this->campos[$this->operacionesold+$i]);
						$this->camposaux[0]=count($this->matrizope);
						if($this->camposaux[0]==2){
							$this->camposaux[1]=$this->matrizope[0];
							$this->camposaux[2]=$this->matrizope[1];
						}
					}else{
						$this->camposaux=array();
					}
				}
				$this->rules=$this->postrquest->rules(1, $this->camposaux);
				$this->messages=$this->postrquest->messages(1, $this->camposaux,$i);
				$validator = Validator::make($this->camposaux, $this->rules, $this->messages);

				if ($validator->fails()) {
					$errors = $validator->errors();
					return response()->json([
						'success' => false,
						'message' => $errors
					], 422);
				}else{
					$this->matriz->inicializarMatriz($this->camposaux[1]); //INICIALIZO LA MATRIZ
				}


				for($j=1;$j<=$this->camposaux[2];$j++){
					if (array_key_exists($this->operacionesold+$i+1,$this->campos)){
						//dd($this->campos[2]);
						$this->operaciones=explode(" ",$this->campos[$this->operacionesold+$i+1]);
						$this->camposaux2[0]=count($this->operaciones);

						if($this->camposaux2[0]==5 || $this->camposaux2[0]==7) {
							for($k=1;$k<=$this->camposaux2[0];$k++){
								$this->camposaux2[$k] = $this->operaciones[$k-1];
							}
							if($this->camposaux2[0]==5) {
								$y2=0;
								$z2=0;
							}else{
								$y2=$this->operaciones[5];
								$z2=$this->operaciones[6];
							}
						}else{
							$this->camposaux2[0]=2;
							$this->camposaux2[1]=0;
							$this->camposaux2[2]=0;
							$this->camposaux2[3]=0;
							$this->camposaux2[4]=0;
							$this->camposaux2[5]=0;
							$this->camposaux2[6]=0;
						}
					}else{
						$this->camposaux2[0]=2;
						$this->camposaux2[1]=0;
						$this->camposaux2[2]=0;
						$this->camposaux2[3]=0;
						$this->camposaux2[4]=0;
						$this->camposaux2[5]=0;
						$this->camposaux2[6]=0;
					}
					$this->operacionesold++;

					$this->rules=$this->postrquest->rules($this->camposaux2[0], $this->camposaux2,$this->camposaux[1],$this->camposaux2[2],$this->camposaux2[3],$this->camposaux2[4],$this->camposaux2[5],$y2,$z2);
					$this->messages=$this->postrquest->messages($this->camposaux2[0], $this->camposaux2,$i,$j);
					$validator = Validator::make($this->camposaux2, $this->rules, $this->messages);

					if ($validator->fails()) {
						$errors = $validator->errors();
						return response()->json([
							'success' => false,
							'message' => $errors
						], 422);
					}else{
						if($this->camposaux2[0]==5) {
							$this->matriz->updateBloque(
								$this->camposaux2[2],
								$this->camposaux2[3],
								$this->camposaux2[4],
								$this->camposaux2[5]
							);
						}else if($this->camposaux2[0]==7) {
							$this->suma=$this->matriz->sumatoria(
								$this->camposaux2[2],
								$this->camposaux2[3],
								$this->camposaux2[4],
								$this->camposaux2[5],
								$this->camposaux2[6],
								$this->camposaux2[7]
							);
							array_push($this->mostrardatos,$this->suma);
						}
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
			'data' => $this->mostrardatos
		], 200);
	}
}