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
    public function rules($cases,$input,$n=0,$x1=0,$y1=0,$z1=0,$x2=0,$y2=0,$z2=0)
    {
		switch ($cases) {
			case 0: // RESTRICCIONES PARA EL CAMPO CASOS DE PRUEBA 
				array_push($this->arrayrules,'required|numeric|min:1|max:50'); 
				break;
			case 1:
				$this->arrayrules=array();
				array_push($this->arrayrules,'required|numeric|size:2');
				array_push($this->arrayrules,'required|numeric|min:1|max:100');
				array_push($this->arrayrules,'required|numeric|min:1|max:1000');
				break;
			case 2:
				$this->arrayrules=array();
				array_push($this->arrayrules,'required|in:UPDATE,update,QUERY,query');
				break;
			case 5:
				$this->arrayrules=array();
				array_push($this->arrayrules,'required');
				array_push($this->arrayrules,'required|in:UPDATE');
				array_push($this->arrayrules,'required|numeric|min:1|max:'.$n.'');
				array_push($this->arrayrules,'required|numeric|min:1|max:'.$n.'');
				array_push($this->arrayrules,'required|numeric|min:1|max:'.$n.'');
				array_push($this->arrayrules,'required|numeric|min:'.pow(-10, 9).'|max:'.pow(10, 9).'');

				break;
			case 7:
				$this->arrayrules=array();
				array_push($this->arrayrules,'required');
				array_push($this->arrayrules,'required|in:QUERY');
				array_push($this->arrayrules,'required|numeric|between:1,'.$x2.'|max:'.$n.'');
				array_push($this->arrayrules,'required|numeric|between:1,'.$y2.'|max:'.$n.'');
				array_push($this->arrayrules,'required|numeric|between:1,'.$z2.'|max:'.$n.'');
				array_push($this->arrayrules,'required|numeric|min:'.$x1.'|max:'.$n.'');
				array_push($this->arrayrules,'required|numeric|min:'.$y1.'|max:'.$n.'');
				array_push($this->arrayrules,'required|numeric|min:'.$z1.'|max:'.$n.'');

				break;
		}

		return $this->arrayrules;
    }

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages($cases,$input,$line=null,$operacion=null)
	{
		switch ($cases) {
			case 0:
				$this->arraymessages['0.required']='Error. Debes indicar la cantidad de Casos de Prueba.';
				$this->arraymessages['0.numeric']='Error. Los Casos de Prueba deben ser numericos.';
				$this->arraymessages['0.min']='Error. Los Casos de Prueba deben ser mayor a 1.';
				$this->arraymessages['0.max']='Error. Los Casos de Prueba deben ser menor a 50).';
				break;
			case 1:
				$this->arraymessages=array();
				$this->arraymessages['0.required']='Error (Caso de prueba '.$line.'). Debes indicar el numero de bloques y la cantidad de operaciones.';
				$this->arraymessages['0.size']='Error (Caso de prueba '.$line.'). Debes indicar 2 valores numericos separados por un espacio.';
				$this->arraymessages['0.numeric']='Error (Caso de prueba '.$line.'). N y M deben ser numeros.';

				$this->arraymessages['1.required']='Error (Caso de prueba '.$line.'). Debes indicar los bloques de la matriz.';
				$this->arraymessages['1.numeric']='Error (Caso de prueba '.$line.'). Los bloques se definen con un numero.';
				$this->arraymessages['1.min']='Error (Caso de prueba '.$line.'). El numero para definir el ultimo bloque de la matriz deben ser mayor o igual a 1.';
				$this->arraymessages['1.max']='Error (Caso de prueba '.$line.'). El numero para definir el ultimo bloque de la matriz deben ser menor o igual a 100).';

				$this->arraymessages['2.required']='Error (Caso de prueba '.$line.'). Debes indicar la cantidad de operaciones.';
				$this->arraymessages['2.numeric']='Error (Caso de prueba '.$line.'). La cantidad de operaciones se definen con un numero.';
				$this->arraymessages['2.min']='Error (Caso de prueba '.$line.'). La cantidad de operaciones deben ser mayor a 1.';
				$this->arraymessages['2.max']='Error (Caso de prueba '.$line.'). La cantidad de operaciones deben ser menor a 1000).';
				break;
			case 2:
				$this->arraymessages=array();
				$this->arraymessages['0.in']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). Revisar el formato de la operacion.';
				break;
			case 5:
				$this->arraymessages=array();
				$this->arraymessages['0.required']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). Error en formato.';

				$this->arraymessages['1.required']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'';
				$this->arraymessages['1.in']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'. La operacion debe iniciar con las palabra UPDATE.';

				$this->arraymessages['2.required']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.')';
				$this->arraymessages['2.numeric']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'. El valor de x debe ser numerico.';
				$this->arraymessages['2.min']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de x debe ser mayor o igual a uno';
				$this->arraymessages['2.max']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de x excede el numero definido para el ultimo bloque.';

				$this->arraymessages['3.required']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.')';
				$this->arraymessages['3.numeric']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'. El valor de y debe ser numerico.';
				$this->arraymessages['3.min']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de y debe ser mayor o igual a uno';
				$this->arraymessages['3.max']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de y excede el numero definido para el ultimo bloque.';

				$this->arraymessages['4.required']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.')';
				$this->arraymessages['4.numeric']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'. El valor de z debe ser numerico.';
				$this->arraymessages['4.min']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de z debe ser mayor o igual a uno';
				$this->arraymessages['4.max']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de z excede el numero definido para el ultimo bloque.';

				$this->arraymessages['5.required']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.')';
				$this->arraymessages['5.numeric']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'. El valor de w debe ser numerico.';
				$this->arraymessages['5.min']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de w debe ser mayor o igual a '.pow(-10, 9).'';
				$this->arraymessages['5.max']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de w debe ser menor o igual a '.pow(10, 9).'';

				break;
			case 7:
				$this->arraymessages=array();
				$this->arraymessages['0.required']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). Error en formato.';

				$this->arraymessages['1.required']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'';
				$this->arraymessages['1.in']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'. La operacion debe iniciar con las palabra QUERY.';

				$this->arraymessages['2.required']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.')';
				$this->arraymessages['2.numeric']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'. El valor de x1 debe ser numerico.';
				$this->arraymessages['2.between']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de x1 debe ser mayor o igual a uno y menor o igual a x2.';
				$this->arraymessages['2.max']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de x1 excede el numero definido para el ultimo bloque.';

				$this->arraymessages['3.required']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.')';
				$this->arraymessages['3.numeric']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'. El valor de y1 debe ser numerico.';
				$this->arraymessages['3.between']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de y1 debe ser mayor o igual a uno y menor o igual a y2.';
				$this->arraymessages['3.max']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de y1 excede el numero definido para el ultimo bloque.';

				$this->arraymessages['4.required']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.')';
				$this->arraymessages['4.numeric']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'. El valor de z1 debe ser numerico.';
				$this->arraymessages['4.between']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de z1 debe ser mayor o igual a uno y menor o igual a z2.';
				$this->arraymessages['4.max']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de z1 excede el numero definido para el ultimo bloque.';

				$this->arraymessages['5.required']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.')';
				$this->arraymessages['5.numeric']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'. El valor de x2 debe ser numerico.';
				$this->arraymessages['5.min']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de x2 debe ser mayor o igual a x1';
				$this->arraymessages['5.max']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de x2 excede el numero definido para el ultimo bloque.';

				$this->arraymessages['6.required']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.')';
				$this->arraymessages['6.numeric']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'. El valor de y2 debe ser numerico.';
				$this->arraymessages['6.min']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de y2 debe ser mayor o igual a y1';
				$this->arraymessages['6.max']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de y2 excede el numero definido para el ultimo bloque.';

				$this->arraymessages['7.required']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.')';
				$this->arraymessages['7.numeric']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'. El valor de z2 debe ser numerico.';
				$this->arraymessages['7.min']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de z2 debe ser mayor o igual a z1';
				$this->arraymessages['7.max']='Error (Caso de prueba '.$line.' - Operacion '.$operacion.'). El valor de z2 excede el numero definido para el ultimo bloque.';

				break;
		}

		return $this->arraymessages;
	}
}
