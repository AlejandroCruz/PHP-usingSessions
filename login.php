<?php # Phase 2 - login.php
/**
 * This page processes the login form submission.
 * Upon successful login, the user is redirected.
 * File includes:
 *	- mysqli_connect.php
 *	- login_functions.inc.php
 *	- register_functions.inc.php
 *	- login_page.inc.php
 */

// Start session (sends cookie PHPSESSID)
session_start();

// Check if the form has been submitted
if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

	// Open connection to DB
	require( 'mysqli_connect.php' );
	
	
	// If button "login" executed
	if( isset($_POST['login']) ) {
	
		// For processing the login
		require( 'includes/login_functions.inc.php' );
		
		// Check the login. The function call check_login here sends 'username' & 'pass' from form in
		//  login_page.inc.php to login_functions.inc.php.
		// It receives back TRUE/FALSE assigned to $check & $row/$errors assigned to $data.
		// The arrays returned from that process: array( TRUE, $row ) || array( FALSE, $errors ).
		list( $check, $data ) = check_login( $dbc, $_POST['username'], $_POST['pass'] );
	
	} elseif( isset($_POST['register']) ) { // Button "register" was executed
	
		// For processing the register
		require( 'includes/register_functions.inc.php' );
		
		// Check the registration.
		list( $check, $data ) = check_login( $dbc, $_POST['new_username'], $_POST['pass1'], $_POST['pass2'] );
	
	} // END if(isset...
	
	
	if( $check ) { // If boolean returned TRUE
		
		// Set superglobal arrays
		$_SESSION['user_id'] = $data['user_id'];
		$_SESSION['user_name'] = $data['user_name'];
		
		// Store HTTP_USER_AGENT for security (hashing)
		$_SESSION['agent'] = md5( $_SERVER['HTTP_USER_AGENT'] );
		
		// Redirect
		redirect_user( 'welcome.php' );
		
	} else { // If boolean FALSE
	
		// Assign $data to $errors for error reporting because $errors is expected
		// in the script that displays the login file: login_page.inc.php
		$errors = $data;
	
	} // END if($check)

	
} // END if($_SERVER...

#--------------------------------------------------------------------------------------------------#
# Start HTML page through login_page.inc.php
#--------------------------------------------------------------------------------------------------#
include( 'includes/login_page.inc.php' );

?>