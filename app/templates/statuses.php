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
foreach ($statuses as $t) {
	echo $t['id'].'<br>';
	echo $t['user'].'<br>';
	echo $t['content'].'<br>';
	echo '<br>';
}