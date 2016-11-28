<?php

session_start();

$page_title = 'PHP Web Application';
include( 'includes/header.html' );

?>

<h1 id="mainhead">Phase 2: Insert Into Database</h1>
<p>This site permits the user access to a control panel for a Web-based travel magazine. It creates scripts that interact with the <i>Traveler</i> database. The site includes menu tabs for <b>Welcome</b> page, <b>Insert</b> page that allows user to enter product information into database, and<b>LogIn/Out</b> tab to end user&#8217s session.</p>
<br /><br />
<div class="list">
	<ul>
		<li>The <i>Welcome</i> and <i>Insert</i> tabs become enabled after logging in.</li>
		<li>The <i>Welcome</i> tab will greet logged in user by registered <i><u>user name</u></i> and
		display message or task.
		<li>The <i>Insert</i> tab gives access to a control panel with a form where product
		information can be inserted into database or deleted.</li>
		<li>After logging out, <i>Welcome</i> and <i>Insert</i> tabs become disabled and access
		to these pages is denied.</i>
	</ul>
</div>

<?php include ('includes/footer.html'); ?>