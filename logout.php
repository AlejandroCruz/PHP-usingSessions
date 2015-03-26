<?php # Phase 2 - logout.php
/*
 * This page lets the user log out
 */

// Start session
session_start();
 
// If session not set, redirect user. Also, validate the HTTP_USER_AGENT
if( !isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) ) {

	// Include needed functions
	require( 'includes/login_functions.inc.php' );
	
	redirect_user(); // page value in login_functions.inc.php

} else { // Cancel the session

	// Clear variables
	$_SESSION = array();
	// Destroy the session itself
	session_destroy();
	// Destroy the cookie
	setcookie( 'PHPSESSID', '', time()-3600, '/', '', 0, 0 );

} // END if(!isset...

#--------------------------------------------------------------------------------------------------#
# Start HTML page through login_page.inc.php
#--------------------------------------------------------------------------------------------------#

$page_title = 'Logged Out';
include( 'includes/header.html' );

// Print logout message
echo '
<h1>Logged Out</h1>
<p>You are now logged out.</p>';

include ('includes/footer.html');
?>

