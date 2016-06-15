# Cube Sumation

Desarrollo de un servicio que permite obtener la sumatoria de un arreglo de tres dimensiones.

## Objetivos
- Indicar cuantos casos de prueba se van a realizar.
- Crear una matriz que inicie en el bloque (1,1,1) y termine en el bloque (N,N,N) por cada caso de prueba definido.
- Definir los tipos de operaciones que se le pueden realizar a cada matriz:
    - UPDATE x y z W -> Actualiza el valor de un bloque en donde "x y z" es la posición del bloque y "W" el valor.
    - QUERY x1 y1 z1 x2 y2 z2 -> Obtiene la sumatoria de los valores en cada bloque contenido en "x" incluyendo "x1" y "x2", contenido en "y" incluyendo "y1" y "y2" y contenido en "z" incluyendo "z1" y "z2".

## Formato de Entrada
- La primera línea contiene un entero "T", el cual representa la cantidad de casos de prueba.
- Por cada caso de prueba la siguiente línea deberá contener dos enteros "N" y "M" separados por un espacio.
- "N" define el último bloque de la matriz.
- "M" define la cantidad de operaciones que se pueden realizar para cada caso de prueba.
- Operaciones que se ejecutarán a la matriz.

## Restricciones
- 1 <= T <= 50
- 1 <= N <= 100
- 1 <= M <= 1000
- 1 <= x1 <= x2 <= N
- 1 <= y1 <= y2 <= N
- 1 <= z1 <= z2 <= N
- 1 <= x,y,z <= N
- (-10^9) <= W <= (10^9)

## Ejemplos de Entrada MÉTODO (REQUEST BY POST)
casosprueba:2
matrix_lines1:4 5
linea1-1:UPDATE 2 2 2 4
linea1-2:QUERY 1 1 1 3 3 3
linea1-3:UPDATE 1 1 1 23
linea1-4:QUERY 2 2 2 4 4 4
linea1-5:QUERY 1 1 1 3 3 3
matrix_lines2:2 4
linea2-1:UPDATE 2 2 2 1
linea2-2:QUERY 1 1 1 1 1 1
linea2-3:QUERY 1 1 1 2 2 2
linea2-4:QUERY 2 2 2 2 2 2

## Ejemplos de Salida
- Las salidas están representadas en formato json.
- Cuando es una respuesta exitosa, se mostrarán los datos de las operaciones QUERY:

