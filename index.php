<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="ru">

<head>

	<meta charset="utf-8">
	<!-- <base href="/"> -->

	<title>OptimizedHTML 4</title>
	<meta name="description" content="">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<!-- Template Basic Images Start -->
	<meta property="og:image" content="path/to/image.jpg">
	<link rel="icon" href="img/favicon/favicon.ico">
	<link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon-180x180.png">
	<!-- Template Basic Images End -->
	
	<!-- Custom Browsers Color Start -->
	<meta name="theme-color" content="#000">
	<!-- Custom Browsers Color End -->

	<link rel="stylesheet" href="css/main.min.css">

</head>

<body>

	<div id="signupForm" class="signup form-flex">
		<form class="form-flex" action="./authorization/authorization.php" method="POST">
			<div class="container">
				<div class="row form-big-row first justify-content-between">

					<div class="col-9">
						<div class="row">
							<div class="col-5">Введите Email:</div>
							<div class="col-7">
								<label for="inputEmail" class="sr-only">Email address</label>
								<input type="email" name="email" class="input" placeholder="Email address" required autofocus>
							</div>
						</div>

						<div class="row">
							<div class="col-5">Введите пароль:</div>
							<div class="col-7">
								<label for="inputPassword" class="sr-only">Password</label>
								<input type="password" class="input" placeholder="Password" required>
							</div>
						</div>

						<div class="row">
							<div class="col-5">Повторите пароль:</div>
							<div class="col-7">
								<label for="inputPassword" class="sr-only">Password</label>
								<input type="password" name="password" class="input" placeholder="Password" required>
							</div>
						</div>
					</div>

					<div class="col-3">
						<div class="img">
							<img class="img" src="img/dwarf.png" width="100%" height="100%" alt="Гном">
						</div>
						<label for="downloadImg" class="sr-only">downloadImg</label>
						<button id="downloadImg" class="button" type="button">Загрузить</button>
					</div>

				</div>
			</div>

			<div class="container second">
				<div class="row form-big-row">

					<div class="col-9">
						<div class="row">
							<div class="col-5">Ваше имя:</div>
							<div class="col-7">
								<label for="inputEmail" class="sr-only">Ваше имя</label>
								<input type="text" name="name" class="input" placeholder="Name" required autofocus>
							</div>
						</div>

						<div class="row">
							<div class="col-5">Ваша раса:</div>
							<div class="col-7">
								<label for="radio-dwarf" class="form-lable">Гном</label>
								<input id="radio-dwarf" type="radio" name="race" class="input radio" value="dwarf" checked required>
								<label for="radio-elf" class="form-lable">Эльф</label>
								<input id="radio-elf" type="radio" name="race" class="input radio" value="elf" required>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<label for="about-me" class="form-lable">О себе:</label><br>
							</div>
						</div>

					</div>
				</div>
				<div class="row form-big-row">
					<div class="col">
							<textarea id="about-me" name="aboutMe" class="input input-textarea" ></textarea>
					</div>
				</div>
				<div class="row form-big-row last justify-content-end">
					<div class="col-4">
							<button class="button" type="submit">Зарегистрироваться</button>
					</div>
				</div>
			</div>

			<div class="container">

			</div>

		</form>		
	</div>

	<div class="isLogIn" style="background-image: url(img/bg-Login.jpg);">

		<div class="top-line">
			<a href="#" class="logo"><img src="img/logo-1.svg" alt="Драгоценности от гномов"></a>
		</div>
		<div class="page-flex">

			<div class="content-flex">
				<div class="flex-center">
					<div class="container-fluid">
						<div class="row justify-content-around align-items-center">

							<div class="col-sm-5 col-xs-10">

								<div class="logIn-composition">

									<div class="welcome">
										<h1 class="h1">Драгоценности от Гномов</h1>
									</div>

									<ul type="disc">
										<li>Приятные коэффициенты</li>
										<li>Широкий выбор драгоценностей</li>
										<li>Эксклюзивно для Эльфов</li>
									</ul>

								</div>

							</div>


							<div class="col-sm-4 col-xs-10 logIn-rightpart">
								
								<div class="logIn-panel">
									<form class="form-signin form-flex" action="./authorization/authorization.php" method="POST">

										<div class="msg">
										<?php
										echo $_SERVER['PHP_SELF'];
										echo $_SESSION['msg'];
										unset($_SESSION['msg']);
										?>
										</div>

										<label for="inputEmail" class="sr-only">Email address</label>
										<input type="email" id="inputEmail" name="email" class="form-control input" placeholder="Email address" required autofocus>
										<label for="inputPassword" class="sr-only">Password</label>
										<input type="password" id="inputPassword" name="password" class="form-control input" placeholder="Password" required>
										<button id="button-signin" class="button" type="submit">Войти</button>
										<button id="button-signup" class="button" type="button">Зарегистрироваться</button>
									</form>
								</div>

							</div>

						</div>
					</div>
				</div>
			</div>

			<div class="footer">
				<div class="container-fluid">
					<div class="row justify-content-around align-items-center">
						<div class="col-lg-3 col-sm-5 phone">
							<i class="fa fa-mobile"></i>+7 (919) 781-95-69
						</div>
						<div class="col-lg-3 col-sm-5">
							Бла-бла-бла
						</div>
						<div class="col-lg-3 col-sm-5">
							Ля-ля-ля
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>




	<script src="js/scripts.min.js"></script>
	
</body>
</html>