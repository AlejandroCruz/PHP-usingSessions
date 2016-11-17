<?php

function redirect_user( $page = 'index.php' ) {

	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname( $_SERVER['PHP_SELF'] );	
	$url = rtrim( $url, '/\\' );	
	$url .= '/' . $page;
	
	header( "Location: $url" );
	exit();

}

function check_login( $dbc, $username = '', $pass = '' ) {

	$errors = array();

	if( empty( $username ) ) {
		$errors[] = 'Please enter username.';
	} else {
		$un = mysqli_real_escape_string( $dbc, trim( $username ) );
	}
	
	if ( empty( $pass ) ) {
		$errors[] = 'Please enter password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim( $pass ));
	}

	if( empty( $errors ) ) {
	
		$q = "
		SELECT user_id, user_name
		FROM users
		WHERE user_name = '$un'
			AND pass = SHA1( '$p' )
		";
		$r = mysqli_query( $dbc, $q );
		
		if( mysqli_num_rows( $r ) == 1 ) {
		
			$row = mysqli_fetch_array( $r, MYSQLI_ASSOC );
			
			return array( TRUE, $row );
			
		} else {
				
				$errors[] = '
				We were unable to find your information.<br />
				Username may not exist on record or	wrong password entered.
				<h1></h1>
				';
		}
	
	} 

	return array( FALSE, $errors );

}