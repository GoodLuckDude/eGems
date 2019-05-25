<?php
//check email and pass in db and return user's name, race, master 
function getUser($email, $password) {
	$user = DB::run("SELECT id, name, race, master FROM users WHERE email = ? and password = ?",
		[$email, $password]
	)->fetch(PDO::FETCH_ASSOC);

	return $user;
}

//registration of user
function registration($email, $password, $name, $race) {						//FIXME добавить в бд столбец aboutMe и подправить эту функцию, пароль захешировать и изменить getUsert!!!!
	DB::run("INSERT INTO users (email, password, name, race) VALUES (?, ?, ?, ?)",
		[$email, $password, $name, $race]);
}

//redirect to elf's profile if elf, page of gems if dwarf....
function goToNeededPage($user) {
	//if user tried open whatever page before autoriz then redirect to this page
	if(isset($_SESSION['neededPage'])) {
		$path = $_SESSION['neededPage'];
		unset($_SESSION['neededPage']);
		header('Location: http://localhost' . $path);
		die();
	}

	if($user['race'] == 'elf') {
		header('Location: http://localhost/elf/profile.php');
		die();

		//race == dwarf
	} else if($user['master'] == false) {
		header('Location: http://localhost/dwarf/profile.php');		//FIXME не профиль, а страницу добавления драгоценностей
		die();

		//dwarf is master
	} else {
		header('Location: http://localhost/dwarf/profile.php');		//FIXME не профиль, а страницу драгоценностей или что там было
		die();
	};
};

function redirect($user) {
	if($user == false) {
		$_SESSION['msg'] = 'Неверный логин или пароль';
		goToLoginPage();
	}
	$_SESSION['authorized'] = true;
	goToNeededPage($user);

//ToDo настроить сессию, куки
};

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
?>




<?php
require_once '../config/database.php';
require_once '../func/common.php';

session_start();

$email = clean($_POST['email']);
$password = clean($_POST['password']);

if(isset($_POST['name'])) {								//если передали name, то сначала регистрация пользователя
	$name = clean($_POST['name']);					//FIXME сделать проверку совпадения паролей, вывод ошибок
	$race = clean($_POST['race']);
	//$aboutMe = clean($_POST['aboutMe']);
	registration($email, $password, $name, $race);	//NOTE как и когда лучше назначать мастера?
}

$user = getUser($email, $password);

redirect($user);

?>