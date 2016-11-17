<?php

$page_title = 'Login';
include( 'includes/header.html' );

if( isset( $errors ) && !empty( $errors ) ) {
	echo'
	<p><b>Error!</b><br /><br />
	<span class="error">The following errors occured:</span><br />';
	foreach( $errors as $msg ) {
		echo "$msg<br />\n";
	}
	echo '</p>';	
}

?>

<div class="cut_h1">
<h1>Member Log In</h1>
<form class="newform" action="login.php" method="post">
		<b>Username: 
			<input type="text" name="username" id="username" size="20" maxlength="20" autofocus="autofocus" tabindex="1"
			value="<?php if( isset( $_POST['username'] ) ) echo $_POST['username']; ?>"><br><br></b>
		<b>Password: 
			<input type="password" name="pass" id="pass" size="20" maxlength="20" tabindex="2"
			value="<?php if( isset( $_POST['pass'] ) ) echo $_POST['pass']; ?>"><br><br></b>
		<input type="submit" value="Log In" name="login" class="button" tabindex="3">
	</form>
</div>
<br />
<div class="cut_h1">
<h1>New Registration</h1>
	<form action="login.php" method="post">
		<b>Username: 
			<input type="text" name="new_username" id="new_username" size="20" maxlength="20" autofocus="autofocus" tabindex="4"
			value="<?php if( isset( $_POST['new_username'] ) ) echo $_POST['new_username']; ?>"><br><br></b>
		<b>Password: 
			<input type="password" name="pass1" id="pass1" size="20" maxlength="20" tabindex="5"
			value="<?php if( isset( $_POST['pass1'] ) ) echo $_POST['pass1']; ?>"><br><br></b>
		<b>Confirm Password: 
			<input type="password" name="pass2" id="pass2" size="20" maxlength="20" tabindex="6"
			value="<?php if( isset( $_POST['pass2'] ) ) echo $_POST['pass2']; ?>"><br><br></b>
		<input type="submit" value="Register" name="register" class="button" tabindex="7">
	</form>
</div>

<?php

include ('includes/footer.html');

?>