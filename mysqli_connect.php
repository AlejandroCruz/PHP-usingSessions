<?php

DEFINE ( 'DB_USER',     'admin'     );
DEFINE ( 'DB_PASSWORD', 'admin'     );
DEFINE ( 'DB_HOST',     'localhost' );
DEFINE ( 'DB_NAME',     'traveler'  );

$dbc = @mysqli_connect ( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

if (mysqli_connect_errno()) {

    printf('<p class="error">Server Connection Failed: %s</p>', mysqli_connect_error() . '<br />' . date(DATE_RFC2822) );
	echo'<p>(Break at Server connection file.)</p>';
    exit();
}

mysqli_set_charset( $dbc, 'utf8' );
