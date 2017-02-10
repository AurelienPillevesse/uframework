<?php include 'header.php' ?>

<h1>List</h1>

<form action="/statuses" method="POST">
	<input type="hidden" name="_method" value="POST">
	<label for="username">Username:</label>
	<input type="text" name="username"/>
	<label for="message">Message:</label>
	<textarea name="message"></textarea>

	<input type="submit" value="Tweet!">
</form>

<?php
if ($statuses!=null) {
	foreach ($statuses as $s) {
		echo '<div><p>'.$s->getId().'</p>';
		echo '<p>'.$s->getUser().'</p>';
		echo '<p>'.$s->getContent().'</p></div>';
	}
}else echo "<h3>No tweet in database.</h3>";

include 'header.php' ?>