<?php # Phase 2 - login_functions.inc.php
/*
 * This file defines two functions used by the login/logout process.
 * If the users accesses restricted page and they are not logged in,
 *  they will be redirected.
 * Function redirect_user determines an absolute URL and redirects the user.
 * The function takes one argument: the page to be redirected to.
 * The argument defaults to index.php.
 */

// Begin fucntion redirect_user
function redirect_user( $page = 'index.php' ) {

	// Start defining the URL
	# URL is http:// plus the host name plus current directory
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname( $_SERVER['PHP_SELF'] );
	
	// Remove any trailing slashes
	$url = rtrim( $url, '/\\' );
	
	// Add the page
	$url .= '/' . $page;
	
	// Redirect the user & quit script
	header( "Location: $url" );
	exit();

} // END fucntion redirect_user

# This function validates the form data (username & password).
# If both are present, the DB is queried.
# The function requires a DB connection.
# The function returns an array of information:
# - TRUE/FALSE variable indicating success
# - an array of either errors or the DB result

// This fucntion is called from login.php
// The call passes: check_login( $dbc, $_POST['username'], $_POST['pass'] )
function check_login( $dbc, $username = '', $pass = '' ) {

	// Initialize error array
	$errors = array();
	
	// Check for account username
	if( empty( $username ) ) {
		$errors[] = 'Please enter username.';
	} else {
		$un = mysqli_real_escape_string( $dbc, trim( $username ) ); // Assign $un
	} // END if(empty...
	
	// Check for a password
	if ( empty( $pass ) ) {
		$errors[] = 'Please enter password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim( $pass )); // Assign $p
	} // END if(empty...
	
	// If no validation errors
	if( empty( $errors ) ) {
	
		// Query for specific username+pass combination
		$q = "
		SELECT user_id, user_name
		FROM users
		WHERE user_name = '$un'
			AND pass = SHA1( '$p' )
		";
		$r = mysqli_query( $dbc, $q ); // Run query
		
		// If username match password on file
		if( mysqli_num_rows( $r ) == 1 ) {
		
			// Fetch record
			$row = mysqli_fetch_array( $r, MYSQLI_ASSOC );
			
			// Return TRUE & the record as $row
			return array( TRUE, $row );
			
		} else { // user_name+pass on DB don't match
				
				$errors[] = '
				We were unable to find your information.<br />
				Username may not exist on record or	wrong password entered.
				<h1></h1>
				';
			
		} // End if(mysqli_num_rows...
	
	} // END if(empty...
	
	// Return FALSE & the errors as $errors
	return array( FALSE, $errors );

} // END fucntion check_login