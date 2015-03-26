<?php # Phase 1 - - mysqli_connect.php

// This file contains the database *Access Information*.
// This file also establishes *MySQL Connection*
// selects the database, and sets the encoding.

// [Set] *Access Information* (as constants)
DEFINE ( 'DB_USER',		'admin'		);
DEFINE ( 'DB_PASSWORD',	'admin'		);
DEFINE ( 'DB_HOST',		'localhost' );
DEFINE ( 'DB_NAME',		'traveler'	);

// *MySQL Connection* (assign ARGUMENTS to $dbc)
$dbc = @mysqli_connect ( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME ); // *Argument order relevant*
	
// Check connection
if (mysqli_connect_errno()) {

    printf('<p class="error">Server Connection Failed: %s</p>', mysqli_connect_error() . '<br />' . date(DATE_RFC2822) );
	echo'<p>(Break at Server connection file.)</p>';
    exit();
}

// Set encoding
mysqli_set_charset( $dbc, 'utf8' );