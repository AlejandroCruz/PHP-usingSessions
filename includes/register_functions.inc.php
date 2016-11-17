<?php

function redirect_user( $page = 'index.php' ) {

	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname( $_SERVER['PHP_SELF'] );
	$url = rtrim( $url, '/\\' );
	$url .= '/' . $page;

	header( "Location: $url" );
	exit();

}

function check_login( $dbc, $new_username = '', $pass1 = '', $pass2 = '' ) {

	$errors = array();
	
	if( empty( $new_username ) ) {
		$errors[] = 'Please enter username.';
	} else {
		$un = mysqli_real_escape_string( $dbc, trim( $new_username ) );
	}

	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Passwords did not match.';
		} else {
			$p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else {
		$errors[] = 'Please enter password.';
	}

	if( empty( $errors ) ) {

		$q = "
		SELECT user_id
		FROM users
		WHERE user_name = '$un'
		";

		$r = mysqli_query( $dbc, $q );

		if( mysqli_num_rows( $r ) == 0 ) {

			$q = "
			INSERT INTO users( user_name, pass, register_date )
			VALUES( '$un', SHA1('$p'), NOW() )
			";
			$r = @mysqli_query( $dbc, $q );
			if( $r ) { 
				
				$q = "
				SELECT user_id, user_name
				FROM users
				WHERE user_name = '$un'
				";
				$r = mysqli_query( $dbc, $q );

				$row = mysqli_fetch_array( $r, MYSQLI_ASSOC );

				return array( TRUE, $row );
				
			} else {
				
				$errors[] = 'System Error.<br />
				You could not be registered at this moment.';
				
			}
			
		} else {
		
			$errors[] = 'The username entered exist on file. Please enter new username.';
		
		}
	
	}

	return array( FALSE, $errors );

}