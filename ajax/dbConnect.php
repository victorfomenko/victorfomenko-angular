<?
	$dbIP = 'localhost';
	$dbUser = 'root';
	$dbPass = 'TwofRag83';
	$dbName = 'victorfomenko';
	$connection = mysql_connect ( $dbIP ,$dbUser, $dbPass ) or DIE( "Couldn't connect ot DB" );
	mysql_select_db( $dbName ) 	or DIE( "Couldn't connect ot DB" );

	function getDataFromDB ( $q ) {
		$command = mysql_query($q);
		$dataReader = dbArray($command);
		return $dataReader;
	}
	function dbArray( $recordset ) {
		if ( ! $recordset ) { return false; }

		$res = array();
		$i = 0;
		while ( $row = mysql_fetch_assoc ( $recordset ) )
		{
			$res[ $i ] = $row;
			$i++;
		}
		return $res;
	}
?>