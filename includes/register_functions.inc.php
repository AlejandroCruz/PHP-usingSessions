<?php # Phase 2 - register_functions.inc.php
/*
 * This file inserts new record on DB.
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

# This function validates the form data (username, password 1 & password 2).
# If all data is present, the DB is queried.
# The function requires a DB connection.
# The function returns an array of information:
# - TRUE/FALSE variable indicating success
# - an array of either errors or the DB result

// This fucntion is called from login.php
// The call passes: check_login( $dbc, $_POST['new_username'], $_POST['pass1'] & $_POST['pass2'] )
function check_login( $dbc, $new_username = '', $pass1 = '', $pass2 = '' ) {

	// Initialize error array
	$errors = array();
	
	// Check for account username
	if( empty( $new_username ) ) {
		$errors[] = 'Please enter username.';
	} else {
		$un = mysqli_real_escape_string( $dbc, trim( $new_username ) ); // Assign $un
	} // END if(empty...
	
	// Check for a password and match against the confirmed password:
	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Passwords did not match.';
		} else {
			$p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else {
		$errors[] = 'Please enter password.';
	} // END if(empty...
	
	// If no validation errors
	if( empty( $errors ) ) {
	
		// Query for username already on record
		$q = "
		SELECT user_id
		FROM users
		WHERE user_name = '$un'
		";
		$r = mysqli_query( $dbc, $q ); // Run query
		
		// If username does not exists
		if( mysqli_num_rows( $r ) == 0 ) {
		
			// Make INSERT query
			$q = "
			INSERT INTO users( user_name, pass, register_date )
			VALUES( '$un', SHA1('$p'), NOW() )
			";
			$r = @mysqli_query( $dbc, $q ); // Run the query
			if( $r ) { // If it ran ok 
				
				// Query new registration ID & Name
				$q = "
				SELECT user_id, user_name
				FROM users
				WHERE user_name = '$un'
				";
				$r = mysqli_query( $dbc, $q ); // Run query
				
				// Fetch record
				$row = mysqli_fetch_array( $r, MYSQLI_ASSOC );
				
				// Return TRUE & the record as $row
				return array( TRUE, $row );
				
			} else { // Query had a system error
				
				$errors[] = 'System Error.<br />
				You could not be registered at this moment.';
				
			} // END if($r)
			
		} else { // Username already taken
		
			$errors[] = 'The username entered exist on file. Please enter new username.';
		
		} // End if(mysqli_num_rows...
	
	} // END if(empty...
	
	// Return FALSE & the errors as $errors
	return array( FALSE, $errors );

} // END fucntion check_login