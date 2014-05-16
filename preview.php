<?
$name = preg_replace ( "~^.*?([^/]+)$~", "$1", $_SERVER["REQUEST_URI"]);
$serverRawImagesDir = "data/full/";
$serverThumbsDir = "data/preview/";
$file404 = "protected/views/site/404.html";
$filename = $serverRawImagesDir . $name;

if (!preg_match ("~^.*\.(jpg|jpeg|gif|png)$~", $name, $match) || !file_exists($filename)){
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	header('Status: 404 Not Found');
	require_once $file404;
	exit;
}

switch ($match[1]){
	case "png":
		$imageOpenFunction = imagecreatefrompng;
		$contentType = "image/png";
		$imagePushFunction = imagepng;
		$imageQuality = 0;
		break;
	case "gif":
		$imageOpenFunction = imagecreatefromgif;
		$contentType = "image/gif";
		$imagePushFunction = imagegif;
		$imageQuality = 0;
		break;
	default:
	case "jpg":
	case "jpeg":
		$imageOpenFunction = imagecreatefromjpeg;
		$contentType = "image/jpeg";
		$imagePushFunction = imagejpeg;
		$imageQuality = 90;
		break;
}

//Открываем исходное изображение
$image = $imageOpenFunction($filename);
imageinterlace($image, true);
$sw = ImageSX($image);
$sh = ImageSY($image);

//Создаем миниатюру
$rh = 120;
$rw = round($rh * $sw / $sh);				
$result = imagecreatetruecolor ($rw, $rh);

//Ресайзим с исходного в мениатюру
imagecopyresampled ($result, $image, 0, 0, 0, 0, $rw, $rh, $sw, $sh);

ob_start();
if ($imageQuality)
	$imagePushFunction ($result, null, $imageQuality);
else
	$imagePushFunction ($result, null);
imagedestroy($result);
imagedestroy($image);

header("Content-type: " . $contentType);
header ("Last-Modified: " . date("r", time()));
header ("Expires: " . date("r", time() + 60 * 60 * 24 * 14 ));
//runTime("header");
$data = ob_get_contents();

//Кэшируем
file_put_contents( $serverThumbsDir . $name, $data);
?>
