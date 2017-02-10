<?php include 'header.php' ?>

<h2>S'enregistrer maintenant</h2>

<form action="/register" method="post">
	Login:<br>
	<input type="text" name="login">
	<br>
	Password:<br>
	<input type="password" name="password">
	<br><br>
	<input type="submit" value="S'enregistrer">
</form>

<?php include 'footer.php' ?>
