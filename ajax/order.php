<?
	include('functions.php');
	include('dbConnect.php');
	$data = (json_decode(file_get_contents("php://input")));
	$fields =  "name,phone,tarif,ip,date";
	$name = $data->name;
	$phone = $data->phone;
	$tarif = $data->tarif;

	$GLOBALS['field_ip'] = $_SERVER['REMOTE_ADDR'];
	$GLOBALS['field_date'] = date('Y-m-d H:i:s');
	$GLOBALS['field_name'] = $name;
	$GLOBALS['field_phone'] = $phone;
	$GLOBALS['field_tarif'] = $tarif;

	// insert
	$values = make_insert( $fields, "field_" );
	$q = "INSERT INTO orders(" . $fields . ") values(" . $values . ")";
	mysql_query( $q );


	$mail_title =	 "Wedding order";
	$ip = 		$_SERVER['REMOTE_ADDR'];

	$mail_data = 	"<message>" . $mail_title . "</message>\n" .
		"<subject>" . $tarif . "</subject>\n" .
		"<name>" . $name . "</name>\n" .
		"<phone>" . $phone . "</phone>\n" .
		"<ip>" . $ip . "</ip>\n" .
		"<date>" . date('d.m.Y H:i') . "</date>\n";

	$mail_title = 	iconv( 'UTF-8', 'KOI8-R', $mail_title );
	$mail_data = 	iconv( 'UTF-8', 'KOI8-R', $mail_data );

	$headers  = 'Content-Type: text/plain; charset="KOI8-R"'. "\r\n";
	$headers .= 'From: victorfomenko.ru <orders@victorfomenko.ru>' . "\r\n";

	mail ( "victorfomenko@me.com" , $mail_title, $mail_data, $headers );

	print("ok");
	exit;
?>