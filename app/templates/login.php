<?php include 'header.php' ?>

<h3>Se connecter</h3>

<form action="/login" method="post">
	Login:<br>
	<input type="text" name="login">
	<br>
	Password:<br>
	<input type="password" name="password">
	<br><br>
	<input type="submit" value="Connection">
</form>

<?php include 'footer.php' ?>
