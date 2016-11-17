<?php

session_start();

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

	require( 'mysqli_connect.php' );

	if( isset($_POST['login']) ) {
	
		require( 'includes/login_functions.inc.php' );
		
		// Check the login. The function call check_login here sends 'username' & 'pass' from form in
		//  login_page.inc.php to login_functions.inc.php.
		// It receives back TRUE/FALSE assigned to $check & $row/$errors assigned to $data.
		// The arrays returned from that process: array( TRUE, $row ) || array( FALSE, $errors ).
		list( $check, $data ) = check_login( $dbc, $_POST['username'], $_POST['pass'] );
	
	} elseif( isset($_POST['register']) ) {

		require( 'includes/register_functions.inc.php' );
		
		list( $check, $data ) = check_login( $dbc, $_POST['new_username'], $_POST['pass1'], $_POST['pass2'] );
	
	}

	if( $check ) {
		
		$_SESSION['user_id'] = $data['user_id'];
		$_SESSION['user_name'] = $data['user_name'];
		
		$_SESSION['agent'] = md5( $_SERVER['HTTP_USER_AGENT'] );

		redirect_user( 'welcome.php' );
		
	} else {

		$errors = $data;
	
	}	
}

include( 'includes/login_page.inc.php' );

?>