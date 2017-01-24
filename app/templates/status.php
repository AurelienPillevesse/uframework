<form action="/statuses/<?= $status['id'] ?>" method="POST">
    <input type="hidden" name="_method" value="DELETE">
    <input type="submit" value="Delete">
</form>

<?php

echo $status['id'].'<br>';
echo $status['user'].'<br>';
echo $status['content'].'<br>';
echo '<br>';