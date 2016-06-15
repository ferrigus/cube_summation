<?php

namespace App\Http\Requests;

class CubeSumPostRequest 
{
	private $arrayrules;
	private $arraymessages;
	private $matrizope;

	public function  __construct(){
		$this->arrayrules=array();
		$this->arraymessages=array();
		$this->matrizope=array();
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($cases,$input)
    {
		switch ($cases) {
			case 0: // RESTRICCIONES PARA EL CAMPO CASOS DE PRUEBA 
				array_push($this->arrayrules,'required|numeric|min:1|max:50'); 
				break;
			case 1:
				//$this->arrayrules=array();
				if(count($input)>1){
					for($i=0;$i<count($input);$i++){
						$this->matrizope=explode(" ",$input[1]);
						if($i==0){
							if(count($this->matrizope)!=2){
								array_push($this->arrayrules,'required|size:2');
							}else{
								
							}
						}
					}
				}else{
					array_push($this->arrayrules,'required');
				}
				/*for($i=0;$i<count($input);$i++){
					if($i==0){
						array_push($this->arrayrules,'required');
						'cantidadmatrizope'.$i.''=>'required|numeric|min:2|max:2', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
					'ultimobloque'.$i.''=>'required|numeric|min:1|max:100', // 1 <= N <= 100 -- ÚLTIMO BLOQUE DE LA MATRIZ
					'numoperaciones'.$i.''=>'required|numeric|min:1|max:1000', // 1 <= M <= 1000 -- NÚMERO DE OPERACIONES (UPDATE & QUERY)
					}
					array_push($this->arrayrules,'required');
					}
				}*/
				break;
			/*case 2:
				echo "i es igual a 2";
				break;*/
		}
		/*for($i=0;$i<$n;$i++){
			array_push($this->arrayrules,'required');
		}*/

		return $this->arrayrules;
		/*return [
			'title' => 'required',
			'body' => 'required',
		];*/
    }

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages($cases,$input)
	{
		switch ($cases) {
			case 0: // 1 <= T <= 50
				$this->arraymessages['0.required']='Error. Debes indicar la cantidad de Casos de Prueba.';
				$this->arraymessages['0.numeric']='Error. Los Casos de Prueba deben ser numericos.';
				$this->arraymessages['0.min']='Error. Los Casos de Prueba deben ser mayor a 1.';
				$this->arraymessages['0.max']='Error. Los Casos de Prueba deben ser menor a 50).';
			case 1:
				//$this->arraymessages=array();
				if(count($input)>1){
					for($i=0;$i<count($input);$i++){
						$this->matrizope=explode(" ",$input[1]);
						if($i==0){
							if(count($this->matrizope)!=2){
								$this->arraymessages['1.required']='Error Caso de Prueba 1, Campo 1. Debes indicar el numero de bloques y la cantidad de operaciones para el .';
								$this->arraymessages['1.size']='Error Caso de Prueba 1, Campo 1. Debes indicar 2 valores numericos separados por un espacio.';
							}
						}
					}
				}else{
					$this->arraymessages['1.required']='Error Caso de Prueba 1, Campo 1. Debes indicar el numero de bloques y la cantidad de operaciones para el Caso de Prueba 1.';
				}
				break;
			/*case 2:
				echo "i es igual a 2";
				break;*/
		}
		/*for($i=0;$i<$n;$i++){
			$this->arraymessages[$i.'.required']='A title is required';
		}*/

		return $this->arraymessages;
		/*return [
			'title.required' => 'A title is required',
			'body.required'  => 'A message is required',
		];*/
	}
}
