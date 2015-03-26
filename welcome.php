<?php # Phase 2 - welcome.php

#####################################################
#
# DEVELOPMENT NOTES
# - Change <id="display_db> to class
#
#####################################################

/*
 * Page that will access session set in login.php.
 * User is redirected here from login.php.
 * It will check that the user is logged in and redirect if not.
 * It will user the cookie for a personalized greeting.
 */

// Start session (sends cookie PHPSESSID)
session_start();

// If session not set, redirect user. Also, validate the HTTP_USER_AGENT
if( !isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) ) {

	// Include needed functions
	require( 'includes/login_functions.inc.php' );
	
	redirect_user(); // page value in login_functions.inc.php

} // END if(!isset...

#--------------------------------------------------------------------------------------------------#
# Start HTML page
#--------------------------------------------------------------------------------------------------#

$page_title = 'The Traveler'; //set page title variable
include( 'includes/header.html' );

echo '
<h1>WELCOME!</h1>
<p>You are now logged in as <span id="display_db"><b>' . $_SESSION['user_name'] . '</b></span>.</p>
<br />
<p><b><u>Today&#8217s task:</u></b></p>

<p>- Visit <a href="insert.php"><b>Insert</b></a> page for adding TRAVELER Magazine issue information or eddit records on DB.</p>
';

include ('includes/footer.html');
?>