<h1>list</h1>

<form action="/statuses" method="POST">
	<input type="hidden" name="_method" value="POST">
	<label for="username">Username:</label>
	<input type="text" name="username">

	<label for="message">Message:</label>
	<textarea name="message"></textarea>

	<input type="submit" value="Tweet!">
</form>

<?php
foreach ($statuses as $s) {
	echo $s->getId().'<br>';
	echo $s->getUser().'<br>';
	echo $s->getContent().'<br>';
	echo '<br>';
}