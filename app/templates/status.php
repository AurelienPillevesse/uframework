<?php include 'header.php';
if ($status) {
    if ($_SESSION['login'] == $status->getUser()) {
        ?>
	<form action="/statuses/<?php echo $status->getId(); ?>" method="POST">
		<input type="hidden" name="_method" value="DELETE">
		<input type="submit" value="Delete">
	</form>

	<?php 
    }
}
echo $status->getId().'<br>';
echo $status->getUser().'<br>';
echo $status->getContent().'<br>';
echo '<br>';

include 'footer.php';
