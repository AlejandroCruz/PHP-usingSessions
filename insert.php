<?php # Phase 2 - insert.php
/*
 * Web page that displays a list of products with editing capabilities.
 * It conatains a form for adding new products to the list.
 */
 
// Start session (sends cookie PHPSESSID)
session_start();

$page_title = 'Archives'; //set page title variable
include( 'includes/header.html' );

// If session not set, redirect user. Also, validate the HTTP_USER_AGENT
if( !isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) ) {

	// Include needed functions
	require( 'includes/login_functions.inc.php' );
	
	redirect_user(); // page value in login_functions.inc.php

} // END if(!isset...
?>

<!-- Open HTML Form ---------------------------------------------------------------------------- -->

<h1>Insert / Edit / Delete Record</h1>

	<form action="insert.php" method="post" id="form_archives">

			<div id="frm_field1">
				
				<b>*Issue #</b>
				<input type="text" name="issue_num" id="issue_num" size="1" maxlength="3" autofocus="autofocus" tabindex="1"
				value="<?php if( isset( $_POST['issue_num'] ) ) echo $_POST['issue_num']; ?>">
				
			</div>
			<div id="frm_field2">
			
				<b>Title</b>
				<input type="text" name="title" id="title" size="15" maxlength="50" tabindex="2"
				value="<?php if( isset( $_POST['title'] ) ) echo $_POST['title']; ?>">
				
			</div>
				
			<div id="frm_field3">
			
				<b>Description</b>
				<input type="text" name="description" id="description" size="15" maxlength="100" tabindex="3"
				value="<?php if( isset( $_POST['description'] ) ) echo $_POST['description']; ?>">
				
			</div>
			<div id="frm_field4">
			
				<b>Category</b>
				<input type="text" name="category" id="category" size="15" maxlength="20" tabindex="3"
				value="<?php if( isset( $_POST['category'] ) ) echo $_POST['category']; ?>">
				
			</div>
			<div id="frm_field5">
			
				<b>Supplier</b>
				<input type="text" name="supplier" id="supplier" size="15" maxlength="10" tabindex="4"
				value="<?php if( isset( $_POST['supplier'] ) ) echo $_POST['supplier']; ?>"><br />
			
			</div>
			<div id="frm_field6">		
		
				<input type="submit" value="Insert" name="insert" class="button" id="button_archives" tabindex="7">
				<input type="submit" value="Update" name="update" class="button" tabindex="8">
				
			</div>
	<span>*Issue # is a required  field.</span>
	</form>

<!-- Close HTML Form --------------------------------------------------------------------------- -->

<?php

require_once( 'mysqli_connect.php' ); // Open connection to DB
mysqli_select_db( $dbc, "traveler" ); // Select DB traveler


// If form submitted
if( ($_SERVER['REQUEST_METHOD'] == 'POST') AND (isset($_POST['insert'])) ) {

	// Initialize error array
	$errors = array();
	
	// Check for account 'issue_num' (magazine number)
	if( empty($_POST['issue_num']) OR !is_numeric($_POST['issue_num']) ) {
		echo '<p>The field <span class="error"><b>Issue #</b></span> requires a numeric value.</p>';
	
	} else {
	
		$in = mysqli_real_escape_string( $dbc, trim( $_POST['issue_num'] ) );
		$ti = mysqli_real_escape_string( $dbc, trim( $_POST['title'] ) );
		$de = mysqli_real_escape_string( $dbc, trim( $_POST['description'] ) );
		$ca = mysqli_real_escape_string( $dbc, trim( $_POST['category'] ) );
		$su = mysqli_real_escape_string( $dbc, trim( $_POST['supplier'] ) );
		
		
		// Query for specific issue_num entered
		$q_in = "
		SELECT issue_num
		FROM archives
		WHERE issue_num = $in
		";
		$r_in = mysqli_query( $dbc, $q_in ); // Run query
		$num = mysqli_num_rows( $r_in ); // Count returned rows
		
		// If issue_num match record on file
		if( $num > 0 ) {
				
			echo '<p>Issue <b>#<span class="error">' . $in . ' </span></b>exists on record.<br />
			Do you mean to update the record? Use "Update" button.</p><br />';
			
		} else { // If no record found make INSERT & execute
				
			// Make query
			$q = "
			INSERT INTO archives ( issue_num, title, description, category, supplier )
			VALUES ( $in, '$ti', '$de', '$ca', '$su' )
			";
			$r = mysqli_query( $dbc, $q ); // Run query
			
			if( !$r ){ // Query error?
			
				echo '<p class="error"><b>Could not execute INSERT query.</b></p>
				<p><b>' . mysqli_error( $dbc ) . '<br /><br />
				Query: ' . $q . '</b></p><br />';
				
			} //END if(!$r)
			
		} // End if($num > 0 )
		
	} // END if(empty...

} // END if($_SERVER...

if( ($_SERVER['REQUEST_METHOD'] == 'POST') AND (isset($_POST['update'])) ) {

	// Initialize error array
	$errors = array();
	
	// Check for account 'issue_num' (magazine number)
	if( empty($_POST['issue_num']) OR !is_numeric($_POST['issue_num']) ) {
		echo '<p>The field <span class="error"><b>Issue #</b></span> requires a numeric value.</p>';
	
	} else {
	
		$in = mysqli_real_escape_string( $dbc, trim( $_POST['issue_num'] ) );
		$ti = mysqli_real_escape_string( $dbc, trim( $_POST['title'] ) );
		$de = mysqli_real_escape_string( $dbc, trim( $_POST['description'] ) );
		$ca = mysqli_real_escape_string( $dbc, trim( $_POST['category'] ) );
		$su = mysqli_real_escape_string( $dbc, trim( $_POST['supplier'] ) );
		
		
		// Query for specific issue_num entered
		$q_in = "
		SELECT issue_num
		FROM archives
		WHERE issue_num = $in
		";
		$r_in = mysqli_query( $dbc, $q_in ); // Run query
		$num = mysqli_num_rows( $r_in ); // Count returned rows
		
		// If issue_num entered has no match on file
		if( $num == 0 ) {
				
			echo '<p>Issue <b>#<span class="error">' . $in . ' </span></b>does not exists on record.<br />
			Do you mean to make a new insert? Use "Insert" button.</p><br />';
			
		} else { // If a match exists execute UPDATE
				
			// Make query
			$q = "
			UPDATE archives 
			SET title='$ti', description='$de', category='$ca', supplier='$su'
			WHERE issue_num = $in LIMIT 1
			";
			$r = mysqli_query( $dbc, $q ); // Run query
			
			if( !$r ){ // Query error?
			
				echo '<p class="error"><b>Could not execute INSERT query:</b></p>
				<p>' . mysqli_error( $dbc ) . '<br />
				Query: ' . $q . '</p><br /><br />';
				
			} //END if(!$r)
			
		} // End if($num > 0 )
		
	} // END if(empty...

} // END if($_SERVER...

//echo '<h3>Past Issues</h3>';

// Make query for all content to display on table/list
$q = "
SELECT issue_num, title, description, category, supplier
FROM archives
";
$r = mysqli_query( $dbc, $q );

// Create table to show result from previous query starting with the headers
echo'
<div id="tbl_archives_wrapper">
<h3>The Traveler Magazine Database</h3>
<table id="table_archives">
<thead id="thead_archives">
	<tr>
		<th id="tbl_th0"><b>Delete</b></th>
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
				<td id="tbl_td0"><b><a href="delete_record.php?in=' . $row['issue_num'] . '">Delete</a></b></td>
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

// Close DB connection
mysqli_close( $dbc );

include ('includes/footer.html');
?>