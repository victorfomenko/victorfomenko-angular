<?php
	include('dbConnect.php');
	$url = $_REQUEST["url"];

	switch ($url){
		default:
			$q =    "SELECT SQL_CALC_FOUND_ROWS
                            filename, title, year
                            FROM photos
                            WHERE home=1
                            ORDER BY year DESC";
			break;
		case "weddings":
			$q = "SELECT filename, title, year FROM photos WHERE wedding=1 ORDER BY id DESC";
			break;

		case "portraits":
			$q = "SELECT filename, title, year FROM photos WHERE portraits=1 ORDER BY id DESC";
			break;

		case "reports":
			$q = "SELECT filename, title, year FROM photos WHERE reports=1 ORDER BY id DESC";
			break;
	}

	$imageStack = array();

	if ($dataReader = getDataFromDB($q)){
		$count = count($dataReader);

		for ($i = 0; $i < $count; $i++){
			$imgData = $dataReader[$i];
			$imgDataFilename = $imgData['filename'];
			$imgDataTitle = $imgData['title'];
			$image = array();
			$image["imgUrl"] = "/data/full/" . $imgDataFilename . '.jpg';
			$image["previewUrl"] = "/data/preview/" . $imgDataFilename . '.jpg';
			$image["title"] = $imgDataTitle;
			array_push($imageStack, $image);
		}
	}

	header ("Content-Type: application/json");
	echo(json_encode($imageStack));

?>