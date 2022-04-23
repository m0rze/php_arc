<option>Выберите время</option>
<option></option>
<?php foreach ( $times as $oneTime ): ?>
	<option class="time_option" value="<?= $oneTime ?>"><?= $oneTime ?></option>
<?php endforeach; ?>