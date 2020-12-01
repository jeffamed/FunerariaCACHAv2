<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Funeraria CACHA') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./css/all.css">

</head>
<body>
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<h2 style="margin-top: -8rem;display: inline; text-align: center;width: 100%;">Funeraria Carrazco Chavarría</h2>
				<div class="login100-pic js-tilt" data-tilt >
					<img src="img/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                        @csrf
					<span class="login100-form-title">
						Iniciar Sesión
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Usuario es requerido">
						<input class="input100" type="text" name="name" placeholder="Usuario">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Contraseña es requerida">
						<input class="input100" type="password" name="password" placeholder="***********">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Entrar
						</button>
					</div>
					<div class="text-center p-t-136">
						<p>
							"Una experiencia diferente...""
						</p>
					</div>
				</form>
			</div>
		</div>
	</div>
    <script src="./js/all.js"></script>
    <script src="./js/app.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
</body>
</html>
