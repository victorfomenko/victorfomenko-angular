<?
	if(isset($_REQUEST['auth_name'])) {
		require('dbConnect.php');

		$userName = $_REQUEST['auth_name'];
		$userPass = $_REQUEST['auth_pass'];

		//Запрашиваем пароль пользователя из БД.
		$q = "	SELECT id, password, last_login, admin
			FROM users
			WHERE name='" . $userName . "' and password='" . $userPass . "'";

		//Проверяем существование пользователя в БД.
		if (!$user = getDataFromDB($q)) die("ERROR. Bad combination user and password");
		if ($count = count($user) > 1) die("ERROR. Semething went wrong. Combinations of user and password > 1");

		//Создаём сессию, если авторизация прошла успешно.
		session_start();
		$_SESSION['user_id'] = $user[0]['id'];
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
	//Стартуем сессию, если уже была создана.


	session_start();
	echo ($_SESSION['ip']);
	if (isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) return;
	exit;
?>