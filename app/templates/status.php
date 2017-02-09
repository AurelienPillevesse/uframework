<?php
php require 'header.php'
 if ($status): ?>
  <form action="/statuses/<?= $status->getId() ?>" method="POST">
      <input type="hidden" name="_method" value="DELETE">
      <input type="submit" value="Delete">
  </form>
<?php endif;
echo $status->getId().'<br>';
echo $status->getUser().'<br>';
echo $status->getContent().'<br>';
echo '<br>';


php require 'footer.php' ?>
