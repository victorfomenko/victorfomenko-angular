<?
	$data = (json_decode(file_get_contents("php://input")));
	$errors = array(
		"login" => false,
		"note" => ""
	);
	if(isset($data->auth_name)) {
		require('dbConnect.php');
		$userName = $data->auth_name;
		$userPass = $data->auth_pass;

		//Запрашиваем пароль пользователя из БД.
		$q = "	SELECT id, name, password, last_login, admin
			FROM users
			WHERE name='" . $userName . "' and password='" . $userPass . "'";

		//Проверяем существование пользователя в БД.
		if (!$user = getDataFromDB($q)) {
			$errors['login'] = false;
			$errors['note'] =  "ERROR. Bad combination user and password";
			header ("Content-Type: application/json");
			print(json_encode($errors));
			exit;
		}
		if ($count = count($user) > 1){
			$errors['note'] =  "ERROR. Semething went wrong. Combinations of user and password > 1";
			header ("Content-Type: application/json");
			print(json_encode($errors));
			exit;
		};

		//Создаём сессию, если авторизация прошла успешно.
		session_start();
		$_SESSION['user_id'] = $user[0]['id'];
		$_SESSION['user_name'] = $user[0]['name'];
		$_SESSION['isadmin'] = $user[0]['admin'];
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

		setcookie("userName", $_SESSION['user_name'], null, '/');
		setcookie("isAdmin", $_SESSION['isadmin'], null, '/');

		$errors['login'] = true;
		echo json_encode($errors);
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
	exit;
?>