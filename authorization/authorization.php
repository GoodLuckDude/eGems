<?php

//check email and pass in db and return user's name, race, master 
function getUser($email, $password) {
	$user = DB::run("SELECT id, name, race, master, password FROM users WHERE email = ?",
		[$email]
	)->fetch(PDO::FETCH_ASSOC);
	if ( !password_verify($password, $user['password']) ) {
		unset($user);
		return false;
	}
	unset($user['password']);
	return $user;
}

//registration of user
function registration($email, $password, $name, $race) {						//FIXME добавить в бд столбец aboutMe и подправить эту функцию, пароль захешировать и изменить getUsers!!!!
	$hash = password_hash($password, PASSWORD_DEFAULT);
	DB::run("INSERT INTO users (email, password, name, race) VALUES (?, ?, ?, ?)",
		[$email, $hash, $name, $race]
	);
	if ($race == "elf") {
		$gems_types = DB::run("SELECT id FROM gems_types")->fetchAll();
		$wish = round(1 / count($gems_types), 2);
		$addWishes = DB::prep("INSERT INTO wishes (elf_id, gem_type_id, wish)
			VALUES (?, ?, ?)
		");
		$elf_id = DB::run("SELECT id FROM users WHERE email = ?", [$email])->fetch();
		foreach ($gems_types as $type) {
			$addWishes->execute( array( $elf_id['id'], $type['id'], $wish ) );
		}
		$diff = 1 - $wish * count($gems_types);
		if ($diff >= 0.009) {
			$wish += $diff;
			DB::run("UPDATE wishes SET wish = ? WHERE elf_id = ? AND gem_type_id = ?",
				[$wish, $elf_id['id'], $gems_types[0]['id']]
			);
		}
	}
}

//redirect to elf's profile if elf, page of gems if dwarf....
function goToNeededPage($user) {
	$headerHost = 'Location: http://localhost';
	//if user tried open whatever page before autoriz then redirect to that page
	if(isset($_SESSION['neededPage'])) {
		$path = $_SESSION['neededPage'];
		unset($_SESSION['neededPage']);
		header($headerHost . $path);
		die();
	}
	$refProfile = '/profile/profile.php?id=';
	if($user['race'] == 'elf') {
		header($headerHost . $refProfile. $_SESSION['loggedUser']['id']);
		die();

		//race == dwarf
	} else if($user['master'] == false) {
		header($headerHost . "/add_gems_page/add_gems_page.php");
		die();

		//dwarf is master
	} else {
		header($headerHost . "/all_gems/all_gems.php");
		die();
	};
};

function redirect($user) {			//FIXME зарефакторить, разделить всю авторизацию на отдельные части и нормально назвать
	$_SESSION['loginEntered'] = $_POST['email'];
	if($user == false) {
		$_SESSION['errMsg'] = 'Неверный логин или пароль';
		goToLoginPage();
	}
	//успешно вошли
	$_SESSION['loggedUser'] = $user;
	DB::run("UPDATE users SET authorization_date = current_date WHERE id = ?",
		[$_SESSION['loggedUser']['id']]
	);
	goToNeededPage($user);

};

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////


session_start();
require_once '../config/database.php';
require_once '../func/common.php';


$email = clean($_POST['email']);
$password = clean($_POST['password']);

if(isset($_POST['name'])) {								//если передали name, то сначала регистрация пользователя
	$name = clean($_POST['name']);					//FIXME сделать проверку совпадения паролей, вывод ошибок
	$race = $_POST['race'];
	//$aboutMe = clean($_POST['aboutMe']);
	registration($email, $password, $name, $race);	//NOTE как и когда лучше назначать мастера?
	if(isset($_POST['ajax'])) {
		$response = array("code" => "success", 'msg' => 'Пользователь создан!');
		echo json_encode($response);
		return;
		die;
	}
}

$user = getUser($email, $password);

redirect($user);

?>