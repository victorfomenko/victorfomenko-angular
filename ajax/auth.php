<?
	if(isset($_REQUEST['auth_name'])) {
		require('dbConnect.php');

		$userName = $_REQUEST['auth_name'];
		$userPass = $_REQUEST['auth_pass'];

		//Запрашиваем пароль пользователя из БД.
		$q = "	SELECT id, name, password, last_login, admin
			FROM users
			WHERE name='" . $userName . "' and password='" . $userPass . "'";

		//Проверяем существование пользователя в БД.
		if (!$user = getDataFromDB($q)) die("ERROR. Bad combination user and password");
		if ($count = count($user) > 1) die("ERROR. Semething went wrong. Combinations of user and password > 1");

		//Создаём сессию, если авторизация прошла успешно.
		session_start();
		$_SESSION['user_id'] = $user[0]['id'];
		$_SESSION['user_name'] = $user[0]['name'];
		$_SESSION['isadmin'] = $user[0]['admin'];
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
//		header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		print("Auth success!");
		exit;
	}

	//Мутим логаут
	if (isset($_GET['action']) AND $_GET['action']=="logout") {
		session_start();
		session_destroy();
		setcookie(session_name(), "", null, "/" );

		header("Location: http://".$_SERVER['HTTP_HOST']."/");
		exit;
	}
	if (isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) return;

	if (false) {
		session_start();
		$userData = array(
			"id" => $_SESSION['user_id'],
			"name" => $_SESSION['user_name'],
			"isAdmin" => $_SESSION['isadmin']
		);
		header ("Content-Type: application/json");
		echo(json_encode($userData));
	}
	exit;
?>