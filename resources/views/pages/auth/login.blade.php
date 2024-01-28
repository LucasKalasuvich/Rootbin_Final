<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Login Page</title>
    <link rel="shortcut icon" href="https://cutewallpaper.org/24/your-logo-here-png/partners-%E2%80%94-tradition-wild.png">
    {{-- <link rel="shortcut icon" href="{{ asset('picture/ramsay.png') }}"> --}}
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
</head>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						{{-- <img src="https://cutewallpaper.org/24/your-logo-here-png/partners-%E2%80%94-tradition-wild.png" alt="logo"> --}}
						<img src="/picture/ramsay.png" alt="logo">
					</div>
					<div class="d-flex justify-content-center mb-3 text-white" >
						<h1 class="font-weight-bold" style="font-size: 44px">RootBin</h1>
					</div>

					<div class="card fat">
						<div class="card-body">
							<h2 class="card-title">Login</h2>
							<form method="POST" action="{{ route('login') }}" class="my-login-validation" novalidate="">
								@csrf
								<div class="form-group">
									<label for="text" class="font-weight-bold">NIK</label>
									<input
                    					class="form-control @error('nik') is-invalid @enderror"
										id="nik"
										type="text"
										placeholder="nik"
										name="nik"
										value="{{ old('nik') }}"
										required
										autocomplete="nik"
										autofocus
                					/>
									@error('nik')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>

								<div class="form-group">
									<label for="password" class="font-weight-bold">Password
										
									</label>
									<input
										class="form-control @error('password') is-invalid @enderror"
										id="password"
										type="password"
										placeholder="password"
										name="password"
										required
										autocomplete="current-password"
									/>

									@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>

								<a href="forgot.html" class="float-left text-white mb-3">
									Lupa Password?
								</a>

								<div class="d-flex justify-content-center mr-5 pr-5">
									<button type="submit" class="btn btn-light btn-block font-weight-bold w-50">
										MASUK
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	{{-- <script src="js/my-login.js"></script> --}}
</body>
</html>