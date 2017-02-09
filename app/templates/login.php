<?php require 'header.php' ?>

<h3>Se connecter</h3>

<form action="/login" method="post">
  <input type="hidden" name="_method" value="LOGIN">
  Login:<br>
  <input type="text" name="login" value="admin">
  <br>
  Password:<br>
  <input type="text" name="password" value="root">
  <br><br>
  <input type="submit" value="Connection">
</form>

<?php require 'footer.php' ?>
