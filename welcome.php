<?php

// Send cookie PHPSESSID
session_start();

if( !isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) ) {

	require( 'includes/login_functions.inc.php' );
	
	redirect_user();

}

$page_title = 'The Traveler';
include( 'includes/header.html' );

echo '
<h1>WELCOME!</h1>
<p>You are now logged in as <span class="display_db"><b>' . $_SESSION['user_name'] . '</b></span>.</p>
<br />
<p><b><u>Today&#8217s task:</u></b></p>
<p>- Visit <a href="insert.php"><b>Insert</b></a> page for adding TRAVELER Magazine issue information or eddit records on DB.</p>
';

include ('includes/footer.html');

?>