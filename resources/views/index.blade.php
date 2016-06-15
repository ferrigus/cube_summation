@extends('layouts.master')

@section('title', 'Página Principal')

@section('content')

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">@yield('title')</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        </div>
      </div>
    </nav>

    <div class="jumbotron">
		<div class="container">
			<h1>Cube Summation</h1>
		</div>
		
		@if (count($errors) >= 1)
			<div class="alert alert-danger">
				@for ($i = 0; $i < count($errors); $i++)
					<li>{{$errors[$i]}}</li>
				@endfor
			</div>
		@endif
		<form class="form-signin" method="POST" action="http://<?=$_SERVER['SERVER_ADDR']?>/cubesum/public/">
        <div class="form-group">
			<label for="nombre" class="sr-only">Ingresar Datos</label>
			<textarea class="form-control" rows="5" id="texto" name="texto" value="{{ old('texto') }}"></textarea>
		</div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Enviar</button>
		</form>
		@if (count($records) >= 1)
			<div class="container">
				<h1>Resultado:</h1>
				@for ($i = 0; $i < count($records); $i++)
					<li>{{$records[$i]}}</li>
				@endfor
			</div>
		@endif
		
    </div>


    <div class="container">
      <hr>

      <footer>
        <p>&copy; 2016 Felix Utrera</p>
      </footer>
    </div>
@endsection