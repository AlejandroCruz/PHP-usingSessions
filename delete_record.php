<?php # Phase 2 - delete_record.php

#####################################################
#
# DEVELOPMENT NOTES
# - Change <id="display_db> to class
#
#####################################################

/*
 * This page is for deleting DB records. It is accessed through insert.php.
 */

// Start session (sends cookie PHPSESSID)
session_start();

$page_title = 'Delete Record'; // Set page title variable
include( 'includes/header.html' ); // Include page header
echo '<h1 id="mainhead">Delete Record</h1>';

// If session not set, redirect user. Also, validate the HTTP_USER_AGENT
if( !isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) ) {

	// Include needed functions
	require( 'includes/login_functions.inc.php' );
	
	redirect_user(); // page value in login_functions.inc.php

} // END if


// Check for valid issue#, through GET or POST
if( (isset($_GET['in'])) && (is_numeric($_GET['in'])) ) { // From insert.php
	$in = $_GET['in'];
} elseif( (isset($_POST['in'])) && (is_numeric($_POST['in'])) ) { // Form submission
	$in = $_POST['in'];
} else { // END if(isset)
	echo'
	<p class="error">This page has been accessed in error.</p>
	';
}

require_once( 'mysqli_connect.php' ); // Open connection to DB
mysqli_select_db( $dbc, "traveler" ); // Select DB traveler


// Check if the form has been submitted
if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

	if( $_POST['sure'] == 'Yes' ) { // Delete the record
	
		// Make delete query
		$q = "
		DELETE
		FROM archives
		WHERE issue_num = $in LIMIT 1
		";
		$r = mysqli_query( $dbc, $q ); // Run query
		if( mysqli_affected_rows($dbc) == 1 ) { // If it ran OK
		
			unset( $warning );
		
			echo'
			<p>The record for <span id="display_db"><b>Issue #' . $_POST['in'] . '</b></span> 
			has been deleted.</p><br />
			';
			echo '<a href="insert.php">BACK</a>';
		} else { // If query did not ran OK
		
			unset( $warning );
		
			echo'
			<p class="error"><b>Record could not be deleted due to system error:</b></p>
			<p>' . mysqli_error( $dbc ) . '<br />
				Query: ' . $q . '</p><br /><br />
			';
			echo '<a href="insert.php">BACK</a>';
		}
	} else { // Confirmation that deletion was not executed
		
		unset( $warning );
		
		echo'
			<p>The record for <b>Issue #' . $_POST['in'] . '</b> has <span id="display_db"><b>NOT</b></span> been deleted.</p><br />
			';
			echo '<a href="insert.php">BACK</a>';
		
	} // END if ($_POST)

} else { // No submit, then show the form

	// Retrieve record info
	$q = "
	SELECT issue_num, title, description, category, supplier
	FROM archives
	WHERE issue_num = $in
	";
	$r = mysqli_query( $dbc, $q );
	
	if( mysqli_num_rows( $r ) == 1) { // Confirmation query for record to delete
		
		// Display record to be deleted with message warning
		// Create table to show result from previous query starting with the headers
		$warning =  '<p class="error">You are about to delete the record below:</p>';
		echo $warning;
		echo'
		<div id="tbl_archives_wrapper">
		<table id="table_archives">
		<thead id="thead_archives">
			<tr>
				<th id="tbl_th1"><b>Issue #</b></th>
				<th id="tbl_th2"><b>Title</b></th>
				<th id="tbl_th3"><b>Description</b></th>
				<th id="tbl_th4"><b>Category</b></th>
				<th id="tbl_th5"><b>Supplier</b></th>
			</tr>
		</thead>	
		';
		
		// Continue with the table body	
		while( $row = mysqli_fetch_array( $r, MYSQLI_ASSOC ) ){
			echo'
				<tbody class="tbody_archives">
					<tr>
						<td id="tbl_td1">' . $row['issue_num'] . '</td>
						<td id="tbl_td2">' . $row['title'] . '</td>
						<td id="tbl_td3">' . $row['description'] . '</td>
						<td id="tbl_td4">' . $row['category'] . '</td>
						<td id="tbl_td5">' . $row['supplier'] . '</td>
					</tr>
				</tbody>
				';
		} // END while
		echo '</table></div>'; // Close the table
		
	} else {
	
		unset( $warning );
	
		echo'
		<p class="error"><b>Could not execute delete command:</b></p>
		<p>' . mysqli_error( $dbc ) . '<br />
		Query: ' . $q . '</p><br />';
		
		echo '<a href="insert.php">BACK</a>';
	} // END if

# Open form for executing delete --------------------------------------------------------------- -->

echo'
<form action="delete_record.php" method="post" id="form_delete">
	<input type="radio" name="sure" value="Yes" />Yes
	<input type="radio" name="sure" value="No" checked="checked" />No
	<input type="submit" name="submit" value="Submit" />
	<input type="hidden" name="in" value="' . $in . '" />
</form>
';
# END HTML form -------------------------------------------------------------------------------- -->

} // END if($_SERVER)

include ('includes/footer.html');
?>