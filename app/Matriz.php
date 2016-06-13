<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

//class Matriz extends Model
class Matriz
{
    private $m, $n, $matriz;
    function __construct($n, $m)
    {
        $this->m = $m;
        $this->n = $n;
        $this->inicializarMatriz($n);
    }
    private function inicializarMatriz($n)
    {
        for ($i = 0; $i <= $n; $i++) {
            for ($j = 0; $j <= $n; $j++) {
                for ($k = 0; $k <= $n; $k++) {
                    $this->matriz[$i][$j][$k] = 0;
                }
            }
        }
    }
    public function updateBloque($x, $y, $z, $value)
    {
        $this->matriz[$x][$y][$z] = $value;
    }

    public function sumatoria($x1, $y1, $z1, $x2, $y2, $z2)
    {
        $sum = 0;
        for ($i = $x1; $i <= $x2; $i++) {
            for ($j = $y1; $j <= $y2; $j++) {
                for ($k = $z1; $k <= $z2; $k++) {
                    $sum += $this->matriz[$i][$j][$k];
                }
            }
        }
        return $sum;
    }

}
