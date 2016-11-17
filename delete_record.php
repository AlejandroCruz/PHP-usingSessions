<?php

// Send cookie PHPSESSID
session_start();

$page_title = 'Delete Record';
include( 'includes/header.html' );
echo '<h1 id="mainhead">Delete Record</h1>';

if( !isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) ) {

	require( 'includes/login_functions.inc.php' );
	
	redirect_user();

}

if( (isset($_GET['in'])) && (is_numeric($_GET['in'])) ) {
	$in = $_GET['in'];
} elseif( (isset($_POST['in'])) && (is_numeric($_POST['in'])) ) {
	$in = $_POST['in'];
} else {
	echo'
	<p class="error">This page has been accessed in error.</p>
	';
}

require_once( 'mysqli_connect.php' );
mysqli_select_db( $dbc, "traveler" );

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

	if( $_POST['sure'] == 'Yes' ) {
	
		$q = "
		DELETE
		FROM archives
		WHERE issue_num = $in LIMIT 1
		";
		$r = mysqli_query( $dbc, $q );
		if( mysqli_affected_rows($dbc) == 1 ) {
		
			unset( $warning );
		
			echo'
			<p>The record for <span class="display_db"><b>Issue #' . $_POST['in'] . '</b></span> 
			has been deleted.</p><br />
			';
			echo '<a href="insert.php">BACK</a>';
		} else {
		
			unset( $warning );
		
			echo'
			<p class="error"><b>Record could not be deleted due to system error:</b></p>
			<p>' . mysqli_error( $dbc ) . '<br />
				Query: ' . $q . '</p><br /><br />
			';
			echo '<a href="insert.php">BACK</a>';
		}
	} else {
		
		unset( $warning );
		
		echo '<p>The record for <b>Issue #' . $_POST['in'] . '</b> has <span class="display_db"><b>NOT</b></span> been deleted.</p><br />';
		echo '<a href="insert.php">BACK</a>';
		
	} // END if ($_POST)

} else {

	$q = "
	SELECT issue_num, title, description, category, supplier
	FROM archives
	WHERE issue_num = $in
	";
	$r = mysqli_query( $dbc, $q );
	
	if( mysqli_num_rows( $r ) == 1) {
		
		$warning = '<p class="error">You are about to delete the record below:</p>';
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
		}
		echo '</table></div>';
		
	} else {
	
		unset( $warning );
	
		echo'
		<p class="error"><b>Could not execute delete command:</b></p>
		<p>' . mysqli_error( $dbc ) . '<br />Query: ' . $q . '</p><br />';
		
		echo '<a href="insert.php">BACK</a>';
	}

echo'
<form action="delete_record.php" method="post" id="form_delete">
	<input type="radio" name="sure" value="Yes" />Yes
	<input type="radio" name="sure" value="No" checked="checked" />No
	<input type="submit" name="submit" value="Submit" />
	<input type="hidden" name="in" value="' . $in . '" />
</form>
';

} // END if($_SERVER)

include ('includes/footer.html');
?>