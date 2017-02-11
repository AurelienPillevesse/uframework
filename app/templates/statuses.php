<?php include 'header.php' ?>

<h1>List</h1>

<form action="/statuses" method="POST">
	<input type="hidden" name="_method" value="POST">
	<div class="row">
		<div class="input-field col s12">
			<input  placeholder="Enter your status"  id="message" name="message" class="validate">
		</div>
	</div>
	<button class="btn waves-effect waves-light" type="submit" name="action">Tweet!
		<i class="material-icons right">send</i>
	</button>
</form>


<form>
    <select style="display: block;">
      <option value="" disabled selected hidden>Trier par</option>
      <option value="createdAt">Date de création</option>
    </select>

    <select style="display: block;">
      <option value="" disabled selected hidden>Ordre</option>
      <option value="ASC">ASC</option>
      <option value="DESC">DESC</option>
    </select>

    <input placeholder="Nombre de status souhaités" id="status_number" name="status_number" type="number" class="validate" min=1>
    <button class="btn waves-effect waves-light" type="submit" name="action">Valider!
		<i class="material-icons right">send</i>
	</button>
</form>


<?php
if ($statuses!=null) {
    foreach ($statuses as $s) {
        ?>
	<div>
		<?php if ($_SESSION['login'] == $s->getUser()) {
            ?>
		<form action="/statuses/<?php echo $s->getId(); ?>" method="POST">
			<input type="hidden" name="_method" value="DELETE">
			<input type="submit" value="Delete">
		</form>
		<?php 
        } ?>
		<p><?php echo $s->getUser(); ?></p>
		<p><?php echo $s->getContent(); ?></p>
		<p><a href="/statuses/<?php echo $s->getId(); ?>">See this status</a></p>
	</div>

	<?php

    }
} else {
    echo "<h3>No tweet in database.</h3>";
}

include 'footer.php' ?>