<?
	// make insert values string
	function make_insert( $fields, $pref = "f_", $function ) {
		$values = $pref . str_replace( ",", "," . $pref, $fields );
		$list = explode(",", $values);
		$values = "";

		foreach( $list as $t => $value )
		{
			$value = $GLOBALS[ $value ];
			$value = clear_sql( $value );
			if ( $function != "" ) {
				if ( function_exists( $function ) ) {
					$value = call_user_func ( $function , $value );
				}
			}

			$values .= "'" . $value . "',";
		}
		$values = substr( $values, 0, -1 );

		return $values;
	}

	// clear from special chars
	function clear_sql( $text ) {
		$text = str_replace( "\\\\", "\\", $text );
		$text = replace_quates( $text );
		$text = str_replace( "\'", "&rsquo;", $text );
		$text = str_replace( "'", "&rsquo;", $text );
		return $text;
	}

	// replace quates
	function replace_quates( $text ) {
		$text = preg_replace( '/(^|\s)"(\S)/', '$1&laquo;$2', $text );
		$text = preg_replace( '/^"(\S)/', '&laquo;$2', $text );
		$text = preg_replace( '/(\S)"([ ;:\-.,?!\>\<])/', '$1&raquo;$2', $text );
		$text = preg_replace( '/([ .,?!])"$/', '$1&raquo;', $text );
		$text = preg_replace( '/(\S)"$/', '$1&raquo;', $text );
		$text = preg_replace( '/(\S)"/', '$1&laquo;$2', $text );
		$text = preg_replace( '/([ .,?!])"([ .,?!])/', '$1&laquo;$2', $text );
		$text = preg_replace( '/(.*)"(.*)/', '$1&laquo;$2', $text );

		return $text;
	}

?>