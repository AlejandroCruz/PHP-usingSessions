<?php

session_start();

if( !isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) ) {

	require( 'includes/login_functions.inc.php' );
	
	redirect_user();

} else {

	// Clear variables
	$_SESSION = array();
	// Destroy the session itself
	session_destroy();
	// Destroy the cookie
	setcookie( 'PHPSESSID', '', time()-3600, '/', '', 0, 0 );
}

$page_title = 'Logged Out';
include( 'includes/header.html' );

echo '
<h1>Logged Out</h1>
<p>You are now logged out.</p>';

include ('includes/footer.html');

?>

