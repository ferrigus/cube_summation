# Cube Summation

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

## Ejemplos de Entrada. MÉTODO (REQUEST BY POST)
    - 2
    - 4 5
    - UPDATE 2 2 2 15
    - QUERY 1 1 1 3 3 3
    - UPDATE 1 1 1 50
    - QUERY 2 2 2 4 4 4
    - QUERY 1 1 1 3 3 3
    - 2 4
    - UPDATE 1 1 1 8
    - QUERY 1 1 1 1 1 1
    - QUERY 1 1 1 2 2 2
    - QUERY 2 2 2 2 2 2

## Ejemplos de Salida
- Las salidas están representadas en formato json.
- Cuando es una respuesta exitosa, se mostrarán los datos de las operaciones QUERY:
    - {"success":true,"data":[15,15,65,8,8,0]}
- Cuando es una respuesta errada, se mostrarán los mensajes relacionados al error:
    - {"success":false,"message":{"6":["Error (Caso de prueba 1 - Operacion 4). El valor de y2 excede el numero definido para el ultimo bloque."]}}


## Clases Principales
- Matriz. Contiene métodos de inicialización, actualización y consulta de la matriz. /app/Matriz.php
- CubesumController. Controlador encargado de gestionar la información. /app/Http/Controllers/CubesumController.php
- CubeSumPostRequest. Clase que contiene las reglas y mensajes de error personalizados. /app/Http/Requests/CubeSumPostRequest.php
    Junto con la clase Validator de Laravel permiten crear restricciones de manera practica y funcional.
- Se crea la vista para consumir el servicio y mostrar su funcionamiento de forma amigable.
	- CubeSumProcessController. Controlador que invoca a la vista. /app/Http/Controllers/CubeSumProcessController.php
	- index.blade.php. Vista principal. /resources/views/index.blade.php

## Responsabilidades de las clases
- En primera instancia y luego de analizar el problema, decidí crear la clase Matriz, en ella se crearon
tres métodos que permiten por ejemplo inicializar, actualizar y consultar una matriz, dicha matriz se carga en memoria para acceder
a ella en un proceso inmediato. En esta clase garantizamos la persistencia de datos
ya que solo requerimos de la información en un pequeño instante de tiempo.

- Una vez definida la clase principal se procedió a crear un controlador quien será el
encargado de administrar la información garantizando que la información que llegue al modelo sea la esperada.

- El controlador se apoya en otras clases para validar la información que ingresa, con esto garantizamos que cada clase
tenga una responsabilidad exclusiva al momento de procesar la información.

## Code Refactoring
- ManageDriverController. Clase modificada para mejorar el código en donde se procesa información de un conductor
y se envía una notificacion. /app/Http/Controllers/ManageDriverController.php

- Se pudo detectar que se intentaba enviar la notificación desde el mismo método que realiza la confirmación de los datos de entrada.
- Se crea una clase que solo se encargará de enviar la notificación,
- De esta forma la refactoricacion es un exto ya que se separaron resposibilidades de clases y métodos.

## Preguntas
- ¿En qué consiste el principio de Responsabilidad Única? ¿Cual es su propósito?
	En mi oponión considero que el propósito de responsabilidad única consiste en que cada clase o método creado debe cumplir con una función específica, 
	el objetivo es que existan mútiples clases que puedan interactuar entre sí para sacar adelante un proceso. Mientras las responssabilidades se dividen al máximo podremos obtener un código 
	mas amigable y funcional brindando con ello mayor escalibilidad.
- ¿Qué caracterisiticas debe tener según tu opinión "buen" código o código limpio?
	- Debe expresar claramente sus propósito e intenciones al ser definido.
	- Lograr en la medida de lo posible que otro desarrollador pueda entender el código rápidamente.
	- Mientras mas enfocado sea el código mejores resultados se obtendrán.
	- Tratar de abarcar en pocas líneas de código la mayoría de los procesos definiendo las clases y métodos de forma adecuada.