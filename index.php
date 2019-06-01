<?php
	session_start();
	include_once "./_parts/header.php"
?>

<body>

	<div id="signupForm" class="signup form-flex">
		<form class="form-flex" action="./authorization/authorization.php" method="POST">
			<div class="container">
				<div class="row form-big-row first justify-content-between">

					<div class="col-9">
						<div class="row">
							<div class="col-5">Введите Email:</div>
							<div class="col-7">
								<input type="email" name="email" class="input" placeholder="Email address" required autofocus>
							</div>
						</div>

						<div class="row">
							<div class="col-5">Введите пароль:</div>
							<div class="col-7">
								<input type="password" class="input" placeholder="Password" required>
							</div>
						</div>

						<div class="row">
							<div class="col-5">Повторите пароль:</div>
							<div class="col-7">
								<input type="password" name="password" class="input" placeholder="Password" required>
							</div>
						</div>
					</div>

					<div class="col-3">
						<div class="img">
							<img class="img" src="img/dwarfSmall.png" width="100%" height="100%" alt="Гном">
						</div>
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
										echo $_SESSION['errMsg'];
										unset($_SESSION['errMsg']);
										?>
										</div>

										<label for="inputEmail" class="sr-only">Email address</label>
										<input type="email" id="inputEmail" name="email" class="form-control input" placeholder="Email address" required value=<?php echo $_SESSION['loginEntered']?>>
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
			<?php include_once "./_parts/footer.php" ?>
		</div>
	</div>




	<script src="js/scripts.min.js"></script>
	
</body>
</html>